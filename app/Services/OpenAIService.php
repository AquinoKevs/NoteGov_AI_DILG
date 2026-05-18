<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class OpenAIService
{
    /**
     * Determine if the OpenAI credentials are configured.
     */
    public function isConfigured(): bool
    {
        return filled(config('services.openai.api_key'));
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
            $response = Http::baseUrl(rtrim(config('services.openai.base_url', 'https://api.openai.com/v1'), '/'))
                ->withToken(config('services.openai.api_key'))
                ->timeout(60)
                ->post('/responses', [
                    'model' => config('services.openai.chat_model', 'gpt-4.1-mini'),
                    'temperature' => 0.2,
                    'input' => [
                        [
                            'role' => 'system',
                            'content' => [[
                                'type' => 'input_text',
                                'text' => 'You are NoteGov AI DILG, an AI governance notebook assistant. Answer with clear government-ready language, cite source titles when possible, and keep your response grounded only in the provided notebook context.',
                            ]],
                        ],
                        [
                            'role' => 'user',
                            'content' => [[
                                'type' => 'input_text',
                                'text' => "Mode: {$mode}\n\nPrompt:\n{$prompt}\n\nNotebook context:\n{$context}",
                            ]],
                        ],
                    ],
                ])
                ->throw()
                ->json();

            return [
                'text' => $this->extractResponseText($response) ?: $this->fallbackAnswer($prompt, $context, $mode),
                'citations' => $citations,
                'provider' => 'openai',
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
            $response = Http::baseUrl(rtrim(config('services.openai.base_url', 'https://api.openai.com/v1'), '/'))
                ->withToken(config('services.openai.api_key'))
                ->timeout(60)
                ->post('/embeddings', [
                    'model' => config('services.openai.embedding_model', 'text-embedding-3-small'),
                    'input' => $chunks,
                ])
                ->throw()
                ->json('data', []);

            return collect($response)
                ->map(fn (array $row) => $row['embedding'] ?? [])
                ->all();
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
            $response = Http::baseUrl(rtrim(config('services.openai.base_url', 'https://api.openai.com/v1'), '/'))
                ->withToken(config('services.openai.api_key'))
                ->timeout(60)
                ->post('/responses', [
                    'model' => config('services.openai.chat_model', 'gpt-4.1-mini'),
                    'temperature' => 0.2,
                    'input' => [
                        [
                            'role' => 'system',
                            'content' => [[
                                'type' => 'input_text',
                                'text' => trim("Summarize the provided notebook content for a government policy and operations audience. {$instructions}"),
                            ]],
                        ],
                        [
                            'role' => 'user',
                            'content' => [[
                                'type' => 'input_text',
                                'text' => Str::limit($content, 12000),
                            ]],
                        ],
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
     * Attempt to extract response text from the Responses API payload.
     */
    protected function extractResponseText(array $response): ?string
    {
        $output = data_get($response, 'output', []);

        foreach ($output as $item) {
            foreach (($item['content'] ?? []) as $contentItem) {
                $text = $contentItem['text'] ?? null;

                if (filled($text)) {
                    return trim($text);
                }
            }
        }

        return data_get($response, 'output_text');
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
