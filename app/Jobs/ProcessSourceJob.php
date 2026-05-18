<?php

namespace App\Jobs;

use App\Models\Source;
use App\Notifications\SourceProcessedNotification;
use App\Services\DocumentIngestionService;
use App\Services\NotebookRagService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Source $source) {}

    /**
     * Execute the job.
     */
    public function handle(DocumentIngestionService $ingestion, NotebookRagService $rag): void
    {
        $source = $this->source->fresh();

        if (! $source) {
            return;
        }

        $source->update(['status' => 'processing']);

        $payload = $ingestion->extractContent($source);

        $source->update([
            'status' => 'indexed',
            'summary' => $payload['summary'],
            'extracted_text' => $payload['text'],
            'metadata' => array_merge($source->metadata ?? [], $payload['metadata']),
            'indexed_at' => now(),
            'last_processed_at' => now(),
        ]);

        $rag->syncSourceEmbeddings($source);

        $source->notebook->owner->notify(new SourceProcessedNotification($source));
    }
}
