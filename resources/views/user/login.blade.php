@extends('layout.master')
@section('content')
<body>
    <!-- Loading Screen -->
    <div class="loader" id="loader">
        <div class="loader-content">
            <div class="loader-prism">
                <div class="prism-face"></div>
                <div class="prism-face"></div>
                <div class="prism-face"></div>
            </div>
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">Authenticating...</div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="header" id="header">
        <nav class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">
                    <div class="logo-prism">
                        <div class="prism-shape"></div>
                    </div>
                </div>
                <span class="logo-text">
                    <span class="prism">PRISM</span>
                    <span class="flux">FLUX</span>
                </span>
            </a>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li><a href="{{ route('user.activities') }}" class="nav-link">Activities</a></li>
                <li><a href="#stats" class="nav-link">Metrics</a></li>
                <li><a href="#skills" class="nav-link">Arsenal</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
            
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <!-- Login Section -->
    <section class="hero" style="min-height: 100vh; padding: 120px 20px 80px; display: flex; align-items: center; justify-content: center;">
        <div class="philosophy-container" style="max-width: 500px;">
            <div class="prism-line"></div>
            <h1 class="philosophy-headline" style="font-size: 42px; margin-bottom: 20px;">Welcome Back</h1>
            <p class="philosophy-subheading" style="max-width: 500px; margin: 0 auto 40px;">
                Sign in to continue exploring activities and managing your bookings.
            </p>

            <div class="stat-card" style="padding: 40px;">

              
                @if ($errors->any())
                    <div style="background: #ff6b6b; color: white; padding: 15px; margin-bottom: 20px; border-radius: 8px; font-size: 14px;">
                        Invalid email or password.
                    </div>
                @endif

                <form method="POST" action="{{ route('login.authenticate') }}">
                    @csrf

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="email" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="password" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Password</label>
                        <input type="password" id="password" name="password" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                        <label style="display: flex; align-items: center; gap: 10px; color: var(--text-secondary);">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: var(--accent-purple);">
                            Remember me
                        </label>
                        <a href="#" style="color: var(--accent-cyan); text-decoration: none;">Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="card-cta" style="width: 100%; padding: 15px;">Sign In</button>
                </form>

                <div style="text-align: center; margin: 30px 0; position: relative;">
                    <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: var(--metal-dark);"></div>
                    <span style="background: var(--carbon-dark); padding: 0 15px; color: var(--text-secondary); position: relative;">OR</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <button class="card-cta" style="background: linear-gradient(135deg, #db4437, #e74c3c); padding: 12px;" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="margin-left: 10px;">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c1.32 0 2.57-.26 3.72-.74l-2.53-2.53c-.53.36-1.15.59-1.81.67v-5.5H8.5v-2.5h2.69V9.7c0-2.63 1.59-4.05 3.99-4.05.98 0 1.99.09 2.96.27l.45-2.5C17.26 2.34 14.74 2 12 2z"/>
                        </svg>
                        Continue with Google
                    </button>
                    <button class="card-cta" style="background: linear-gradient(135deg, #000000, #333333); padding: 12px;" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="margin-left: 10px;">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                            <circle cx="12" cy="9" r="2"/>
                        </svg>
                        Continue with Apple
                    </button>
                </div>

                <p style="text-align: center; margin-top: 30px; color: var(--text-secondary);">
                    Don't have an account? <a href="{{ route('user.register') }}" style="color: var(--accent-cyan); text-decoration: none;">Sign up</a>
                </p>
            </div>
        </div>
    </section>
    @endsection

    @section('scripts')

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                loader.classList.add('hidden');
            }, 1000);
        });
    </script>
    @endsection
