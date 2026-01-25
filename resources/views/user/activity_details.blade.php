@extends('layout.master')

@section('style')
    <style>
        .gallery-image {
            border-radius: 10px;
            overflow: hidden;
        }
        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .review-card {
            padding: 20px;
            border-bottom: 1px solid var(--metal-dark);
        }
        .review-card:last-child {
            border-bottom: none;
        }
        .rating-stars svg {
            width: 16px;
            height: 16px;
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
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">Loading Activity...</div>
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

    <!-- Breadcrumb -->
    <div style="padding: 20px 30px; background: rgba(18, 18, 18, 0.95); border-bottom: 1px solid var(--metal-dark);">
        <div class="philosophy-container">
            <p style="color: var(--text-secondary);">
                <a href="{{ route('home') }}" style="color: var(--accent-cyan); text-decoration: none;">Home</a> 
                > 
                <a href="{{ route('user.activities') }}" style="color: var(--accent-cyan); text-decoration: none;">Activities</a> 
                > {{ $activity->title }}
            </p>
        </div>
    </div>

    <!-- Activity Details -->
    <section class="stats-section" style="padding: 60px 30px;">
        <div class="philosophy-container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 60px;">
                <!-- Gallery -->
                <div>
                    <div class="card-image" style="width: 100%; height: 400px; margin-bottom: 20px; border-radius: 20px;">
                        @if($activity->primaryImage)
                            <img src="{{ asset('storage/' . $activity->primaryImage->image_url) }}" alt="{{ $activity->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-activity.jpg') }}" alt="Default Image" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                        @foreach($activity->images as $image)
                            <div class="card-image gallery-image">
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Gallery Image" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Info -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
                        <span class="tech-badge" style="background: rgba(153, 69, 255, 0.1); border-color: var(--accent-purple);">
                            {{ $activity->category?->name ?? 'General' }}
                        </span>
                        <div class="rating-stars" style="color: var(--accent-yellow); display: flex; align-items: center; gap: 5px;">
                            <span>{{ number_format($activity->rating ?? 0, 1) }}</span>
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < floor($activity->rating ?? 0))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                @endif
                            @endfor
                            <span>({{ $activity->reviews_count ?? 0 }} reviews)</span>
                        </div>
                    </div>
                    <h1 class="philosophy-headline" style="font-size: 36px; margin-bottom: 20px; background: linear-gradient(135deg, var(--text-primary), var(--accent-purple)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $activity->title }}</h1>
                    <p style="color: var(--text-secondary); margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
                        <span>📍</span> {{ $activity->location }}
                    </p>

                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
                        <img src="{{ asset($activity->host->avatar_url ?? 'images/default-host.jpg') }}" alt="{{ $activity->host->name }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        <div>
                            <h4 style="color: var(--text-primary); margin-bottom: 5px;">{{ $activity->host->name }}</h4>
                            <p style="color: var(--text-secondary); font-size: 14px;">{{ $activity->host->bio ?? 'Host' }}</p>
                        </div>
                    </div>

                    <div style="background: rgba(153, 69, 255, 0.1); border: 1px solid var(--accent-purple); border-radius: 15px; padding: 20px; margin-bottom: 30px;">
                        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 15px;">
                            <div class="stat-number" style="font-size: 32px; color: var(--accent-cyan);">{{ $activity->price }} JOD</div>
                            @if($activity->original_price && $activity->original_price > $activity->price)
                                <div style="text-decoration: line-through; color: var(--text-dim);">{{ $activity->original_price }} JOD</div>
                                <span style="background: var(--accent-green); color: var(--primary-black); padding: 3px 10px; border-radius: 20px; font-weight: bold;">
                                    {{ round((($activity->original_price - $activity->price) / $activity->original_price) * 100) }}% OFF
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('booking.create', $activity->id) }}" class="card-cta" style="width: 100%;">Book This Activity</a>
                    </div>

                    <div class="form-group">
                        <label for="date" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Select Date</label>
                        <input type="date" id="date" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                    </div>
                </div>
            </div>

            <!-- Description -->
<div class="stat-card" style="padding: 30px; margin-bottom: 40px;">
    <h2 class="section-title">About This Activity</h2>

    @if($activity->description)
        <div class="activity-description">
            {!! nl2br(e($activity->description)) !!}
        </div>
    @else
        <p class="stat-description" style="color: var(--text-secondary);">No description available.</p>
    @endif

    
    @if($activity->description && strpos($activity->description, '### What You\'ll Get:') !== false)
        <div class="what-you-get-section">
            <h3 style="color: var(--text-primary); margin: 25px 0 15px 0; font-size: 20px; font-weight: bold;">What You'll Get:</h3>
            <ul style="color: var(--text-secondary); padding-left: 20px; list-style-type: disc;">
                @php
                    $content = $activity->description;
                    preg_match('/### What You\'ll Get:\s*([\s\S]*?)(?:\n\s*\n|###|$)/', $content, $matches);
                    $items = isset($matches[1]) ? explode("\n", trim($matches[1])) : [];
                @endphp
                @foreach($items as $item)
                    @if(trim($item) && str_starts_with(trim($item), '-'))
                        <li style="margin-bottom: 8px; line-height: 1.5;">{{ trim(substr($item, 1)) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    @if($activity->description && strpos($activity->description, '### What to Bring:') !== false)
        <div class="what-to-bring-section">
            <h3 style="color: var(--text-primary); margin: 25px 0 15px 0; font-size: 20px; font-weight: bold;">What to Bring:</h3>
            <ul style="color: var(--text-secondary); padding-left: 20px; list-style-type: disc;">
                @php
                    $content = $activity->description;
                    preg_match('/### What to Bring:\s*([\s\S]*?)(?:\n\s*\n|$)/', $content, $matches);
                    $items = isset($matches[1]) ? explode("\n", trim($matches[1])) : [];
                @endphp
                @foreach($items as $item)
                    @if(trim($item) && str_starts_with(trim($item), '-'))
                        <li style="margin-bottom: 8px; line-height: 1.5;">{{ trim(substr($item, 1)) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
</div>

            <!-- Reviews -->
            <div class="stat-card" style="padding: 30px;">
                <h2 class="section-title">Reviews & Ratings</h2>
                <div style="display: flex; align-items: center; gap: 30px; margin-bottom: 30px;">
                    <div style="font-size: 48px; font-weight: 900; color: var(--accent-cyan);">{{ number_format($activity->rating ?? 0, 1) }}</div>
                    <div>
                        <div class="rating-stars" style="color: var(--accent-yellow); display: flex; align-items: center; gap: 5px; margin-bottom: 5px;">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < floor($activity->rating ?? 0))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p style="color: var(--text-secondary);">Based on {{ $activity->reviews_count ?? 0 }} reviews</p>
                    </div>
                </div>

                @forelse($activity->reviews as $review)
                    <div class="review-card">
                        <div style="display: flex; align-items: start; gap: 15px; margin-bottom: 15px;">
                            <img src="{{ asset($review->user->avatar_url ?? 'images/default-user.jpg') }}" alt="{{ $review->user->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            <div>
                                <h4 style="color: var(--text-primary); margin-bottom: 5px;">{{ $review->user->name }}</h4>
                                <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 10px;">{{ $review->created_at->format('F j, Y') }}</p>
                                <div class="rating-stars" style="color: var(--accent-yellow); display: flex; align-items: center; gap: 5px; margin-bottom: 10px;">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $review->rating)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <p class="stat-description">{{ $review->comment }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-secondary); text-align: center; padding: 20px;">No reviews yet.</p>
                @endforelse
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