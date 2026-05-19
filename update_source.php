<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Source;
use App\Services\DocumentIngestionService;

echo "Updating source...\n";

$source = Source::find(4);

if (!$source) {
    echo "Source not found!\n";
    exit(1);
}

$ingestion = app(DocumentIngestionService::class);
$payload = $ingestion->extractContent($source);

// Truncate to 50,000 characters to fit in database
$truncatedText = substr($payload['text'], 0, 50000);

echo "Updating source with truncated text (" . strlen($truncatedText) . " chars)...\n";

$source->status = 'indexed';
$source->summary = $payload['summary'];
$source->extracted_text = $truncatedText;
$source->indexed_at = now();
$source->last_processed_at = now();
$source->save();

echo "Source updated successfully!\n";
echo "Now go to your notebook and ask a question!\n";
