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
    <body class="font-sans antialiased bg-pattern">
        <div x-data="{ navOpen: false }" class="relative min-h-screen overflow-hidden">
            <div class="relative flex min-h-screen">
                <aside class="hidden w-72 shrink-0 xl:flex xl:flex-col relative overflow-hidden" style="background: linear-gradient(180deg, #031B4E 0%, #071A3F 100%);">
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-full" style="background: radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.15) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(37, 99, 235, 0.1) 0%, transparent 50%);"></div>
                    </div>
                    
                    <div class="relative z-10 px-6 py-8 flex flex-col h-full">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-[0_4px_20px_rgba(59,130,246,0.4)]">
                                <x-application-logo class="h-7 w-7 shrink-0" />
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.28em] text-blue-300">DILG</p>
                                <p class="text-xl font-bold text-white">NoteGov AI</p>
                            </div>
                        </a>

                        <div class="mt-10 space-y-1.5">
                            <a href="{{ route('notebooks.index') }}" class="sidebar-nav-item {{ request()->routeIs('notebooks.*') && !request()->routeIs('notebooks.show') ? 'sidebar-nav-item-active' : 'sidebar-nav-item-inactive' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.831 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span>My Workspace</span>
                            </a>

                            @if(auth()->user()->role === 'admin')
                                <div class="pt-5 pb-3">
                                    <p class="px-4 text-[11px] font-bold uppercase tracking-[0.25em] text-gray-500">Admin Tools</p>
                                </div>
                                <a href="{{ route('analytics') }}" class="sidebar-nav-item {{ request()->routeIs('analytics') ? 'sidebar-nav-item-active' : 'sidebar-nav-item-inactive' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <span>Admin Dashboard</span>
                                </a>
                                <a href="{{ route('users.index') }}" class="sidebar-nav-item {{ request()->routeIs('users.*') ? 'sidebar-nav-item-active' : 'sidebar-nav-item-inactive' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span>User Management</span>
                                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                </a>
                                <a href="{{ route('settings.index') }}" class="sidebar-nav-item {{ request()->routeIs('settings.*') ? 'sidebar-nav-item-active' : 'sidebar-nav-item-inactive' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>System Settings</span>
                                </a>
                            @endif
                        </div>

                        <div class="mt-auto">
                            <div class="profile-glass-card p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-white truncate">Knowledge Admin</p>
                                        <p class="text-xs text-blue-200 truncate">Super Administrator</p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 nav-glass">
                        <div class="flex items-center justify-between gap-4 px-6 py-5">
                            <div class="flex min-w-0 items-center gap-3">
                                <button type="button" class="btn-premium-glass xl:hidden" @click="navOpen = true">Menu</button>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-600">DILG KNOWLEDGE ASSISTANT</p>
                                </div>
                            </div>

                            <div class="hidden flex-1 items-center justify-end gap-3 lg:flex">
                                @auth
                                    <button class="p-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                        </svg>
                                    </button>
                                    <div class="h-8 w-px bg-gray-200"></div>
                                    <div x-data="{ appUserMenuOpen: false }" class="relative">
                                        <button @click="appUserMenuOpen = !appUserMenuOpen" class="flex items-center gap-3 px-3 py-2 rounded-xl border border-gray-200 bg-white hover:border-gray-300 hover:bg-gray-50 transition-all">
                                            <img src="{{ asset('images/dilg-logo.png') }}" alt="DILG" class="w-6 h-6 rounded-full object-cover">
                                            <div class="text-left hidden sm:block">
                                                <p class="text-sm font-semibold text-gray-900">DILG Knowledge Operations</p>
                                            </div>
                                        </button>
                                        <div x-show="appUserMenuOpen" @click.outside="appUserMenuOpen = false" class="absolute top-12 right-0 bg-white border border-gray-200 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] min-w-[220px] z-50">
                                            <div class="px-5 py-4 border-b border-gray-100">
                                                <p class="font-bold text-gray-900 text-sm">{{ Auth::user()->name ?? 'User' }}</p>
                                                <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email ?? '' }}</p>
                                            </div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full text-left px-5 py-3 text-red-600 font-semibold text-sm hover:bg-gray-50 transition">
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
                            <button type="button" class="btn-premium-glass" @click="navOpen = false">Close</button>
                        </div>
                        <div class="mt-8 space-y-2">
                            <a href="{{ route('notebooks.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('notebooks.*') ? 'bg-blue-50 text-blue-700' : '' }}">My Workspace</a>
                            @if(auth()->user()->role === 'admin')
                                <div class="pt-4 pb-2 px-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Admin Tools</div>
                                <a href="{{ route('analytics') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('analytics') ? 'bg-blue-50 text-blue-700' : '' }}">Admin Dashboard</a>
                                <a href="{{ route('users.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700' : '' }}">User Management</a>
                                <a href="{{ route('settings.index') }}" class="block rounded-2xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('settings.*') ? 'bg-blue-50 text-blue-700' : '' }}">System Settings</a>
                            @endif
                        </div>
                    </aside>

                    <main class="relative flex-1 px-6 pb-10 pt-8">
                        @if (session('status'))
                            <div class="glass-panel mb-6 border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ $slot }}

                        <footer class="mt-12 text-center">
                            <p class="text-sm font-semibold text-gray-700 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Secured. Reliable. Government-Grade.
                            </p>
                            <p class="text-xs text-gray-500 mt-2">NoteGov AI DILG Platform</p>
                        </footer>
                    </main>
                </div>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
