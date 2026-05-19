<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Source;
use App\Services\DocumentIngestionService;

echo "Processing source...\n";

$source = Source::find(4);

if (!$source) {
    echo "Source not found!\n";
    exit(1);
}

echo "Source found: {$source->name}\n";
echo "Status: {$source->status}\n";
echo "Storage path: {$source->storage_path}\n";

$ingestion = app(DocumentIngestionService::class);

echo "\nExtracting content...\n";
try {
    $payload = $ingestion->extractContent($source);
    
    echo "Extraction complete!\n";
    echo "Text length: " . strlen($payload['text']) . "\n";
    echo "Summary: {$payload['summary']}\n";
    
    if (strlen($payload['text']) > 0) {
        echo "\nFirst 500 chars:\n";
        echo substr($payload['text'], 0, 500) . "\n";
    }
    
    echo "\nUpdating source...\n";
    $source->update([
        'status' => 'indexed',
        'summary' => $payload['summary'],
        'extracted_text' => $payload['text'],
        'metadata' => array_merge($source->metadata ?? [], $payload['metadata']),
        'indexed_at' => now(),
        'last_processed_at' => now(),
    ]);
    
    echo "Source updated successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
