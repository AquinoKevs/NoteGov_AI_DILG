<x-app-layout>
    <div class="space-y-8">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-600 mb-2">DILG KNOWLEDGE ASSISTANT</p>
                <h1 class="text-3xl font-bold text-gray-900">Notebooks</h1>
                <p class="text-gray-500 mt-2">Create, manage, and collaborate on AI-powered notebooks.</p>
            </div>
            <form method="POST" action="{{ route('notebooks.create.quick') }}">
                @csrf
                <button type="submit" class="btn-premium text-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create notebook
                </button>
            </form>
        </div>

        <!-- Top Statistics Section -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="glass-panel bg-white p-5 border border-gray-100 rounded-2xl shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-gray-500 mt-3">Total Notebooks</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totals['notebooks'] ?? $notebooks->count()) }}</h3>
                <p class="text-[11px] text-gray-400 mt-2">All notebooks in workspace</p>
            </div>

            <div class="glass-panel bg-white p-5 border border-gray-100 rounded-2xl shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="p-3 bg-violet-50 rounded-xl text-violet-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-gray-500 mt-3">Categories</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($categories->count()) }}</h3>
                <p class="text-[11px] text-gray-400 mt-2">Notebook categories</p>
            </div>

            <div class="glass-panel bg-white p-5 border border-gray-100 rounded-2xl shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="p-3 bg-green-50 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-gray-500 mt-3">Your Role</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ ucfirst(auth()->user()->role ?? 'User') }}</h3>
                <div class="mt-2">
                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-semibold text-green-700">Full Access</span>
                </div>
            </div>

            <div class="glass-panel bg-white p-5 border border-gray-100 rounded-2xl shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-gray-500 mt-3">Last Active</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ now()->format('M d, Y') }}</h3>
                <p class="text-[11px] text-gray-400 mt-2">Your last active date</p>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="flex items-center gap-4 flex-wrap">
            <form method="GET" class="flex items-center gap-4 flex-1 min-w-[300px]">
                <div class="relative flex-1 max-w-md">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="search" name="search" value="{{ $search }}" placeholder="Search notebook titles..." class="search-input !py-3">
                </div>
                <select name="category_id" class="btn-premium-glass min-w-[180px]">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-premium-glass px-4 py-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filters
                </button>
            </form>
        </div>

        <!-- Recent Notebooks Section -->
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-semibold text-gray-900">Recent Notebooks</h2>
                <div class="flex items-center gap-3">
                    <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700">View all</a>
                    <div class="flex items-center gap-2">
                        <button class="p-2 rounded-lg bg-blue-50 text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                            </svg>
                        </button>
                        <button class="p-2 rounded-lg text-gray-400 hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            @if($notebooks->count() > 0)
                <div class="max-w-md">
                    <x-notebook-card :notebook="$notebooks->first()" />
                </div>
            @else
                <div class="glass-panel col-span-full px-10 py-16 text-center rounded-3xl">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.831 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <p class="text-xl font-semibold text-gray-900">No notebooks matched your filters.</p>
                    <p class="mt-2 text-sm text-gray-600">Try a broader search or create a new governance notebook.</p>
                    <form method="POST" action="{{ route('notebooks.create') }}" class="inline-block mt-8">
                        @csrf
                        <button type="submit" class="btn-premium">Create Notebook</button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Security Section -->
        <div class="mt-12 glass-panel rounded-3xl p-6 border border-gray-100">
            <div class="flex items-center justify-between gap-6 flex-wrap">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Secured. Reliable. Government-Grade.</h3>
                        <p class="text-xs text-gray-500 mt-1">Your data is encrypted and protected with enterprise-grade security and compliance standards.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2 text-xs text-gray-600 bg-gray-50 px-4 py-2 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        NoteGov AI DILG Platform
                    </div>
                </div>
            </div>
        </div>

        <div>
            {{ $notebooks->links() }}
        </div>
    </div>
</x-app-layout>
