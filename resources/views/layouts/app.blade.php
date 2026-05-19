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
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-500">Knowledge Hub</p>
                            <p class="text-lg font-bold text-gray-900">NoteGov AI</p>
                        </div>
                    </a>

                    <div class="mt-8 space-y-2 text-sm">
                        <a href="{{ route('notebooks.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('notebooks.*') && !request()->routeIs('notebooks.show') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span>My Workspace</span>
                            </div>
                        </a>

                        @if(auth()->user()->role === 'admin')
                            <div class="pt-4 pb-2">
                                <p class="px-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Admin Tools</p>
                            </div>
                            <a href="{{ route('analytics') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('analytics') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <span>Admin Dashboard</span>
                                </div>
                            </a>
                            <a href="{{ route('users.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('users.*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span>User Management</span>
                                </div>
                            </a>
                            <a href="{{ route('settings.index') }}" class="flex items-center justify-between rounded-2xl px-4 py-3 transition {{ request()->routeIs('settings.*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>System Settings</span>
                                </div>
                            </a>
                        @endif
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
                        <div class="mt-8 space-y-2">
                            <a href="{{ route('notebooks.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('notebooks.*') ? 'bg-sky-50 text-sky-700' : '' }}">My Workspace</a>
                            @if(auth()->user()->role === 'admin')
                                <div class="pt-4 pb-2 px-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Admin Tools</div>
                                <a href="{{ route('analytics') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('analytics') ? 'bg-sky-50 text-sky-700' : '' }}">Admin Dashboard</a>
                                <a href="{{ route('users.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('users.*') ? 'bg-sky-50 text-sky-700' : '' }}">User Management</a>
                                <a href="{{ route('settings.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('settings.*') ? 'bg-sky-50 text-sky-700' : '' }}">System Settings</a>
                            @endif
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
        @stack('scripts')
    </body>
</html>
