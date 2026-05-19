<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoteGov AI DILG - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        /* Glassmorphism login card */
        .login-card {
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

        .login-card::before {
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

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #cbd5e1;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 2px solid rgba(0, 212, 255, 0.4);
            background: rgba(17, 34, 64, 0.5);
            cursor: pointer;
            accent-color: #00d4ff;
        }

        .forgot-password {
            font-size: 13px;
            color: #00d4ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #1de0ff;
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

        .btn-secondary {
            width: 100%;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #FFFFFF;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.6);
            box-shadow: 0 4px 20px rgba(0, 212, 255, 0.2);
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
            margin-bottom: 12px;
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
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .google-icon svg {
            width: 20px;
            height: 20px;
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

        .auth-links {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 12px;
        }

        .register-link {
            font-size: 13px;
            color: #94a3b8;
            white-space: nowrap;
        }

        .register-link a {
            color: #00d4ff;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #1de0ff;
            text-decoration: underline;
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

            .auth-links {
                flex-direction: column;
                gap: 12px;
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

            .login-card {
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
            <div class="login-card">
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
                    <h1 class="card-title">Welcome back</h1>
                    <p class="card-subtitle">Sign in to continue to NoteGov AI DILG</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input 
                            id="email" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="your.name@dilg.gov.ph"
                        >
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="password-wrapper">
                            <input 
                                id="password" 
                                class="form-input"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="Enter your password"
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

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <label class="remember-me" for="remember">
                            <input id="remember" type="checkbox" name="remember">
                            Remember me
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <!-- Log in Button -->
                    <button type="submit" class="btn-primary">
                        <span>Log in</span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">or</span>
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
                    Continue with Google
                </button>

                <!-- Register Link -->
                <div class="auth-links">
                    <div class="register-link">
                        Don't have an account? <a href="{{ route('register') }}">Register</a>
                    </div>
                </div>
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
    </script>
</body>
</html>
