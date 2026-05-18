<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $notebook->title }} - NoteGov AI DILG</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|space-grotesk:400,500,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * {
                box-sizing: border-box;
            }
            body {
                font-family: 'Manrope', sans-serif;
                background: #f8fafc;
                margin: 0;
                padding: 0;
                color: #1e293b;
                overflow: hidden;
                height: 100dvh;
            }
            .notebook-layout {
                display: flex;
                flex: 1;
                min-height: 0;
                gap: 0;
            }
            .notebook-layout.sources-collapsed {
                /* state class used for widths below */
            }
            .notebook-layout.sources-collapsed .panel-left .panel-header {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }
            .notebook-layout.sources-collapsed .panel-left .panel-header h2 {
                display: none;
            }
            .panel-left, .panel-right {
                background: white;
                border: 1px solid #e2e8f0;
                display: flex;
                flex-direction: column;
                height: 100%;
                min-height: 0;
                overflow: hidden;
            }
            .panel-left {
                width: 380px;
                flex: 0 0 auto;
                transition: width 240ms ease;
            }
            .panel-right {
                flex: 1 1 auto;
                min-width: 0;
            }
            .notebook-layout.sources-collapsed .panel-left {
                width: 72px;
            }
            .panel-header {
                padding: 20px 24px;
                border-bottom: 1px solid #e2e8f0;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .panel-header h2 {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 22px;
                font-weight: 700;
                margin: 0;
                color: #1e293b;
            }
            .panel-content {
                flex: 1;
                min-height: 0;
                overflow-y: auto;
                padding: 24px;
            }
            .panel-content::-webkit-scrollbar {
                width: 8px;
            }
            .panel-content::-webkit-scrollbar-track {
                background: transparent;
            }
            .panel-content::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 999px;
            }
            .panel-content {
                scrollbar-width: thin;
                scrollbar-color: #cbd5e1 transparent;
            }
            .add-sources-btn {
                width: 100%;
                padding: 12px 20px;
                border: 2px dashed #cbd5e1;
                border-radius: 999px;
                background: white;
                font-family: 'Manrope', sans-serif;
                font-size: 16px;
                font-weight: 700;
                color: #1e293b;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                margin-bottom: 24px;
            }
            .add-sources-btn:hover {
                border-color: #94a3b8;
                background: #f8fafc;
            }
            .sources-collapsed-actions {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 12px;
                padding: 12px 0;
            }
            .sources-icon-btn {
                width: 44px;
                height: 44px;
                border-radius: 14px;
                border: 1px solid #e2e8f0;
                background: white;
                color: #475569;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.15s ease;
            }
            .sources-icon-btn:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
                color: #1e293b;
            }
            .sources-icon-btn.primary {
                border-style: dashed;
            }
            .sources-icon-badge {
                position: absolute;
                top: -6px;
                right: -6px;
                background: #1e293b;
                color: white;
                border-radius: 999px;
                padding: 2px 6px;
                font-size: 11px;
                font-weight: 700;
                line-height: 1.2;
                border: 2px solid white;
            }
            .empty-state {
                text-align: center;
                padding: 60px 20px;
                color: #64748b;
            }
            .empty-state svg {
                width: 48px;
                height: 48px;
                margin-bottom: 16px;
                color: #cbd5e1;
            }
            .empty-state p {
                margin: 0;
                font-size: 16px;
                line-height: 1.6;
            }
            .empty-state .title {
                font-weight: 700;
                color: #475569;
                margin-bottom: 8px;
            }
            .chat-welcome {
                max-width: 900px;
                margin: 0 auto;
                padding: 48px 32px;
            }
            .chat-welcome h3 {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 42px;
                font-weight: 700;
                margin: 0 0 24px;
                color: #1e293b;
                line-height: 1.1;
            }
            .chat-welcome p {
                font-size: 20px;
                line-height: 1.7;
                color: #475569;
                margin: 0 0 16px;
            }
            .search-option-btn {
                padding: 8px 16px;
                border: 1px solid #e2e8f0;
                background: white;
                border-radius: 999px;
                font-family: 'Manrope', sans-serif;
                font-size: 14px;
                font-weight: 600;
                color: #1e293b;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
                transition: all 0.2s ease;
            }
            .search-option-btn:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }
            .chat-input-area {
                border-top: 1px solid #e2e8f0;
                padding: 24px;
            }
            .chat-input-wrapper {
                max-width: 768px;
                margin: 0 auto;
                position: relative;
            }
            .chat-textarea {
                width: 100%;
                border: 1px solid #e2e8f0;
                border-radius: 24px;
                padding: 16px 80px 16px 24px;
                font-family: 'Manrope', sans-serif;
                font-size: 16px;
                resize: none;
                outline: none;
                background: white;
                color: #1e293b;
            }
            .chat-textarea:focus {
                border-color: #38bdf8;
                box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
            }
            .chat-send-btn {
                position: absolute;
                right: 12px;
                bottom: 12px;
                width: 48px;
                height: 48px;
                border-radius: 50%;
                border: none;
                background: #e2e8f0;
                color: #64748b;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
            }
            .chat-send-btn:hover {
                background: #38bdf8;
                color: white;
            }
            .source-count {
                position: absolute;
                right: 72px;
                bottom: 24px;
                font-size: 14px;
                font-weight: 600;
                color: #64748b;
            }
            .message {
                max-width: 768px;
                margin: 0 auto 32px;
            }
            .message.user {
                display: flex;
                justify-content: flex-end;
            }
            .message.user .bubble {
                background: #f1f5f9;
                border-radius: 24px;
                border-bottom-right-radius: 4px;
                padding: 16px 24px;
                max-width: 80%;
            }
            .message.assistant .bubble {
                padding: 0;
            }
            .message-role {
                font-size: 14px;
                font-weight: 700;
                color: #64748b;
                margin-bottom: 12px;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .message-content {
                font-size: 18px;
                line-height: 1.7;
                color: #1e293b;
            }
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
                padding: 24px;
            }
            .modal-content {
                background: white;
                border-radius: 32px;
                width: 100%;
                max-width: 900px;
                max-height: 90vh;
                overflow-y: auto;
                position: relative;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
            .modal-close {
                position: absolute;
                top: 24px;
                right: 24px;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: none;
                background: transparent;
                color: #64748b;
                cursor: pointer;
                font-size: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
            }
            .modal-close:hover {
                background: #f1f5f9;
                color: #1e293b;
            }
            .modal-header {
                padding: 48px 48px 32px;
                text-align: center;
            }
            .modal-header h2 {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 32px;
                font-weight: 700;
                margin: 0;
                color: #1e293b;
                line-height: 1.2;
            }
            .modal-header .highlight {
                background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .modal-search {
                padding: 0 48px 32px;
            }
            .search-input-wrapper {
                border: 2px solid #e2e8f0;
                border-radius: 24px;
                padding: 16px 24px;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }
            .search-input-wrapper.focused {
                border-color: #3b82f6;
            }
            .search-input {
                width: 100%;
                border: none;
                font-family: 'Manrope', sans-serif;
                font-size: 18px;
                color: #1e293b;
                outline: none;
                background: transparent;
            }
            .search-input::placeholder {
                color: #94a3b8;
            }
            .search-options {
                display: flex;
                gap: 12px;
                align-items: center;
            }
            .search-option-btn {
                padding: 10px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 999px;
                background: white;
                font-family: 'Manrope', sans-serif;
                font-size: 14px;
                font-weight: 600;
                color: #1e293b;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s ease;
            }
            .search-option-btn:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }
            .search-submit-btn {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: none;
                background: #e2e8f0;
                color: #64748b;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-left: auto;
                transition: all 0.2s ease;
            }
            .search-submit-btn:hover {
                background: #3b82f6;
                color: white;
            }
            .modal-upload {
                padding: 0 48px 48px;
            }
            .upload-area {
                border: 2px dashed #cbd5e1;
                border-radius: 32px;
                padding: 60px 40px;
                background: #f8fafc;
                text-align: center;
            }
            .upload-area h3 {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 28px;
                font-weight: 600;
                margin: 0 0 8px;
                color: #1e293b;
            }
            .upload-area p {
                margin: 0 0 32px;
                font-size: 16px;
                color: #64748b;
            }
            .upload-buttons {
                display: flex;
                gap: 16px;
                justify-content: center;
                flex-wrap: wrap;
            }
            .upload-btn {
                padding: 14px 24px;
                border: 1px solid #e2e8f0;
                border-radius: 999px;
                background: white;
                font-family: 'Manrope', sans-serif;
                font-size: 16px;
                font-weight: 700;
                color: #1e293b;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 10px;
                transition: all 0.2s ease;
            }
            .upload-btn:hover {
                background: #f1f5f9;
                border-color: #cbd5e1;
            }
            .upload-btn svg {
                width: 22px;
                height: 22px;
            }
            .form-section {
                padding: 48px;
            }
            .form-group {
                margin-bottom: 20px;
            }
            .form-group label {
                display: block;
                font-family: 'Space Grotesk', sans-serif;
                font-size: 18px;
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 8px;
            }
            .form-input {
                width: 100%;
                border: 2px solid #e2e8f0;
                border-radius: 16px;
                padding: 16px 20px;
                font-family: 'Manrope', sans-serif;
                font-size: 16px;
                color: #1e293b;
                outline: none;
                background: white;
            }
            .form-input:focus {
                border-color: #3b82f6;
            }
            .form-input::placeholder {
                color: #94a3b8;
            }
            .file-label {
                display: block;
                border: 2px dashed #cbd5e1;
                border-radius: 16px;
                padding: 32px;
                text-align: center;
                cursor: pointer;
                font-family: 'Manrope', sans-serif;
                font-size: 16px;
                color: #64748b;
                background: white;
            }
            .file-label:hover {
                border-color: #94a3b8;
                background: #f8fafc;
            }
            .back-btn {
                padding: 10px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 999px;
                background: white;
                font-family: 'Manrope', sans-serif;
                font-size: 14px;
                font-weight: 600;
                color: #64748b;
                cursor: pointer;
                margin-bottom: 20px;
            }
            .back-btn:hover {
                background: #f1f5f9;
            }
            .submit-btn {
                width: 100%;
                padding: 16px 32px;
                border: none;
                border-radius: 16px;
                background: #3b82f6;
                color: white;
                font-family: 'Space Grotesk', sans-serif;
                font-size: 18px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .submit-btn:hover {
                background: #2563eb;
            }
        </style>
    </head>
    <body>
        <div
            style="display: flex; flex-direction: column; height: 100dvh;"
            x-data="{
                ...workspaceChat({
                    endpoint: @js(route('api.notebooks.chats.messages.store', [$notebook, $activeChat])),
                    csrf: @js(csrf_token()),
                    mode: @js($activeChat->mode ?? 'qa'),
                    suggestions: @js($workspace['suggested_questions']),
                    initialMessages: @js($activeChat->messages->map(fn ($message) => [
                        'id' => $message->id,
                        'role' => $message->role,
                        'content' => $message->content,
                        'citations' => $message->citations ?? [],
                        'created_at' => $message->created_at?->format('M d, Y h:i A'),
                    ])->values()),
                }),
                sourcesCollapsed: false,
                showModal: false,
                modalStep: 'main',
                sourceType: 'pdf',
                fileName: '',
                sourceTitle: '',
                sourceUrl: '',
                searchQuery: '',
                searchMode: 'web',
                showAppsMenu: false,
                showSettingsMenu: false,
                showShareModal: false,
                shareAccess: 'restricted',
                showAccessDropdown: false,
                showAnalyticsModal: false,
                performSearch() {
                    if (!this.searchQuery.trim()) {
                        alert('Please enter a search query');
                        return;
                    }
                    alert(`Searching ${this.searchMode === 'web' ? 'the web' : 'Fast Research'} for: ${this.searchQuery}\n\nWeb search integration coming soon!`);
                }
            }"
        >
            <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 24px;">
                    <div style="width: 48px; height: 48px; background: #1e293b; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 28px; font-weight: 700; color: #1e293b; margin: 0;">{{ $notebook->title }}</h1>
                </div>
                
                <div style="display: flex; align-items: center; gap: 16px;">
                    <form method="POST" action="{{ route('notebooks.create.quick') }}">
                        @csrf
                        <button type="submit" style="padding: 12px 28px; background: #1e293b; color: white; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create notebook
                        </button>
                    </form>
                    
                    <button @click="showAnalyticsModal = true" style="padding: 10px 20px; border: 1px solid #e2e8f0; background: white; color: #475569; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Analytics
                    </button>
                    
                    <button @click="showShareModal = true" style="padding: 10px 20px; border: 1px solid #e2e8f0; background: white; color: #475569; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        Share
                    </button>
                    
                    <div style="position: relative;">
                        <button @click="showSettingsMenu = !showSettingsMenu" style="padding: 10px 20px; border: 1px solid #e2e8f0; background: white; color: #475569; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </button>
                        
                        <div x-show="showSettingsMenu" style="position: absolute; top: 56px; right: 0; width: 320px; background: white; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); z-index: 1000; overflow: hidden;" @click.outside="showSettingsMenu = false">
                            <div style="display: flex; flex-direction: column;">
                                <button style="padding: 16px 24px; border: none; background: white; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 20px; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b;">
                                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    NotebookLM Help
                                </button>
                                
                                <button style="padding: 16px 24px; border: none; background: white; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 20px; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b;">
                                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Send feedback
                                </button>
                                
                                <button style="padding: 16px 24px; border: none; background: white; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 20px; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b;">
                                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v2a2 2 0 01-2 2v4h-4v-4a2 2 0 012-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l-2 2m0 0l-2-2m2 2l2-2m-2 2l2 2"></path>
                                    </svg>
                                    Discord
                                </button>
                                
                                <button style="padding: 16px 24px; border: none; background: white; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 20px; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b;">
                                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c1.657 0 3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    Output Language
                                </button>
                                
                                <button style="padding: 16px 24px; border: none; background: white; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 20px; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b;">
                                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 018.382 3.984m-3.544 6.372C6.892 15.853 6 18.287 6 21h12c0-2.713-.892-5.147-2.382-7.016M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Licenses
                                </button>
                                
                                <button style="padding: 16px 24px; border: none; background: white; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 20px; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b;">
                                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531A3.374 3.374 0 006.38 16.854l-.547-.547z"></path>
                                    </svg>
                                    Device
                                </button>
                                
                                <div style="border-top: 1px solid #e2e8f0; margin-top: 8px;">
                                    <button style="padding: 16px 24px; border: none; background: white; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 20px; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b; width: 100%;">
                                        <div style="width: 36px; height: 36px; background: #1e293b; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                        </div>
                                        Upgrade NotebookLM
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button @click="showAppsMenu = !showAppsMenu" style="width: 40px; height: 40px; background: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; position: relative;">
                        <svg style="width: 24px; height: 24px; color: #475569;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM16,6c0,1.1 0.9,2 2,2s2,-0.9 2,-2 -0.9,-2 -2,-2 -2,0.9 -2,2zM12,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2z"></path>
                        </svg>
                    </button>
                    
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 700;">
                        K
                    </div>
                </div>
            </div>
            
            <div x-show="showAppsMenu" style="position: absolute; top: 80px; right: 32px; width: 360px; background: #f8fafc; border-radius: 32px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); z-index: 1000; padding: 32px; max-height: 80vh; overflow-y: auto;" @click.outside="showAppsMenu = false">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
                    <h2 style="font-family: 'Space Grotesk', sans-serif; font-size: 28px; font-weight: 700; color: #1e293b; margin: 0;">Your favorites</h2>
                    <button style="width: 48px; height: 48px; background: #e2e8f0; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 24px; height: 24px; color: #475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <span style="font-size: 28px; font-weight: 700; color: white;">K</span>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Account</p>
                    </div>
                    
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                            <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                <path fill="#EA4335" d="M12,37.5h24v-3h-24V37.5z"/>
                                <path fill="#4285F4" d="M12,27.5h24v-3h-24V27.5z"/>
                                <path fill="#34A853" d="M12,47.5h12v-3h-12V47.5z"/>
                                <path fill="#FBBC05" d="M36,27.5l12,12l-12,12V27.5z"/>
                            </svg>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Drive</p>
                    </div>
                    
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                            <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                <path fill="#4285F4" d="M36,12v24l18,12"/>
                                <path fill="#EA4335" d="M36,36l18,12V12"/>
                                <path fill="#FBBC05" d="M36,36L18,48V12l18,12"/>
                                <path fill="#34A853" d="M18,48l18,12l18-12"/>
                            </svg>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Gmail</p>
                    </div>
                    
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                            <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                <rect fill="#FF0000" x="8" y="24" width="56" height="24" rx="4"/>
                                <polygon fill="white" points="32,31 44,36 32,41"/>
                            </svg>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">YouTube</p>
                    </div>
                    
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                            <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                <defs>
                                    <linearGradient id="gemini-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#4285F4"/>
                                        <stop offset="33%" style="stop-color:#EA4335"/>
                                        <stop offset="66%" style="stop-color:#FBBC05"/>
                                        <stop offset="100%" style="stop-color:#34A853"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#gemini-grad)" d="M36,12c13.3,0 24,10.7 24,24s-10.7,24 -24,24s-24,-10.7 -24,-24s10.7,-24 24,-24z"/>
                                <circle fill="white" cx="36" cy="36" r="8"/>
                            </svg>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Gemini</p>
                    </div>
                    
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                            <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                <defs>
                                    <linearGradient id="maps-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" style="stop-color:#4285F4"/>
                                        <stop offset="50%" style="stop-color:#34A853"/>
                                        <stop offset="100%" style="stop-color:#EA4335"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#maps-grad)" d="M36,12c-11,0 -20,9 -20,20c0,12 20,30 20,30s20,-18 20,-30c0,-11 -9,-20 -20,-20zM36,38c-3.3,0 -6,-2.7 -6,-6s2.7,-6 6,-6s6,2.7 6,6s-2.7,6 -6,6z"/>
                            </svg>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Maps</p>
                    </div>
                    
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                            <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                <path fill="#4285F4" d="M36,12c-13.3,0 -24,10.7 -24,24s10.7,24 24,24c2.8,0 5.4,-0.5 7.9,-1.4c-1.1,-1.2 -1.9,-2.8 -1.9,-4.6c0,-3.5 2.9,-6.4 6.4,-6.4c1.1,0 2.2,0.3 3.1,0.8c2.2,-6.9 8.6,-12.2 16.2,-12.2c-1.7,-8.8 -9.3,-15.7 -19.5,-15.7z"/>
                                <path fill="#EA4335" d="M67.5,45.5c0.3,0 0.5,0 0.8,0c0.4,0 0.7,-0.1 1,-0.3c0.4,-0.2 0.7,-0.6 0.8,-1c0.1,-0.4 0.2,-0.8 0.1,-1.2c-0.1,-0.4 -0.3,-0.8 -0.6,-1.1c-0.3,-0.3 -0.7,-0.5 -1.1,-0.6c-0.4,-0.1 -0.8,-0.2 -1.3,-0.1c-0.4,0 -0.8,0.1 -1.2,0.3c-0.3,0.2 -0.6,0.5 -0.8,0.9c-0.2,0.4 -0.3,0.8 -0.2,1.3c0,0.4 0.1,0.8 0.3,1.1c0.2,0.3 0.5,0.6 0.9,0.8c0.4,0.2 0.8,0.3 1.2,0.3z"/>
                                <path fill="#FBBC05" d="M60.6,51.5c0.5,0 1,-0.1 1.4,-0.3c0.4,-0.2 0.8,-0.5 1,-1c0.2,-0.4 0.3,-0.9 0.2,-1.4c-0.1,-0.5 -0.4,-0.9 -0.8,-1.2c-0.4,-0.3 -0.8,-0.5 -1.3,-0.5c-0.5,0 -1,0.1 -1.4,0.4c-0.4,0.3 -0.7,0.7 -0.9,1.1c-0.2,0.5 -0.2,1 0,1.5c0.2,0.4 0.5,0.8 0.9,1.1c0.4,0.3 0.8,0.4 1.3,0.4z"/>
                                <path fill="#34A853" d="M53.6,57.5c0.6,0 1.2,-0.1 1.7,-0.4c0.5,-0.2 0.9,-0.6 1.2,-1.1c0.3,-0.5 0.4,-1.1 0.3,-1.7c-0.1,-0.6 -0.4,-1.1 -0.9,-1.5c-0.5,-0.4 -1.1,-0.6 -1.7,-0.6c-0.6,0 -1.2,0.2 -1.7,0.5c-0.5,0.4 -0.8,0.9 -1.1,1.5c-0.2,0.6 -0.2,1.2 0,1.7c0.3,0.5 0.6,0.9 1.1,1.2c0.5,0.3 1.1,0.4 1.7,0.4z"/>
                            </svg>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Search</p>
                    </div>
                    
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                            <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                <rect fill="#4285F4" x="8" y="12" width="56" height="48" rx="6"/>
                                <rect fill="#EA4335" x="8" y="12" width="56" height="12"/>
                                <rect fill="white" x="12" y="28" width="16" height="4" rx="2"/>
                                <rect fill="white" x="12" y="36" width="48" height="4" rx="2"/>
                                <rect fill="white" x="12" y="44" width="48" height="4" rx="2"/>
                                <text x="44" y="24" fill="white" font-size="16" font-weight="700">31</text>
                            </svg>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Calendar</p>
                    </div>
                    
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                            <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                <rect fill="#4285F4" x="8" y="16" width="56" height="40" rx="6"/>
                                <rect fill="#EA4335" x="8" y="16" width="56" height="8"/>
                                <rect fill="#FBBC05" x="16" y="32" width="40" height="8" rx="4"/>
                                <rect fill="#34A853" x="16" y="44" width="32" height="8" rx="4"/>
                                <text x="36" y="28" fill="white" font-size="14" font-weight="700" text-anchor="middle">GE</text>
                            </svg>
                        </div>
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">News</p>
                    </div>
                </div>
                
                <div style="border-top: 1px solid #e2e8f0; margin: 32px -32px; padding: 32px 32px 0;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                        <div style="text-align: center; cursor: pointer;">
                            <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                                <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                    <path fill="#EA4335" d="M36,12a24,24 0 0,1 24,24a24,24 0 0,1 -24,24a24,24 0 0,1 -24,-24a24,24 0 0,1 24,-24z"/>
                                    <path fill="#FBBC05" d="M36,12a24,24 0 0,0 0,48a12,12 0 0,0 12,-12a12,12 0 0,1 12,-12a12,12 0 0,0 -12,-12a12,12 0 0,1 -12,-12z"/>
                                    <path fill="#4285F4" d="M36,36a12,12 0 0,1 -12,-12a12,12 0 0,0 -12,12a12,12 0 0,0 12,12a12,12 0 0,1 12,-12z"/>
                                    <path fill="#34A853" d="M36,36a12,12 0 0,0 12,12a12,12 0 0,1 12,12a24,24 0 0,0 0,-48a12,12 0 0,0 -12,12a12,12 0 0,1 -12,12z"/>
                                </svg>
                            </div>
                            <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Photos</p>
                        </div>
                        
                        <div style="text-align: center; cursor: pointer;">
                            <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                                <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                    <path fill="#4285F4" d="M12,36a24,24 0 0,1 24,-24h0a24,24 0 0,1 24,24v0"/>
                                    <path fill="#EA4335" d="M60,36a24,24 0 0,1 -24,24h0a24,24 0 0,1 -24,-24v0"/>
                                    <path fill="#34A853" d="M12,36a24,24 0 0,0 24,24h0a24,24 0 0,0 24,-24v0"/>
                                    <path fill="#FBBC05" d="M60,36a24,24 0 0,0 -24,-24h0a24,24 0 0,0 -24,24v0"/>
                                </svg>
                            </div>
                            <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Meet</p>
                        </div>
                        
                        <div style="text-align: center; cursor: pointer;">
                            <div style="width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; overflow: hidden;">
                                <svg viewBox="0 0 72 72" style="width: 72px; height: 72px;">
                                    <rect fill="#4285F4" x="12" y="12" width="48" height="48" rx="8"/>
                                    <rect fill="white" x="20" y="20" width="32" height="32" rx="4"/>
                                    <text x="36" y="42" fill="#4285F4" font-size="20" font-weight="700" text-anchor="middle">G</text>
                                    <text x="50" y="42" fill="#34A853" font-size="14" font-weight="700" text-anchor="middle">文</text>
                                </svg>
                            </div>
                            <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Translate</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div x-show="showShareModal" class="modal-overlay" @click.self="showShareModal = false">
                <div class="modal-content" style="max-width: 640px; border-radius: 24px;" @click.stop>
                    <form method="POST" action="{{ route('notebooks.members.store', $notebook) }}">
                        @csrf
                        <div style="padding: 24px 32px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <svg style="width: 28px; height: 28px; color: #1e293b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                </svg>
                                <h2 style="font-family: 'Space Grotesk', sans-serif; font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Share "{{ $notebook->title }}"</h2>
                            </div>
                            <button type="button" class="modal-close" @click="showShareModal = false">&times;</button>
                        </div>
                        
                        <div style="padding: 32px;">
                            <div style="margin-bottom: 32px;">
                                <input type="email" name="email" placeholder="Add people by email *" required style="width: 100%; padding: 20px 24px; border: 2px solid #e2e8f0; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 18px; color: #1e293b; outline: none; background: white;">
                            <input type="hidden" name="permission" value="view">
                            @error('email')
                                <p style="color: #ef4444; font-size: 14px; margin-top: 8px;">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div style="margin-bottom: 32px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                                <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">People with access</h3>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 16px; padding: 16px 0; border-bottom: 1px solid #e2e8f0;">
                                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-family: 'Manrope', sans-serif; font-size: 24px; font-weight: 700;">
                                    {{ strtoupper(substr(($notebook->owner->name ?? 'K'), 0, 1)) }}
                                </div>
                                <div style="flex: 1;">
                                    <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0 0 4px;">{{ $notebook->owner->name ?? 'Owner' }}</p>
                                    <p style="font-family: 'Manrope', sans-serif; font-size: 14px; color: #64748b; margin: 0;">{{ $notebook->owner->email ?? '' }}</p>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-family: 'Manrope', sans-serif; font-size: 16px; color: #94a3b8;">Owner</span>
                                </div>
                            </div>
                            
                            @foreach($notebook->memberships as $membership)
                                <div style="display: flex; align-items: center; gap: 16px; padding: 16px 0; border-bottom: 1px solid #e2e8f0;">
                                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-family: 'Manrope', sans-serif; font-size: 24px; font-weight: 700;">
                                        {{ strtoupper(substr(($membership->user->name ?? 'U'), 0, 1)) }}
                                    </div>
                                    <div style="flex: 1;">
                                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #1e293b; margin: 0 0 4px;">{{ $membership->user->name ?? 'User' }}</p>
                                        <p style="font-family: 'Manrope', sans-serif; font-size: 14px; color: #64748b; margin: 0;">{{ $membership->user->email ?? '' }}</p>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-family: 'Manrope', sans-serif; font-size: 16px; color: #94a3b8;">{{ ucfirst($membership->permission) }}</span>
                                        <form method="POST" action="{{ route('notebooks.members.destroy', [$notebook, $membership]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="padding: 4px 8px; border: none; background: none; color: #ef4444; cursor: pointer; font-family: 'Manrope', sans-serif; font-size: 14px; font-weight: 600;">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <button type="button" onclick="navigator.clipboard.writeText('{{ request()->url() }}')" style="flex: 1; padding: 16px 32px; border: 1px solid #e2e8f0; border-radius: 999px; background: white; font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 700; color: #1e293b; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2zm6-8a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Copy link
                            </button>
                            <button type="submit" style="padding: 16px 48px; border: none; border-radius: 999px; background: #1e293b; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 700; color: white; cursor: pointer;">
                                Share
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            
            <div x-show="showAnalyticsModal" class="modal-overlay" @click.self="showAnalyticsModal = false">
                <div class="modal-content" style="max-width: 900px; border-radius: 24px;" @click.stop>
                    <div style="padding: 24px 32px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                        <h2 style="font-family: 'Space Grotesk', sans-serif; font-size: 32px; font-weight: 700; color: #1e293b; margin: 0;">Analytics</h2>
                        <button class="modal-close" @click="showAnalyticsModal = false">&times;</button>
                    </div>
                    
                    <div style="padding: 64px 48px; text-align: center;">
                        <div style="width: 200px; height: 200px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(239, 68, 68, 0.1)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 40px;">
                            <svg style="width: 80px; height: 80px; color: #1e40af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 6l18 18"></path>
                            </svg>
                        </div>
                        
                        <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 24px; font-weight: 700; color: #1e293b; margin: 0 0 24px;">No Analytics yet!</h3>
                        
                        <p style="font-family: 'Manrope', sans-serif; font-size: 20px; color: #1e293b; line-height: 1.7; margin: 0 0 16px;">To see analytics, this notebook needs to be shared with at least 4 other users and have some chat activity within the past 7 days.</p>
                        
                        <p style="font-family: 'Manrope', sans-serif; font-size: 18px; color: #64748b; margin: 0;">Note: Analytics update approximately every 24 hours.</p>
                    </div>
                </div>
            </div>
            
            <div class="notebook-layout" :class="sourcesCollapsed ? 'sources-collapsed' : ''">
            <div class="panel-left">
                <div class="panel-header">
                    <h2>Sources</h2>
                    <button type="button" class="text-gray-400 hover:text-gray-600" @click="sourcesCollapsed = !sourcesCollapsed" :aria-label="sourcesCollapsed ? 'Expand sources panel' : 'Collapse sources panel'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="panel-content" x-show="!sourcesCollapsed" x-transition.opacity.duration.200ms>
                    <button class="add-sources-btn" type="button" @click="showModal = true; modalStep = 'main'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add sources
                    </button>

                    <div style="margin-top: 24px; padding: 20px; background: #f8fafc; border-radius: 24px; border: 1px solid #e2e8f0;">
                        <p style="font-family: 'Manrope', sans-serif; font-size: 16px; color: #475569; margin: 0 0 16px;">Search the web for new sources</p>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <button class="search-option-btn" :class="searchMode === 'web' ? 'border-blue-500 bg-blue-50' : ''" @click="searchMode = 'web'" style="padding: 8px 16px; border: 1px solid #e2e8f0; background: white; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 14px; font-weight: 600; color: #1e293b; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c1.657 0 3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                Web
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <button class="search-option-btn" :class="searchMode === 'fast' ? 'border-blue-500 bg-blue-50' : ''" @click="searchMode = 'fast'" style="padding: 8px 16px; border: 1px solid #e2e8f0; background: white; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 14px; font-weight: 600; color: #1e293b; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531A3.374 3.374 0 006.38 16.854l-.547-.547z"></path>
                                </svg>
                                Fast Research
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <button @click="performSearch()" style="width: 40px; height: 40px; border-radius: 50%; border: none; background: #e2e8f0; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; margin-left: auto;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @forelse ($sources as $source)
                            <div class="border border-gray-100 bg-white rounded-2xl px-4 py-4 flex items-center justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $source->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ strtoupper($source->type) }}</p>
                                </div>
                                <form method="POST" action="{{ route('notebooks.sources.destroy', [$notebook, $source]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-rose-500 hover:text-rose-700 font-semibold" type="submit">Remove</button>
                                </form>
                            </div>
                        @empty
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="title">Saved sources will appear here</p>
                                <p>Click Add source above to add PDFs, websites, text, videos, or audio files.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($sources->hasPages())
                        <div style="margin-top: 16px;">
                            {{ $sources->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
                <div class="panel-content" x-show="sourcesCollapsed" x-transition.opacity.duration.200ms style="padding: 16px 0;">
                    <div class="sources-collapsed-actions">
                        <button type="button" class="sources-icon-btn primary" title="Add sources" @click="showModal = true; modalStep = 'main'">
                            <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>

                        <button type="button" class="sources-icon-btn" title="Search sources" @click="showModal = true; modalStep = 'main'">
                            <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>

                        <button type="button" class="sources-icon-btn" title="Show sources" @click="sourcesCollapsed = false" style="position: relative;">
                            <span class="sources-icon-badge">{{ $sourcesTotal }}</span>
                            <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-right">
                <div class="panel-header">
                    <h2>Chat</h2>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                </div>

                <div id="chat-scroll" class="panel-content">
                    <template x-if="messages.length === 0">
                        <div class="chat-welcome" style="padding: 48px 64px;">
                            <div style="font-size: 48px; margin-bottom: 24px;">👋</div>
                            <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 42px; font-weight: 700; color: #1e293b; margin: 0 0 24px; line-height: 1.1;">Let's start your notebook...</h3>
                            <p style="font-family: 'Manrope', sans-serif; font-size: 20px; color: #475569; line-height: 1.7; margin: 0 0 32px;">This is your blank canvas to understand, create, or make progress on something new. I can help you get started or you can go ahead and add your own sources.</p>
                            <p style="font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b; margin: 0 0 24px;">What would you like this notebook to help you do?</p>
                            <div style="display: flex; flex-direction: column; gap: 12px; max-width: 500px;">
                                <button type="button" @click="prompt = 'Start a project'; sendPrompt()" style="padding: 12px 24px; border: 1px solid #e2e8f0; background: white; color: #1e293b; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; align-self: flex-start;">
                                    Start a project
                                </button>
                                <button type="button" @click="prompt = 'Learn or understand something'; sendPrompt()" style="padding: 12px 24px; border: 1px solid #e2e8f0; background: white; color: #1e293b; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; align-self: flex-start;">
                                    Learn or understand something
                                </button>
                                <button type="button" @click="prompt = 'Create a podcast, video, slide deck, etc.'; sendPrompt()" style="padding: 12px 24px; border: 1px solid #e2e8f0; background: white; color: #1e293b; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; align-self: flex-start;">
                                    Create a podcast, video, slide deck, etc.
                                </button>
                                <button type="button" @click="prompt = 'Something else...'; sendPrompt()" style="padding: 12px 24px; border: 1px solid #e2e8f0; background: white; color: #1e293b; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; align-self: flex-start;">
                                    Something else...
                                </button>
                            </div>
                        </div>
                    </template>

                    <template x-for="message in messages" :key="message.id ?? `${message.role}-${message.created_at}-${message.content.length}`">
                        <div class="message" :class="message.role">
                            <div class="bubble">
                                <template x-if="message.role === 'assistant'">
                                    <div class="message-role">NoteGov AI</div>
                                </template>
                                <p class="message-content whitespace-pre-wrap" x-text="message.content"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="chat-input-area">
                    <div class="chat-input-wrapper">
                        <textarea
                            x-model="prompt"
                            rows="3"
                            class="chat-textarea"
                            placeholder="Ask a question or create something"
                        ></textarea>
                        <span class="source-count" x-text="`{{ $sourcesTotal }} sources`"></span>
                        <button
                            type="button"
                            class="chat-send-btn"
                            @click="sendPrompt()"
                            :disabled="isLoading"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="showModal" class="modal-overlay" @click.self="showModal = false">
                <div class="modal-content" @click.stop>
                    <button class="modal-close" @click="showModal = false">&times;</button>
                    
                    <template x-if="modalStep === 'main'">
                        <div>
                            <div class="modal-header">
                                <h2>Create Audio and Video Overviews from<br><span class="highlight">websites</span></h2>
                            </div>

                            <div class="modal-search">
                                <div class="search-input-wrapper">
                                    <input type="text" x-model="searchQuery" class="search-input" placeholder="Search the web for new sources">
                                    <div class="search-options">
                                        <button class="search-option-btn" :class="searchMode === 'web' ? 'border-blue-500 bg-blue-50' : ''" @click="searchMode = 'web'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c1.657 0 3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                            </svg>
                                            Web
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <button class="search-option-btn" :class="searchMode === 'fast' ? 'border-blue-500 bg-blue-50' : ''" @click="searchMode = 'fast'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531A3.374 3.374 0 006.38 16.854l-.547-.547z"></path>
                                            </svg>
                                            Fast Research
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <button class="search-submit-btn" @click="performSearch()">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-upload">
                                <div class="upload-area">
                                    <h3>or drop your files</h3>
                                    <p>pdf, images, docs, audio, and <span style="text-decoration: underline; cursor: pointer;">more</span></p>
                                    
                                    <div class="upload-buttons">
                                        <button class="upload-btn" type="button" @click="modalStep = 'upload'; sourceType = 'pdf'">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                            </svg>
                                            Upload files
                                        </button>
                                        <button class="upload-btn" type="button" @click="modalStep = 'url'; sourceType = 'url'">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2zm6-8a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Websites
                                        </button>
                                        <button class="upload-btn" type="button" @click="modalStep = 'drive'">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            Drive
                                        </button>
                                        <button class="upload-btn" type="button" @click="modalStep = 'text'; sourceType = 'txt'">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002-2h10a2 2 0 002-2M9 5a2 2 0 012-2h2a2 0 012 2M9 5a2 2 0 00-2-2v2m0 16a2 2 0 002 2h2a2 0 002-2m-2-2v-2"></path>
                                            </svg>
                                            Copied text
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="modalStep === 'upload'">
                        <div class="form-section">
                            <button class="back-btn" @click="modalStep = 'main'">&larr; Back</button>
                            <form method="POST" action="{{ route('notebooks.sources.store', $notebook) }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="source_type" :value="sourceType">
                                
                                <div class="form-group">
                                    <label>Source Title</label>
                                    <input type="text" name="title" x-model="sourceTitle" class="form-input" placeholder="Source title (optional)">
                                </div>

                                <div class="form-group">
                                    <label>Upload File</label>
                                    <label class="file-label">
                                        <input type="file" name="upload_file" class="hidden" @change="fileName = $event.target.files[0]?.name || ''">
                                        <span x-text="fileName || 'Click to select or drag file here'"></span>
                                    </label>
                                </div>

                                <button type="submit" class="submit-btn">Add Source</button>
                            </form>
                        </div>
                    </template>

                    <template x-if="modalStep === 'url'">
                        <div class="form-section">
                            <div class="flex items-center justify-between mb-8">
                                <button class="back-btn" @click="modalStep = 'main'" style="background: transparent; border: none; padding: 0; font-size: 28px; margin-bottom: 0;">&#8592;</button>
                                <h2 style="font-family: 'Space Grotesk', sans-serif; font-size: 28px; font-weight: 700; color: #1e293b; margin: 0;">Website and YouTube URLs</h2>
                                <button class="modal-close" @click="showModal = false" style="position: relative; top: auto; right: auto;">&times;</button>
                            </div>

                            <p style="font-size: 18px; color: #334155; margin-bottom: 32px;">Paste in Website and YouTube URLs below to upload as a source in NotebookLM.</p>

                            <form method="POST" action="{{ route('notebooks.sources.store', $notebook) }}">
                                @csrf
                                <input type="hidden" name="source_type" value="url">
                                
                                <div style="margin-bottom: 32px;">
                                    <textarea name="source_url" x-model="sourceUrl" rows="8" style="width: 100%; border: 2px solid #e2e8f0; border-radius: 24px; padding: 24px; font-family: 'Manrope', sans-serif; font-size: 18px; color: #1e293b; outline: none; resize: vertical; min-height: 200px;" placeholder="Paste any links"></textarea>
                                </div>

                                <ul style="font-size: 16px; color: #334155; margin: 0 0 32px 24px; padding: 0; line-height: 2;">
                                    <li>To add multiple URLs, separate with a space or new line.</li>
                                    <li>Only the visible text on the website will be imported at this time.</li>
                                    <li>Paid articles are not supported.</li>
                                    <li>Only the text transcript in YouTube will be imported at this time.</li>
                                    <li>Only public YouTube videos are supported.</li>
                                    <li>Recently uploaded videos may not be available to import.</li>
                                    <li>If upload fails, <a href="#" style="color: #3b82f6; text-decoration: underline;">learn more</a> for common reasons.</li>
                                </ul>

                                <div style="display: flex; justify-content: flex-end;">
                                    <button type="submit" style="padding: 16px 40px; border: none; border-radius: 999px; background: #e2e8f0; color: #64748b; font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; cursor: pointer;">Insert</button>
                                </div>
                            </form>
                        </div>
                    </template>

                    <template x-if="modalStep === 'text'">
                        <div class="form-section">
                            <button class="back-btn" @click="modalStep = 'main'">&larr; Back</button>
                            <form method="POST" action="{{ route('notebooks.sources.store', $notebook) }}">
                                @csrf
                                <input type="hidden" name="source_type" value="txt">
                                
                                <div class="form-group">
                                    <label>Source Title</label>
                                    <input type="text" name="title" x-model="sourceTitle" class="form-input" placeholder="Source title (optional)">
                                </div>

                                <div class="form-group">
                                    <label>Paste Text</label>
                                    <textarea name="copied_text" rows="8" class="form-input" placeholder="Paste your text here..."></textarea>
                                </div>

                                <button type="submit" class="submit-btn">Add Source</button>
                            </form>
                        </div>
                    </template>

                    <template x-if="modalStep === 'drive'">
                        <div class="form-section">
                            <button class="back-btn" @click="modalStep = 'main'">&larr; Back</button>
                            <div class="text-center py-16">
                                <svg class="w-20 h-20 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                <h3 class="text-2xl font-bold text-gray-800 mb-3">Google Drive Integration</h3>
                                <p class="text-lg text-gray-600 mb-6 max-w-md mx-auto">Coming soon! You'll be able to connect your Google Drive and import files directly from Drive into your notebook.</p>
                                <button class="submit-btn" @click="modalStep = 'main'">Back to Main Menu</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            </div>
        </div>

        <script>
            function workspaceChat(config) {
                return {
                    endpoint: config.endpoint,
                    csrf: config.csrf,
                    mode: config.mode || 'qa',
                    messages: config.initialMessages || [],
                    suggestions: config.suggestions || [],
                    prompt: '',
                    isLoading: false,
                    async sendPrompt() {
                        const userPrompt = this.prompt.trim();
                        if (! userPrompt || this.isLoading) return;

                        this.messages.push({
                            role: 'user',
                            content: userPrompt,
                            created_at: 'Now',
                            citations: [],
                        });

                        const assistantMessage = {
                            role: 'assistant',
                            content: '',
                            created_at: 'Now',
                            citations: [],
                        };

                        this.messages.push(assistantMessage);
                        this.prompt = '';
                        this.isLoading = true;
                        this.scrollToBottom();

                        try {
                            const response = await fetch(this.endpoint, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'text/event-stream',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': this.csrf,
                                },
                                body: JSON.stringify({
                                    prompt: userPrompt,
                                    mode: this.mode,
                                    stream: true,
                                }),
                            });

                            const reader = response.body.getReader();
                            const decoder = new TextDecoder();
                            let buffer = '';

                            while (true) {
                                const { value, done } = await reader.read();
                                if (done) break;

                                buffer += decoder.decode(value, { stream: true });
                                const chunks = buffer.split('\n\n');
                                buffer = chunks.pop() || '';

                                chunks.forEach((eventChunk) => {
                                    if (! eventChunk.startsWith('data: ')) {
                                        return;
                                    }

                                    const payload = JSON.parse(eventChunk.replace('data: ', ''));

                                    if (payload.chunk) {
                                        assistantMessage.content += payload.chunk;
                                    }

                                    if (payload.message) {
                                        assistantMessage.id = payload.message.id;
                                        assistantMessage.content = payload.message.content;
                                        assistantMessage.citations = payload.message.citations || [];
                                    }

                                    this.scrollToBottom();
                                });
                            }
                        } catch (error) {
                            assistantMessage.content = 'The AI response could not be completed right now. Please try again after the current source processing finishes or after verifying the OpenAI configuration.';
                        } finally {
                            this.isLoading = false;
                            this.scrollToBottom();
                        }
                    },
                    scrollToBottom() {
                        this.$nextTick(() => {
                            const container = document.getElementById('chat-scroll');
                            if (container) {
                                container.scrollTop = container.scrollHeight;
                            }
                        });
                    },
                };
            }
        </script>
    </body>
</html>
