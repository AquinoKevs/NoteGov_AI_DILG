<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Chat;
use App\Models\Notebook;
use App\Models\Source;
use Illuminate\View\View;

class AdminAnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard.
     */
    public function __invoke(): View
    {
        return view('analytics.index', [
            'totals' => [
                'notebooks' => Notebook::count(),
                'sources' => Source::count(),
                'indexed_sources' => Source::where('status', 'indexed')->count(),
                'active_chats' => Chat::count(),
            ],
            'latestActivity' => ActivityLog::with(['user', 'notebook'])->latest('created_at')->limit(12)->get(),
            'sourceStatuses' => Source::query()
                ->selectRaw('status, count(*) as aggregate')
                ->groupBy('status')
                ->orderBy('status')
                ->get(),
        ]);
    }
}
