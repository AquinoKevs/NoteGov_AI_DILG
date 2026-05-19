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
            .sources-card {
                margin-top: 24px;
                padding: 18px;
                background: #f8fafc;
                border-radius: 24px;
                border: 1px solid #e2e8f0;
            }
            .sources-card-title {
                font-family: 'Manrope', sans-serif;
                font-size: 15px;
                font-weight: 800;
                color: #0f172a;
                margin: 0 0 4px;
            }
            .sources-card-subtitle {
                font-family: 'Manrope', sans-serif;
                font-size: 12px;
                color: #64748b;
                margin: 0 0 14px;
                line-height: 1.4;
            }
            .sources-controls {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .sources-search-btn {
                width: 40px;
                height: 40px;
                border-radius: 999px;
                border: 1px solid #bfdbfe;
                background: white;
                color: #2563eb;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: all 0.15s ease;
            }
            .sources-search-btn:hover {
                background: #eff6ff;
                border-color: #93c5fd;
            }
            .sources-section-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 18px 6px 10px;
            }
            .sources-section-left {
                display: flex;
                align-items: center;
                gap: 10px;
                min-width: 0;
            }
            .sources-count-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 18px;
                min-width: 18px;
                padding: 0 6px;
                border-radius: 999px;
                background: #dbeafe;
                color: #1d4ed8;
                font-size: 11px;
                font-weight: 800;
            }
            .source-row {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 12px;
            }
            .source-left {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                min-width: 0;
            }
            .source-icon {
                width: 40px;
                height: 40px;
                border-radius: 14px;
                background: #eff6ff;
                border: 1px solid #dbeafe;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #2563eb;
                flex: 0 0 auto;
            }
            .source-meta {
                min-width: 0;
            }
            .source-desc {
                font-size: 12px;
                color: #64748b;
                margin-top: 2px;
                line-height: 1.4;
            }
            .source-added {
                font-size: 11px;
                color: #94a3b8;
                margin-top: 4px;
            }
            .source-actions {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                justify-content: space-between;
                flex: 0 0 auto;
            }
            .source-preview {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                border: 1px solid #e2e8f0;
                background: white;
                color: #2563eb;
                border-radius: 999px;
                padding: 6px 10px;
                font-size: 12px;
                font-weight: 700;
                text-decoration: none;
                transition: all 0.15s ease;
            }
            .source-preview:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }
            .sources-footer-note {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 10px 6px 0;
                color: #94a3b8;
                font-size: 11px;
                font-weight: 600;
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

            /* --- Chat UI (match reference screenshot) --- */
            .chat-header-left {
                display: flex;
                align-items: center;
                gap: 14px;
                min-width: 0;
            }
            .chat-header-icon {
                width: 36px;
                height: 36px;
                border-radius: 999px;
                background: #eef2ff;
                border: 1px solid #e2e8f0;
                color: #2563eb;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 auto;
            }
            .chat-title-wrap {
                min-width: 0;
            }
            .chat-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 20px;
                font-weight: 700;
                margin: 0;
                color: #0f172a;
                line-height: 1.1;
            }
            .chat-subtitle {
                margin: 2px 0 0;
                font-size: 12px;
                font-weight: 600;
                color: #94a3b8;
                line-height: 1.2;
            }

            #chat-scroll.panel-content {
                padding: 0;
                background: #ffffff;
            }
            .chat-thread {
                max-width: 820px;
                margin: 0 auto;
                padding: 24px 24px 28px;
            }
            .chat-message {
                display: flex;
                gap: 14px;
                align-items: flex-start;
                margin: 0 0 20px;
            }
            .chat-message.user {
                justify-content: flex-end;
            }
            .chat-message.assistant {
                justify-content: flex-start;
            }
            .chat-avatar {
                width: 34px;
                height: 34px;
                border-radius: 999px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 auto;
                border: 1px solid #e2e8f0;
                background: #f8fafc;
                color: #64748b;
                overflow: hidden;
            }
            .chat-avatar.assistant {
                background: #eef2ff;
                color: #2563eb;
            }
            .chat-avatar.user {
                background: #eff6ff;
                color: #2563eb;
            }
            .chat-bubble {
                position: relative;
                max-width: 680px;
                border-radius: 18px;
                padding: 16px 18px;
                border: 1px solid #e2e8f0;
                background: #f1f5f9;
                color: #0f172a;
            }
            .chat-message.user .chat-bubble {
                border-bottom-right-radius: 6px;
                padding-bottom: 34px;
            }
            .chat-message.assistant .chat-bubble {
                background: #ffffff;
            }
            .chat-role {
                font-size: 12px;
                font-weight: 800;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #64748b;
                margin: 0 0 8px;
            }
            .chat-content {
                font-size: 16px;
                line-height: 1.65;
                margin: 0;
                white-space: pre-wrap;
            }
            .chat-meta {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                position: absolute;
                right: 12px;
                bottom: 10px;
                font-size: 12px;
                font-weight: 700;
                color: #94a3b8;
            }
            .assistant-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1px solid #f1f5f9;
                color: #94a3b8;
                font-size: 12px;
                font-weight: 700;
            }
            .assistant-footer-left {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                min-width: 0;
            }
            .assistant-footer-right {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                flex: 0 0 auto;
            }
            .assistant-action-btn {
                width: 28px;
                height: 28px;
                border-radius: 999px;
                border: 1px solid #e2e8f0;
                background: #ffffff;
                color: #64748b;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.15s ease;
            }
            .assistant-action-btn:hover {
                background: #f8fafc;
                color: #0f172a;
                border-color: #cbd5e1;
            }

            .chat-input-area {
                border-top: 1px solid #e2e8f0;
                padding: 18px 20px;
                background: #ffffff;
            }
            .chat-input-wrapper {
                max-width: 820px;
                margin: 0 auto;
                position: relative;
            }
            .chat-composer {
                border: 1px solid #e2e8f0;
                border-radius: 18px;
                background: #ffffff;
                padding: 10px 12px;
                display: flex;
                flex-direction: column;
                gap: 10px;
                box-shadow: 0 1px 0 rgba(15, 23, 42, 0.02);
            }
            .chat-textarea {
                width: 100%;
                border: none;
                outline: none;
                resize: none;
                background: transparent;
                padding: 10px 10px 6px;
                font-family: 'Manrope', sans-serif;
                font-size: 16px;
                color: #0f172a;
                min-height: 44px;
                line-height: 1.5;
            }
            .chat-textarea::placeholder {
                color: #94a3b8;
                font-weight: 600;
            }
            .chat-composer:focus-within {
                border-color: #60a5fa;
                box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.14);
            }
            .chat-tools {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                padding: 0 6px 4px;
            }
            .chat-tools-left {
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }
            .chat-tools-right {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                flex: 0 0 auto;
            }
            .chat-pill {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 12px;
                border: 1px solid #e2e8f0;
                border-radius: 999px;
                background: #ffffff;
                color: #0f172a;
                font-size: 13px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.15s ease;
            }
            .chat-pill:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }
            .chat-icon-btn {
                width: 34px;
                height: 34px;
                border-radius: 999px;
                border: 1px solid #e2e8f0;
                background: #ffffff;
                color: #64748b;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.15s ease;
            }
            .chat-icon-btn:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
                color: #0f172a;
            }
            .source-count {
                position: static;
                font-size: 13px;
                font-weight: 800;
                color: #64748b;
                white-space: nowrap;
            }
            .chat-send-btn {
                position: static;
                width: 40px;
                height: 40px;
                border-radius: 999px;
                border: none;
                background: #2563eb;
                color: #ffffff;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: all 0.15s ease;
            }
            .chat-send-btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }
            .chat-send-btn:hover:not(:disabled) {
                background: #1d4ed8;
                color: #ffffff;
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
                        'created_at' => $message->created_at?->format('h:i A'),
                    ])->values()),
                }),
                sourcesCollapsed: false,
                selectedSourceIds: [],
                pageSourceIds: @js($sources->getCollection()->pluck('id')->values()),
                get selectAllChecked() {
                    if (!this.pageSourceIds.length) return false;
                    return this.pageSourceIds.every((id) => this.selectedSourceIds.includes(id));
                },
                toggleSelectAll() {
                    if (this.selectAllChecked) {
                        this.selectedSourceIds = this.selectedSourceIds.filter((id) => !this.pageSourceIds.includes(id));
                        return;
                    }

                    const merged = new Set([...(this.selectedSourceIds || []), ...(this.pageSourceIds || [])]);
                    this.selectedSourceIds = Array.from(merged);
                },
                showModal: false,
                modalStep: 'main',
                sourceType: 'pdf',
                fileName: '',
                sourceTitle: '',
                sourceUrl: '',
                searchQuery: '',
                searchMode: 'web',
                showShareModal: false,
                shareAccess: 'restricted',
                showAccessDropdown: false,

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
                    <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; border-radius: 50%; background: white; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='white'">
                        <svg style="width: 24px; height: 24px; color: #475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
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
                    
                    <button @click="showShareModal = true" style="padding: 10px 20px; border: 1px solid #e2e8f0; background: white; color: #475569; border-radius: 999px; font-family: 'Manrope', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        Share
                    </button>
                    
                    <div x-data="{ userMenuOpen: false }" style="position: relative;">
                        <button @click="userMenuOpen = !userMenuOpen" style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-family: 'Manrope', sans-serif; font-size: 18px; font-weight: 700; cursor: pointer; border: none;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </button>
                        <div x-show="userMenuOpen" @click.outside="userMenuOpen = false" style="position: absolute; top: 50px; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); min-width: 200px; z-index: 100;">
                            <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0;">
                                <p style="font-family: 'Manrope', sans-serif; font-size: 14px; font-weight: 700; color: #1e293b; margin: 0;">{{ Auth::user()->name ?? 'User' }}</p>
                                <p style="font-family: 'Manrope', sans-serif; font-size: 13px; color: #64748b; margin: 4px 0 0;">{{ Auth::user()->email ?? '' }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" style="width: 100%; padding: 12px 20px; text-align: left; background: none; border: none; cursor: pointer; font-family: 'Manrope', sans-serif; font-size: 14px; font-weight: 600; color: #ef4444;">
                                    Log out
                                </button>
                            </form>
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

                    <div class="sources-card">
                        <p class="sources-card-title">Find new sources</p>
                        <p class="sources-card-subtitle">Search the web for high-quality, relevant sources</p>
                        <div class="sources-controls">
                            <button class="search-option-btn" :class="searchMode === 'web' ? 'border-blue-500 bg-blue-50' : ''" @click="searchMode = 'web'" style="padding: 8px 14px;">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c1.657 0 3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                Web
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <button class="search-option-btn" :class="searchMode === 'fast' ? 'border-blue-500 bg-blue-50' : ''" @click="searchMode = 'fast'" style="padding: 8px 14px;">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531A3.374 3.374 0 006.38 16.854l-.547-.547z"></path>
                                </svg>
                                Fast Research
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <button type="button" class="sources-search-btn" @click="performSearch()" title="Search">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="sources-section-header">
                        <div class="sources-section-left">
                            <span style="font-size: 13px; font-weight: 800; color: #0f172a;">Sources</span>
                            <span class="sources-count-badge">{{ $sourcesTotal }}</span>
                        </div>
                        @if ($sources->count())
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 12px; font-weight: 700; color: #64748b;">Select all</span>
                                <input type="checkbox" :checked="selectAllChecked" @change="toggleSelectAll()" style="width: 16px; height: 16px;">
                            </div>
                        @endif
                    </div>

                    <div class="space-y-3">
                        @forelse ($sources as $source)
                            <div class="border border-gray-100 bg-white rounded-2xl px-4 py-4">
                                <div class="source-row">
                                    <div class="source-left">
                                        <div class="source-icon" aria-hidden="true">
                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h7l3 3v13a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"></path>
                                            </svg>
                                        </div>
                                        <div class="source-meta">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $source->name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ strtoupper($source->type) }}</p>
                                            @if (filled($source->summary))
                                                <div class="source-desc">{{ str($source->summary)->limit(80) }}</div>
                                            @endif
                                            <div class="source-added">Added {{ optional($source->created_at)->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="source-actions">
                                        <input
                                            type="checkbox"
                                            :value="{{ $source->id }}"
                                            x-model="selectedSourceIds"
                                            style="width: 16px; height: 16px; margin-top: 2px;"
                                            title="Include in chat context"
                                        >
                                        <a class="source-preview" href="{{ route('notebooks.sources.show', [$notebook, $source]) }}" target="_blank" rel="noopener">
                                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Preview
                                        </a>
                                    </div>
                                </div>
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

                    <div class="sources-footer-note">
                        <span>Secure &amp; private</span>
                        <span>Only selected sources will be used</span>
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
                    <div class="chat-header-left">
                        <div class="chat-header-icon" aria-hidden="true">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-3.35-.59L3 20l1.2-3.18A7.86 7.86 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div class="chat-title-wrap">
                            <p class="chat-title">Chat</p>
                            <p class="chat-subtitle">Ask questions about your sources</p>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600" type="button" aria-label="Chat menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                </div>

                <div id="chat-scroll" class="panel-content">
                    <div class="chat-thread">
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
                        <div class="chat-message" :class="message.role">
                            <template x-if="message.role === 'assistant'">
                                <div class="chat-avatar assistant" aria-hidden="true">
                                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </div>
                            </template>

                            <div class="chat-bubble">
                                <template x-if="message.role === 'assistant'">
                                    <div class="chat-role">Notegov AI</div>
                                </template>

                                <p class="chat-content" x-text="message.content"></p>

                                <template x-if="message.role === 'user'">
                                    <div class="chat-meta">
                                        <span x-text="message.created_at ?? ''"></span>
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </template>

                                <template x-if="message.role === 'assistant'">
                                    <div class="assistant-footer">
                                        <div class="assistant-footer-left">
                                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span x-text="`Answer generated from ${(selectedSourceIds.length || {{ $sourcesTotal }})} sources`"></span>
                                        </div>
                                        <div class="assistant-footer-right">
                                            <span x-text="message.created_at ?? ''"></span>
                                            <button type="button" class="assistant-action-btn" title="Helpful">
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 9V5a3 3 0 00-6 0v4H5a2 2 0 00-2 2v7a2 2 0 002 2h9a2 2 0 002-2v-1m5-10h-5.5a2 2 0 00-2 2v8a2 2 0 002 2H21a2 2 0 002-2v-7a2 2 0 00-2-2z"></path>
                                                </svg>
                                            </button>
                                            <button type="button" class="assistant-action-btn" title="Not helpful">
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 15v4a3 3 0 006 0v-4h3a2 2 0 002-2V6a2 2 0 00-2-2H8.5a2 2 0 00-2 2v8a2 2 0 002 2H10zm-5 0H3a2 2 0 01-2-2V6a2 2 0 012-2h2"></path>
                                                </svg>
                                            </button>
                                            <button type="button" class="assistant-action-btn" title="Copy">
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7V5a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2h2"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <template x-if="message.role === 'user'">
                                <div class="chat-avatar user" aria-hidden="true">
                                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </template>
                        </div>
                    </template>
                    </div>
                </div>

                <div class="chat-input-area">
                    <div class="chat-input-wrapper">
                        <div class="chat-composer">
                            <textarea
                                x-model="prompt"
                                rows="1"
                                class="chat-textarea"
                                placeholder="Ask a question or create something..."
                                @keydown.enter.prevent="if (! $event.shiftKey) { sendPrompt() } else { prompt += '\n' }"
                            ></textarea>

                            <div class="chat-tools">
                                <div class="chat-tools-left">
                                    <button type="button" class="chat-icon-btn" title="Attach">
                                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.44 11.05l-8.49 8.49a5 5 0 01-7.07-7.07l9.9-9.9a3.5 3.5 0 014.95 4.95l-9.19 9.19a2 2 0 01-2.83-2.83l8.49-8.49"></path>
                                        </svg>
                                    </button>

                                    <button type="button" class="chat-pill">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.6 9h16.8M3.6 15h16.8M12 3a15 15 0 010 18"></path>
                                        </svg>
                                        Web
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <button type="button" class="chat-pill">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531A3.374 3.374 0 006.38 16.854l-.547-.547z"></path>
                                        </svg>
                                        Fast Research
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="chat-tools-right">
                                    <span class="source-count" x-text="`${selectedSourceIds.length || {{ $sourcesTotal }}} sources`"></span>
                                    <button
                                        type="button"
                                        class="chat-send-btn"
                                        @click="sendPrompt()"
                                        :disabled="isLoading"
                                        aria-label="Send"
                                    >
                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
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
                                     selected_source_ids: (this.selectedSourceIds && this.selectedSourceIds.length) ? this.selectedSourceIds : null,
                                 }),
                             });

                             if (!response.ok) {
                                 throw new Error(`Request failed: ${response.status}`);
                             }
                             if (!response.body) {
                                 throw new Error('No response body');
                             }

                             const reader = response.body.getReader();
                             const decoder = new TextDecoder();
                             let buffer = '';

                            while (true) {
                                const { value, done } = await reader.read();
                                if (done) break;

                                 buffer += decoder.decode(value, { stream: true });
                                 const normalized = buffer.replace(/\r\n/g, '\n');
                                 const chunks = normalized.split('\n\n');
                                 buffer = chunks.pop() || '';

                                 chunks.forEach((eventChunk) => {
                                     const trimmed = eventChunk.trim();
                                     if (! trimmed.startsWith('data:')) {
                                         return;
                                     }

                                     const jsonText = trimmed.replace(/^data:\s*/, '');
                                     if (jsonText === '[DONE]') return;
                                     const payload = JSON.parse(jsonText);

                                     if (payload.chunk) {
                                         assistantMessage.content += payload.chunk;
                                         this.messages = [...this.messages];
                                     }

                                     if (payload.message) {
                                         assistantMessage.id = payload.message.id;
                                         assistantMessage.content = payload.message.content;
                                         assistantMessage.citations = payload.message.citations || [];
                                         this.messages = [...this.messages];
                                     }

                                     this.scrollToBottom();
                                 });
                             }
                         } catch (error) {
                             assistantMessage.content = 'The AI response could not be completed right now. Please try again after the current source processing finishes or after verifying the OpenAI configuration.';
                             this.messages = [...this.messages];
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
