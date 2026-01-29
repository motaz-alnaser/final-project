@extends('layout.admin_master')
@section('page_title', 'Activities Management')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <!-- Filters -->
<div class="filters-bar">
    <form method="GET" action="{{ route('admin.activities') }}">
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name_en }}
                </option>
            @endforeach
        </select>

        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>

        <input type="text" name="search" placeholder="Search activities..." class="filter-input" value="{{ request('search') }}">

        <a href="{{ route('admin.create_activity') }}" class="create-btn">+ Create New Activity</a>
    </form>
</div>

            <!-- Activities Table -->
            <div class="stat-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Bookings</th>
                            <th>Category</th>
                            <th>Host</th>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td>
                                    
<a href="{{ route('admin.edit_activity', $activity->id) }}">                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>
                                    
                                        <form method="POST" action="{{ route('admin.delete_activity', $activity->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this activity?')">
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
                                <td>{{ $activity->bookings_count }}</td>
                                <td>{{ $activity->category?->name ?? 'Uncategorized' }}</td>
                                <td>{{ $activity->host->name ?? 'Unknown' }}</td>
                                <td>
                                    <span>{{ $activity->title }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No activities found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
<div class="pagination-wrapper" style="margin-top: 40px; text-align: center;">
    {{ $activities->links('vendor.pagination.custom') }}
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