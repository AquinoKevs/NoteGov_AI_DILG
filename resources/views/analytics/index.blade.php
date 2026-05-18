<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">Admin analytics</div>
            <div class="text-2xl font-bold text-white sm:text-3xl">Platform health, adoption, and AI processing visibility.</div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Users" :value="$totals['users']" hint="All registered accounts" accent="sky" />
            <x-stat-card label="Notebooks" :value="$totals['notebooks']" hint="Knowledge workspaces created" accent="amber" />
            <x-stat-card label="Sources" :value="$totals['sources']" hint="Files and links uploaded" accent="emerald" />
            <x-stat-card label="Indexed Sources" :value="$totals['indexed_sources']" hint="Ready for AI chat" accent="rose" />
        </div>

        <div class="grid gap-6 xl:grid-cols-[.8fr_.6fr_.6fr]">
            <div class="panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Latest activity</p>
                <div class="mt-5 space-y-3">
                    @foreach ($latestActivity as $activity)
                        <div class="panel-muted px-4 py-4">
                            <p class="text-sm font-semibold text-white">{{ $activity->description }}</p>
                            <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $activity->action }} • {{ $activity->created_at?->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Role distribution</p>
                <div class="mt-5 space-y-3">
                    @foreach ($roleDistribution as $row)
                        <div class="panel-muted flex items-center justify-between px-4 py-4">
                            <span class="text-sm font-semibold text-white">{{ str($row->role)->headline() }}</span>
                            <span class="text-sm text-slate-300">{{ $row->aggregate }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Source status mix</p>
                <div class="mt-5 space-y-3">
                    @foreach ($sourceStatuses as $row)
                        <div class="panel-muted flex items-center justify-between px-4 py-4">
                            <span class="text-sm font-semibold text-white">{{ str($row->status)->headline() }}</span>
                            <span class="text-sm text-slate-300">{{ $row->aggregate }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
