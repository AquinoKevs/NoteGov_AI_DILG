<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
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
        if (! $this->isConfigured()) {
            return [
                'text' => $this->fallbackAnswer($prompt, $context, $mode),
                'citations' => $citations,
                'provider' => 'local-fallback',
            ];
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
                                ['text' => "You are NoteGov AI DILG, an AI governance notebook assistant. Answer with clear government-ready language, cite source titles when possible, and keep your response grounded only in the provided notebook context.\n\nMode: {$mode}\n\nPrompt:\n{$prompt}\n\nNotebook context:\n{$context}"],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                    ],
                ])
                ->throw()
                ->json();

            return [
                'text' => $this->extractResponseText($response) ?: $this->fallbackAnswer($prompt, $context, $mode),
                'citations' => $citations,
                'provider' => 'gemini',
            ];
        } catch (Throwable $exception) {
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
            return "I do not have indexed notebook context yet for this request. Upload or process more sources, then try again with a more specific question about policies, reports, or action items.";
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
