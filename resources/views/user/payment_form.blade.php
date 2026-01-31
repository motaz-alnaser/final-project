@extends('layout.master')

@section('style')
<style>
    .payment-summary {
        background: var(--carbon-dark);
        border: 1px solid var(--metal-dark);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .summary-item:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 18px;
        color: var(--accent-primary);
    }
    .btn-secondary {
        background: var(--metal-dark);
        color: var(--text-primary);
        border: 1px solid var(--metal-dark);
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        margin-right: 15px;
        transition: all 0.3s ease;
    }
    .btn-secondary:hover {
        background: var(--accent-primary);
        border-color: var(--accent-primary);
        color: #020617;
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
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">Loading...</div>
        </div>
    </div>

   

    <!-- Page Header -->
    <section class="hero" style="min-height: 30vh; padding: 120px 20px 60px;">
        <div class="philosophy-container">
            <div class="prism-line"></div>
            <h1 class="philosophy-headline" style="font-size: 48px;">Payment Summary</h1>
            <p class="philosophy-subheading" style="max-width: 700px; margin: 0 auto;">
                Review your booking details before proceeding to payment.
            </p>
        </div>
    </section>

    <!-- Payment Summary -->
    <section class="stats-section" style="padding: 60px 30px;">
        <div class="philosophy-container">
            <div style="max-width: 700px; margin: 0 auto;">
                <!-- Activity Info -->
                <div class="payment-summary">
                    <h3 style="color: var(--text-primary); margin-bottom: 20px; font-size: 24px;">Activity Details</h3>
                    <div class="summary-item">
                        <span>Activity:</span>
                        <span>{{ $activity->title }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Category:</span>
                        <span>{{ $activity->category->name_en ?? 'N/A' }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Date:</span>
                        <span>{{ \Carbon\Carbon::parse($activity->activity_date)->format('F d, Y') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Time:</span>
                        <span>{{ \Carbon\Carbon::parse($activity->activity_time)->format('g:i A') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Location:</span>
                        <span>{{ $activity->location }}</span>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="payment-summary">
                    <h3 style="color: var(--text-primary); margin-bottom: 20px; font-size: 24px;">Booking Summary</h3>
                    <div class="summary-item">
                        <span>Participants:</span>
                        <span>{{ $bookingData['num_participants'] }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Price per Person:</span>
                        <span>${{ number_format($activity->price, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Total Amount:</span>
                        <span>${{ number_format($bookingData['num_participants'] * $activity->price, 2) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; justify-content: center; gap: 15px; margin-top: 30px;">
                    <a href="{{ route('booking.create', $activity->id) }}" class="btn-secondary">
                        ← Edit Booking
                    </a>
                   <form method="POST" action="{{ route('booking.payment.process', $activity->id) }}">
    @csrf
    <button type="submit" class="card-cta" style="width: auto; padding: 12px 30px;">
        Confirm & Pay Now
    </button>
</form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@section('scripts')
@section('scripts')
<script>
    // مسح الـ loader فور تحميل صفحة ملخص الدفع
    document.addEventListener('DOMContentLoaded', () => {
        const loader = document.getElementById('loader');
        if (loader) {
            loader.classList.add('hidden');
        }
    });
</script>
@endsection
@endsection
@endsection