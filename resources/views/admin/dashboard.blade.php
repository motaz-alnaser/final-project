@extends('layout.admin_master')

@section('page_title', 'Admin Dashboard')

@section('content')
    <!-- Stats Cards -->
    <section class="stats-section">
        <div class="philosophy-container">
            <div class="dashboard-stats-grid">
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(153, 69, 255, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <div class="stat-number">{{ $totalUsers }}</div>
                    <div class="stat-label">Total Users</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(249, 115, 22, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <div class="stat-number">{{ $activeActivities }}</div>
                    <div class="stat-label">Active Activities</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(59, 130, 246, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="stat-number">{{ $totalBookings }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon" style="background: rgba(250, 204, 21, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="M12 10v6"></path>
                            <path d="M8 10h8"></path>
                        </svg>
                    </div>
                    <div class="stat-number">{{ number_format($totalRevenue, 2) }} JOD</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts & Recent Activities -->
    <section class="stats-section">
        <div class="philosophy-container">
            <!-- Placeholder Chart -->
            <div class="stat-card" style="padding: 30px; margin-bottom: 30px;">
                <h2 class="section-title" style="font-size: 24px; margin-bottom: 20px;">User Growth</h2>
                <div style="height: 250px; display: flex; align-items: flex-end; justify-content: space-around; border-bottom: 1px solid var(--metal-dark); padding: 20px 0;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 30px; background: linear-gradient(to top, var(--accent-cyan), var(--accent-purple)); border-radius: 4px;"></div>
                        <small style="color: var(--text-secondary);">Jan</small>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 50px; background: linear-gradient(to top, var(--accent-cyan), var(--accent-purple)); border-radius: 4px;"></div>
                        <small style="color: var(--text-secondary);">Feb</small>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 70px; background: linear-gradient(to top, var(--accent-cyan), var(--accent-purple)); border-radius: 4px;"></div>
                        <small style="color: var(--text-secondary);">Mar</small>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 90px; background: linear-gradient(to top, var(--accent-cyan), var(--accent-purple)); border-radius: 4px;"></div>
                        <small style="color: var(--text-secondary);">Apr</small>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 110px; background: linear-gradient(to top, var(--accent-cyan), var(--accent-purple)); border-radius: 4px;"></div>
                        <small style="color: var(--text-secondary);">May</small>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 130px; background: linear-gradient(to top, var(--accent-cyan), var(--accent-purple)); border-radius: 4px;"></div>
                        <small style="color: var(--text-secondary);">Jun</small>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="stat-card">
                <div class="recent-activities-header">
                    <h2 class="section-title">Recent Activities</h2>
                    <a href="{{ route('admin.activities') }}" class="card-cta">View All</a>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Host</th>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivities as $activity)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.edit_activity', $activity->id) }}" class="action-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>
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
                                    <span class="status-badge status-{{ strtolower($activity->status) }}">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </td>
                                <td>{{ $activity->category?->name_en ?? 'Uncategorized' }}</td>
                                <td>{{ $activity->host->name ?? 'Unknown' }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; border-radius: 5px; overflow: hidden;">
                                            <!-- <img src="{{ asset($activity->image_url ?? 'images/default-activity.jpg') }}" alt="{{ $activity->title }}" style="width: 100%; height: 100%; object-fit: cover;"> -->
                                        </div>
                                        <span>{{ $activity->title }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No recent activities found.
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
@endsection

@section('footer')
    <p>&copy; 2026 PRISM FLUX Admin Panel. All rights reserved.</p>
@endsection