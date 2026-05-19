<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="chip mb-2">Platform Administration</div>
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">System Settings</h1>
                <p class="mt-1 text-sm text-gray-500">Manage and configure the overall platform settings for NoteGov AI DILG.</p>
            </div>
            <button type="submit" form="settings-form" class="btn-primary">Save Changes</button>
        </div>
    </x-slot>

    <div class="space-y-8 py-6" x-data="{ tab: 'general' }">
        <!-- Settings Navigation -->
        <div class="flex items-center gap-1 border-b border-gray-200 overflow-x-auto">
            <button @click="tab = 'general'" :class="tab === 'general' ? 'border-sky-500 text-sky-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 text-sm font-medium transition">
                1. General Settings
            </button>
            <button @click="tab = 'featured'" :class="tab === 'featured' ? 'border-sky-500 text-sky-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 text-sm font-medium transition">
                2. Featured Notebooks ⭐
            </button>
            <button @click="tab = 'notifications'" :class="tab === 'notifications' ? 'border-sky-500 text-sky-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 text-sm font-medium transition">
                3. Notification Settings 🔔
            </button>
            <button @click="tab = 'backup'" :class="tab === 'backup' ? 'border-sky-500 text-sky-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 text-sm font-medium transition">
                4. Backup & Storage 💾
            </button>
        </div>

        <form id="settings-form" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- General Settings -->
            <div x-show="tab === 'general'" class="space-y-6">
                <div class="panel bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">General Information</h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <x-input-label for="system_name" value="System Name" />
                            <x-text-input id="system_name" name="system_name" type="text" class="mt-1 block w-full" :value="$settings['system_name']" />
                        </div>
                        <div>
                            <x-input-label for="organization_name" value="Organization Name" />
                            <x-text-input id="organization_name" name="organization_name" type="text" class="mt-1 block w-full" :value="$settings['organization']" />
                        </div>
                        <div>
                            <x-input-label for="timezone" value="Timezone" />
                            <select id="timezone" name="timezone" class="mt-1 block w-full rounded-2xl border-gray-200 focus:border-sky-500 focus:ring-sky-500">
                                <option value="Asia/Manila" {{ $settings['timezone'] === 'Asia/Manila' ? 'selected' : '' }}>Asia/Manila (UTC+08:00)</option>
                                <option value="UTC">UTC</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="default_language" value="Default Language" />
                            <select id="default_language" name="default_language" class="mt-1 block w-full rounded-2xl border-gray-200 focus:border-sky-500 focus:ring-sky-500">
                                <option value="English" {{ $settings['language'] === 'English' ? 'selected' : '' }}>English</option>
                                <option value="Filipino">Filipino</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-50 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900">Logo Upload</h4>
                                <p class="text-sm text-gray-500">Upload your organization's logo for the sidebar and emails.</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100 overflow-hidden">
                                    <x-application-logo class="w-10 h-10" />
                                </div>
                                <button type="button" class="btn-secondary text-xs">Choose File</button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900">Maintenance Mode</h4>
                                <p class="text-sm text-gray-500">Put the platform in maintenance mode for updates.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="maintenance_mode" class="sr-only peer" {{ $settings['maintenance_mode'] ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Notebooks -->
            <div x-show="tab === 'featured'" class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($featuredNotebooks as $notebook)
                        <div class="panel bg-white overflow-hidden rounded-3xl shadow-sm border border-gray-100 group">
                            <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                @if($notebook->cover_image_path)
                                    <img src="{{ Storage::url($notebook->cover_image_path) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300" style="background-color: {{ $notebook->cover_color }}">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3 flex gap-2">
                                    @if($notebook->is_pinned)
                                        <button type="button" class="p-2 bg-white/90 backdrop-blur rounded-xl text-amber-500 shadow-sm hover:bg-white transition" title="Pinned to Homepage">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 2z"></path></svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md">{{ $notebook->category->name ?? 'Governance' }}</span>
                                    <span class="text-[10px] font-medium text-gray-400">Updated {{ $notebook->updated_at->diffForHumans() }}</span>
                                </div>
                                <h4 class="font-bold text-gray-900 truncate">{{ $notebook->title }}</h4>
                                
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <button type="button" class="btn-secondary py-1.5 px-3 text-xs">Featured Toggle</button>
                                    <button type="button" class="btn-secondary py-1.5 px-3 text-xs">Pin to Home</button>
                                    <a href="{{ route('notebooks.show', $notebook) }}" target="_blank" class="btn-secondary py-1.5 px-3 text-xs">View as User</a>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                        <span class="text-xs font-semibold text-gray-500">Public Visibility</span>
                                    </div>
                                    <button type="button" class="text-gray-400 hover:text-gray-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full panel bg-white p-12 text-center rounded-3xl border border-dashed border-gray-200">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-900">No Featured Notebooks</h4>
                            <p class="text-sm text-gray-500 mt-1 max-w-xs mx-auto">Highlight "Top Governance Reports" or important workspaces for all users to see.</p>
                            <button type="button" class="btn-primary mt-6">Select Notebooks to Feature</button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Notification Settings -->
            <div x-show="tab === 'notifications'" class="space-y-6">
                <div class="panel bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-8">Notification Preferences</h3>
                    
                    <div class="space-y-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900">Email Alerts</h4>
                                <p class="text-sm text-gray-500">Global toggle for all system email notifications.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notifications[email]" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900">Workspace Updates</h4>
                                <p class="text-sm text-gray-500">Notify when sources are added or members join workspaces.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notifications[workspace]" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900">AI Completion Alerts</h4>
                                <p class="text-sm text-gray-500">Get notified when complex AI indexing or generation tasks finish.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notifications[ai]" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900">User Login Alerts</h4>
                                <p class="text-sm text-gray-500">Security notifications for new device logins.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notifications[login]" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900">System Maintenance Notifications</h4>
                                <p class="text-sm text-gray-500">Alert users 24 hours before scheduled maintenance.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notifications[maintenance]" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup & Storage -->
            <div x-show="tab === 'backup'" class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="panel bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-lg font-bold text-gray-900">Storage Usage</h3>
                            <span class="text-sm font-bold text-sky-600">{{ $storageUsage['used'] }} GB / {{ $storageUsage['total'] }} GB</span>
                        </div>
                        
                        <div class="w-full h-4 bg-gray-50 rounded-full overflow-hidden mb-4">
                            <div class="h-full bg-sky-500 rounded-full transition-all duration-1000" style="width: {{ $storageUsage['percentage'] }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500 leading-relaxed">System file storage is currently at <strong>{{ $storageUsage['percentage'] }}%</strong> capacity. Automatic cleanup of old backups is enabled.</p>
                        
                        <div class="mt-8 pt-8 border-t border-gray-50">
                            <h4 class="font-bold text-gray-900 mb-4">File Storage Monitoring</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Uploaded Sources</span>
                                    <span class="font-bold text-gray-900">32.4 GB</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">System Logs</span>
                                    <span class="font-bold text-gray-900">1.2 GB</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Database Backups</span>
                                    <span class="font-bold text-gray-900">12.2 GB</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-8">Backup Management</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="backup_schedule" value="Backup Schedule" />
                                <select id="backup_schedule" name="backup_schedule" class="mt-1 block w-full rounded-2xl border-gray-200 focus:border-sky-500 focus:ring-sky-500">
                                    <option value="daily">Daily (3:00 AM)</option>
                                    <option value="weekly">Weekly (Sunday Night)</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <div>
                                    <h4 class="font-bold text-gray-900">Automatic Backup</h4>
                                    <p class="text-sm text-gray-500">Run scheduled database and file backups.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="auto_backup" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                                </label>
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-8">
                                <button type="button" class="btn-secondary py-3 text-sm font-bold flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Export Data
                                </button>
                                <button type="button" class="btn-primary py-3 text-sm font-bold flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 border-emerald-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    Backup DB
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
