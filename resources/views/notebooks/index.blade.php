<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Notebooks - {{ config('app.name', 'NoteGov AI DILG') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|space-grotesk:400,500,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <style>
            * {
                box-sizing: border-box;
            }
            body {
                font-family: 'Manrope', sans-serif;
                background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 100%);
                margin: 0;
                padding: 0;
                color: white;
                min-height: 100vh;
            }
            .container-main {
                max-width: 1400px;
                margin: 0 auto;
                padding: 32px 48px;
            }
            .header-top {
                display: flex;
                justify-content: flex-end;
                gap: 16px;
                margin-bottom: 48px;
            }
            .header-btn {
                padding: 10px 20px;
                border-radius: 12px;
                border: 1px solid rgba(255,255,255,0.15);
                background: rgba(255,255,255,0.05);
                color: rgba(255,255,255,0.8);
                font-family: 'Manrope', sans-serif;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s ease;
            }
            .header-btn:hover {
                background: rgba(255,255,255,0.1);
                border-color: rgba(255,255,255,0.25);
            }
            .section-recent {
                margin-bottom: 48px;
            }
            .section-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 24px;
            }
            .section-title-area {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
            .section-greeting {
                font-size: 14px;
                font-weight: 700;
                color: #6366f1;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .section-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 32px;
                font-weight: 700;
                margin: 0;
                color: white;
            }
            .section-actions {
                display: flex;
                align-items: center;
                gap: 16px;
            }
            .search-input {
                padding: 10px 20px;
                padding-left: 44px;
                border-radius: 12px;
                border: 1px solid rgba(255,255,255,0.15);
                background: rgba(255,255,255,0.05);
                color: white;
                font-family: 'Manrope', sans-serif;
                font-size: 14px;
                min-width: 240px;
                outline: none;
                transition: all 0.2s ease;
            }
            .search-input:focus {
                border-color: rgba(99,102,241,0.5);
                box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
            }
            .search-input::placeholder {
                color: rgba(255,255,255,0.4);
            }
            .search-wrapper {
                position: relative;
            }
            .search-icon {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: rgba(255,255,255,0.5);
                width: 18px;
                height: 18px;
            }
            .view-toggle {
                display: flex;
                border: 1px solid rgba(255,255,255,0.15);
                border-radius: 12px;
                overflow: hidden;
            }
            .view-btn {
                padding: 8px 14px;
                border: none;
                background: transparent;
                color: rgba(255,255,255,0.6);
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .view-btn.active {
                background: rgba(99,102,241,0.2);
                color: #818cf8;
            }
            .view-btn:hover:not(.active) {
                background: rgba(255,255,255,0.05);
            }
            .sort-dropdown {
                padding: 10px 16px;
                border-radius: 12px;
                border: 1px solid rgba(255,255,255,0.15);
                background: rgba(255,255,255,0.05);
                color: rgba(255,255,255,0.8);
                font-family: 'Manrope', sans-serif;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .create-btn {
                padding: 10px 24px;
                border-radius: 12px;
                border: none;
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                color: white;
                font-family: 'Manrope', sans-serif;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s ease;
            }
            .create-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 30px rgba(99,102,241,0.3);
            }
            .notebooks-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 24px;
            }
            .notebook-card {
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 20px;
                padding: 24px;
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .notebook-card:hover {
                border-color: rgba(99,102,241,0.3);
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            }
            .notebook-card.create {
                border: 2px dashed rgba(99,102,241,0.4);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 260px;
            }
            .notebook-card.create:hover {
                border-color: rgba(99,102,241,0.7);
                background: rgba(99,102,241,0.05);
            }
            .create-icon-wrapper {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                background: rgba(99,102,241,0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 16px;
                transition: all 0.3s ease;
            }
            .notebook-card.create:hover .create-icon-wrapper {
                background: rgba(99,102,241,0.3);
                transform: scale(1.1);
            }
            .create-icon {
                width: 32px;
                height: 32px;
                color: #818cf8;
            }
            .create-text {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 18px;
                font-weight: 700;
                margin-bottom: 6px;
            }
            .create-subtext {
                font-size: 13px;
                color: rgba(255,255,255,0.5);
            }
            .notebook-cover {
                width: 72px;
                height: 72px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 32px;
                margin-bottom: 20px;
            }
            .notebook-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
            }
            .notebook-menu-btn {
                padding: 4px;
                border-radius: 8px;
                background: transparent;
                border: none;
                cursor: pointer;
                color: rgba(255,255,255,0.4);
                transition: all 0.2s ease;
            }
            .notebook-menu-btn:hover {
                background: rgba(255,255,255,0.1);
            }
            .notebook-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 20px;
                font-weight: 700;
                margin-bottom: 12px;
                color: white;
            }
            .notebook-meta {
                display: flex;
                align-items: center;
                gap: 12px;
                padding-top: 16px;
                border-top: 1px solid rgba(255,255,255,0.08);
            }
            .notebook-category {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 6px 12px;
                border-radius: 10px;
                background: rgba(255,255,255,0.05);
                font-size: 13px;
                font-weight: 600;
                color: rgba(255,255,255,0.7);
            }
            .notebook-owner {
                margin-left: auto;
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 13px;
                color: rgba(255,255,255,0.5);
            }
            .owner-avatar {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: linear-gradient(135deg, #6366f1, #8b5cf6);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                font-weight: 700;
            }
            .section-featured {
                padding-top: 32px;
                border-top: 1px solid rgba(255,255,255,0.08);
            }
            .featured-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 24px;
            }
            .featured-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 18px;
                font-weight: 700;
                color: rgba(255,255,255,0.8);
            }
            .view-all {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #818cf8;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .view-all:hover {
                color: #a5b4fc;
            }
            .featured-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 20px;
            }
            .featured-card {
                position: relative;
                border-radius: 20px;
                overflow: hidden;
                cursor: pointer;
                transition: all 0.3s ease;
                height: 260px;
            }
            .featured-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            }
            .featured-bg {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-size: cover;
                background-position: center;
                filter: brightness(0.5);
            }
            .featured-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(to top, rgba(15,15,35,0.95) 0%, rgba(15,15,35,0.4) 50%, transparent 100%);
            }
            .featured-content {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 24px;
            }
            .featured-source {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 8px;
                font-size: 13px;
                font-weight: 600;
                color: rgba(255,255,255,0.7);
            }
            .featured-source-icon {
                width: 20px;
                height: 20px;
                border-radius: 4px;
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                font-weight: 800;
                color: #1a1a2e;
            }
            .featured-card-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 20px;
                font-weight: 700;
                margin-bottom: 12px;
            }
            .featured-card-meta {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .featured-date {
                font-size: 13px;
                color: rgba(255,255,255,0.6);
            }
            .featured-open-btn {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #1a1a2e;
                transition: all 0.2s ease;
            }
            .featured-card:hover .featured-open-btn {
                transform: scale(1.1);
            }
            .notebooks-list {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }
            .notebook-list-item {
                display: flex;
                align-items: center;
                gap: 16px;
                padding: 16px 20px;
                background: rgba(255,255,255,0.05);
                border:1px solid rgba(255,255,255,0.1);
                border-radius: 16px;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .notebook-list-item:hover {
                border-color: rgba(99,102,241,0.3);
                background: rgba(99,102,241,0.05);
            }
            .notebook-list-cover {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:20px;
            }
            .notebook-list-info {
                flex: 1;
                display:flex;
                flex-direction:column;
                gap:4px;
            }
            .notebook-list-title {
                font-family:'Space Grotesk', sans-serif;
                font-size:16px;
                font-weight:700;
                color:white;
            }
            .notebook-list-meta {
                display:flex;
                gap:16px;
                font-size:13px;
                color:rgba(255,255,255,0.5);
            }
        </style>
    </head>
    <body>
        <div class="container-main" x-data="notebookIndex()">
            <script>
                function notebookIndex() {
                    return {
                        userMenuOpen: false, 
                        showRenameModal: false,
                        renameNotebookId: null,
                        renameTitle: '',
                        searchQuery: '',
                        viewMode: 'grid',
                        sortBy: 'recent',
                        allNotebooks: @json($userNotebooks),

                        get filteredNotebooks() {
                            let notebooks = [...this.allNotebooks];

                            if (this.searchQuery.trim() !== '') {
                                const q = this.searchQuery.toLowerCase();
                                notebooks = notebooks.filter(n => 
                                    n.title.toLowerCase().includes(q)
                                );
                            }

                            if (this.sortBy === 'title') {
                                notebooks.sort((a, b) => a.title.localeCompare(b.title));
                            } else if (this.sortBy === 'oldest') {
                                notebooks.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                            } else {
                                notebooks.sort((a, b) => new Date(b.last_activity_at) - new Date(a.last_activity_at));
                            }

                            return notebooks;
                        }
                    }
                }
            </script>
            <div class="header-top">
                <a href="{{ route('profile.edit') }}" class="header-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    </svg>
                    Settings
                </a>
                <div class="relative">
                    <button @click="userMenuOpen = !userMenuOpen" class="header-btn">
                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px;">
                            <path d="M3 3h7v7H3V3zm11 0h7v7h-7V3zm0 11h7v7h-7v-7zM3 14h7v7H3v-7z"/>
                        </svg>
                        <div style="width:24px; height:24px; border-radius:50%; background:linear-gradient(135deg, #8b5cf6, #a855f7); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </button>
                    <div x-show="userMenuOpen" @click.outside="userMenuOpen = false" style="position:absolute; top:50px; right:0; background:rgba(20,20,40,0.98); border:1px solid rgba(255,255,255,0.15); border-radius:16px; box-shadow:0 20px 40px rgba(0,0,0,0.4); min-width:220px; z-index:100;">
                        <div style="padding:16px 20px; border-bottom:1px solid rgba(255,255,255,0.1);">
                            <p style="font-size:14px; font-weight:700; margin:0;">{{ Auth::user()->name ?? 'User' }}</p>
                            <p style="font-size:13px; color:rgba(255,255,255,0.5); margin:4px 0 0;">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" style="display:block; padding:12px 20px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:rgba(255,255,255,0.7); text-decoration:none;">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="width:100%; padding:12px 20px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:#ef4444;">
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="section-recent">
                <div class="section-header">
                    <div class="section-title-area">
                        <div class="section-greeting">Good morning, {{ explode(' ', Auth::user()->name)[0] ?? 'User' }}</div>
                        <h2 class="section-title">Recent notebooks</h2>
                    </div>
                    <div class="section-actions">
                        <div class="search-wrapper">
                            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" class="search-input" placeholder="Search notebooks..." x-model="searchQuery">
                        </div>
                        <div class="view-toggle">
                            <button class="view-btn" :class="viewMode === 'grid' ? 'active' : ''" @click="viewMode = 'grid'">
                                <svg fill="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px;">
                                    <path d="M3 3h7v7H3V3zm11 0h7v7h-7V3zm0 11h7v7h-7v-7zM3 14h7v7H3v-7z"/>
                                </svg>
                            </button>
                            <button class="view-btn" :class="viewMode === 'list' ? 'active' : ''" @click="viewMode = 'list'">
                                <svg fill="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px;">
                                    <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                                </svg>
                            </button>
                        </div>
                        <div x-data="{ sortDropdownOpen: false }" class="relative">
                            <button @click="sortDropdownOpen = !sortDropdownOpen" class="sort-dropdown">
                                <span x-text="sortBy === 'recent' ? 'Most recent' : (sortBy === 'title' ? 'Title' : 'Oldest')"></span> ▾
                            </button>
                            <div x-show="sortDropdownOpen" @click.outside="sortDropdownOpen = false" style="position:absolute; top:45px; right:0; background:rgba(20,20,40,0.98); border:1px solid rgba(255,255,255,0.15); border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.4); min-width:160px; z-index:100;">
                                <button @click="sortBy = 'recent'; sortDropdownOpen = false;" style="width:100%; padding:10px 16px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.1);">
                                    Most recent
                                </button>
                                <button @click="sortBy = 'title'; sortDropdownOpen = false;" style="width:100%; padding:10px 16px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.1);">
                                    Title
                                </button>
                                <button @click="sortBy = 'oldest'; sortDropdownOpen = false;" style="width:100%; padding:10px 16px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:rgba(255,255,255,0.8);">
                                    Oldest
                                </button>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('notebooks.create.quick') }}">
                            @csrf
                            <button type="submit" class="create-btn">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create new
                            </button>
                        </form>
                    </div>
                </div>

                <template x-if="viewMode === 'grid'">
                    <div class="notebooks-grid">
                        <form method="POST" action="{{ route('notebooks.create.quick') }}" class="notebook-card create">
                            @csrf
                            <div class="create-icon-wrapper">
                                <svg class="create-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div class="create-text">Create new notebook</div>
                            <div class="create-subtext">Start from scratch</div>
                        </form>

                        <template x-for="notebook in filteredNotebooks" :key="notebook.id">
                            <div class="notebook-card" style="cursor: default;">
                                <div class="notebook-header">
                                    <a :href="'/notebooks/' + notebook.id" class="notebook-cover" :style="{ background: notebook.cover_color ?? '#6366f1' }" style="text-decoration: none; color: inherit;">
                                        📓
                                    </a>
                                    <div x-data="{ notebookMenuOpen: false }" class="relative">
                                        <button @click="notebookMenuOpen = !notebookMenuOpen" class="notebook-menu-btn">
                                            <svg fill="currentColor" viewBox="0 0 24 24" style="width:20px; height:20px;">
                                                <circle cx="12" cy="6" r="2"/>
                                                <circle cx="12" cy="12" r="2"/>
                                                <circle cx="12" cy="18" r="2"/>
                                            </svg>
                                        </button>
                                        <div x-show="notebookMenuOpen" @click.outside="notebookMenuOpen = false" style="position:absolute; top:30px; right:0; background:rgba(20,20,40,0.98); border:1px solid rgba(255,255,255,0.15); border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.4); min-width:160px; z-index:100;">
                                            <button @click="notebookMenuOpen = false; showRenameModal = true; renameNotebookId = notebook.id; renameTitle = notebook.title;" style="width:100%; padding:10px 16px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.1);">
                                                Rename
                                            </button>
                                            <form method="POST" :action="'/notebooks/' + notebook.id" onsubmit="return confirm('Are you sure you want to delete this notebook?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="width:100%; padding:10px 16px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:#ef4444;">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <a :href="'/notebooks/' + notebook.id" style="text-decoration: none; color: inherit;">
                                    <div class="notebook-title" x-text="notebook.title"></div>
                                    <div class="notebook-meta">
                                        <div class="notebook-category">
                                            <svg fill="currentColor" viewBox="0 0 24 24" style="width:14px; height:14px;">
                                                <path d="M3 7V5c0-1.1.9-2 2-2h4l2 2h8c1.1 0 2 .9 2 2v2H3zm0 12h18V9H3v10z"/>
                                            </svg>
                                            <span x-text="notebook.category?.name ?? 'Projects'"></span>
                                        </div>
                                        <div class="notebook-owner">
                                            <div class="owner-avatar" x-text="notebook.owner?.name?.charAt(0).toUpperCase() ?? 'U'"></div>
                                            <span>You</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="viewMode === 'list'">
                    <div class="notebooks-list">
                        <form method="POST" action="{{ route('notebooks.create.quick') }}" class="notebook-list-item" style="display:flex; align-items:center; gap:16px; padding:20px; border:2px dashed rgba(99,102,241,0.4);">
                            @csrf
                            <div style="width:48px; height:48px; border-radius:12px; background:rgba(99,102,241,0.2); display:flex; align-items:center; justify-content:center;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px; height:24px; color:#818cf8;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <div style="font-family:'Space Grotesk', sans-serif; font-size:16px; font-weight:700; color:white;">Create new notebook</div>
                                <div style="font-size:13px; color:rgba(255,255,255,0.5);">Start from scratch</div>
                            </div>
                        </form>

                        <template x-for="notebook in filteredNotebooks" :key="notebook.id">
                            <div class="notebook-list-item" style="cursor: default;">
                                <a :href="'/notebooks/' + notebook.id" class="notebook-list-cover" :style="{ background: notebook.cover_color ?? '#6366f1' }" style="text-decoration: none; color: inherit;">
                                    📓
                                </a>
                                <div class="notebook-list-info">
                                    <a :href="'/notebooks/' + notebook.id" style="text-decoration: none;">
                                        <div class="notebook-list-title" x-text="notebook.title"></div>
                                    </a>
                                    <div class="notebook-list-meta">
                                        <span x-text="(notebook.sources_count ?? 0) + ' sources'"></span>
                                        <span x-text="new Date(notebook.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' })"></span>
                                        <span>Owner</span>
                                    </div>
                                </div>
                                <div x-data="{ notebookMenuOpen: false }" class="relative">
                                    <button @click="notebookMenuOpen = !notebookMenuOpen" class="notebook-menu-btn">
                                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:20px; height:20px;">
                                            <circle cx="12" cy="6" r="2"/>
                                            <circle cx="12" cy="12" r="2"/>
                                            <circle cx="12" cy="18" r="2"/>
                                        </svg>
                                    </button>
                                    <div x-show="notebookMenuOpen" @click.outside="notebookMenuOpen = false" style="position:absolute; top:30px; right:0; background:rgba(20,20,40,0.98); border:1px solid rgba(255,255,255,0.15); border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.4); min-width:160px; z-index:100;">
                                        <button @click="notebookMenuOpen = false; showRenameModal = true; renameNotebookId = notebook.id; renameTitle = notebook.title;" style="width:100%; padding:10px 16px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.1);">
                                            Rename
                                        </button>
                                        <form method="POST" :action="'/notebooks/' + notebook.id" onsubmit="return confirm('Are you sure you want to delete this notebook?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="width:100%; padding:10px 16px; text-align:left; background:none; border:none; cursor:pointer; font-size:14px; font-weight:600; color:#ef4444;">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            @if ($featuredNotebooks->isNotEmpty())
                <div class="section-featured">
                    <div class="featured-header">
                        <div class="featured-title">Featured notebooks</div>
                        <div class="view-all">
                            View all
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px; height:16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="featured-grid">
                        @foreach ($featuredNotebooks as $index => $notebook)
                            <a href="{{ route('notebooks.show', $notebook) }}" class="featured-card">
                                <div class="featured-bg" style="background: linear-gradient(135deg, {{ $notebook->cover_color ?? '#6366f1' }} 0%, #0f0f23 100%);"></div>
                                <div class="featured-overlay"></div>
                                <div class="featured-content">
                                    <div class="featured-source">
                                        <div class="featured-source-icon">
                                            {{ strtoupper(substr($notebook->owner->name ?? 'N', 0, 1)) }}
                                        </div>
                                        {{ $notebook->owner->name ?? 'NoteGov' }}
                                    </div>
                                    <div class="featured-card-title">{{ $notebook->title }}</div>
                                    <div class="featured-card-meta">
                                        <div class="featured-date">{{ $notebook->created_at->format('d M Y') }} • {{ $notebook->sources_count }} sources</div>
                                        <div class="featured-open-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div x-show="showRenameModal" style="position:fixed; inset:0; background:rgba(0,0,0,0.7); display:flex; align-items:center; justify-content:center; z-index:200;" x-transition>
                <div style="background:#1a1a2e; border:1px solid rgba(255,255,255,0.15); border-radius:24px; padding:32px; max-width:500px; width:90%;">
                    <h3 style="font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; color:white; margin:0 0 24px;">Rename Notebook</h3>
                    <form method="POST" :action="`/notebooks/${renameNotebookId}`">
                        @csrf
                        @method('PATCH')
                        <div style="margin-bottom:24px;">
                            <label style="display:block; font-family:'Manrope', sans-serif; font-size:14px; font-weight:600; color:rgba(255,255,255,0.8); margin-bottom:8px;">Notebook Name</label>
                            <input type="text" name="title" x-model="renameTitle" required style="width:100%; padding:16px 20px; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.05); color:white; font-family:'Manrope', sans-serif; font-size:16px; border-radius:16px; outline:none;">
                        </div>
                        <div style="display:flex; gap:12px;">
                            <button type="button" @click="showRenameModal = false" style="flex:1; padding:16px 32px; border:1px solid rgba(255,255,255,0.15); border-radius:16px; background:transparent; color:rgba(255,255,255,0.8); font-family:'Manrope', sans-serif; font-size:16px; font-weight:600; cursor:pointer;">Cancel</button>
                            <button type="submit" style="flex:1; padding:16px 32px; border:none; border-radius:16px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; font-family:'Manrope', sans-serif; font-size:16px; font-weight:600; cursor:pointer;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
