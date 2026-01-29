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
        .form-select {
            width: 100%;
            padding: 15px;
            background: var(--carbon-dark);
            border: 1px solid var(--metal-dark);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 14px;
        }
        .card-cta {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            text-align: center;
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
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">Booking...</div>
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

    <!-- Page Header -->
    <section class="hero" style="min-height: 30vh; padding: 120px 20px 60px;">
        <div class="philosophy-container">
            <div class="prism-line"></div>
            <h1 class="philosophy-headline" style="font-size: 48px;">Book {{ $activity->title }}</h1>
            <p class="philosophy-subheading" style="max-width: 700px; margin: 0 auto;">
                Complete the form below to reserve your spot for this activity.
            </p>
        </div>
    </section>

    <!-- Booking Form -->
    <section class="stats-section" style="padding: 60px 30px;">
        <div class="philosophy-container">
            <div class="stat-card" style="padding: 40px;">
                <form method="POST" action="{{ route('booking.store', $activity->id) }}">
                    @csrf

                   

                   

                    <div class="form-group">
                        <label for="num_participants" class="form-label">Number of Participants (Max: {{ $activity->max_participants }})</label>
                        <input type="number" id="num_participants" name="num_participants" min="1" max="{{ $activity->max_participants }}" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="total_amount" class="form-label">Total Amount ({{ $activity->price }} JOD per person)</label>
                        <input type="number" id="total_amount" name="total_amount" step="0.01" readonly class="form-input" value="{{ $activity->price }}">
                    </div>

                    <button type="submit" class="card-cta">Confirm Booking</button>
                </form>
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

        document.getElementById('num_participants').addEventListener('input', function() {
            const pricePerPerson = {{ $activity->price }};
            const numParticipants = parseInt(this.value) || 0;
            const totalAmount = pricePerPerson * numParticipants;
            document.getElementById('total_amount').value = totalAmount.toFixed(2);
        });
    </script>
    @endsection
