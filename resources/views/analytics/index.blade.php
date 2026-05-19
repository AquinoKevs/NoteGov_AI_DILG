<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="chip mb-2">Platform Overview</div>
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Admin Dashboard</h1>
            </div>
            <div class="flex gap-2">
                <button class="btn-secondary text-sm">Download Report</button>
                <button class="btn-primary text-sm">Refresh Data</button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 py-6">
        <!-- Top Stats Cards -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="panel bg-white p-6 shadow-sm border border-gray-100 rounded-3xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-sky-50 rounded-2xl text-sky-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Users</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totals['users']) }}</h3>
            </div>

            <div class="panel bg-white p-6 shadow-sm border border-gray-100 rounded-3xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-violet-50 rounded-2xl text-violet-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+8%</span>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Workspaces</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totals['notebooks']) }}</h3>
            </div>

            <div class="panel bg-white p-6 shadow-sm border border-gray-100 rounded-3xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-amber-50 rounded-2xl text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-lg">Live</span>
                </div>
                <p class="text-sm font-medium text-gray-500">Active Sessions</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totals['active_sessions']) }}</h3>
            </div>

            <div class="panel bg-white p-6 shadow-sm border border-gray-100 rounded-3xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-rose-50 rounded-2xl text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+24%</span>
                </div>
                <p class="text-sm font-medium text-gray-500">AI Requests</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totals['ai_requests']) }}</h3>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="panel bg-white p-6 shadow-sm border border-gray-100 rounded-3xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">User Activity & Workspace Growth</h3>
                    <select class="text-xs border-none bg-gray-50 rounded-lg focus:ring-0">
                        <option>Last 14 days</option>
                        <option>Last 30 days</option>
                    </select>
                </div>
                <div class="h-[300px] w-full">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            <div class="panel bg-white p-6 shadow-sm border border-gray-100 rounded-3xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">AI Analytics (Requests)</h3>
                    <div class="flex items-center gap-2">
                        <span class="flex items-center gap-1 text-xs text-gray-500"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Requests</span>
                    </div>
                </div>
                <div class="h-[300px] w-full">
                    <canvas id="aiChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Lower Section: Activity & Mix -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Latest Activity -->
            <div class="lg:col-span-2 panel bg-white p-6 shadow-sm border border-gray-100 rounded-3xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Latest Platform Activity</h3>
                    <a href="#" class="text-xs font-semibold text-sky-600 hover:text-sky-700">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-400 border-b border-gray-50">
                                <th class="pb-3 font-semibold">User</th>
                                <th class="pb-3 font-semibold">Action</th>
                                <th class="pb-3 font-semibold">Workspace</th>
                                <th class="pb-3 font-semibold">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($latestActivity as $activity)
                                <tr class="text-sm">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                                {{ strtoupper(substr($activity->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $activity->user->name ?? 'System' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-gray-600">{{ $activity->description }}</td>
                                    <td class="py-4">
                                        <span class="px-2 py-1 bg-gray-50 text-gray-600 rounded-lg text-xs font-medium">
                                            {{ $activity->notebook->title ?? 'Global' }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-gray-400 text-xs">{{ $activity->created_at?->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Source Mix -->
            <div class="panel bg-white p-6 shadow-sm border border-gray-100 rounded-3xl">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Source Status Mix</h3>
                <div class="space-y-4">
                    @foreach ($sourceStatuses as $row)
                        @php
                            $colors = [
                                'indexed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'bar' => 'bg-emerald-500'],
                                'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'bar' => 'bg-amber-500'],
                                'error' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'bar' => 'bg-rose-500'],
                                'processing' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'bar' => 'bg-sky-500'],
                            ];
                            $c = $colors[$row->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'bar' => 'bg-gray-500'];
                            $percentage = ($totals['sources'] > 0) ? ($row->aggregate / $totals['sources']) * 100 : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold {{ $c['text'] }}">{{ str($row->status)->headline() }}</span>
                                <span class="text-xs font-bold text-gray-400">{{ $row->aggregate }}</span>
                            </div>
                            <div class="w-full h-2 bg-gray-50 rounded-full overflow-hidden">
                                <div class="h-full {{ $c['bar'] }} rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 p-4 bg-sky-50 rounded-2xl">
                    <p class="text-xs font-bold text-sky-800 uppercase tracking-wider mb-1">Processing Power</p>
                    <p class="text-sm text-sky-700 leading-relaxed">System is operating at peak efficiency. {{ $totals['indexed_sources'] }} sources successfully indexed.</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctxActivity = document.getElementById('activityChart').getContext('2d');
            new Chart(ctxActivity, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [
                        {
                            label: 'Users',
                            data: @json($chartData['userActivity']),
                            borderColor: '#0ea5e9',
                            backgroundColor: 'rgba(14, 165, 233, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Workspaces',
                            data: @json($chartData['workspaceUsage']),
                            borderColor: '#8b5cf6',
                            backgroundColor: 'transparent',
                            fill: false,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6,
                                padding: 20,
                                font: { size: 11, weight: '600' }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            padding: 12,
                            backgroundColor: '#1e293b',
                            titleFont: { size: 13 },
                            bodyFont: { size: 13 },
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: true, color: '#f1f5f9' },
                            ticks: { font: { size: 11 }, color: '#94a3b8', padding: 10 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 }, color: '#94a3b8', padding: 10 }
                        }
                    }
                }
            });

            const ctxAi = document.getElementById('aiChart').getContext('2d');
            new Chart(ctxAi, {
                type: 'bar',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Requests',
                        data: @json($chartData['aiRequests']),
                        backgroundColor: '#f43f5e',
                        borderRadius: 6,
                        barThickness: 12,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 12,
                            backgroundColor: '#1e293b',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: true, color: '#f1f5f9' },
                            ticks: { font: { size: 11 }, color: '#94a3b8', padding: 10 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 }, color: '#94a3b8', padding: 10 }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
