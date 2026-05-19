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

                    <div class="mt-8 space-y-2 text-sm" x-data="{ systemSettingsOpen: false }">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span>Dashboard</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-gray-400">01</span>
                        </a>

                        <a href="{{ route('users.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('users.*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span>User Management</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-gray-400">02</span>
                        </a>

                        <a href="{{ route('notebooks.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('notebooks.*') && !request()->routeIs('notebooks.show') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span>Workspace</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-gray-400">03</span>
                        </a>

                        <button @click="systemSettingsOpen = !systemSettingsOpen" class="flex items-center justify-between rounded-2xl px-4 py-3 transition w-full text-left text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <span>System Settings</span>
                            <span class="text-xs uppercase tracking-[0.22em] text-gray-400">04</span>
                        </button>

                        <div x-show="systemSettingsOpen" x-transition class="pl-4 space-y-1">
                            <a href="{{ route('notebooks.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('notebooks.*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span>Feature Notebooks</span>
                            </a>
                        </div>
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
                                @auth
                                    <div x-data="{ appUserMenuOpen: false }" class="relative">
                                        <button @click="appUserMenuOpen = !appUserMenuOpen" class="w-10 h-10 bg-gradient-to-br from-violet-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold cursor-pointer border-none">
                                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                        </button>
                                        <div x-show="appUserMenuOpen" @click.outside="appUserMenuOpen = false" class="absolute top-12 right-0 bg-white border border-gray-200 rounded-2xl shadow-xl min-w-[200px] z-50">
                                            <div class="px-5 py-4 border-b border-gray-200">
                                                <p class="font-bold text-gray-900 text-sm">{{ Auth::user()->name ?? 'User' }}</p>
                                                <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email ?? '' }}</p>
                                            </div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full text-left px-5 py-3 text-red-500 font-semibold text-sm hover:bg-gray-50 transition">
                                                    Log out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endauth
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
                        <div class="mt-8 space-y-2" x-data="{ mobileSystemSettingsOpen: false }">
                            <a href="{{ route('dashboard') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold">Dashboard</a>
                            <a href="{{ route('users.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold">User Management</a>
                            <a href="{{ route('notebooks.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold">Workspace</a>
                            <button @click="mobileSystemSettingsOpen = !mobileSystemSettingsOpen" class="flex items-center justify-between rounded-2xl px-4 py-3 w-full text-left text-gray-700 hover:bg-gray-50 font-semibold">
                                <span>System Settings</span>
                            </button>
                            <div x-show="mobileSystemSettingsOpen" x-transition class="pl-4 space-y-1">
                                <a href="{{ route('notebooks.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold">Feature Notebooks</a>
                            </div>
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
