@extends('layout.admin_master')

@section('page_title', 'Reviews Management')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            

            <!-- Reviews Table -->
            <div class="stat-card">
                <table class="reviews-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Activity</th>
                            <th>User</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.edit_review', $review->id) }}" class="action-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.delete_review', $review->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this review?')">
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
                                    <span class="status-badge status-{{ strtolower($review->status) }}">
                                        {{ ucfirst($review->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="star" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <polygon points="12,2 15.09,8.26 22,9.27 16.5,14.08 17.74,21.09 12,17.74 6.26,21.09 7.5,14.08 2,9.27 8.91,8.26"/>
                                                </svg>
                                            @else
                                                <svg class="star empty" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polygon points="12,2 15.09,8.26 22,9.27 16.5,14.08 17.74,21.09 12,17.74 6.26,21.09 7.5,14.08 2,9.27 8.91,8.26"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td>{{ Str::limit($review->comment, 50) }}</td>
                                <td>{{ $review->activity->title }}</td>
                                <td>{{ $review->user->name }}</td>
                                <td>{{ $review->created_at->format('M j, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No reviews found.
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
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                if (loader) loader.classList.add('hidden');
            }, 1000);
        });
    </script>
@endsection