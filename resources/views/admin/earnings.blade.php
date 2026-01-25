@extends('layout.admin_master')

@section('page_title', 'Earnings Management')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <!-- Summary Cards -->
            <div class="dashboard-stats-grid">
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(249, 115, 22, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="M12 10v6"></path>
                            <path d="M8 10h8"></path>
                        </svg>
                    </div>
                    <div class="stat-number">{{ number_format($totalEarnings, 2) }} JOD</div>
                    <div class="stat-label">Total Earnings</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(249, 115, 22, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="stat-number">{{ number_format($netEarnings, 2) }} JOD</div>
                    <div class="stat-label">Net Earnings</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(249, 115, 22, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 10 12 15 7 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                    </div>
                    <div class="stat-number">{{ number_format($platformFees, 2) }} JOD</div>
                    <div class="stat-label">Platform Fees</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(249, 115, 22, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <div class="stat-number">{{ $activities->sum('confirmed_bookings_count') }}</div>
                    <div class="stat-label">Total Confirmed Bookings</div>
                </div>
            </div>

            <!-- Activities Earnings Table -->
            <div class="stat-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Host</th>
                            <th>Total Earnings</th>
                            <th>Confirmed Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td>{{ $activity->title }}</td>
                                <td>{{ $activity->host->name ?? 'Unknown' }}</td>
                                <td>{{ number_format($activity->total_earnings, 2) }} JOD</td>
                                <td>{{ $activity->confirmed_bookings_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No activities found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/templatemo-prism-scripts.js') }}" defer></script>
    <script>
        
        function animateCounter(element) {
            const target = parseFloat(element.textContent.replace(/[^\d.-]/g, ''));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            
            const counter = setInterval(() => {
                current += step;
                if (current >= target) {
                    element.textContent = target.toFixed(2) + ' JOD';
                    clearInterval(counter);
                } else {
                    element.textContent = current.toFixed(2) + ' JOD';
                }
            }, 16);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.stat-number').forEach(animateCounter);
        });
    </script>
@endsection