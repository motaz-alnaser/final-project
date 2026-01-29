@extends('layout.admin_master')

@section('page_title', 'Bookings Management')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
           <!-- Filters -->
<div class="filters-bar">
    <form method="GET" action="{{ route('owner.bookings') }}">
        <select name="activity" class="filter-select" onchange="this.form.submit()">
            <option value="">All Activities</option>
            @foreach($activities as $activity)
                <option value="{{ $activity->id }}" {{ request('activity') == $activity->id ? 'selected' : '' }}>
                    {{ $activity->title }}
                </option>
            @endforeach
        </select>

        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <input type="text" name="search" placeholder="Search bookings..." class="filter-input" value="{{ request('search') }}">
    </form>
</div>

            <!-- Bookings Table -->
            <div class="stat-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Participants</th>
                            <th>Date & Time</th>
                            <th>Customer</th>
                            <th>Activity</th>
                            <th>Booking ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>
                                  
                                    <form method="POST" action="{{ route('owner.delete_booking', $booking->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this reservation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($booking->status) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>{{ number_format($booking->total_amount, 2) }} JOD</td>
                                <td>{{ $booking->num_participants }}</td>
                                <td>
                                    {{ $booking->booking_date->format('M j, Y') }}<br>
                                    {{ $booking->booking_time }}
                                </td>
                                <td>{{ $booking->user->name }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div class="card-image" style="width: 40px; height: 40px; border-radius: 5px; overflow: hidden;">
                                            <img src="{{ $activity->primaryImage ? asset('storage/' . $activity->primaryImage->image_url) : asset('images/default-activity.jpg') }}" alt="{{ $activity->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <span>{{ $booking->activity->title }}</span>
                                    </div>
                                </td>
                                <td>#{{ $booking->id }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No bookings found for your activities.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
<div class="pagination-wrapper" style="margin-top: 40px; text-align: center;">
    {{ $bookings->links('vendor.pagination.custom') }}
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
                if (loader) loader.classList.add('hidden');
            }, 1000);
        });
    </script>
@endsection