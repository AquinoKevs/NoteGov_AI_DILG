<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notebook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotebookApiController extends Controller
{
    /**
     * Display a listing of accessible notebooks.
     */
    public function index(Request $request): JsonResponse
    {
        $notebooks = Notebook::query()
            ->with(['owner', 'category'])
            ->withCount(['sources', 'chats', 'members'])
            ->accessibleBy($request->user())
            ->orderByDesc('last_activity_at')
            ->paginate(10);

        return response()->json($notebooks);
    }

    /**
     * Display the specified notebook.
     */
    public function show(Request $request, Notebook $notebook): JsonResponse
    {
        $this->authorize('view', $notebook);

        $notebook->load(['owner', 'category', 'members', 'sources', 'chats.messages']);

        return response()->json($notebook);
    }
}
