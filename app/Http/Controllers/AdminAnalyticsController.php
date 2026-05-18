<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Notebook;
use App\Models\Source;
use App\Models\User;
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
                'users' => User::count(),
                'admins' => User::where('role', User::ROLE_ADMIN)->count(),
                'staff' => User::where('role', User::ROLE_STAFF)->count(),
                'viewers' => User::where('role', User::ROLE_VIEWER)->count(),
                'notebooks' => Notebook::count(),
                'sources' => Source::count(),
                'indexed_sources' => Source::where('status', 'indexed')->count(),
            ],
            'latestActivity' => ActivityLog::with(['user', 'notebook'])->latest('created_at')->limit(12)->get(),
            'roleDistribution' => User::query()
                ->selectRaw('role, count(*) as aggregate')
                ->groupBy('role')
                ->orderBy('role')
                ->get(),
            'sourceStatuses' => Source::query()
                ->selectRaw('status, count(*) as aggregate')
                ->groupBy('status')
                ->orderBy('status')
                ->get(),
        ]);
    }
}
