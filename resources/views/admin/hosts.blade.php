@extends('layout.admin_master')
@section('page_title', 'Hosts Management')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <!-- Filters -->
<div class="filters-bar">
    <form method="GET" action="{{ route('admin.hosts') }}">
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>

        <input type="text" name="search" placeholder="Search hosts..." class="filter-input" value="{{ request('search') }}">
    </form>
</div>

            <!-- Hosts Table -->
            <div class="stat-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Host</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hosts as $host)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.edit_user', $host->id) }}" class="action-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.delete_user', $host->id) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا المضيف؟')">
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
                                <td>{{ $host->created_at->format('M Y') }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($host->status ?? 'active') }}">
                                        {{ ucfirst($host->status ?? 'Active') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="role-badge role-{{ strtolower($host->role) }}">
                                        {{ ucfirst($host->role) }}
                                    </span>
                                </td>
                                <td>{{ $host->email }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden;">
                                            <!-- <img src="{{ asset($host->avatar_url ?? 'images/default-avatar.jpg') }}" alt="{{ $host->name }}" style="width: 100%; height: 100%; object-fit: cover;"> -->
                                        </div>
                                        <span>{{ $host->name }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No hosts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
<div class="pagination-wrapper" style="margin-top: 40px; text-align: center;">
    {{ $hosts->links('vendor.pagination.custom') }}
</div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/templatemo-prism-scripts.js') }}" defer></script>
@endsection