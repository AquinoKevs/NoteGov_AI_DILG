<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Notebook;
use App\Services\NotebookInsightsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, NotebookInsightsService $insights): View
    {
        $user = $request->user();
        $search = trim((string) $request->input('search'));
        $sort = (string) $request->input('sort', 'recent');

        $baseQuery = Notebook::query()
            ->with(['owner', 'category'])
            ->withCount(['sources', 'chats', 'members'])
            ->accessibleBy($user);

        if ($search !== '') {
            $baseQuery->where(function ($query) use ($search): void {
                $query
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        match ($sort) {
            'title' => $baseQuery->orderBy('title'),
            'oldest' => $baseQuery->oldest('created_at'),
            default => $baseQuery->orderByDesc('last_activity_at')->orderByDesc('updated_at'),
        };

        $recentNotebooks = (clone $baseQuery)->limit(6)->get();
        $featuredNotebooks = Notebook::query()
            ->with(['owner', 'category'])
            ->withCount(['sources', 'chats'])
            ->accessibleBy($user)
            ->whereNotNull('featured_at')
            ->orderByDesc('featured_at')
            ->limit(4)
            ->get();

        if ($featuredNotebooks->isEmpty()) {
            $featuredNotebooks = (clone $baseQuery)->limit(4)->get();
        }

        $activities = ActivityLog::query()
            ->with(['user', 'notebook', 'source'])
            ->whereHas('notebook', fn ($notebookQuery) => $notebookQuery->accessibleBy($user))
            ->latest('created_at')
            ->limit(8)
            ->get();

        $categoryBreakdown = Category::query()
            ->withCount(['notebooks' => fn ($query) => $query->accessibleBy($user)])
            ->orderByDesc('notebooks_count')
            ->limit(6)
            ->get();

        $stats = [
            'notebooks' => Notebook::query()->accessibleBy($user)->count(),
            'sources' => \App\Models\Source::query()->whereHas('notebook', fn ($query) => $query->accessibleBy($user))->count(),
            'chats' => \App\Models\Chat::query()->whereHas('notebook', fn ($query) => $query->accessibleBy($user))->count(),
            'pending_sources' => \App\Models\Source::query()
                ->whereHas('notebook', fn ($query) => $query->accessibleBy($user))
                ->whereIn('status', ['queued', 'processing'])
                ->count(),
        ];

        $workspaceHighlight = $recentNotebooks->first();
        $highlightInsights = $workspaceHighlight ? $insights->buildWorkspace($workspaceHighlight) : null;

        return view('dashboard', compact(
            'search',
            'sort',
            'stats',
            'recentNotebooks',
            'featuredNotebooks',
            'categoryBreakdown',
            'activities',
            'workspaceHighlight',
            'highlightInsights',
        ));
    }
}
