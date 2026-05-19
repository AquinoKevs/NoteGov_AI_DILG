<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">Notebook directory</div>
            <div class="text-2xl font-bold text-gray-900 sm:text-3xl">Browse every governance notebook in the shared workspace.</div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="panel p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Filters</h3>
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
            <form method="GET" class="grid gap-4 lg:grid-cols-[1fr_220px_auto]">
                <input type="search" name="search" value="{{ $search }}" placeholder="Search notebook titles" class="input-shell">
                <select name="category_id" class="input-shell">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button class="btn-primary" type="submit">Apply Filters</button>
            </form>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($notebooks as $notebook)
                <x-notebook-card :notebook="$notebook" />
            @empty
                <div class="panel-muted col-span-full px-6 py-12 text-center">
                    <p class="text-xl font-semibold text-gray-900">No notebooks matched your filters.</p>
                    <p class="mt-2 text-sm text-gray-600">Try a broader search or create a new governance notebook.</p>
                    <form method="POST" action="{{ route('notebooks.create') }}" class="inline-block mt-6">
                        @csrf
                        <button type="submit" class="btn-primary">Create Notebook</button>
                    </form>
                </div>
            @endforelse
        </div>

        <div>
            {{ $notebooks->links() }}
        </div>
    </div>
</x-app-layout>
