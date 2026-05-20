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
    <body class="font-sans antialiased bg-gray-100">
        <div x-data="{ navOpen: false }" class="relative min-h-screen">
            <div class="relative flex min-h-screen">
                <aside class="hidden w-72 shrink-0 xl:flex xl:flex-col xl:fixed xl:h-screen xl:inset-y-0 xl:left-0 bg-gray-900 text-white z-20">
                    <div class="px-6 py-8 flex flex-col h-full">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                <x-application-logo class="h-7 w-7 shrink-0" />
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.28em] text-blue-400">DILG</p>
                                <p class="text-xl font-bold text-white">NoteGov AI</p>
                            </div>
                        </a>

                        <div class="space-y-2">
                            <a href="{{ route('notebooks.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('notebooks.*') && !request()->routeIs('notebooks.show') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.831 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span class="font-semibold">My Workspace</span>
                            </a>

                            @if(auth()->user()->role === 'admin')
                                <div class="pt-6 pb-2">
                                    <p class="px-4 text-xs font-bold uppercase tracking-wider text-gray-500">Admin Tools</p>
                                </div>
                                <a href="{{ route('analytics') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('analytics') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <span class="font-semibold">Admin Dashboard</span>
                                </a>
                                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span class="font-semibold">User Management</span>
                                </a>
                                <a href="{{ route('featured-notebooks.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('featured-notebooks.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.95 1.71l-1.52 4.674c-.3.921-1.604.921-1.902 0l-5.449-1.675a1 1 0 00-.95.69h-4.915c-.969 0-1.371-1.24-.95-1.71l1.52-4.674a1 1 0 00-.95-.69H5.183c-.969 0-1.371 1.24-.95 1.71l1.519 4.674c.3.921 1.603.921 1.902 0l5.45 1.675c.3.921 1.604-.921 1.902 0z"></path></svg>
                                    <span class="font-semibold">Featured Notebooks</span>
                                </a>
                                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('settings.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-1.066 2.572c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 001.066-2.573c.94 1.543-.826 3.31-2.37 2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="font-semibold">System Settings</span>
                                </a>
                            @endif
                        </div>

                        <div class="mt-auto">
                            <div class="p-4 rounded-xl bg-gray-800 border border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'User' }}</p>
                                        <p class="text-xs text-blue-300">{{ ucfirst(Auth::user()->role ?? 'User') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="flex min-w-0 flex-1 flex-col xl:ml-72">
                    <header class="sticky top-0 z-30 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between gap-4 px-6 py-5">
                            <div class="flex items-center gap-3">
                                <button type="button" class="xl:hidden px-4 py-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-700" @click="navOpen = true">Menu</button>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-600">DILG KNOWLEDGE ASSISTANT</p>
                                </div>
                            </div>

                            <div class="hidden flex-1 items-center justify-end gap-3 lg:flex">
                                @auth
                                    <div x-data="{ appUserMenuOpen: false }" class="relative">
                                        <button @click="appUserMenuOpen = !appUserMenuOpen" class="flex items-center gap-3 px-3 py-2 rounded-xl border border-gray-200 bg-white hover:border-gray-300 hover:bg-gray-50 transition">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                            </div>
                                        </button>
                                        <div x-show="appUserMenuOpen" @click.outside="appUserMenuOpen = false" class="absolute top-12 right-0 bg-white border border-gray-200 rounded-2xl shadow-xl min-w-[220px] z-50">
                                            <div class="px-5 py-4 border-b border-gray-100">
                                                <p class="font-bold text-gray-900 text-sm">{{ Auth::user()->name ?? 'User' }}</p>
                                                <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email ?? '' }}</p>
                                            </div>
                                            <a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Profile</a>
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
                    <aside x-show="navOpen" x-transition class="fixed inset-y-0 left-0 z-50 w-80 bg-white px-5 py-6 xl:hidden">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                    <x-application-logo class="h-7 w-7 shrink-0" />
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-[0.24em] text-gray-500">NoteGov AI DILG</p>
                                    <p class="font-semibold text-gray-900">Navigation</p>
                                </div>
                            </div>
                            <button type="button" class="px-4 py-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-700" @click="navOpen = false">Close</button>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('notebooks.index') }}" class="block rounded-xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('notebooks.*') ? 'bg-blue-50 text-blue-700' : '' }}">My Workspace</a>
                            @if(auth()->user()->role === 'admin')
                                <div class="pt-4 pb-2 px-4 text-xs font-bold uppercase tracking-wider text-gray-400">Admin Tools</div>
                                <a href="{{ route('analytics') }}" class="block rounded-xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('analytics') ? 'bg-blue-50 text-blue-700' : '' }}">Admin Dashboard</a>
                                <a href="{{ route('users.index') }}" class="block rounded-xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700' : '' }}">User Management</a>
                                <a href="{{ route('featured-notebooks.index') }}" class="block rounded-xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('featured-notebooks.*') ? 'bg-blue-50 text-blue-700' : '' }}">Featured Notebooks</a>
                                <a href="{{ route('settings.index') }}" class="block rounded-xl px-4 py-3 text-gray-700 hover:bg-gray-50 font-semibold {{ request()->routeIs('settings.*') ? 'bg-blue-50 text-blue-700' : '' }}">System Settings</a>
                            @endif
                        </div>
                    </aside>

                    <main class="relative flex-1 px-6 pb-10 pt-8">
                        @if (session('status'))
                            <div class="mb-6 rounded-2xl border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
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
