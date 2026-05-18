<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">Operational intelligence</div>
            <div class="text-2xl font-bold text-white sm:text-3xl">Governance notebooks, grounded answers, and AI-ready source workspaces.</div>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[1.3fr_.7fr]">
        <section class="space-y-6">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <x-stat-card label="Accessible Notebooks" :value="$stats['notebooks']" hint="Your active knowledge spaces" accent="sky" />
                <x-stat-card label="Indexed Sources" :value="$stats['sources']" hint="Documents and links in scope" accent="amber" />
                <x-stat-card label="Active Chats" :value="$stats['chats']" hint="Notebook-specific AI threads" accent="emerald" />
                <x-stat-card label="Pending Processing" :value="$stats['pending_sources']" hint="Queued for AI indexing" accent="rose" />
            </div>

            <div class="panel p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Recent notebooks</p>
                        <h2 class="mt-2 text-2xl font-bold text-white">Continue where your governance work left off.</h2>
                    </div>
                    <a href="{{ route('notebooks.create') }}" class="btn-primary">Create New Notebook</a>
                </div>

                <div class="mt-6 grid gap-4 lg:grid-cols-2">
                    @forelse ($recentNotebooks as $notebook)
                        <x-notebook-card :notebook="$notebook" />
                    @empty
                        <div class="panel-muted col-span-full px-6 py-10 text-center">
                            <p class="text-lg font-semibold text-white">No notebooks yet</p>
                            <p class="mt-2 text-sm text-slate-300">Start a notebook for policies, LGU research, project updates, or governance reference materials.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="panel p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Featured workspaces</p>
                        <h2 class="mt-2 text-2xl font-bold text-white">Priority notebooks for current initiatives.</h2>
                    </div>
                    <a href="{{ route('notebooks.index') }}" class="btn-secondary">Browse all</a>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    @foreach ($featuredNotebooks as $notebook)
                        <x-notebook-card :notebook="$notebook" />
                    @endforeach
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">AI Workspace Highlight</p>
                @if ($workspaceHighlight && $highlightInsights)
                    <h2 class="mt-2 text-2xl font-bold text-white">{{ $workspaceHighlight->title }}</h2>
                    <p class="mt-4 text-sm leading-7 text-slate-300">{{ $highlightInsights['summary'] }}</p>

                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($highlightInsights['smart_tags'] as $tag)
                            <span class="chip">{{ $tag }}</span>
                        @endforeach
                    </div>

                    <div class="mt-6 space-y-3">
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Suggested questions</p>
                        @foreach ($highlightInsights['suggested_questions'] as $question)
                            <div class="panel-muted px-4 py-3 text-sm text-slate-200">{{ $question }}</div>
                        @endforeach
                    </div>

                    <a href="{{ route('notebooks.show', $workspaceHighlight) }}" class="btn-primary mt-6 w-full">Open Workspace</a>
                @else
                    <div class="panel-muted mt-4 px-5 py-6 text-sm text-slate-300">
                        Create your first notebook to unlock summaries, smart tags, suggested prompts, and AI chat grounded in your own sources.
                    </div>
                @endif
            </div>

            <div class="panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Category Breakdown</p>
                <div class="mt-5 space-y-3">
                    @forelse ($categoryBreakdown as $category)
                        <div class="panel-muted flex items-center justify-between px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="h-3 w-3 rounded-full" style="background-color: {{ $category->color }}"></span>
                                <span class="text-sm text-slate-200">{{ $category->name }}</span>
                            </div>
                            <span class="text-sm font-semibold text-white">{{ $category->notebooks_count }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">Categories will appear once notebooks are created.</p>
                    @endforelse
                </div>
            </div>

            <div class="panel p-6">
                <div class="flex items-center justify-between">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Activity History</p>
                    <a href="{{ route('notifications.index') }}" class="text-sm text-sky-200">View alerts</a>
                </div>
                <div class="mt-5 space-y-3">
                    @forelse ($activities as $activity)
                        <div class="panel-muted px-4 py-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-semibold text-white">{{ $activity->description }}</p>
                                <span class="text-xs text-slate-500">{{ $activity->created_at?->diffForHumans() }}</span>
                            </div>
                            <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $activity->action }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">Recent uploads, sharing activity, and AI actions will appear here.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</x-app-layout>
