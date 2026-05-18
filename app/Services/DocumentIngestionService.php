<?php

namespace App\Services;

use App\Jobs\ProcessSourceJob;
use App\Models\Notebook;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class DocumentIngestionService
{
    public function __construct(protected ActivityLogger $activityLogger) {}

    /**
     * Create a new notebook source and queue it for processing.
     */
    public function createSource(Notebook $notebook, array $validated, ?UploadedFile $file, ?User $user): Source
    {
        $type = $validated['source_type'];
        $storagePath = $file?->store("notebooks/{$notebook->id}/sources", 'public');
        $sourceUrl = $validated['source_url'] ?? null;
        $name = $validated['title']
            ?? $file?->getClientOriginalName()
            ?? parse_url((string) $sourceUrl, PHP_URL_HOST)
            ?? Str::headline($type.' source');

        $source = $notebook->sources()->create([
            'uploaded_by' => $user?->id,
            'type' => $type,
            'name' => $name,
            'original_name' => $file?->getClientOriginalName(),
            'storage_disk' => 'public',
            'storage_path' => $storagePath,
            'source_url' => $sourceUrl,
            'mime_type' => $file?->getClientMimeType(),
            'file_size' => $file?->getSize(),
            'status' => 'queued',
            'content_hash' => $file ? sha1_file($file->getRealPath()) : sha1((string) $sourceUrl),
            'metadata' => [
                'notes' => $validated['notes'] ?? null,
                'extension' => $file?->getClientOriginalExtension(),
            ],
        ]);

        ProcessSourceJob::dispatch($source);

        $this->activityLogger->log(
            $user,
            'source.uploaded',
            "Uploaded source {$source->name}.",
            $notebook,
            $source
        );

        return $source;
    }

    /**
     * Extract content and metadata from a source.
     *
     * @return array{text:string,summary:string,metadata:array<string, mixed>}
     */
    public function extractContent(Source $source): array
    {
        $text = match ($source->type) {
            'txt' => $this->extractFromTextFile($source),
            'docx' => $this->extractFromDocx($source),
            'pdf' => $this->extractFromPdf($source),
            'url', 'youtube' => $this->extractFromUrl($source),
            'audio', 'video' => $this->extractFromMedia($source),
            default => '',
        };

        $summary = Str::limit(preg_replace('/\s+/', ' ', $text) ?? $text, 420);

        return [
            'text' => $text,
            'summary' => $summary !== '' ? $summary : 'Source queued for deeper indexing.',
            'metadata' => array_filter([
                'word_count' => str_word_count($text),
                'character_count' => Str::length($text),
            ]),
        ];
    }

    /**
     * Delete a source from storage.
     */
    public function deleteSource(Source $source): void
    {
        if ($source->storage_path) {
            Storage::disk($source->storage_disk)->delete($source->storage_path);
        }
    }

    protected function extractFromTextFile(Source $source): string
    {
        $path = $source->storage_path ? Storage::disk($source->storage_disk)->path($source->storage_path) : null;

        return $path && is_file($path) ? (file_get_contents($path) ?: '') : '';
    }

    protected function extractFromDocx(Source $source): string
    {
        $path = $source->storage_path ? Storage::disk($source->storage_disk)->path($source->storage_path) : null;

        if (! $path || ! is_file($path)) {
            return '';
        }

        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            return '';
        }

        $content = $zip->getFromName('word/document.xml') ?: '';
        $zip->close();

        return trim(preg_replace('/\s+/', ' ', strip_tags($content)) ?? strip_tags($content));
    }

    protected function extractFromPdf(Source $source): string
    {
        $path = $source->storage_path ? Storage::disk($source->storage_disk)->path($source->storage_path) : null;

        if (! $path || ! is_file($path)) {
            return '';
        }

        $binary = file_get_contents($path) ?: '';
        preg_match_all('/\((.*?)\)/s', $binary, $matches);

        return trim(preg_replace('/\s+/', ' ', implode(' ', $matches[1] ?? [])) ?? '');
    }

    protected function extractFromUrl(Source $source): string
    {
        $notes = data_get($source->metadata, 'notes');

        return trim("Imported link: {$source->source_url}\n\n{$notes}");
    }

    protected function extractFromMedia(Source $source): string
    {
        $notes = data_get($source->metadata, 'notes');

        return trim("Media source {$source->name} is queued for transcription.\n\n{$notes}");
    }
}
