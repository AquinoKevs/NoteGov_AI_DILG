<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NoteGov AI DILG') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|space-grotesk:400,500,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @php
            $user = auth()->user();
            $unreadNotifications = $user?->unreadNotifications()->count() ?? 0;
        @endphp

        <div x-data="{ navOpen: false }" class="relative min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-0 opacity-70">
                <div class="absolute inset-x-0 top-0 h-72 bg-[radial-gradient(circle_at_top,rgba(56,189,248,0.18),transparent_55%)]"></div>
                <div class="absolute -left-24 top-1/3 h-72 w-72 rounded-full bg-amber-400/10 blur-3xl"></div>
                <div class="absolute -right-20 top-28 h-80 w-80 rounded-full bg-sky-400/10 blur-3xl"></div>
            </div>

            <div class="relative flex min-h-screen">
                <aside class="hidden w-80 shrink-0 border-r border-white/8 bg-slate-950/70 px-6 py-6 backdrop-blur-xl xl:flex xl:flex-col">
                    <a href="{{ route('dashboard') }}" class="panel aurora-border flex items-center gap-4 px-4 py-4">
                        <x-application-logo class="h-12 w-12 shrink-0" />
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-200/80">Governance AI</p>
                            <p class="text-lg font-bold text-white">NoteGov AI DILG</p>
                        </div>
                    </a>

                    <div class="mt-8 space-y-2 text-sm">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('dashboard') ? 'bg-sky-400/15 text-white' : 'text-slate-300 hover:bg-white/6 hover:text-white' }}">
                            <span>Dashboard</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-slate-500">01</span>
                        </a>
                        <a href="{{ route('notebooks.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('notebooks.*') ? 'bg-sky-400/15 text-white' : 'text-slate-300 hover:bg-white/6 hover:text-white' }}">
                            <span>Notebooks</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-slate-500">02</span>
                        </a>
                        <a href="{{ route('notifications.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('notifications.*') ? 'bg-sky-400/15 text-white' : 'text-slate-300 hover:bg-white/6 hover:text-white' }}">
                            <span>Notifications</span>
                            <span class="rounded-full bg-white/10 px-2 py-0.5 text-[10px] font-semibold text-slate-200">{{ $unreadNotifications }}</span>
                        </a>
                        @if ($user?->isAdmin())
                            <a href="{{ route('analytics') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('analytics') ? 'bg-sky-400/15 text-white' : 'text-slate-300 hover:bg-white/6 hover:text-white' }}">
                                <span>Admin Analytics</span>
                                <span class="text-xs uppercase tracking-[0.22em] text-slate-500">03</span>
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('profile.*') ? 'bg-sky-400/15 text-white' : 'text-slate-300 hover:bg-white/6 hover:text-white' }}">
                            <span>Profile</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-slate-500">04</span>
                        </a>
                    </div>

                    <div class="panel mt-8 space-y-4 p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Workspace</p>
                            <span class="chip">AI Ready</span>
                        </div>
                        <div class="grid gap-3">
                            <div class="panel-muted px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Role</p>
                                <p class="mt-2 text-lg font-semibold text-white">{{ str($user?->role ?? 'staff')->headline() }}</p>
                            </div>
                            <div class="panel-muted px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Office</p>
                                <p class="mt-2 text-sm text-slate-200">{{ $user?->office ?: 'DILG Knowledge Operations' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="floating-grid panel mt-auto overflow-hidden px-5 py-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Mission Focus</p>
                        <h3 class="mt-3 text-xl font-bold text-white">Policy-grade answers, built from your own notebook sources.</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Upload documents, websites, audio, and videos. Then ask for reports, action items, comparisons, and governance insights in one workspace.</p>
                    </div>
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 border-b border-white/8 bg-slate-950/60 backdrop-blur-xl">
                        <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                            <div class="flex min-w-0 items-center gap-3">
                                <button type="button" class="btn-secondary xl:hidden" @click="navOpen = true">Menu</button>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">DILG Knowledge Assistant</p>
                                    <div class="truncate text-lg font-bold text-white">
                                        @isset($header)
                                            {{ $header }}
                                        @else
                                            NoteGov AI DILG
                                        @endisset
                                    </div>
                                </div>
                            </div>

                            <div class="hidden flex-1 items-center justify-end gap-3 lg:flex">
                                <form action="{{ route('dashboard') }}" method="GET" class="w-full max-w-sm">
                                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search notebooks, reports, or source topics" class="input-shell">
                                </form>
                                <a href="{{ route('notebooks.create') }}" class="btn-primary">New Notebook</a>
                                <a href="{{ route('notifications.index') }}" class="btn-secondary">Alerts {{ $unreadNotifications > 0 ? "({$unreadNotifications})" : '' }}</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn-secondary">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <div x-show="navOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/80 xl:hidden" @click="navOpen = false"></div>
                    <aside x-show="navOpen" x-transition class="fixed inset-y-0 left-0 z-50 w-80 border-r border-white/10 bg-slate-950/96 px-5 py-6 backdrop-blur-xl xl:hidden">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                                <x-application-logo class="h-10 w-10" />
                                <div>
                                    <p class="text-xs uppercase tracking-[0.24em] text-slate-400">NoteGov AI DILG</p>
                                    <p class="font-semibold text-white">Navigation</p>
                                </div>
                            </a>
                            <button type="button" class="btn-secondary" @click="navOpen = false">Close</button>
                        </div>
                        <div class="mt-8 space-y-2">
                            <a href="{{ route('dashboard') }}" class="block rounded-2xl px-4 py-3 text-slate-200 hover:bg-white/6">Dashboard</a>
                            <a href="{{ route('notebooks.index') }}" class="block rounded-2xl px-4 py-3 text-slate-200 hover:bg-white/6">Notebooks</a>
                            @if ($user?->isAdmin())
                                <a href="{{ route('analytics') }}" class="block rounded-2xl px-4 py-3 text-slate-200 hover:bg-white/6">Admin Analytics</a>
                            @endif
                            <a href="{{ route('notifications.index') }}" class="block rounded-2xl px-4 py-3 text-slate-200 hover:bg-white/6">Notifications</a>
                            <a href="{{ route('profile.edit') }}" class="block rounded-2xl px-4 py-3 text-slate-200 hover:bg-white/6">Profile</a>
                        </div>
                    </aside>

                    <main class="relative flex-1 px-4 pb-10 pt-6 sm:px-6 lg:px-8">
                        @if (session('status'))
                            <div class="panel mb-6 border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
