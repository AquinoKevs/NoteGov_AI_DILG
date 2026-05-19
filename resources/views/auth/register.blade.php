<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoteGov AI DILG - Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a192f;
            min-height: 100vh;
            color: #FFFFFF;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated scanning lines */
        .scanlines {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                transparent 50%,
                rgba(0, 212, 255, 0.02) 50%
            );
            background-size: 100% 4px;
            animation: scan 8s linear infinite;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes scan {
            from { background-position: 0 0; }
            to { background-position: 0 100%; }
        }

        /* Futuristic grid background */
        .grid-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(0, 212, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 212, 255, 0.03) 1px, transparent 1px);
            background-size: 80px 80px;
            pointer-events: none;
            z-index: 0;
        }

        /* Ambient neon glow */
        .glow-top-right {
            position: fixed;
            top: -300px;
            right: -300px;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.25) 0%, transparent 70%);
            filter: blur(100px);
            pointer-events: none;
            z-index: 0;
        }

        .glow-bottom-left {
            position: fixed;
            bottom: -300px;
            left: -300px;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.18) 0%, transparent 70%);
            filter: blur(100px);
            pointer-events: none;
            z-index: 0;
        }

        /* Main container */
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px 40px;
            gap: 40px;
            position: relative;
            z-index: 2;
            min-height: 100vh;
            align-items: center;
        }

        /* Left section */
        .left-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 0;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .dilg-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 50%;
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.3);
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .logo-text .brand-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: #00d4ff;
        }

        .logo-text .brand-name {
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
        }

        .hero-text {
            font-size: 32px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
            color: #e6f1ff;
        }

        .hero-text .accent {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .description {
            font-size: 14px;
            line-height: 1.6;
            color: #94a3b8;
            margin-bottom: 20px;
            max-width: 550px;
        }

        /* Holographic AI city illustration */
        .holographic-illustration {
            width: 100%;
            max-width: 350px;
            margin-bottom: 24px;
        }

        .holographic-illustration svg {
            width: 100%;
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.4)); }
            50% { filter: drop-shadow(0 0 40px rgba(0, 212, 255, 0.7)); }
        }

        /* Feature cards */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 12px;
            padding: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-4px);
            border-color: rgba(0, 212, 255, 0.6);
            box-shadow: 0 12px 48px rgba(0, 212, 255, 0.2);
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .feature-icon svg {
            width: 18px;
            height: 18px;
            color: #00d4ff;
        }

        .feature-card h4 {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #FFFFFF;
        }

        .feature-card p {
            font-size: 11px;
            line-height: 1.5;
            color: #94a3b8;
        }

        /* Right section */
        .right-section {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Glassmorphism register card */
        .register-card {
            width: 100%;
            max-width: 520px;
            background: rgba(17, 34, 64, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 32px rgba(0, 212, 255, 0.15);
            position: relative;
            overflow: hidden;
        }

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.8), transparent);
        }

        .card-header {
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 24px;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 8px;
        }

        .card-subtitle {
            font-size: 14px;
            color: #94a3b8;
            line-height: 1.5;
        }

        /* Form styles */
        .form-row {
            display: grid;
            grid-template-columns: 2fr 2fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #cbd5e1;
        }

        .form-label .required {
            color: #00d4ff;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(17, 34, 64, 0.8);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 10px;
            font-size: 14px;
            color: #FFFFFF;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: rgba(0, 212, 255, 0.8);
            box-shadow: 0 0 24px rgba(0, 212, 255, 0.25);
            background: rgba(17, 34, 64, 0.95);
        }

        .form-input option {
            background: #0a192f;
            color: #FFFFFF;
        }

        .form-input::placeholder {
            color: #64748b;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 6px;
            transition: color 0.3s ease;
            border-radius: 8px;
        }

        .password-toggle:hover {
            color: #00d4ff;
            background: rgba(0, 212, 255, 0.1);
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
            display: block;
        }

        /* Terms box */
        .terms-box {
            display: flex;
            gap: 10px;
            padding: 12px 16px;
            background: rgba(0, 212, 255, 0.05);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 10px;
            margin: 16px 0;
        }

        .terms-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid rgba(0, 212, 255, 0.4);
            background: rgba(17, 34, 64, 0.5);
            cursor: pointer;
            accent-color: #00d4ff;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .terms-text {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
        }

        .terms-text a {
            color: #00d4ff;
            text-decoration: none;
            font-weight: 600;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            padding: 14px 28px;
            background: linear-gradient(135deg, #00d4ff 0%, #0077b3 100%);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            color: #001122;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 32px rgba(0, 212, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 48px rgba(0, 212, 255, 0.45);
            background: linear-gradient(135deg, #1de0ff 0%, #0088cc 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary svg {
            width: 18px;
            height: 18px;
        }

        .signin-link {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
            color: #94a3b8;
        }

        .signin-link a {
            color: #00d4ff;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .signin-link a:hover {
            color: #1de0ff;
            text-decoration: underline;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: rgba(0, 212, 255, 0.25);
        }

        .divider-text {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* Google button */
        .btn-google {
            width: 100%;
            padding: 14px 28px;
            background: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-google:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0, 212, 255, 0.2);
            border-color: rgba(0, 212, 255, 0.4);
        }

        .btn-google:active {
            transform: translateY(0);
        }

        .google-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .google-icon svg {
            width: 24px;
            height: 24px;
        }

        /* Error messages */
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            color: #fca5a5;
            font-size: 14px;
        }

        .status-message {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.4);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            color: #86efac;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
                padding: 32px 24px;
                gap: 48px;
            }

            .left-section {
                align-items: center;
                text-align: center;
            }

            .hero-text {
                font-size: 36px;
            }

            .description {
                max-width: 100%;
            }

            .features-grid {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .container {
                padding: 24px 16px;
            }

            .logo-area {
                flex-direction: column;
            }

            .hero-text {
                font-size: 28px;
            }

            .register-card {
                padding: 32px 24px;
            }

            .card-title {
                font-size: 24px;
            }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <div class="grid-bg"></div>
    <div class="scanlines"></div>
    <div class="glow-top-right"></div>
    <div class="glow-bottom-left"></div>

    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="logo-area">
                <img src="{{ asset('images/dilg-logo.png') }}" alt="DILG Logo" class="dilg-logo">
                <div class="logo-text">
                    <span class="brand-label">GOVERNMENT AI</span>
                    <span class="brand-name">NoteGov AI DILG</span>
                </div>
            </div>

            <h1 class="hero-text">
                Transform government operations with <span class="accent">AI-powered intelligence</span>
            </h1>

            <p class="description">
                NoteGov AI delivers enterprise-grade policy intelligence, document analysis, and collaborative workflows designed exclusively for Philippine government institutions. Built with the latest AI technology to drive smarter, evidence-based governance.
            </p>

            <!-- Holographic AI City Illustration -->
            <div class="holographic-illustration">
                <svg viewBox="0 0 500 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="cityGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:0.8"/>
                            <stop offset="100%" style="stop-color:#00d4ff;stop-opacity:0.1"/>
                        </linearGradient>
                        <linearGradient id="glowGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:0.4"/>
                            <stop offset="100%" style="stop-color:#00d4ff;stop-opacity:0"/>
                        </linearGradient>
                    </defs>
                    
                    <!-- Background glow -->
                    <ellipse cx="250" cy="280" rx="200" ry="40" fill="url(#glowGrad)"/>
                    
                    <!-- Skyline buildings -->
                    <rect x="50" y="120" width="40" height="180" fill="url(#cityGrad)" rx="4"/>
                    <rect x="100" y="80" width="50" height="220" fill="url(#cityGrad)" rx="4"/>
                    <rect x="160" y="140" width="35" height="160" fill="url(#cityGrad)" rx="4"/>
                    <rect x="210" y="60" width="80" height="240" fill="url(#cityGrad)" rx="4"/>
                    <rect x="300" y="100" width="45" height="200" fill="url(#cityGrad)" rx="4"/>
                    <rect x="355" y="130" width="55" height="170" fill="url(#cityGrad)" rx="4"/>
                    <rect x="420" y="90" width="40" height="210" fill="url(#cityGrad)" rx="4"/>
                    
                    <!-- Windows -->
                    <g fill="#00d4ff" fill-opacity="0.6">
                        <rect x="58" y="135" width="8" height="12" rx="2"/>
                        <rect x="74" y="135" width="8" height="12" rx="2"/>
                        <rect x="58" y="160" width="8" height="12" rx="2"/>
                        <rect x="74" y="160" width="8" height="12" rx="2"/>
                        
                        <rect x="110" y="100" width="10" height="14" rx="2"/>
                        <rect x="130" y="100" width="10" height="14" rx="2"/>
                        <rect x="110" y="130" width="10" height="14" rx="2"/>
                        <rect x="130" y="130" width="10" height="14" rx="2"/>
                        
                        <rect x="225" y="80" width="12" height="16" rx="2"/>
                        <rect x="263" y="80" width="12" height="16" rx="2"/>
                        <rect x="225" y="115" width="12" height="16" rx="2"/>
                        <rect x="263" y="115" width="12" height="16" rx="2"/>
                    </g>
                    
                    <!-- Tower antenna -->
                    <line x1="250" y1="60" x2="250" y2="30" stroke="#00d4ff" stroke-width="2"/>
                    <circle cx="250" cy="25" r="6" fill="#00d4ff"/>
                    
                    <!-- Floating particles -->
                    <circle cx="150" cy="50" r="3" fill="#00d4ff" fill-opacity="0.7">
                        <animate attributeName="cy" values="50;40;50" dur="3s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="350" cy="70" r="2" fill="#00d4ff" fill-opacity="0.6">
                        <animate attributeName="cy" values="70;60;70" dur="2.5s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="400" cy="40" r="3" fill="#00d4ff" fill-opacity="0.5">
                        <animate attributeName="cy" values="40;30;40" dur="3.5s" repeatCount="indefinite"/>
                    </circle>
                </svg>
            </div>

            <!-- Feature Cards -->
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <h4>Policy Intelligence</h4>
                    <p>Advanced ML-powered policy analysis for legislative and governance documents</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h4>Collaborative Workspaces</h4>
                    <p>Secure team collaboration tools for cross-agency governance projects</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h4>Secure. Compliant. Trusted.</h4>
                    <p>Government-grade compliance with Philippine Data Privacy Act and security standards</p>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="register-card">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="card-header">
                    <h1 class="card-title">Create your account</h1>
                    <p class="card-subtitle">Build smarter, evidence-based governance for your local government unit</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Row -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="last_name">Last Name <span class="required">*</span></label>
                            <input 
                                id="last_name" 
                                class="form-input" 
                                type="text" 
                                name="last_name" 
                                value="{{ old('last_name') }}" 
                                required 
                                placeholder="Dela Cruz"
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="first_name">First Name <span class="required">*</span></label>
                            <input 
                                id="first_name" 
                                class="form-input" 
                                type="text" 
                                name="first_name" 
                                value="{{ old('first_name') }}" 
                                required 
                                placeholder="Juan"
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="middle_initial">M.I.</label>
                            <input 
                                id="middle_initial" 
                                class="form-input" 
                                type="text" 
                                name="middle_initial" 
                                value="{{ old('middle_initial') }}" 
                                maxlength="1"
                                placeholder="A"
                            >
                        </div>
                    </div>

                    <!-- Work Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Work Email <span class="required">*</span></label>
                        <input 
                            id="email" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="your.name@dilg.gov.ph"
                        >
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label" for="password">Password <span class="required">*</span></label>
                        <div class="password-wrapper">
                            <input 
                                id="password" 
                                class="form-input"
                                type="password"
                                name="password"
                                required 
                                minlength="12"
                                placeholder="Create a secure password (min. 12 characters)"
                            >
                            <button type="button" class="password-toggle" id="passwordToggle" aria-label="Show password">
                                <svg id="eyeOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eyeClosed" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password <span class="required">*</span></label>
                        <div class="password-wrapper">
                            <input 
                                id="password_confirmation" 
                                class="form-input"
                                type="password"
                                name="password_confirmation"
                                required 
                                placeholder="Confirm your password"
                            >
                            <button type="button" class="password-toggle" id="confirmPasswordToggle" aria-label="Show password">
                                <svg id="confirmEyeOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="confirmEyeClosed" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Office Selection -->
                    <div class="form-row" x-data="{ 
                        officeType: '{{ old('office_type') }}',
                        regions: {{ $regions->toJson() }},
                        provinces: {{ $provinces->toJson() }},
                        cities: {{ $cities->toJson() }},
                        selectedOfficeId: '{{ old('office_id') }}'
                    }">
                        <div class="form-group">
                            <label class="form-label" for="office_type">Select Office <span class="required">*</span></label>
                            <select 
                                id="office_type" 
                                name="office_type" 
                                class="form-input" 
                                required 
                                x-model="officeType"
                                @change="selectedOfficeId = ''"
                            >
                                <option value="" disabled selected>Choose type</option>
                                <option value="Regional">Regional</option>
                                <option value="Provincial">Provincial</option>
                                <option value="City/Municipality">City/Municipality</option>
                            </select>
                        </div>

                        <div class="form-group" style="grid-column: span 2;" x-show="officeType">
                            <label class="form-label">
                                <span x-show="officeType === 'Regional'">Select Region</span>
                                <span x-show="officeType === 'Provincial'">Select Province</span>
                                <span x-show="officeType === 'City/Municipality'">Select City/Municipality</span>
                                <span class="required">*</span>
                            </label>
                            <select 
                                name="office_id" 
                                class="form-input" 
                                required 
                                x-model="selectedOfficeId"
                            >
                                <option value="" disabled selected>Choose option</option>
                                <template x-if="officeType === 'Regional'">
                                    <template x-for="region in regions" :key="region.id">
                                        <option :value="region.id" x-text="region.name" :selected="selectedOfficeId == region.id"></option>
                                    </template>
                                </template>
                                <template x-if="officeType === 'Provincial'">
                                    <template x-for="province in provinces" :key="province.id">
                                        <option :value="province.id" x-text="province.name" :selected="selectedOfficeId == province.id"></option>
                                    </template>
                                </template>
                                <template x-if="officeType === 'City/Municipality'">
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.id" x-text="city.name" :selected="selectedOfficeId == city.id"></option>
                                    </template>
                                </template>
                            </select>
                        </div>
                    </div>

                    <!-- Terms Box -->
                    <div class="terms-box">
                        <input type="checkbox" id="terms" class="terms-checkbox" name="terms" required>
                        <div class="terms-text">
                            <label for="terms" style="cursor: pointer;">By creating an account, you agree to our <a href="{{ route('terms') }}">Terms of Service</a> and <a href="{{ route('privacy') }}">Privacy Policy</a>.</label>
                        </div>
                    </div>

                    <!-- Create Account Button -->
                    <button type="submit" class="btn-primary">
                        <span>Create Account</span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>

                <!-- Sign in Link -->
                <div class="signin-link">
                    Already registered? <a href="{{ route('login') }}">Sign in</a>
                </div>

                <!-- Divider -->
                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">or continue with</span>
                    <div class="divider-line"></div>
                </div>

                <!-- Google Button -->
                <button class="btn-google">
                    <div class="google-icon">
                        <svg viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                    </div>
                    Sign up with Google
                </button>
            </div>
        </div>
    </div>

    <script>
        // Password toggle
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        });

        // Confirm password toggle
        document.getElementById('confirmPasswordToggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const eyeOpen = document.getElementById('confirmEyeOpen');
            const eyeClosed = document.getElementById('confirmEyeClosed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        });
    </script>
</body>
</html>
