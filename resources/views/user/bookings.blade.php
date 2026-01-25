@extends('layout.master')

@section('style')
    <style>
        .bookings-tab {
            display: none;
        }
        .bookings-tab.active {
            display: block;
        }
        .category-tab {
            background: transparent;
            border: 1px solid var(--metal-dark);
            color: var(--text-secondary);
            padding: 12px 30px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .category-tab.active {
            background: var(--accent-purple);
            color: white;
            border-color: var(--accent-purple);
        }
        .category-tab:hover:not(.active) {
            background: var(--carbon-medium);
            color: var(--text-primary);
        }
        .booking-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .status-pending {
            background: rgba(255, 204, 0, 0.1);
            border: 1px solid var(--accent-yellow);
            color: var(--accent-yellow);
        }
        .status-confirmed {
            background: rgba(0, 255, 136, 0.1);
            border: 1px solid var(--accent-green);
            color: var(--accent-green);
        }
        .status-completed {
            background: rgba(100, 100, 100, 0.1);
            border: 1px solid var(--text-dim);
            color: var(--text-dim);
        }
        .status-cancelled {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--error);
            color: var(--error);
        }
        .booking-card {
            padding: 25px;
            margin-bottom: 20px;
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
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">Loading Bookings...</div>
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
                    <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.jpg') }}" alt="{{ auth()->user()->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="menu-toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Header -->
    <section class="hero" style="min-height: 30vh; padding: 120px 20px 60px;">
        <div class="philosophy-container">
            <div class="prism-line"></div>
            <h1 class="philosophy-headline" style="font-size: 48px;">My Bookings</h1>
            <p class="philosophy-subheading" style="max-width: 700px; margin: 0 auto;">
                Manage all your upcoming, past, and cancelled bookings
            </p>
        </div>
    </section>

    <!-- Bookings Content -->
    <section class="stats-section" style="padding: 60px 30px;">
        <div class="philosophy-container">
            <!-- Tabs -->
            <div style="display: flex; gap: 20px; margin-bottom: 40px; flex-wrap: wrap;">
                <button class="category-tab active" data-tab="upcoming" onclick="switchTab('upcoming')">Upcoming</button>
                <button class="category-tab" data-tab="past" onclick="switchTab('past')">Past</button>
                <button class="category-tab" data-tab="cancelled" onclick="switchTab('cancelled')">Cancelled</button>
            </div>

            <!-- Upcoming Bookings -->
            <div class="bookings-tab active" id="upcoming">
                @forelse($upcomingBookings as $booking)
                    <div class="stat-card booking-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <div class="booking-status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</div>
                            <div style="color: var(--text-secondary);">{{ $booking->booking_date->format('F j, Y') }}</div>
                        </div>
                        <div style="display: grid; grid-template-columns: 120px 1fr auto; gap: 20px;">
                            <div class="card-image" style="width: 100%; height: 100px; border-radius: 10px;">
                                <img src="{{ asset($booking->activity->image_url ?? 'images/default-activity.jpg') }}" alt="{{ $booking->activity->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <h3 class="card-title" style="font-size: 20px; margin-bottom: 10px;">{{ $booking->activity->title }}</h3>
                                <p class="stat-description" style="margin-bottom: 10px;">{{ $booking->activity->location }}</p>
                                <div style="color: var(--text-secondary);">{{ $booking->time ?? 'Time not set' }}</div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 10px; justify-content: center;">
                                <div style="text-align: right;">
                                    <div style="color: var(--text-secondary); font-size: 14px;">Booking #{{ $booking->id }}</div>
                                    <div class="stat-number" style="font-size: 20px; color: var(--accent-cyan);">{{ $booking->total_price ?? $booking->activity->price }} JOD</div>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 10px;">
@if($booking->status !== 'cancelled' && $booking->booking_date > now())
    @php
        $oneHourAfterCreation = $booking->created_at->addHour();
        $canCancel = now()->lt($oneHourAfterCreation);
    @endphp
    @if($canCancel)
        <form method="POST" action="{{ route('booking.cancel', $booking->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="card-cta" style="padding: 8px 20px; font-size: 14px; background: linear-gradient(135deg, #ef4444, #dc2626);">
                Cancel Booking
            </button>
        </form>
    @else
        <button class="card-cta" style="padding: 8px 20px; font-size: 14px; background: #6b7280;" disabled>
            Cannot Cancel (More than 1 hour passed)
        </button>
    @endif
@else
    <button class="card-cta" style="padding: 8px 20px; font-size: 14px; background: #6b7280;" disabled>
        {{ $booking->status === 'cancelled' ? 'Cancelled' : 'Started' }}
    </button>
@endif
                                   
                                    @if(!$booking->review)
                                        <button class="card-cta" style="padding: 8px 20px; font-size: 14px;" onclick="openReviewModal({{ $booking->id }})">Rate Activity</button>
                                    @endif
                                    <!-- <a href="{{ route('user.bookings', $booking->activity->id) }}" class="card-cta" style="padding: 8px 20px; font-size: 14px;">View Details</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="stat-card" style="padding: 40px; text-align: center;">
                        <p>You have no upcoming bookings.</p>
                    </div>
                @endforelse
            </div>

            <!-- Past Bookings -->
            <div class="bookings-tab" id="past">
                @forelse($pastBookings as $booking)
                    <div class="stat-card booking-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <div class="booking-status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</div>
                            <div style="color: var(--text-secondary);">{{ $booking->date->format('F j, Y') }}</div>
                        </div>
                        <div style="display: grid; grid-template-columns: 120px 1fr auto; gap: 20px;">
                            <div class="card-image" style="width: 100%; height: 100px; border-radius: 10px;">
                                <img src="{{ asset($booking->activity->image_url ?? 'images/default-activity.jpg') }}" alt="{{ $booking->activity->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <h3 class="card-title" style="font-size: 20px; margin-bottom: 10px;">{{ $booking->activity->title }}</h3>
                                <p class="stat-description" style="margin-bottom: 10px;">{{ $booking->activity->location }}</p>
                                <div style="color: var(--text-secondary);">{{ $booking->time ?? 'Time not set' }}</div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 10px; justify-content: center;">
                                <div style="text-align: right;">
                                    <div style="color: var(--text-secondary); font-size: 14px;">Booking #{{ $booking->id }}</div>
                                    <div class="stat-number" style="font-size: 20px; color: var(--accent-cyan);">{{ $booking->total_price ?? $booking->activity->price }} JOD</div>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    @if(!$booking->review)
                                        <button class="card-cta" style="padding: 8px 20px; font-size: 14px;" onclick="openReviewModal({{ $booking->id }})">Rate Activity</button>
                                    @endif
                                    <a href="{{ route('activity.show', $booking->activity->id) }}" class="card-cta" style="padding: 8px 20px; font-size: 14px;">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="stat-card" style="padding: 40px; text-align: center;">
                        <p>You have no past bookings.</p>
                    </div>
                @endforelse
            </div>

            <!-- Cancelled Bookings -->
            <div class="bookings-tab" id="cancelled">
                @forelse($cancelledBookings as $booking)
                    <div class="stat-card booking-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <div class="booking-status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</div>
                            <div style="color: var(--text-secondary);">{{ $booking->updated_at->format('F j, Y') }}</div>
                        </div>
                        <div style="display: grid; grid-template-columns: 120px 1fr auto; gap: 20px;">
                            <div class="card-image" style="width: 100%; height: 100px; border-radius: 10px;">
                                <img src="{{ asset($booking->activity->image_url ?? 'images/default-activity.jpg') }}" alt="{{ $booking->activity->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <h3 class="card-title" style="font-size: 20px; margin-bottom: 10px;">{{ $booking->activity->title }}</h3>
                                <p class="stat-description" style="margin-bottom: 10px;">{{ $booking->activity->location }}</p>
                                <div style="color: var(--text-secondary);">{{ $booking->time ?? 'Time not set' }}</div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 10px; justify-content: center;">
                                <div style="text-align: right;">
                                    <div style="color: var(--text-secondary); font-size: 14px;">Booking #{{ $booking->id }}</div>
                                    <div class="stat-number" style="font-size: 20px; color: var(--accent-cyan);">{{ $booking->total_price ?? $booking->activity->price }} JOD</div>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                   
                                    @if(!$booking->review)
                                        <button class="card-cta" style="padding: 8px 20px; font-size: 14px;" onclick="openReviewModal({{ $booking->id }})">Rate Activity</button>
                                    @endif
                                    <a href="{{ route('user.activity_details', $booking->activity->id) }}" class="card-cta" style="padding: 8px 20px; font-size: 14px;">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="stat-card" style="padding: 40px; text-align: center;">
                        <p>You have no cancelled bookings.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Review Modal -->
    <div id="reviewModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:1000; justify-content:center; align-items:center;">
        <div class="modal-content" style="background:var(--carbon-dark); border:1px solid var(--metal-dark); border-radius:15px; padding:30px; width:90%; max-width:500px; position:relative;">
            <h3 style="color:var(--text-primary); margin-bottom:20px;">Rate Activity</h3>

            <form id="reviewForm" method="POST" action="">
                @csrf
                <input type="hidden" name="booking_id" id="modalBookingId">

                <!-- Star Rating -->
                <div style="margin-bottom:20px;">
                    <label style="color:var(--text-secondary); display:block; margin-bottom:10px;">Your Rating:</label>
                    <div class="star-rating" style="display:flex; gap:5px; justify-content:center;">
                        <input type="radio" name="rating" value="1" id="star1" required>
                        <label for="star1" style="font-size:24px; color:#ddd; cursor:pointer;">★</label>
                        <input type="radio" name="rating" value="2" id="star2">
                        <label for="star2" style="font-size:24px; color:#ddd; cursor:pointer;">★</label>
                        <input type="radio" name="rating" value="3" id="star3">
                        <label for="star3" style="font-size:24px; color:#ddd; cursor:pointer;">★</label>
                        <input type="radio" name="rating" value="4" id="star4">
                        <label for="star4" style="font-size:24px; color:#ddd; cursor:pointer;">★</label>
                        <input type="radio" name="rating" value="5" id="star5">
                        <label for="star5" style="font-size:24px; color:#ddd; cursor:pointer;">★</label>
                    </div>
                </div>

                <!-- Review Text -->
                <div style="margin-bottom:20px;">
                    <label for="reviewText" style="color:var(--text-secondary); display:block; margin-bottom:10px;">Your Review:</label>
                    <textarea name="review_text" id="reviewText" rows="4" style="width:100%; background:var(--carbon-medium); border:1px solid var(--metal-dark); color:var(--text-primary); padding:10px; border-radius:8px;" placeholder="Write your review here..."></textarea>
                </div>

                <!-- Buttons -->
                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" class="card-cta" style="padding:8px 20px; background:var(--carbon-medium);" onclick="closeReviewModal()">Cancel</button>
                    <button type="submit" class="card-cta" style="padding:8px 20px; background:linear-gradient(135deg, var(--accent-purple), var(--accent-cyan));">Submit Review</button>
                </div>
            </form>

            <button type="button" class="close-btn" style="position:absolute; top:15px; right:15px; background:none; border:none; color:var(--text-secondary); font-size:20px; cursor:pointer;" onclick="closeReviewModal()">×</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                loader.classList.add('hidden');
            }, 1000);
        });

        function switchTab(tabName) {
            document.querySelectorAll('.bookings-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.category-tab').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }

        let currentBookingId = null;

        function openReviewModal(bookingId) {
            currentBookingId = bookingId;
            document.getElementById('modalBookingId').value = bookingId;
            document.getElementById('reviewForm').action = `/booking/review/${bookingId}`;
            document.getElementById('reviewModal').style.display = 'flex';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
            document.getElementById('reviewForm').reset();
            document.querySelectorAll('.star-rating input').forEach(radio => radio.checked = false);
        }

        document.getElementById('reviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewModal();
            }
        });
    </script>
@endsection