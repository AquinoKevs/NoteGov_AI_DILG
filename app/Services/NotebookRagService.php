<?php

namespace App\Services;

use App\Models\AiEmbedding;
use App\Models\Notebook;
use App\Models\Source;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NotebookRagService
{
    public function __construct(protected GeminiService $openAI) {}

    /**
     * Index a source into chunked embeddings.
     */
    public function syncSourceEmbeddings(Source $source): void
    {
        $text = trim($source->extracted_text ?: ($source->summary ?: ''));

        $source->embeddings()->delete();

        if ($text === '') {
            return;
        }

        $chunks = $this->chunkText($text);
        $vectors = $this->openAI->embeddings(array_column($chunks, 'content'));

        foreach ($chunks as $index => $chunk) {
            AiEmbedding::create([
                'notebook_id' => $source->notebook_id,
                'source_id' => $source->id,
                'message_id' => null,
                'chunk_index' => $index,
                'content_hash' => sha1($chunk['content']),
                'embedding_model' => $vectors !== [] ? config('services.gemini.embedding_model', 'text-embedding-004') : null,
                'token_count' => $chunk['token_count'],
                'content' => $chunk['content'],
                'embedding' => $vectors[$index] ?? null,
                'metadata' => [
                    'source_name' => $source->name,
                    'type' => $source->type,
                ],
            ]);
        }
    }

    /**
     * Build notebook context for an incoming prompt.
     *
     * @return array{context:string,citations:array<int, array<string, mixed>>,chunks:Collection<int, AiEmbedding>}
     */
    public function buildContext(Notebook $notebook, string $prompt, int $limit = 4, ?array $sourceIds = null): array
    {
        $chunks = $this->searchRelevantChunks($notebook, $prompt, $limit, $sourceIds);

        if ($chunks->isEmpty()) {
            $fallbackSources = $notebook->sources()
                ->whereNotNull('summary')
                ->when(
                    is_array($sourceIds) && $sourceIds !== [],
                    fn ($query) => $query->whereIn('id', $sourceIds)
                )
                ->latest('updated_at')
                ->limit($limit)
                ->get();

            $context = $fallbackSources
                ->map(fn (Source $source) => "[{$source->name}] ".$source->summary)
                ->implode("\n\n");

            $citations = $fallbackSources
                ->map(fn (Source $source) => [
                    'source_id' => $source->id,
                    'source_name' => $source->name,
                    'type' => $source->type,
                ])
                ->all();

            return [
                'context' => $context,
                'citations' => $citations,
                'chunks' => collect(),
            ];
        }

        return [
            'context' => $chunks
                ->map(fn (AiEmbedding $chunk) => '['.data_get($chunk->metadata, 'source_name', 'Notebook source').'] '.$chunk->content)
                ->implode("\n\n"),
            'citations' => $chunks
                ->map(fn (AiEmbedding $chunk) => [
                    'source_id' => $chunk->source_id,
                    'source_name' => data_get($chunk->metadata, 'source_name', 'Notebook source'),
                    'chunk_index' => $chunk->chunk_index,
                    'type' => data_get($chunk->metadata, 'type', 'document'),
                ])
                ->values()
                ->all(),
            'chunks' => $chunks,
        ];
    }

    /**
     * Find relevant chunks using lexical overlap as a lightweight fallback.
     *
     * @return Collection<int, AiEmbedding>
     */
    public function searchRelevantChunks(Notebook $notebook, string $prompt, int $limit = 4, ?array $sourceIds = null): Collection
    {
        $keywords = collect(Str::of($prompt)->lower()->replaceMatches('/[^a-z0-9\s]/', ' ')->explode(' '))
            ->filter(fn (string $part) => Str::length($part) > 2)
            ->unique()
            ->values();

        return $notebook->embeddings()
            ->with('source')
            ->when(
                is_array($sourceIds) && $sourceIds !== [],
                fn ($query) => $query->whereIn('source_id', $sourceIds)
            )
            ->get()
            ->map(function (AiEmbedding $chunk) use ($keywords): AiEmbedding {
                $haystack = Str::lower($chunk->content);
                $score = $keywords->sum(fn (string $keyword) => substr_count($haystack, $keyword));
                $chunk->setAttribute('relevance_score', $score);

                return $chunk;
            })
            ->filter(fn (AiEmbedding $chunk) => ($chunk->getAttribute('relevance_score') ?? 0) > 0)
            ->sortByDesc(fn (AiEmbedding $chunk) => $chunk->getAttribute('relevance_score'))
            ->take($limit)
            ->values();
    }

    /**
     * Split a text payload into chunks suitable for indexing.
     *
     * @return array<int, array{content:string,token_count:int}>
     */
    protected function chunkText(string $text, int $chunkSize = 1000): array
    {
        $normalized = preg_replace('/\s+/', ' ', trim($text)) ?? trim($text);
        $chunks = [];

        foreach (str_split($normalized, $chunkSize) as $chunk) {
            $content = trim($chunk);

            if ($content === '') {
                continue;
            }

            $chunks[] = [
                'content' => $content,
                'token_count' => (int) ceil(str_word_count($content) * 1.35),
            ];
        }

        return $chunks;
    }
}
