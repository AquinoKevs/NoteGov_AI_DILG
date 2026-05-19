<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking sources:\n";
echo "================\n\n";

$sources = App\Models\Source::latest()->take(5)->get();

foreach ($sources as $source) {
    echo "ID: {$source->id}\n";
    echo "Name: {$source->name}\n";
    echo "Status: {$source->status}\n";
    echo "Extracted text length: " . strlen($source->extracted_text ?? '') . "\n";
    
    if (strlen($source->extracted_text ?? '') > 0) {
        echo "First 300 chars:\n";
        echo substr($source->extracted_text, 0, 300) . "\n";
    } else {
        echo "NO EXTRACTED TEXT!\n";
    }
    
    echo "\n---\n\n";
}
