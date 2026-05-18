<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSourceRequest;
use App\Models\Notebook;
use App\Models\Source;
use App\Services\ActivityLogger;
use App\Services\DocumentIngestionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function __construct(
        protected DocumentIngestionService $ingestion,
        protected ActivityLogger $activityLogger,
    ) {}

    /**
     * Store a newly uploaded source.
     */
    public function store(StoreSourceRequest $request, Notebook $notebook): RedirectResponse
    {
        $source = $this->ingestion->createSource(
            $notebook,
            $request->validated(),
            $request->file('upload_file'),
            $request->user()
        );

        return redirect()
            ->route('notebooks.show', $notebook)
            ->with('status', "Source {$source->name} uploaded and queued for indexing.");
    }

    /**
     * Remove the specified source.
     */
    public function destroy(Request $request, Notebook $notebook, Source $source): RedirectResponse
    {
        $this->authorize('delete', $source);

        $this->ingestion->deleteSource($source);

        $this->activityLogger->log(
            $request->user(),
            'source.deleted',
            "Deleted source {$source->name}.",
            $notebook,
            $source,
            [],
            $request->ip(),
            $request->userAgent()
        );

        $source->delete();

        return redirect()
            ->route('notebooks.show', $notebook)
            ->with('status', 'Source deleted.');
    }
}
