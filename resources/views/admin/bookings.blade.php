@extends('layout.admin_master')
@section('page_title', 'Bookings Management')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <!-- Filters -->
<div class="filters-bar">
    <form method="GET" action="{{ route('admin.bookings') }}">
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
                                    <a href="{{ route('admin.edit_booking', $booking->id) }}" class="action-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.delete_booking', $booking->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this reservation?')">
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
                                    <span>{{ $booking->activity->title }}</span>
                                </td>
                                <td>#{{ $booking->id }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No bookings found.
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