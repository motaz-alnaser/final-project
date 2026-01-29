@extends('layout.master')

@section('content')
<div class="stats-section" style="padding: 60px 30px;">
    <div class="philosophy-container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto;">
            <div style="font-size: 64px; color: var(--accent-green); margin-bottom: 20px;">✓</div>
            <h2 class="section-title">Payment Successful!</h2>
            <p style="color: var(--text-secondary); margin-bottom: 30px;">
                Your booking for <strong>{{ $booking->activity->title }}</strong> has been confirmed.
            </p>
            <div style="background: rgba(0, 255, 136, 0.1); border: 1px solid var(--accent-green); border-radius: 10px; padding: 20px; margin-bottom: 30px;">
                <p><strong>Booking #{{ $booking->id }}</strong></p>
                <p>{{ $booking->activity->title }} — {{ $booking->activity->location }}</p>
                <p>Date: {{ \Carbon\Carbon::parse($booking->activity->activity_date)->format('F j, Y') }} at {{ $booking->activity->activity_time }}</p>
                <p>Total: {{ $booking->total_amount }} JOD</p>
            </div>
            <a href="{{ route('user.bookings') }}" class="card-cta">View My Bookings</a>
        </div>
    </div>
</div>
@endsection