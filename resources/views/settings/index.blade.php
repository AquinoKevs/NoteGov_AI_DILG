<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DILG NoteGov AI - System Settings</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            min-height: 100vh;
            color: #0f172a;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #041B4D 0%, #06286b 100%);
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            box-shadow: 4px 0 24px rgba(4, 27, 77, 0.2);
        }
        
        .sidebar-header {
            margin-bottom: 48px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
        }
        
        .dilg-logo {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, #fff 0%, #f0f4ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(255, 255, 255, 0.15);
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .dilg-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        
        .brand-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .brand-text .dilg {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            line-height: 1;
        }
        
        .brand-text .notegov {
            font-size: 15px;
            font-weight: 500;
            color: #93c5fd;
            letter-spacing: 0.3px;
            line-height: 1;
        }
        
        .sidebar-nav {
            flex: 1;
        }
        
        .nav-label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 16px;
            padding-left: 4px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #cbd5e1;
            font-size: 14px;
            font-weight: 500;
            line-height: 1;
        }
        
        .nav-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #ffffff;
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
        }
        
        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }
        
        .sidebar-footer {
            margin-top: auto;
        }
        
        .profile-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }
        
        .profile-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .profile-name {
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            line-height: 1;
        }
        
        .profile-role {
            font-size: 11px;
            color: #93c5fd;
            font-weight: 500;
            line-height: 1;
        }
        
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 32px 48px;
        }
        
        .main-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        
        .header-left {
            flex: 1;
        }
        
        .header-badges {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1;
        }
        
        .badge-label {
            color: #3b82f6;
        }
        
        .badge-platform {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1d4ed8;
            padding: 6px 14px;
            border-radius: 9999px;
        }
        
        .header-title {
            font-size: 36px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }
        
        .header-subtitle {
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            line-height: 1;
            white-space: nowrap;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
        }
        
        .settings-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 32px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 0;
        }
        
        .tab {
            padding: 16px 24px;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s ease;
            background: none;
            border-top: none;
            border-left: none;
            border-right: none;
            line-height: 1;
            white-space: nowrap;
        }
        
        .tab:hover {
            color: #3b82f6;
        }
        
        .tab.active {
            color: #1d4ed8;
            border-bottom-color: #3b82f6;
        }
        
        .settings-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.05);
            border: 1px solid #e2e8f0;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1;
        }
        
        .section-title svg {
            color: #3b82f6;
            flex-shrink: 0;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            line-height: 1;
        }
        
        .form-input, .form-select {
            padding: 12px 16px 12px 44px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            font-family: inherit;
            color: #0f172a;
            background: #ffffff;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            width: 100%;
            line-height: 1.5;
        }
        
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-input::placeholder {
            color: #94a3b8;
        }
        
        .input-icon-wrapper {
            position: relative;
        }
        
        .input-icon-wrapper svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #e2e8f0 50%, transparent 100%);
            margin: 32px 0;
        }
        
        .additional-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .additional-section:last-child {
            border-bottom: none;
        }
        
        .section-info {
            flex: 1;
        }
        
        .section-info h4 {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
            line-height: 1.2;
        }
        
        .section-info p {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }
        
        .logo-upload-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .logo-preview {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px dashed #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .logo-preview img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        
        .btn-secondary {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            line-height: 1;
            white-space: nowrap;
        }
        
        .btn-secondary:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        
        .toggle-switch {
            position: relative;
            width: 56px;
            height: 30px;
            flex-shrink: 0;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #e2e8f0;
            transition: 0.3s;
            border-radius: 9999px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
            left: 3px;
            bottom: 3px;
            background: white;
            transition: 0.3s;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
        }
        
        .toggle-switch input:checked + .toggle-slider {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        
        [x-cloak] {
            display: none !important;
        }
        
        .tab-section {
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        
        .background-decoration {
            position: fixed;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: radial-gradient(ellipse at 80% 20%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        radial-gradient(ellipse at 20% 80%, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .main-header {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body x-data="{ activeTab: 'general' }">
    <div class="background-decoration"></div>
    
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <div class="dilg-logo">
                        <img src="{{ asset('images/dilg-logo.png') }}" alt="DILG Logo" onerror="this.style.display='none'; this.parentElement.innerHTML='<span style=\"font-size:20px;font-weight:800;color:#041B4D;line-height:1;\">DILG</span>';">

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

    <div class="space-y-8 py-6" x-data="{ 
        tab: '{{ session('status') && str_contains(session('status'), 'PSGC') ? 'psgc' : 'general' }}', 
        selectedFileName: '',
        importMode: 'upsert',
        isImporting: false,
        importSuccess: false,
        importMessage: '',
        psgcCounts: {
            regions: {{ $psgcCounts['regions'] }},
            provinces: {{ $psgcCounts['provinces'] }},
            cities: {{ $psgcCounts['cities'] }}
        },
        async handleImport() {
            const fileInput = document.getElementById('psgc_csv');
            if (!fileInput.files.length) return;

            this.isImporting = true;
            this.importSuccess = false;
            
            const formData = new FormData();
            formData.append('psgc_csv', fileInput.files[0]);
            formData.append('import_mode', this.importMode);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route('settings.import-psgc') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();
                
                if (result.status === 'success') {
                    this.importSuccess = true;
                    this.importMessage = result.message;
                    this.psgcCounts = result.counts;
                    this.selectedFileName = '';
                    fileInput.value = '';
                } else {
                    alert('Import failed: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Import error:', error);
                alert('An error occurred during import.');
            } finally {
                this.isImporting = false;
            }
        }
    }">
        @if (session('status'))
            <div class="panel mb-6 border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <template x-if="importSuccess">
            <div class="panel mb-6 border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span x-text="importMessage"></span>
                </div>
                <button @click="importSuccess = false" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        </template>

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
            <button @click="tab = 'psgc'" :class="tab === 'psgc' ? 'border-sky-500 text-sky-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 text-sm font-medium transition">
                5. PSGC Master Data Settings 📂
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
                    <div class="brand-text">
                        <span class="dilg">DILG</span>
                        <span class="notegov">NoteGov AI</span>
                    </div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-label">NAVIGATION</div>
                
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    My Workspace
                </a>
                
                <a href="{{ route('analytics') }}" class="nav-item">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Admin Dashboard
                </a>
                
                <a href="{{ route('users.index') }}" class="nav-item">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    User Management
                </a>
                
                <a href="{{ route('settings.index') }}" class="nav-item active">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.572c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    System Settings
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">{{ auth()->user()->name[0] ?? 'A' }}</div>
                        <div class="profile-info">
                            <div class="profile-name">Knowledge Admin</div>
                            <div class="profile-role">Super Administrator</div>
                        </div>
                        <svg style="width:16px;height:16px;color:#94a3b8;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </aside>
        
        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <div class="header-badges">
                        <span class="badge badge-label">DILG KNOWLEDGE ASSISTANT</span>
                        <span class="badge badge-platform">PLATFORM ADMINISTRATION</span>
                    </div>
                    <h1 class="header-title">System Settings</h1>
                    <p class="header-subtitle">Manage and configure the overall platform settings for NoteGov AI DILG.</p>
                </div>
                
                <button type="submit" form="settings-form" class="btn-primary">
                    <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Changes
                </button>
            </header>
            
            <div class="settings-tabs">
                <button 
                    class="tab" 
                    :class="{ 'active': activeTab === 'general' }"
                    @click="activeTab = 'general'"
                >1. General Settings</button>
                <button 
                    class="tab" 
                    :class="{ 'active': activeTab === 'featured' }"
                    @click="activeTab = 'featured'"
                >2. Featured Notebooks ⭐</button>
                <button 
                    class="tab" 
                    :class="{ 'active': activeTab === 'notifications' }"
                    @click="activeTab = 'notifications'"
                >3. Notification Settings 🔔</button>
                <button 
                    class="tab" 
                    :class="{ 'active': activeTab === 'backup' }"
                    @click="activeTab = 'backup'"
                >4. Backup & Storage 💾</button>
            </div>
            
            <form id="settings-form" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="tab-section" x-show="activeTab === 'general'">
                    <div class="settings-card">
                        <h3 class="section-title">
                            <svg style="width:22px;height:22px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            General Information
                        </h3>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">System Name</label>
                                <div class="input-icon-wrapper">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <input type="text" name="system_name" class="form-input" value="{{ $settings['system_name'] }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Organization Name</label>
                                <div class="input-icon-wrapper">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <input type="text" name="organization_name" class="form-input" value="{{ $settings['organization'] }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Timezone</label>
                                <div class="input-icon-wrapper">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <select name="timezone" class="form-select">
                                        <option value="Asia/Manila" {{ $settings['timezone'] === 'Asia/Manila' ? 'selected' : '' }}>Asia/Manila (UTC+08:00)</option>
                                        <option value="UTC">UTC</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Default Language</label>
                                <div class="input-icon-wrapper">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <select name="default_language" class="form-select">
                                        <option value="English" {{ $settings['language'] === 'English' ? 'selected' : '' }}>English</option>
                                        <option value="Filipino">Filipino</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                        
                        <div class="additional-section">
                            <div class="section-info">
                                <h4>Logo Upload</h4>
                                <p>Upload your organization's logo for the sidebar and emails.</p>
                            </div>
                            <div class="logo-upload-area">
                                <div class="logo-preview">
                                    <img src="{{ asset('images/dilg-logo.png') }}" alt="Logo" onerror="this.parentElement.innerHTML='<span style=\"font-size:24px;color:#94a3b8;\">📷</span>';">
                                </div>
                                <label class="btn-secondary" style="cursor:pointer;">
                                    Choose File
                                    <input type="file" name="logo" style="display:none;">
                                </label>
                            </div>
                        </div>
                        
                        <div class="additional-section">
                            <div class="section-info">
                                <h4>Maintenance Mode</h4>
                                <p>Put the platform in maintenance mode for updates.</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="maintenance_mode" {{ $settings['maintenance_mode'] ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="tab-section" x-show="activeTab === 'featured'">
                    <div class="settings-card">
                        <h3 class="section-title">
                            <svg style="width:22px;height:22px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976-2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            Featured Notebooks
                        </h3>
                        <p style="color:#64748b;font-size:14px;line-height:1.6;">Highlight important workspaces for all users to see.</p>
                    </div>
                </div>
                
                <div class="tab-section" x-show="activeTab === 'notifications'">
                    <div class="settings-card">
                        <h3 class="section-title">
                            <svg style="width:22px;height:22px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            Notification Settings
                        </h3>
                        <p style="color:#64748b;font-size:14px;line-height:1.6;">Configure system-wide notification preferences.</p>
                    </div>
                </div>
                
                <div class="tab-section" x-show="activeTab === 'backup'">
                    <div class="settings-card">
                        <h3 class="section-title">
                            <svg style="width:22px;height:22px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                            Backup & Storage
                        </h3>
                        <p style="color:#64748b;font-size:14px;line-height:1.6;">Manage backups and monitor storage usage.</p>
                    </div>
                </div>
            </form>
            
            <div style="text-align:center;margin-top:48px;padding-top:24px;border-top:1px solid #e2e8f0;">
                <p style="color:#64748b;font-size:13px;display:flex;align-items:center;justify-content:center;gap:8px;line-height:1.6;">
                    <svg style="width:18px;height:18px;color:#3b82f6;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Secured. Reliable. Government-Grade.
                </p>
                <p style="color:#94a3b8;font-size:12px;margin-top:8px;line-height:1.6;">NoteGov AI DILG Platform</p>
            </div>
        </main>
        </form>

        <!-- PSGC Master Data Settings -->
        <div x-show="tab === 'psgc'" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="panel bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Data Statistics</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-sky-50 p-4 rounded-2xl border border-sky-100 text-center">
                            <div class="text-2xl font-bold text-sky-600" x-text="psgcCounts.regions"></div>
                            <div class="text-xs font-semibold text-sky-500 uppercase tracking-wider">Regions</div>
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-2xl border border-indigo-100 text-center">
                            <div class="text-2xl font-bold text-indigo-600" x-text="psgcCounts.provinces"></div>
                            <div class="text-xs font-semibold text-indigo-500 uppercase tracking-wider">Provinces</div>
                        </div>
                        <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-100 text-center">
                            <div class="text-2xl font-bold text-emerald-600" x-text="psgcCounts.cities"></div>
                            <div class="text-xs font-semibold text-emerald-500 uppercase tracking-wider">Cities</div>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex gap-4">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-amber-900">Import Guidelines</h4>
                            <p class="text-xs text-amber-800 mt-1">Upload a CSV file with columns: <strong>Region, Province, City/Municipality</strong>. The system will automatically map them.</p>
                        </div>
                    </div>
                </div>

                <div class="panel bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Import PSGC Data</h3>
                    
                    <div class="mb-8">
                        <label class="text-sm font-bold text-gray-700 block mb-4">Select Import Mode</label>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                            <button @click="importMode = 'upsert'" :class="importMode === 'upsert' ? 'bg-sky-50 border-sky-500 text-sky-700 shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-white'" class="flex flex-col items-center justify-center p-4 border-2 rounded-2xl transition-all duration-200 text-center">
                                <svg class="w-5 h-5 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m0 0H15"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">Upsert</span>
                                <span class="text-[9px] mt-1 opacity-70">Insert & Update</span>
                            </button>
                            <button @click="importMode = 'insert_only'" :class="importMode === 'insert_only' ? 'bg-emerald-50 border-emerald-500 text-emerald-700 shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-white'" class="flex flex-col items-center justify-center p-4 border-2 rounded-2xl transition-all duration-200 text-center">
                                <svg class="w-5 h-5 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">Insert Only</span>
                                <span class="text-[9px] mt-1 opacity-70">Add New Only</span>
                            </button>
                            <button @click="importMode = 'update_only'" :class="importMode === 'update_only' ? 'bg-indigo-50 border-indigo-500 text-indigo-700 shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-white'" class="flex flex-col items-center justify-center p-4 border-2 rounded-2xl transition-all duration-200 text-center">
                                <svg class="w-5 h-5 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">Update Only</span>
                                <span class="text-[9px] mt-1 opacity-70">Update Existing</span>
                            </button>
                            <button @click="importMode = 'refresh'" :class="importMode === 'refresh' ? 'bg-rose-50 border-rose-500 text-rose-700 shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-white'" class="flex flex-col items-center justify-center p-4 border-2 rounded-2xl transition-all duration-200 text-center">
                                <svg class="w-5 h-5 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">Refresh</span>
                                <span class="text-[9px] mt-1 opacity-70">Wipe & Import</span>
                            </button>
                        </div>
                    </div>

                    <form @submit.prevent="handleImport" enctype="multipart/form-data" class="space-y-6">
                        <div class="relative group">
                            <label for="psgc_csv" :class="isImporting ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer hover:bg-white hover:border-sky-400'" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50 transition-all duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <template x-if="!isImporting">
                                            <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        </template>
                                        <template x-if="isImporting">
                                            <svg class="w-6 h-6 text-sky-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m0 0H15"></path></svg>
                                        </template>
                                    </div>
                                    <p class="text-sm font-bold text-gray-700" x-text="isImporting ? 'Processing data...' : (selectedFileName ? selectedFileName : 'Click to upload or drag and drop')"></p>
                                    <p class="text-xs text-gray-500 mt-1" x-show="!selectedFileName && !isImporting">CSV files only (Max. 10MB)</p>
                                    <p class="text-xs text-sky-600 mt-2 font-bold" x-show="selectedFileName && !isImporting">File selected successfully</p>
                                </div>
                                <input id="psgc_csv" name="psgc_csv" type="file" class="hidden" accept=".csv" :disabled="isImporting" @change="selectedFileName = $event.target.files[0].name" />
                            </label>
                        </div>
                        <div class="flex flex-col gap-4">
                            <button type="submit" x-show="selectedFileName && !isImporting" class="btn-primary w-full py-4 text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-sky-100 transition-all active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Import PSGC Data
                            </button>
                            <button type="button" x-show="isImporting" disabled class="btn-primary w-full py-4 text-sm font-bold flex items-center justify-center gap-2 opacity-70 cursor-not-allowed">
                                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m0 0H15"></path></svg>
                                Importing Data...
                            </button>
                            <div class="text-center">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Supports Standard PSGC CSV Format</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
