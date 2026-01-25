@extends('layout.master')
@section('style')
    <style>
        .form-group {
            margin-bottom: 25px;
        }
        .form-label {
            display: block;
            color: var(--text-secondary);
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }
        .form-input {
            width: 100%;
            padding: 15px;
            background: var(--carbon-dark);
            border: 1px solid var(--metal-dark);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 14px;
        }
        .form-textarea {
            width: 100%;
            padding: 15px;
            background: var(--carbon-dark);
            border: 1px solid var(--metal-dark);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 14px;
            resize: vertical;
        }
        .nav-link.active {
            background: rgba(153, 69, 255, 0.1);
            color: var(--accent-cyan);
        }
        .section-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: var(--text-primary);
        }
    </style>
    @endsection
@section('content')
    <!-- Loading Screen -->
    <div class="loader" id="loader">
        <div class="loader-content">
            <div class="loader-prism">
                <div class="prism-face"></div>
                <div class="prism-face"></div>
                <div class="prism-face"></div>
            </div>
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">Loading Profile...</div>
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
            
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-primary);">
                    <img src="{{ $user->avatar_url ?? asset('images/default-avatar.jpg') }}" alt="{{ $user->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <span>{{ $user->name }}</span>
                </div>
                <div class="menu-toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Profile Header -->
    <section class="hero" style="min-height: 30vh; padding: 120px 20px 60px; background: linear-gradient(180deg, var(--primary-black) 0%, rgba(153, 69, 255, 0.05) 100%);">
        <div class="philosophy-container">
            <div style="display: flex; align-items: end; gap: 30px;">
                <div style="position: relative;">
                    <img src="{{ $user->avatar_url ?? asset('images/default-avatar.jpg') }}" alt="{{ $user->name }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent-purple);">
                    <button style="position: absolute; bottom: 0; right: 0; background: var(--accent-purple); border: none; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Change Avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </button>
                </div>
                <div>
                    <h1 class="philosophy-headline" style="font-size: 36px; margin-bottom: 10px;">{{ $user->name }}</h1>
                    <p style="color: var(--text-secondary); margin-bottom: 20px;">Member since {{ $user->created_at->format('F Y') }}</p>
                    <div style="display: flex; gap: 30px;">
                        <div style="text-align: center;">
                            <div class="stat-number" style="font-size: 24px; color: var(--accent-cyan);">{{ $user->bookings()->count() ?? 0 }}</div>
                            <div style="color: var(--text-secondary);">Booked Activities</div>
                        </div>
                        <div style="text-align: center;">
                            <div class="stat-number" style="font-size: 24px; color: var(--accent-cyan);">{{ $user->reviews()->count() ?? 0 }}</div>
                            <div style="color: var(--text-secondary);">Reviews</div>
                        </div>
                        <div style="text-align: center;">
                            <div class="stat-number" style="font-size: 24px; color: var(--accent-cyan);">{{ number_format($user->averageRatingAttribute ?? 0, 1) }}</div>
                            <div style="color: var(--text-secondary);">Avg Rating</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Content -->
    <section class="stats-section" style="padding: 60px 30px;">
        <div class="philosophy-container">
            <div style="display: grid; grid-template-columns: 300px 1fr; gap: 40px;">
                <!-- Sidebar -->
                <div class="stat-card" style="padding: 25px;">
                    <nav style="display: flex; flex-direction: column; gap: 15px;">
                        <a href="{{ route('user.profile') }}" class="nav-link active" style="padding: 12px 20px; border-radius: 10px; background: rgba(153, 69, 255, 0.1); color: var(--accent-cyan); text-decoration: none; display: flex; align-items: center; gap: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Account Info
                        </a>
                        <a href="{{ route('user.bookings') }}" class="nav-link" style="padding: 12px 20px; border-radius: 10px; color: var(--text-secondary); text-decoration: none; display: flex; align-items: center; gap: 10px; transition: all 0.3s ease;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            My Bookings
                        </a>
                       <form method="POST" action="{{ route('logout') }}" style="display:inline;">
    @csrf
    <button type="submit" class="nav-link" style="background: none; border: none; padding: 0; margin: 0; cursor: pointer; text-decoration: none; color: var(--text-secondary); display: flex; align-items: center; gap: 10px; transition: all 0.3s ease;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        Logout
    </button>
</form>
                    </nav>
                </div>

                <!-- Main Content -->
                <div>
                    <!-- Display Success Message -->
                    @if(session('success'))
                        <div style="background: var(--accent-green); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Account Info Form -->
                    <div class="stat-card" style="padding: 30px; margin-bottom: 40px;">
                        <h2 class="section-title">Account Information</h2>
                        <form method="POST" action="{{ route('user.update_profile') }}">
                            @csrf
                            @method('PUT')

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', explode(' ', $user->name)[0]) }}" required class="form-input">
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', explode(' ', $user->name)[1] ?? '') }}" required class="form-input">
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 30px;">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea id="bio" name="bio" rows="4" class="form-textarea">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                            
                            <button type="submit" class="card-cta" style="padding: 12px 30px;">Save Changes</button>
                        </form>
                    </div>

                    <!-- Change Password Form -->
                    <div class="stat-card" style="padding: 30px; margin-bottom: 40px;">
                        <h2 class="section-title">Change Password</h2>
                        <form method="POST" action="{{ route('user.change_password') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" id="current_password" name="current_password" required class="form-input">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" id="new_password" name="new_password" required class="form-input">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 30px;">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="form-input">
                            </div>
                            
                            <button type="submit" class="card-cta" style="padding: 12px 30px;">Update Password</button>
                        </form>
                    </div>

                    <!-- Upcoming Activities -->
                    <div class="stat-card" style="padding: 30px;">
                        <h2 class="section-title">Upcoming Activities</h2>
                        @forelse($user->bookings()->where('status', 'confirmed')->where('booking_date', '>=', now())->orderBy('booking_date', 'asc')->limit(2)->get() as $booking)
                            <div style="display: flex; align-items: start; gap: 20px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--metal-dark);">
                                <div style="text-align: center; min-width: 80px;">
                                    <div style="font-size: 24px; font-weight: 900; color: var(--accent-cyan);">{{ $booking->booking_date->format('d') }}</div>
                                    <div style="color: var(--text-secondary);">{{ $booking->booking_date->format('M') }}</div>
                                </div>
                                <div style="flex: 1;">
                                    <h3 class="card-title" style="font-size: 20px; margin-bottom: 10px;">{{ $booking->activity->title }}</h3>
                                    <p class="stat-description" style="margin-bottom: 10px;">{{ $booking->activity->location }}</p>
                                    <div style="color: var(--text-secondary);">{{ $booking->booking_time }}</div>
                                </div>
                                <div>
                                    <a href="{{ route('activity.show', $booking->activity->id) }}" class="card-cta" style="padding: 8px 20px; font-size: 14px;">View Details</a>
                                </div>
                            </div>
                        @empty
                            <p style="color: var(--text-secondary); text-align: center; padding: 20px;">You have no upcoming activities.</p>
                        @endforelse
                    </div>
                </div>
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