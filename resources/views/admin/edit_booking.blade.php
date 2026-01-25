@extends('layout.admin_master')
@section('page_title', 'Edit Booking')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <div class="stat-card centered-form-card">
                <form id="editBookingForm" method="POST" action="{{ route('admin.update_booking', $booking->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Display Success Message -->
                    @if(session('success'))
                        <div style="background: var(--accent-green); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div>
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="bookingActivity" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Activity</label>
                                <select id="bookingActivity" name="activity_id" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    @foreach($activities as $activity)
                                        <option value="{{ $activity->id }}" {{ $activity->id == old('activity_id', $booking->activity_id) ? 'selected' : '' }}>
                                            {{ $activity->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="bookingParticipants" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Number of Participants</label>
                                <input type="number" id="bookingParticipants" name="num_participants" value="{{ old('num_participants', $booking->num_participants) }}" required min="1" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="bookingDate" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Booking Date</label>
                                <input type="date" id="bookingDate" name="booking_date" value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                        </div>

                        <div>
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="bookingAmount" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Total Amount (JOD)</label>
                                <input type="number" id="bookingAmount" name="total_amount" value="{{ old('total_amount', $booking->total_amount) }}" required min="0" step="0.01" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="bookingTime" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Booking Time</label>
                                <input type="time" id="bookingTime" name="booking_time" value="{{ old('booking_time', $booking->booking_time) }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="bookingStatus" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Status</label>
                                <select id="bookingStatus" name="status" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    <option value="confirmed" {{ old('status', $booking->status) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="pending" {{ old('status', $booking->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ old('status', $booking->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $booking->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-top: 20px;">
                        <button type="submit" class="card-cta" style="flex: 1; padding: 12px;">Update Booking</button>
                        <a href="{{ route('admin.bookings') }}" class="card-cta" style="flex: 1; padding: 12px; background: linear-gradient(135deg, var(--metal-dark), var(--carbon-medium));">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/templatemo-prism-scripts.js') }}" defer></script>
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                if (loader) loader.classList.add('hidden');
            }, 1000);
        });
    </script>
@endsection