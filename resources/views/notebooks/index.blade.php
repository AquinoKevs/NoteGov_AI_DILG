<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">Notebook directory</div>
            <div class="text-2xl font-bold text-white sm:text-3xl">Browse every governance notebook you can access.</div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="panel p-6">
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
                    <p class="text-xl font-semibold text-white">No notebooks matched your filters.</p>
                    <p class="mt-2 text-sm text-slate-300">Try a broader search or create a new governance notebook.</p>
                    <a href="{{ route('notebooks.create') }}" class="btn-primary mt-6">Create Notebook</a>
                </div>
            @endforelse
        </div>

        <div>
            {{ $notebooks->links() }}
        </div>
    </div>
</x-app-layout>
