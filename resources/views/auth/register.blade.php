<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoteGov AI - Register</title>
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
            background: linear-gradient(135deg, #071028 0%, #0F172A 100%);
            height: 100vh;
            display: flex;
            align-items: stretch;
            justify-content: center;
            color: #FFFFFF;
            overflow: hidden;
            position: relative;
        }

        /* Grid overlay */
        .grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 1px 1px, rgba(96, 165, 250, 0.1) 1px, transparent 0),
                linear-gradient(rgba(37, 99, 235, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.03) 1px, transparent 1px);
            background-size: 40px 40px, 80px 80px, 80px 80px;
            background-position: -1px -1px, 0 0, 0 0;
            pointer-events: none;
            z-index: 0;
        }

        /* Ambient glow */
        .glow-1 {
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.2) 0%, transparent 70%);
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        .glow-2 {
            position: absolute;
            bottom: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, transparent 70%);
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        /* Main container */
        .container {
            display: flex;
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 32px 40px;
            gap: 60px;
            position: relative;
            z-index: 1;
            height: 100%;
        }

        /* Left section */
        .left-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 40px;
            min-width: 0;
        }

        .logo-placeholder {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            margin-bottom: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-headline {
            font-size: 52px;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 24px;
            letter-spacing: -0.02em;
        }

        .main-headline .accent {
            background: linear-gradient(135deg, #2563EB 0%, #60A5FA 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .main-description {
            font-size: 18px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.7);
            max-width: 520px;
            margin-bottom: 56px;
        }

        /* Feature cards */
        .features-grid {
            display: grid;
            gap: 20px;
        }

        .feature-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 24px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(96, 165, 250, 0.3);
            transform: translateX(4px);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.3) 0%, rgba(96, 165, 250, 0.3) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon svg {
            width: 24px;
            height: 24px;
            color: #60A5FA;
        }

        .feature-content h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
            color: #FFFFFF;
        }

        .feature-content p {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
        }

        /* Right section */
        .right-section {
            flex: 0 0 auto;
            width: 100%;
            max-width: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 0;
        }

        /* Glassmorphism login card */
        .login-card {
            width: 100%;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(96, 165, 250, 0.2);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.05);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(96, 165, 250, 0.5), transparent);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #FFFFFF;
        }

        .login-header p {
            font-size: 15px;
            color: rgba(255,255,255,0.6);
        }

        /* Form styles */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            color: rgba(255,255,255,0.9);
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            font-size: 15px;
            color: #FFFFFF;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #60A5FA;
            box-shadow: 0 0 0 4px rgba(96,165,250,0.15);
            background: rgba(255,255,255,0.08);
        }

        .form-input::placeholder {
            color: rgba(255,255,255,0.4);
        }

        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
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
            color: rgba(255,255,255,0.5);
            cursor: pointer;
            padding: 4px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #FFFFFF;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            padding: 16px 32px;
            background: linear-gradient(135deg, #2563EB 0%, #60A5FA 100%);
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            color: #FFFFFF;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(37,99,235,0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(37,99,235,0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary svg {
            width: 20px;
            height: 20px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 28px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        .divider-text {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
        }

        .terms-box {
            display: flex;
            gap: 12px;
            padding: 16px 18px;
            background: rgba(37,99,235,0.05);
            border: 1px solid rgba(37,99,235,0.1);
            border-radius: 12px;
            margin: 24px 0;
        }

        .terms-icon {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, rgba(37,99,235,0.2) 0%, rgba(96,165,250,0.2) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .terms-icon svg {
            width: 14px;
            height: 14px;
            color: #2563EB;
        }

        .terms-text {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            line-height: 1.6;
        }

        .terms-text a {
            color: #60A5FA;
            text-decoration: none;
            font-weight: 500;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 32px;
        }

        .signin-link {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
        }

        .signin-link a {
            color: #60A5FA;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signin-link a:hover {
            color: #93C5FD;
            text-decoration: underline;
        }

        .error-message {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            color: #FCA5A5;
            font-size: 14px;
        }

        .status-message {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            color: #86EFAC;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .container {
                flex-direction: column;
                padding: 24px;
            }

            .left-section {
                padding: 20px;
                text-align: center;
            }

            .logo-placeholder {
                margin: 0 auto 32px;
            }

            .main-description {
                margin: 0 auto 40px;
            }

            .right-section {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .main-headline {
                font-size: 36px;
            }

            .login-card {
                padding: 32px 24px;
            }

            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="grid-overlay"></div>
    <div class="glow-1"></div>
    <div class="glow-2"></div>

    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 48px;">
                <div class="logo-placeholder" style="background: transparent; border: none; margin-bottom: 0;">
                    <img src="{{ asset('images/dilg-logo.png') }}" alt="DILG Logo" style="width: 120px; height: 120px; object-fit: contain;">
                </div>
                <div>
                    <p style="font-size: 13px; font-weight: 600; letter-spacing: 0.28em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin: 0 0 4px 0;">GOVERNMENT AI</p>
                    <p style="font-size: 32px; font-weight: 700; color: white; letter-spacing: -0.02em; margin: 0;">NoteGov AI DILG</p>
                </div>
            </div>

            <h1 class="main-headline">
                Transform government operations with <span class="accent">AI-powered</span> intelligence
            </h1>

            <p class="main-description">
                NoteGov AI delivers enterprise-grade policy intelligence, document analysis, and collaborative workflows designed exclusively for government institutions.
            </p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h4>Policy Intelligence</h4>
                        <p>Advanced analysis for legislative and policy documents</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h4>Collaborative Workspaces</h4>
                        <p>Secure team collaboration for cross-agency projects</p>
                    </div>
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

                <div class="login-header">
                    <h1>Create your account</h1>
                    <p>Join NoteGov AI DILG and start building smarter, evidence-based governance.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Row -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="last_name">Last Name <span style="color: #ef4444;">*</span></label>
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
                            <label class="form-label" for="first_name">First Name <span style="color: #ef4444;">*</span></label>
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

                        <div class="form-group" style="flex: 0 0 100px;">
                            <label class="form-label" for="middle_initial">M.I.</label>
                            <input 
                                id="middle_initial" 
                                class="form-input" 
                                type="text" 
                                name="middle_initial" 
                                value="{{ old('middle_initial') }}" 
                                maxlength="3"
                                placeholder="A"
                            >
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email <span style="color: #ef4444;">*</span></label>
                        <input 
                            id="email" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="Enter your email address"
                        >
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label" for="password">Password <span style="color: #ef4444;">*</span></label>
                        <div class="password-wrapper">
                            <input 
                                id="password" 
                                class="form-input"
                                type="password"
                                name="password"
                                required 
                                placeholder="Enter your password"
                            >
                            <button type="button" class="password-toggle" id="passwordToggle">
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
                        <label class="form-label" for="password_confirmation">Confirm Password <span style="color: #ef4444;">*</span></label>
                        <div class="password-wrapper">
                            <input 
                                id="password_confirmation" 
                                class="form-input"
                                type="password"
                                name="password_confirmation"
                                required 
                                placeholder="Confirm your password"
                            >
                            <button type="button" class="password-toggle" id="confirmPasswordToggle">
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

                    <!-- Terms Box -->
                    <div class="terms-box">
                        <div class="terms-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="terms-text">
                            By creating an account, you agree to our <a href="{{ route('terms') }}" style="color: #60A5FA; text-decoration: none; font-weight: 500;">Terms of Service</a> and <a href="{{ route('privacy') }}" style="color: #60A5FA; text-decoration: none; font-weight: 500;">Privacy Policy</a>.
                        </div>
                    </div>

                    <div class="form-footer">
                        <div class="signin-link">
                            Already registered? <a href="{{ route('login') }}">Sign in</a>
                        </div>

                        <button type="submit" class="btn-primary">
                            <span>Create Account</span>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
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
