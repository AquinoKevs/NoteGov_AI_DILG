<x-app-layout>
    <style>
        .container-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 0 48px;
        }
        .section {
            margin-bottom: 48px;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }
        .section-title-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-greeting {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #64748b;
            margin-bottom: 4px;
        }
        .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 240px;
            max-width: 360px;
        }
        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #94a3b8;
        }
        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            color: #0f172a;
            font-family: 'Manrope', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }
        .search-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        .notebooks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .notebook-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        .notebook-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(15,23,42,0.04);
        }
        .notebook-card.create {
            border: 2px dashed #e2e8f0;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            gap: 12px;
        }
        .create-icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: white;
            border: 2px dashed #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .create-icon {
            width: 24px;
            height: 24px;
            color: #64748b;
        }
        .create-text {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
        }
        .create-subtext {
            font-size: 13px;
            color: #64748b;
        }
        .notebook-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .notebook-cover {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .notebook-menu-btn {
            padding: 6px 8px;
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .notebook-menu-btn:hover {
            background: #f1f5f9;
            color: #475569;
        }
        .notebook-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        .notebook-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }
        .notebook-category {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        .notebook-owner {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        .owner-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8b5cf6, #a855f7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: white;
        }
        .shelf-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
        }
        .shelf-header {
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .shelf-header:hover {
            background: #f8fafc;
        }
        .shelf-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .shelf-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .shelf-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
        }
        .shelf-count {
            font-size: 12px;
            color: #64748b;
        }
        .shelf-content {
            padding: 16px 20px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }
        .shelf-notebook {
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .shelf-notebook:hover {
            background: #f1f5f9;
        }
        .shelf-notebook-cover {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .shelf-notebook-title {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            line-height: 1.3;
        }
        .btn-add-shelf {
            width: 100%;
            padding: 24px;
            border: 2px dashed #e2e8f0;
            background: #f8fafc;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        .btn-add-shelf:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        .pin-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            padding: 3px 8px;
            border-radius: 6px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .featured-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            padding: 3px 8px;
            border-radius: 6px;
            background: linear-gradient(135deg, #ec4899, #db2777);
            color: white;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            border-radius: 16px;
            background: white;
            border: 1px dashed #e2e8f0;
        }
        .empty-state-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .empty-state-text {
            font-size: 13px;
            color: #64748b;
        }
    </style>

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
                    selectedNotebooks: [],
                    bulkAction: '',
                    showBulkActions: false,
                    showCreateShelfModal: false,
                    newShelfName: '',
                    newShelfIcon: '📚',
                    expandedShelves: {},

                    toggleNotebook(id) {
                        const index = this.selectedNotebooks.indexOf(id);
                        if (index > -1) {
                            this.selectedNotebooks.splice(index, 1);
                        } else {
                            this.selectedNotebooks.push(id);
                        }
                        this.showBulkActions = this.selectedNotebooks.length > 0;
                    },
                    
                    toggleSelectAll() {
                        if (this.selectedNotebooks.length === this.filteredNotebooks.length) {
                            this.selectedNotebooks = [];
                        } else {
                            this.selectedNotebooks = this.filteredNotebooks.map(n => n.id);
                        }
                        this.showBulkActions = this.selectedNotebooks.length > 0;
                    },
                    
                    get allSelected() {
                        return this.filteredNotebooks.length > 0 && 
                            this.selectedNotebooks.length === this.filteredNotebooks.length;
                    },

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
                    },

                    toggleShelf(shelfId) {
                        this.expandedShelves[shelfId] = !this.expandedShelves[shelfId];
                    }
                }
            }
        </script>

        @if (session('status'))
            <div class="mb-6 rounded-xl border-emerald-200 bg-emerald-50 px-5 py-3 text-sm text-emerald-800 font-medium">
                {{ session('status') }}
            </div>
        @endif

        <!-- Recent Notebooks -->
        <div class="section">
            <template x-if="showBulkActions">
                <form method="POST" action="{{ route('notebooks.bulk') }}" class="flex items-center gap-3 mb-6 p-4 bg-slate-50 border border-slate-200 rounded-xl w-full">
                    @csrf
                    <template x-for="id in selectedNotebooks" :key="id">
                        <input type="hidden" name="notebook_ids[]" :value="id">
                    </template>
                    <span class="text-slate-700 font-medium text-sm" x-text="selectedNotebooks.length + ' selected'"></span>
                    <select name="action" x-model="bulkAction" required class="bg-white border border-slate-200 text-slate-900 rounded-lg px-3 py-2 text-sm">
                        <option value="">Select action</option>
                        <option value="delete">Delete</option>
                        <option value="pin">Pin</option>
                        <option value="unpin">Unpin</option>
                        <option value="share">Share</option>
                    </select>
                    <button type="submit" :disabled="!bulkAction" class="btn-premium text-sm" onclick="return confirm('Are you sure you want to perform this action?')">Apply</button>
                    <button type="button" @click="selectedNotebooks = []; showBulkActions = false;" class="btn-premium-outline text-sm">Clear</button>
                </form>
            </template>
            <div class="section-header">
                <div class="section-title-area">
                    <div class="section-icon" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="section-greeting">Recent</div>
                        <h2 class="section-title">Recent Notebooks</h2>
                    </div>
                </div>
                <div class="search-wrapper">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" class="search-input" placeholder="Search notebooks..." x-model="searchQuery">
                </div>
            </div>

            <div class="notebooks-grid">
                <form method="POST" action="{{ route('notebooks.create.quick') }}" class="notebook-card create">
                    @csrf
                    <button
                        type="submit"
                        style="all: unset; width: 100%; height: 100%; cursor: pointer; display: flex; flex-direction: column; align-items: center;"
                        aria-label="Create new notebook"
                    >
                        <div class="create-icon-wrapper">
                            <svg class="create-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="create-text">Create notebook</div>
                        <div class="create-subtext">Start from scratch</div>
                    </button>
                </form>

                @if ($userNotebooks->isEmpty())
                    <div class="empty-state" style="grid-column: span 3;">
                        <div class="empty-state-title">No notebooks yet</div>
                        <div class="empty-state-text">Create your first notebook to get started</div>
                    </div>
                @else
                    @foreach ($userNotebooks as $notebook)
                        <div class="notebook-card" style="cursor: default;">
                            <div class="notebook-header" style="gap: 8px;">
                                <input type="checkbox" :checked="selectedNotebooks.includes({{ $notebook->id }})" @click.stop="toggleNotebook({{ $notebook->id }})" class="w-4 h-4 rounded" style="accent-color: #6366f1;">
                                <a href="{{ route('notebooks.show', $notebook) }}" class="notebook-cover" style="background: {{ $notebook->cover_color ?? '#6366f1' }}; text-decoration: none; color: inherit;">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                                <div x-data="{ notebookMenuOpen: false }" class="relative">
                                    <button @click="notebookMenuOpen = !notebookMenuOpen" class="notebook-menu-btn">
                                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px;">
                                            <circle cx="12" cy="6" r="2"/>
                                            <circle cx="12" cy="12" r="2"/>
                                            <circle cx="12" cy="18" r="2"/>
                                        </svg>
                                    </button>
                                    <div x-show="notebookMenuOpen" @click.outside="notebookMenuOpen = false" style="position:absolute; top:28px; right:0; background:white; border:1px solid #e2e8f0; border-radius:10px; box-shadow:0 4px 12px rgba(15,23,42,0.1); min-width:150px; z-index:100;">
                                        <button @click="notebookMenuOpen = false; showRenameModal = true; renameNotebookId = {{ $notebook->id }}; renameTitle = '{{ $notebook->title }}';" style="width:100%; padding:10px 14px; text-align:left; background:none; border:none; cursor:pointer; font-size:13px; font-weight:500; color:#0f172a; border-bottom:1px solid #f1f5f9;">
                                            Rename
                                        </button>
                                        <form method="POST" action="{{ route('notebooks.duplicate', $notebook) }}">
                                            @csrf
                                            <button type="submit" style="width:100%; padding:10px 14px; text-align:left; background:none; border:none; cursor:pointer; font-size:13px; font-weight:500; color:#0f172a; border-bottom:1px solid #f1f5f9;">
                                                Duplicate
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('notebooks.pin', $notebook) }}">
                                            @csrf
                                            <button type="submit" style="width:100%; padding:10px 14px; text-align:left; background:none; border:none; cursor:pointer; font-size:13px; font-weight:500; color:#0f172a; border-bottom:1px solid #f1f5f9;">
                                                Pin
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('notebooks.destroy', $notebook) }}" onsubmit="return confirm('Are you sure you want to delete this notebook?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="width:100%; padding:10px 14px; text-align:left; background:none; border:none; cursor:pointer; font-size:13px; font-weight:500; color:#ef4444;">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('notebooks.show', $notebook) }}" style="text-decoration: none; color: inherit;">
                                <div class="notebook-title">{{ $notebook->title }}</div>
                                <div class="notebook-meta">
                                    <div class="notebook-category">
                                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:13px; height:13px;">
                                            <path d="M3 7V5c0-1.1.9-2 2-2h4l2 2h8c1.1 0 2 .9 2 2v2H3zm0 12h18V9H3v10z"/>
                                        </svg>
                                        <span>{{ $notebook->category->name ?? 'Projects' }}</span>
                                    </div>
                                    <div class="notebook-owner">
                                        <div class="owner-avatar" style="background: linear-gradient(135deg, #8b5cf6, #a855f7);">
                                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span>You</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Featured Notebooks -->
        @if ($featuredNotebooks->isNotEmpty())
            <div class="section">
                <div class="section-header">
                    <div class="section-title-area">
                        <div class="section-icon" style="background: linear-gradient(135deg, #ec4899, #db2777);">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.95 1.71l-1.52 4.674c-.3.921-1.604.921-1.902 0l-5.449-1.675a1 1 0 00-.95.69h-4.915c-.969 0-1.371-1.24-.95-1.71l1.52-4.674a1 1 0 00-.95-.69H5.183c-.969 0-1.371 1.24-.95 1.71l1.519 4.674c.3.921 1.603.921 1.902 0l5.45 1.675c.3.921 1.604-.921 1.902 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="section-greeting">Featured</div>
                            <h2 class="section-title">Featured Notebooks</h2>
                        </div>
                    </div>
                </div>

                <div class="notebooks-grid">
                    @foreach ($featuredNotebooks as $notebook)
                        <div class="notebook-card" style="cursor: default;">
                            <div class="featured-badge">Featured</div>
                            <div class="notebook-header" style="gap: 8px;">
                                <a href="{{ route('notebooks.show', $notebook) }}" class="notebook-cover" style="background: {{ $notebook->cover_color ?? '#ec4899' }}; text-decoration: none; color: inherit;">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                            </div>
                            <a href="{{ route('notebooks.show', $notebook) }}" style="text-decoration: none; color: inherit;">
                                <div class="notebook-title">{{ $notebook->title }}</div>
                                <div class="notebook-meta">
                                    <div class="notebook-category">
                                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:13px; height:13px;">
                                            <path d="M3 7V5c0-1.1.9-2 2-2h4l2 2h8c1.1 0 2 .9 2 2v2H3zm0 12h18V9H3v10z"/>
                                        </svg>
                                        <span>{{ $notebook->category->name ?? 'Projects' }}</span>
                                    </div>
                                    <div class="notebook-owner">
                                        <div class="owner-avatar" style="background: linear-gradient(135deg, #ec4899, #db2777);">
                                            {{ strtoupper(substr($notebook->owner->name ?? 'N', 0, 1)) }}
                                        </div>
                                        <span>{{ $notebook->owner->name ?? 'User' }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Pinned Notebooks -->
        @if ($pinnedNotebooks->isNotEmpty())
            <div class="section">
                <div class="section-header">
                    <div class="section-title-area">
                        <div class="section-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="section-greeting">Pinned</div>
                            <h2 class="section-title">Pinned Notebooks</h2>
                        </div>
                    </div>
                </div>

                <div class="notebooks-grid">
                    @foreach ($pinnedNotebooks as $notebook)
                        <div class="notebook-card" style="cursor: default;">
                            <div class="pin-badge">Pinned</div>
                            <div class="notebook-header" style="gap: 8px;">
                                <a href="{{ route('notebooks.show', $notebook) }}" class="notebook-cover" style="background: {{ $notebook->cover_color ?? '#f59e0b' }}; text-decoration: none; color: inherit;">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                                <div x-data="{ notebookMenuOpen: false }" class="relative">
                                    <button @click="notebookMenuOpen = !notebookMenuOpen" class="notebook-menu-btn">
                                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px;">
                                            <circle cx="12" cy="6" r="2"/>
                                            <circle cx="12" cy="12" r="2"/>
                                            <circle cx="12" cy="18" r="2"/>
                                        </svg>
                                    </button>
                                    <div x-show="notebookMenuOpen" @click.outside="notebookMenuOpen = false" style="position:absolute; top:28px; right:0; background:white; border:1px solid #e2e8f0; border-radius:10px; box-shadow:0 4px 12px rgba(15,23,42,0.1); min-width:150px; z-index:100;">
                                        <form method="POST" action="{{ route('notebooks.unpin', $notebook) }}">
                                            @csrf
                                            <button type="submit" style="width:100%; padding:10px 14px; text-align:left; background:none; border:none; cursor:pointer; font-size:13px; font-weight:500; color:#0f172a;">
                                                Unpin
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('notebooks.show', $notebook) }}" style="text-decoration: none; color: inherit;">
                                <div class="notebook-title">{{ $notebook->title }}</div>
                                <div class="notebook-meta">
                                    <div class="notebook-category">
                                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:13px; height:13px;">
                                            <path d="M3 7V5c0-1.1.9-2 2-2h4l2 2h8c1.1 0 2 .9 2 2v2H3zm0 12h18V9H3v10z"/>
                                        </svg>
                                        <span>{{ $notebook->category->name ?? 'Projects' }}</span>
                                    </div>
                                    <div class="notebook-owner">
                                        <div class="owner-avatar" style="background: linear-gradient(135deg, #8b5cf6, #a855f7);">
                                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span>You</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Shelves -->
        <div class="section">
            <div class="section-header">
                <div class="section-title-area">
                    <div class="section-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="section-greeting">Organize</div>
                        <h2 class="section-title">Shelves</h2>
                    </div>
                </div>
            </div>

            <div class="notebooks-grid">
                @foreach ($shelves as $shelf)
                    <div class="shelf-card">
                        <div class="shelf-header" @click="toggleShelf({{ $shelf->id }})">
                            <div class="shelf-header-left">
                                <div class="shelf-icon" style="background: {{ $shelf->color ?? '#10b981' }}20; color: {{ $shelf->color ?? '#10b981' }};">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="shelf-title">{{ $shelf->name }}</div>
                                    <div class="shelf-count">{{ $shelf->notebooks->count() }} notebooks</div>
                                </div>
                            </div>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px; color:#94a3b8; transition: transform 0.2s ease;" :style="{ transform: expandedShelves[{{ $shelf->id }}] ? 'rotate(180deg)' : 'rotate(0deg)' }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div x-show="expandedShelves[{{ $shelf->id }}]" x-collapse style="padding:16px;">
                            @if ($shelf->notebooks->isEmpty())
                                <div class="empty-state" style="padding:20px 16px;">
                                    <div class="empty-state-title" style="font-size:14px;">No notebooks in this shelf</div>
                                    <div class="empty-state-text" style="font-size:12px;">Add notebooks to organize them</div>
                                </div>
                            @else
                                <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); gap:10px;">
                                    @foreach ($shelf->notebooks as $notebook)
                                        <a href="{{ route('notebooks.show', $notebook) }}" class="shelf-notebook" style="text-decoration: none;">
                                            <div class="shelf-notebook-cover" style="background: {{ $notebook->cover_color ?? '#10b981' }};">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="shelf-notebook-title">{{ $notebook->title }}</div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <button @click="showCreateShelfModal = true" class="btn-add-shelf">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Shelf
                </button>
            </div>
        </div>

        <!-- Shared Notebooks -->
        @if ($sharedNotebooks->isNotEmpty())
            <div class="section">
                <div class="section-header">
                    <div class="section-title-area">
                        <div class="section-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="section-greeting">Collaboration</div>
                            <h2 class="section-title">Shared Notebooks</h2>
                        </div>
                    </div>
                </div>
                <div class="notebooks-grid">
                    @foreach ($sharedNotebooks as $notebook)
                        <div class="notebook-card">
                            <div class="notebook-header">
                                <a href="{{ route('notebooks.show', $notebook) }}" class="notebook-cover" style="background: {{ $notebook->cover_color ?? '#06b6d4' }}; text-decoration: none; color: inherit;">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                            </div>
                            <a href="{{ route('notebooks.show', $notebook) }}" style="text-decoration: none; color: inherit;">
                                <div class="notebook-title">{{ $notebook->title }}</div>
                            </a>
                            <div class="notebook-meta">
                                <div class="notebook-owner">
                                    <div class="owner-avatar" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                                        {{ strtoupper(substr($notebook->owner->name ?? 'N', 0, 1)) }}
                                    </div>
                                    <span>{{ $notebook->owner->name ?? 'User' }}</span>
                                </div>
                                <div class="shared-role" style="padding: 3px 10px; border-radius: 999px; background: rgba(6,182,212,0.1); color: #06b6d4; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">{{ $notebook->pivot->permission ?? 'Viewer' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div x-show="showCreateShelfModal" style="position:fixed; inset:0; background:rgba(15,23,42,0.5); display:flex; align-items:center; justify-content:center; z-index:200;" x-transition>
            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; padding:28px; max-width:480px; width:90%; box-shadow:0 20px 40px rgba(15,23,42,0.15);">
                <h3 style="font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:600; color:#0f172a; margin:0 0 20px;">Create Shelf</h3>
                <form method="POST" action="{{ route('shelves.store') }}">
                    @csrf
                    <div style="margin-bottom:20px;">
                        <label style="display:block; font-family:'Manrope', sans-serif; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Shelf Name</label>
                        <input type="text" name="name" x-model="newShelfName" required style="width:100%; padding:12px 16px; border:1px solid #e2e8f0; background:white; color:#0f172a; font-family:'Manrope', sans-serif; font-size:14px; border-radius:10px; outline:none;">
                    </div>
                    <div style="margin-bottom:24px;">
                        <label style="display:block; font-family:'Manrope', sans-serif; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Icon</label>
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            <template x-for="icon in ['📚', '📁', '📂', '📊', '📈', '💼', '🎯', '🚀']">
                                <button type="button" @click="newShelfIcon = icon" :style="{ background: newShelfIcon === icon ? 'rgba(16,185,129,0.1)' : 'transparent', border: newShelfIcon === icon ? '2px solid #10b981' : '2px solid transparent' }" style="width:40px; height:40px; border-radius:10px; font-size:18px; cursor:pointer; transition:all 0.2s ease;">
                                    <span x-text="icon"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button type="button" @click="showCreateShelfModal = false; newShelfName = '';" style="flex:1; padding:12px 24px; border:1px solid #e2e8f0; border-radius:10px; background:white; color:#0f172a; font-family:'Manrope', sans-serif; font-size:14px; font-weight:600; cursor:pointer;">Cancel</button>
                        <button type="submit" style="flex:1; padding:12px 24px; border:none; border-radius:10px; background:linear-gradient(135deg,#10b981,#059669); color:white; font-family:'Manrope', sans-serif; font-size:14px; font-weight:600; cursor:pointer;">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showRenameModal" style="position:fixed; inset:0; background:rgba(15,23,42,0.5); display:flex; align-items:center; justify-content:center; z-index:200;" x-transition>
            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; padding:28px; max-width:480px; width:90%; box-shadow:0 20px 40px rgba(15,23,42,0.15);">
                <h3 style="font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:600; color:#0f172a; margin:0 0 20px;">Rename Notebook</h3>
                <form method="POST" :action="`/notebooks/${renameNotebookId}`">
                    @csrf
                    @method('PATCH')
                    <div style="margin-bottom:24px;">
                        <label style="display:block; font-family:'Manrope', sans-serif; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Notebook Name</label>
                        <input type="text" name="title" x-model="renameTitle" required style="width:100%; padding:12px 16px; border:1px solid #e2e8f0; background:white; color:#0f172a; font-family:'Manrope', sans-serif; font-size:14px; border-radius:10px; outline:none;">
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button type="button" @click="showRenameModal = false" style="flex:1; padding:12px 24px; border:1px solid #e2e8f0; border-radius:10px; background:white; color:#0f172a; font-family:'Manrope', sans-serif; font-size:14px; font-weight:600; cursor:pointer;">Cancel</button>
                        <button type="submit" style="flex:1; padding:12px 24px; border:none; border-radius:10px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; font-family:'Manrope', sans-serif; font-size:14px; font-weight:600; cursor:pointer;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
