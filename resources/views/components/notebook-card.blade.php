@props(['notebook'])

<a href="{{ route('notebooks.show', $notebook) }}" class="group panel block overflow-hidden p-4 transition hover:-translate-y-1 hover:border-sky-300/20 hover:bg-white/7">
    <div class="rounded-[22px] p-5 text-white" style="background: linear-gradient(135deg, {{ $notebook->cover_color ?? '#1f6feb' }} 0%, rgba(8,15,31,0.95) 85%);">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-white/65">{{ $notebook->category?->name ?: 'General notebook' }}</p>
                <h3 class="mt-3 text-xl font-bold">{{ $notebook->title }}</h3>
            </div>
            <span class="chip border-white/15 bg-black/20 text-white/80">{{ str($notebook->visibility)->headline() }}</span>
        </div>
        <p class="mt-4 line-clamp-3 text-sm leading-6 text-white/78">{{ $notebook->summary ?: \Illuminate\Support\Str::limit(strip_tags($notebook->description ?: 'AI-ready governance notebook for policies, projects, and local government operations.'), 160) }}</p>
    </div>

    <div class="mt-4 flex items-center justify-between text-sm text-slate-300">
        <div class="flex items-center gap-3">
            <span>{{ $notebook->sources_count ?? $notebook->sources()->count() }} sources</span>
            <span>{{ $notebook->chats_count ?? $notebook->chats()->count() }} chats</span>
        </div>
        <span class="text-slate-400">Updated {{ optional($notebook->last_activity_at ?? $notebook->updated_at)->diffForHumans() }}</span>
    </div>
</a>
