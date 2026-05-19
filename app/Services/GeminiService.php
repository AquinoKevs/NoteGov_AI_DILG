<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class GeminiService
{
    /**
     * Determine if the Gemini credentials are configured.
     */
    public function isConfigured(): bool
    {
        return filled(config('services.gemini.api_key'));
    }

    /**
     * Generate a notebook-aware answer.
     *
     * @return array{text:string,citations:array<int, array<string, mixed>>,provider:string}
     */
    public function answer(string $prompt, string $context, array $citations = [], string $mode = 'qa'): array
    {
        Log::info('GeminiService: Generating answer', [
            'prompt' => $prompt,
            'context_length' => Str::length($context),
            'citations_count' => count($citations),
        ]);

        if (! $this->isConfigured()) {
            return [
                'text' => $this->fallbackAnswer($prompt, $context, $mode),
                'citations' => $citations,
                'provider' => 'local-fallback',
            ];
        }

        if (trim($context) === '') {
            return [
                'text' => "The uploaded document does not contain enough information to answer this question.",
                'citations' => $citations,
                'provider' => 'gemini',
            ];
        }

        try {
            $apiKey = config('services.gemini.api_key');
            $model = config('services.gemini.chat_model', 'gemini-flash-latest');
            
            $systemPrompt = <<<PROMPT
You are an AI assistant for government and legal documents.

You must answer ONLY using the provided document context.

If the answer is not found in the document, respond with exactly:
"The uploaded document does not contain enough information to answer this question."

DO NOT use any external knowledge. DO NOT hallucinate. DO NOT make up information.

DOCUMENT CONTEXT:
{$context}

QUESTION:
{$prompt}
PROMPT;

            Log::info('GeminiService: Sending request to API', [
                'prompt_preview' => Str::limit($systemPrompt, 500),
            ]);
            
            $response = Http::baseUrl('https://generativelanguage.googleapis.com/v1beta')
                ->timeout(120)
                ->post("/models/{$model}:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $systemPrompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.1,
                        'topK' => 40,
                        'topP' => 0.95,
                    ],
                ])
                ->throw()
                ->json();

            Log::info('GeminiService: Received raw response', [
                'raw_response' => $response,
            ]);

            $text = $this->extractResponseText($response);

            return [
                'text' => $text ?: $this->fallbackAnswer($prompt, $context, $mode),
                'citations' => $citations,
                'provider' => 'gemini',
            ];
        } catch (Throwable $exception) {
            Log::error('GeminiService: API error', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
            report($exception);

            return [
                'text' => $this->fallbackAnswer($prompt, $context, $mode),
                'citations' => $citations,
                'provider' => 'local-fallback',
            ];
        }
    }

    /**
     * Generate embeddings for a set of chunks.
     *
     * @param  array<int, string>  $chunks
     * @return array<int, array<int, float>>
     */
    public function embeddings(array $chunks): array
    {
        if (! $this->isConfigured() || $chunks === []) {
            return [];
        }

        try {
            $apiKey = config('services.gemini.api_key');
            $model = config('services.gemini.embedding_model', 'gemini-embedding-001');
            $embeddings = [];

            foreach ($chunks as $chunk) {
                $response = Http::baseUrl('https://generativelanguage.googleapis.com/v1beta')
                    ->timeout(60)
                    ->post("/models/{$model}:embedContent?key={$apiKey}", [
                        'content' => [
                            'parts' => [
                                ['text' => $chunk],
                            ],
                        ],
                    ])
                    ->throw()
                    ->json();

                $embedding = data_get($response, 'embedding.values', []);
                $embeddings[] = $embedding;
            }

            return $embeddings;
        } catch (Throwable $exception) {
            report($exception);

            return [];
        }
    }

    /**
     * Summarize a content block.
     */
    public function summarize(string $content, string $instructions = ''): string
    {
        $content = trim($content);

        if ($content === '') {
            return 'No source content has been indexed yet.';
        }

        if (! $this->isConfigured()) {
            return Str::limit(preg_replace('/\s+/', ' ', $content) ?? $content, 420);
        }

        try {
            $apiKey = config('services.gemini.api_key');
            $model = config('services.gemini.chat_model', 'gemini-flash-latest');
            
            $response = Http::baseUrl('https://generativelanguage.googleapis.com/v1beta')
                ->timeout(60)
                ->post("/models/{$model}:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => trim("Summarize the provided notebook content for a government policy and operations audience. {$instructions}\n\nContent:\n" . Str::limit($content, 12000))],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                    ],
                ])
                ->throw()
                ->json();

            return $this->extractResponseText($response) ?: Str::limit($content, 420);
        } catch (Throwable $exception) {
            report($exception);

            return Str::limit($content, 420);
        }
    }

    /**
     * Attempt to extract response text from Gemini API payload.
     */
    protected function extractResponseText(array $response): ?string
    {
        $candidates = data_get($response, 'candidates', []);
        
        foreach ($candidates as $candidate) {
            $content = data_get($candidate, 'content', []);
            $parts = data_get($content, 'parts', []);
            
            foreach ($parts as $part) {
                $text = data_get($part, 'text');
                
                if (filled($text)) {
                    return trim($text);
                }
            }
        }

        return null;
    }

    /**
     * Build a deterministic fallback answer.
     */
    protected function fallbackAnswer(string $prompt, string $context, string $mode): string
    {
        $context = trim($context);

        if ($context === '') {
            return "The uploaded document does not contain enough information to answer this question.";
        }

        $opening = match ($mode) {
            'summary' => 'Notebook summary:',
            'report' => 'Draft report response:',
            'brief' => 'Policy brief response:',
            'compare' => 'Cross-source comparison:',
            default => 'Answer based on indexed notebook content:',
        };

        return $opening."\n\n".Str::limit($context, 900)."\n\nRequested prompt: ".$prompt;
    }
}