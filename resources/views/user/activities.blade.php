@extends('layout.master')

@section('style')
    <style>
        .filter-select, .filter-input {
            background: var(--carbon-medium);
            border: 1px solid var(--metal-dark);
            color: var(--text-primary);
            padding: 12px 20px;
            border-radius: 30px;
            min-width: 180px;
        }
        .filter-input {
            min-width: 250px;
        }
        .activity-card {
            height: auto;
            padding: 25px;
        }
        .card-image {
            width: 100%;
            height: 180px;
            margin-bottom: 20px;
            overflow: hidden;
            border-radius: 8px;
        }
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(30%);
            transition: transform 0.3s ease;
        }
        .card-image img:hover {
            transform: scale(1.05);
        }
        .tech-badge {
            background: rgba(153, 69, 255, 0.1);
            border: 1px solid var(--accent-purple);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .card-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--text-primary);
        }
        .stat-description {
            margin-bottom: 20px;
            color: var(--text-secondary);
        }
        .stat-number {
            font-size: 24px;
            color: var(--accent-cyan);
        }
        .card-cta {
            padding: 8px 20px;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
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
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">Loading Activities...</div>
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
                <li><a href="{{ route('user.activities') }}" class="nav-link active">Activities</a></li>
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
    <section class="hero" style="min-height: 40vh; padding: 120px 20px 60px;">
        <div class="philosophy-container">
            <div class="prism-line"></div>
            <h1 class="philosophy-headline" style="font-size: 48px;">Discover Experiences</h1>
            <p class="philosophy-subheading" style="max-width: 700px; margin: 0 auto;">
                Browse our curated collection of immersive activities across categories.
            </p>
        </div>
    </section>

    <!-- Filters -->
    <section class="stats-section" style="padding: 60px 30px;">
        <div class="philosophy-container">
            <form method="GET" action="{{ route('user.activities') }}" style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; margin-bottom: 40px;">
                <select name="category" class="filter-select" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name_en }}
                        </option>
                    @endforeach
                </select>

                <select name="location" class="filter-select" onchange="this.form.submit()">
                    <option value="all">All Locations</option>
                    @foreach($locations as $location)
                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                            {{ $location }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="search" placeholder="Search activities..." class="filter-input" value="{{ request('search') }}">
            </form>

            <!-- Activities Grid -->
            <div class="activities-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
                @forelse($activities as $activity)
                    <div class="stat-card activity-card">
                        <div class="card-image">
                            @if($activity->primaryImage)
                                <img src="{{ asset('storage/' . $activity->primaryImage->image_url) }}" alt="{{ $activity->title }}">
                            @else
                                <img src="{{ asset('images/default-activity.jpg') }}" alt="Default Image">
                            @endif
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span class="tech-badge">
                                {{ $activity->category?->name_en ?? 'General' }}
                            </span>
                            <div style="color: var(--accent-yellow); display: flex; align-items: center; gap: 5px;">
                                <span>{{ number_format($activity->rating ?? 0, 1) }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </div>
                        </div>
                        <h3 class="card-title">{{ $activity->title }}</h3>
                        <p class="stat-description">{{ $activity->location }}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="stat-number">{{ $activity->price }} JOD</div>
                            <a href="{{ route('user.activity_details', $activity->id) }}" class="card-cta">Details</a>
                        </div>
                    </div>
                @empty
                    <div class="stat-card" style="padding: 40px; text-align: center; grid-column: 1 / -1;">
                        <p>No activities found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
                <div style="margin-top: 40px; display: flex; justify-content: center;">
                    {{ $activities->appends(request()->query())->links() }}
                </div>
            @endif
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