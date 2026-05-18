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
            }
            .notebook-layout {
                display: grid;
                grid-template-columns: 380px 1fr;
                height: 100vh;
                gap: 0;
            }
            .panel-left, .panel-right {
                background: white;
                border: 1px solid #e2e8f0;
                display: flex;
                flex-direction: column;
                height: 100vh;
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
                overflow-y: auto;
                padding: 24px;
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
                max-width: 768px;
                margin: 0 auto;
            }
            .chat-welcome h3 {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 28px;
                font-weight: 700;
                margin: 0 0 24px;
                color: #1e293b;
            }
            .chat-welcome p {
                font-size: 18px;
                line-height: 1.7;
                color: #334155;
                margin: 0 0 16px;
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
                padding: 0 48px 48px;
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
                showModal: false,
                modalStep: 'main',
                sourceType: 'pdf',
                fileName: '',
                sourceTitle: '',
                sourceUrl: '',
                searchQuery: '',
                searchMode: 'web',
                performSearch() {
                    if (!this.searchQuery.trim()) {
                        alert('Please enter a search query');
                        return;
                    }
                    alert(`Searching ${this.searchMode === 'web' ? 'the web' : 'Fast Research'} for: ${this.searchQuery}\n\nWeb search integration coming soon!`);
                }
            }"
            class="notebook-layout"
        >
            <div class="panel-left">
                <div class="panel-header">
                    <h2>Sources</h2>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="panel-content">
                    <button class="add-sources-btn" type="button" @click="showModal = true; modalStep = 'main'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add sources
                    </button>

                    <div class="space-y-3">
                        @forelse ($notebook->sources as $source)
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
                        <div class="chat-welcome">
                            <h3>Hello! I'm so glad you're here.</h3>
                            <p>I'm your guide to mastering NotebookLM. Think of me as your collaborative thought partner. NotebookLM is unique because it stays <strong>grounded</strong> in the information you provide, giving you citations for every answer and helping you synthesize complex ideas.</p>
                            <p>To get started, the best first step is to add some content to the <strong>source panel</strong> on the left. You can upload PDFs, Google Docs, website links, or even YouTube videos. If you don't have a specific file ready, I can help you find some! We have <strong>"fast research"</strong> for quick web searches or <strong>"deep research"</strong> for a more comprehensive dive into a topic.</p>
                            <p>Once your sources are in, we can chat about them, or you can jump into the <strong>studio panel</strong> to create things like podcasts, study guides, or even a full slide deck in seconds.</p>
                            <p>What are you working on or hoping to learn about today? <strong>Would you like me to find some initial sources for you using a web search?</strong></p>
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
                        <span class="source-count" x-text="`{{ $notebook->sources->count() }} sources`"></span>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5a2 2 0 00-2-2v2m0 16a2 2 0 002 2h2a2 2 0 002-2m-2-2v-2"></path>
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
                        <div class="form-section" style="padding: 48px;">
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
