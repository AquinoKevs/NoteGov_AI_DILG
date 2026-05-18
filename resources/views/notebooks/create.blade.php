<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Create Notebook - NoteGov AI DILG</title>
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
                height: calc(100vh - 80px);
                gap: 0;
            }
            .panel-left, .panel-right {
                background: white;
                border: 1px solid #e2e8f0;
                display: flex;
                flex-direction: column;
                height: 100%;
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
            .search-section {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 24px;
                padding: 20px;
                margin-bottom: 24px;
            }
            .search-section p {
                font-family: 'Manrope', sans-serif;
                font-size: 16px;
                color: #64748b;
                margin: 0 0 16px;
            }
            .search-options {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .search-option-btn {
                padding: 8px 16px;
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
            }
            .search-submit-btn {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                border: none;
                background: #e2e8f0;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .option-btn {
                padding: 14px 28px;
                border: 1px solid #e2e8f0;
                border-radius: 999px;
                background: white;
                font-family: 'Manrope', sans-serif;
                font-size: 18px;
                font-weight: 600;
                color: #1e293b;
                cursor: pointer;
                width: fit-content;
            }
            .option-btn:hover {
                border-color: #94a3b8;
                background: #f8fafc;
            }
        </style>
    </head>
    <body>
        <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 24px;">
                <div style="width: 48px; height: 48px; background: #1e293b; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 28px; font-weight: 700; color: #1e293b; margin: 0;">Untitled notebook</h1>
            </div>
            
            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="{{ route('notebooks.create') }}" style="padding: 12px 28px; background: #1e293b; color: white; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create notebook
                </a>
                
                <button style="padding: 10px 20px; border: 1px solid #e2e8f0; background: white; color: #475569; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Analytics
                </button>
                
                <button style="padding: 10px 20px; border: 1px solid #e2e8f0; background: white; color: #475569; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                    </svg>
                    Share
                </button>
                
                <button style="padding: 10px 20px; border: 1px solid #e2e8f0; background: white; color: #475569; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </button>
                
                <button style="width: 40px; height: 40px; background: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; position: relative;">
                    <svg style="width: 24px; height: 24px; color: #475569;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM16,6c0,1.1 0.9,2 2,2s2,-0.9 2,-2 -0.9,-2 -2,-2 -2,0.9 -2,2zM12,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2z"></path>
                    </svg>
                </button>
                
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 700;">
                    K
                </div>
            </div>
        </div>
        
        <div class="notebook-layout">
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
                <button class="add-sources-btn" type="button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add sources
                </button>
                
                <div class="search-section">
                    <p>Search the web for new sources</p>
                    <div class="search-options">
                        <button class="search-option-btn">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c1.657 0 3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            Web
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <button class="search-option-btn">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531A3.374 3.374 0 006.38 16.854l-.547-.547z"></path>
                            </svg>
                            Fast Research
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <button class="search-submit-btn">
                            <svg style="width: 20px; height: 20px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="title">Saved sources will appear here</p>
                    <p>Click Add source above to add PDFs, websites, text, videos, or audio files. Or import a file directly from Google Drive.</p>
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
                <div class="chat-welcome">
                    <div style="font-size: 48px; margin-bottom: 24px;">👋</div>
                    <h3>Let's start your notebook...</h3>
                    <p>This is your blank canvas to understand, create, or make progress on something new. I can help you get started or you can go ahead and add your own sources.</p>
                    <p style="font-weight: 700; margin-top: 32px;">What would you like this notebook to help you do?</p>
                    <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 24px;">
                        <button class="option-btn">Start a project</button>
                        <button class="option-btn">Learn or understand something</button>
                        <button class="option-btn">Create a podcast, video, slide deck, etc.</button>
                        <button class="option-btn">Something else...</button>
                    </div>
                </div>
            </div>

            <div class="chat-input-area">
                <div class="chat-input-wrapper">
                    <textarea
                        rows="3"
                        class="chat-textarea"
                        placeholder="Ask a question or create something"
                    ></textarea>
                    <span class="source-count">0 sources</span>
                    <button
                        type="button"
                        class="chat-send-btn"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
