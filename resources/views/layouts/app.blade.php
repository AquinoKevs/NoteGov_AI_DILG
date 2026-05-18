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
    <body class="font-sans antialiased bg-gray-50">
        <div x-data="{ navOpen: false }" class="relative min-h-screen overflow-hidden">
            <div class="relative flex min-h-screen">
                <aside class="hidden w-80 shrink-0 border-r border-gray-200 bg-white px-6 py-6 xl:flex xl:flex-col">
                    <a href="{{ route('dashboard') }}" class="panel flex items-center gap-4 px-4 py-4">
                        <x-application-logo class="h-12 w-12 shrink-0" />
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-500">Governance AI</p>
                            <p class="text-lg font-bold text-gray-900">NoteGov AI DILG</p>
                        </div>
                    </a>

                    <div class="mt-8 space-y-2 text-sm">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span>Dashboard</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-gray-400">01</span>
                        </a>
                        <a href="{{ route('notebooks.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('notebooks.*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span>Notebooks</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-gray-400">02</span>
                        </a>
                        <a href="{{ route('analytics') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('analytics') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span>Analytics</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-gray-400">03</span>
                        </a>
                    </div>

                    <div class="panel mt-8 space-y-4 p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-gray-500">Workspace</p>
                            <span class="chip bg-emerald-50 text-emerald-700 border-emerald-200">Open Access</span>
                        </div>
                        <div class="grid gap-3">
                            <div class="border border-gray-100 rounded-2xl px-4 py-3 bg-gray-50">
                                <p class="text-xs uppercase tracking-[0.22em] text-gray-500">Mode</p>
                                <p class="mt-2 text-lg font-semibold text-gray-900">Shared knowledge workspace</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl px-4 py-3 bg-gray-50">
                                <p class="text-xs uppercase tracking-[0.22em] text-gray-500">Office</p>
                                <p class="mt-2 text-sm text-gray-700">DILG Knowledge Operations</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel mt-auto overflow-hidden px-5 py-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-gray-500">Mission Focus</p>
                        <h3 class="mt-3 text-xl font-bold text-gray-900 leading-tight">Policy-grade answers, built from your own notebook sources.</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Upload documents, websites, audio, and videos. Then ask for reports, action items, comparisons, and governance insights in one workspace.</p>
                    </div>
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 border-b border-gray-200 bg-white">
                        <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                            <div class="flex min-w-0 items-center gap-3">
                                <button type="button" class="btn-secondary xl:hidden" @click="navOpen = true">Menu</button>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gray-500">DILG Knowledge Assistant</p>
                                    <div class="truncate text-lg font-bold text-gray-900">
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
                                <a href="{{ route('analytics') }}" class="btn-secondary">Analytics</a>
                            </div>
                        </div>
                    </header>

                    <div x-show="navOpen" x-transition.opacity class="fixed inset-0 z-40 bg-gray-900/50 xl:hidden" @click="navOpen = false"></div>
                    <aside x-show="navOpen" x-transition class="fixed inset-y-0 left-0 z-50 w-80 border-r border-gray-200 bg-white px-5 py-6 xl:hidden">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                                <x-application-logo class="h-10 w-10" />
                                <div>
                                    <p class="text-xs uppercase tracking-[0.24em] text-gray-500">NoteGov AI DILG</p>
                                    <p class="font-semibold text-gray-900">Navigation</p>
                                </div>
                            </a>
                            <button type="button" class="btn-secondary" @click="navOpen = false">Close</button>
                        </div>
                        <div class="mt-8 space-y-2">
                            <a href="{{ route('dashboard') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold">Dashboard</a>
                            <a href="{{ route('notebooks.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold">Notebooks</a>
                            <a href="{{ route('analytics') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold">Analytics</a>
                        </div>
                    </aside>

                    <main class="relative flex-1 px-4 pb-10 pt-6 sm:px-6 lg:px-8">
                        @if (session('status'))
                            <div class="panel mb-6 border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
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
