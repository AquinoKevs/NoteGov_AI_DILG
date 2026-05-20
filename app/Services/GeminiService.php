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
                'used_sources' => false,
            ];
        }

        $trimmedContext = trim($context);
        
        if (str_starts_with($trimmedContext, 'PDF too large to parse') || str_starts_with($trimmedContext, 'File type')) {
            Log::info('GeminiService: Context contains failed source messages, filtering them out and proceeding with normal AI chat', [
                'context_preview' => Str::limit($trimmedContext, 200),
            ]);
            $trimmedContext = '';
        }

        if ($trimmedContext === '') {
            try {
                $apiKey = config('services.gemini.api_key');
                $model = config('services.gemini.chat_model', 'gemini-flash-latest');
                
                $systemPrompt = <<<PROMPT
You are NoteGov AI, a general-purpose AI assistant with deep knowledge across many fields.
- Respond conversationally and naturally to the user's message
- Answer questions on any topic, from everyday conversations to technical/academic subjects
- Sources are optional enhancements only; you can chat normally even without them
- Keep responses friendly, helpful, comprehensive, and professional
- Follow all safety and ethical guidelines while answering legitimate questions
- Provide accurate, appropriate, and useful information in every response
- Never mention document processing failures or technical issues
- Focus on what the user is asking

USER MESSAGE:
{$prompt}
PROMPT;

                Log::info('GeminiService: Sending conversational request to API (no sources available)');
                
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
                            'temperature' => 0.7,
                        ],
                    ]);

                Log::info('GeminiService: Received conversational raw response', [
                    'status' => $response->status(),
                    'raw_response' => $response->json(),
                ]);

                if ($response->status() === 429) {
                    $text = "You've exceeded your Gemini API free quota limit. Please try again tomorrow or upgrade your API plan.";
                } elseif ($response->failed()) {
                    $text = $this->friendlyFallbackAnswer($prompt);
                } else {
                    $responseJson = $response->json();
                    $text = $this->extractResponseText($responseJson) ?: $this->friendlyFallbackAnswer($prompt);
                }

                $provider = $response->status() === 429 ? 'gemini-quota-error' : 'gemini-conversational';
                return [
                    'text' => $text,
                    'citations' => [],
                    'provider' => $provider,
                    'used_sources' => false,
                ];
            } catch (Throwable $exception) {
                Log::error('GeminiService: Conversational API error', [
                    'error' => $exception->getMessage(),
                ]);
                
                return [
                    'text' => $this->friendlyFallbackAnswer($prompt),
                    'citations' => [],
                    'provider' => 'local-fallback',
                    'used_sources' => false,
                ];
            }
        }

        try {
            $apiKey = config('services.gemini.api_key');
            $model = config('services.gemini.chat_model', 'gemini-flash-latest');
            
            $systemPrompt = <<<PROMPT
You are NoteGov AI, a general-purpose AI assistant that can use document context when available.

GUIDELINES FOR ANSWERING:
- If document context is available and relevant, prioritize using that information
- If the answer isn't in the document, you can still answer using your general knowledge
- Give direct, accurate, comprehensive answers
- Use clean formatting (bullet points, numbered lists, etc. when appropriate)
- Avoid repeating duplicated content
- Ignore unrelated extracted preview text, document headers, or metadata
- Answer only the requested question
- Do NOT repeat raw extracted text, file preview, metadata, or document headers unless specifically asked
- Do NOT include phrases like "Answer based on indexed notebook content"
- Follow all safety and ethical guidelines while answering legitimate questions
- Provide appropriate and useful information in every response

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
                ]);

            Log::info('GeminiService: Received raw response', [
                'status' => $response->status(),
                'raw_response' => $response->json(),
            ]);

            if ($response->status() === 429) {
                return [
                    'text' => "You've exceeded your Gemini API free quota limit. Please try again tomorrow or upgrade your API plan.",
                    'citations' => $citations,
                    'provider' => 'gemini-quota-error',
                    'used_sources' => false,
                ];
            }

            if ($response->failed()) {
                return [
                    'text' => $this->fallbackAnswer($prompt, $context, $mode),
                    'citations' => $citations,
                    'provider' => 'local-fallback',
                    'used_sources' => false,
                ];
            }

            $responseJson = $response->json();
            $text = $this->extractResponseText($responseJson);

            $finalAnswer = $text ?: $this->fallbackAnswer($prompt, $context, $mode);

            Log::info('GeminiService: Final formatted response ready', [
                'final_answer_text' => $finalAnswer,
            ]);

            return [
                'text' => $finalAnswer,
                'citations' => $citations,
                'provider' => 'gemini',
                'used_sources' => true,
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
                'used_sources' => false,
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
    protected function friendlyFallbackAnswer(string $prompt): string
    {
        $lowerPrompt = strtolower(trim($prompt));
        
        if (str_contains($lowerPrompt, 'hi') || str_contains($lowerPrompt, 'hello') || str_contains($lowerPrompt, 'hey')) {
            return "Hello! How can I help you today?";
        }
        
        if (str_contains($lowerPrompt, 'how are you')) {
            return "I'm doing well, thank you for asking! How can I assist you today?";
        }
        
        return "Hello! I'm NoteGov AI. How can I help you today?";
    }

    protected function fallbackAnswer(string $prompt, string $context, string $mode): string
    {
        $context = trim($context);

        if ($context === '') {
            return $this->friendlyFallbackAnswer($prompt);
        }

        return "NoteGov AI is currently unavailable. Please try again later.";
    }
}