<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">Dashboard</div>
            <div class="text-2xl font-bold text-gray-900 sm:text-3xl">Welcome back, {{ $user->name }}!</div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div class="panel p-6">
                <div class="text-sm font-semibold text-gray-500 mb-1">Total Notebooks</div>
                <div class="text-3xl font-bold text-gray-900">{{ $notebooks->count() }}</div>
            </div>
            <div class="panel p-6">
                <div class="text-sm font-semibold text-gray-500 mb-1">Categories</div>
                <div class="text-3xl font-bold text-gray-900">{{ $categories->count() }}</div>
            </div>
            <div class="panel p-6">
                <div class="text-sm font-semibold text-gray-500 mb-1">Your Role</div>
                <div class="text-3xl font-bold text-gray-900">{{ ucfirst($user->role) }}</div>
            </div>
            <div class="panel p-6">
                <div class="text-sm font-semibold text-gray-500 mb-1">Last Active</div>
                <div class="text-lg font-bold text-gray-900">{{ $user->last_active_at?->format('M d, Y') ?? 'Never' }}</div>
            </div>
        </div>

        <!-- Recent Notebooks -->
        <div class="panel p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Recent Notebooks</h2>
                <div class="flex items-center gap-3">
                    <a href="{{ route('notebooks.index') }}" class="text-sky-600 hover:text-sky-700 font-semibold text-sm">View all →</a>
                    <form method="POST" action="{{ route('notebooks.create.quick') }}">
                        @csrf
                        <button type="submit" class="btn-primary flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create notebook
                        </button>
                    </form>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($notebooks as $notebook)
                    <x-notebook-card :notebook="$notebook" />
                @empty
                    <div class="panel-muted col-span-full px-6 py-12 text-center">
                        <p class="text-xl font-semibold text-gray-900">No notebooks yet.</p>
                        <a href="{{ route('notebooks.create') }}" class="btn-primary mt-6">Create Notebook</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
