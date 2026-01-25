@extends('layout.admin_master')

@section('page_title', 'Users Management')
@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
          <!-- Filters -->
<div class="filters-bar">
    <form method="GET" action="{{ route('admin.users') }}">
        <select name="role" class="filter-select" onchange="this.form.submit()">
            <option value="">All Roles</option>
            <option value="regular" {{ request('role') == 'regular' ? 'selected' : '' }}>Regular Users</option>
            <option value="hosts" {{ request('role') == 'hosts' ? 'selected' : '' }}>Activity Hosts</option>
            <option value="admins" {{ request('role') == 'admins' ? 'selected' : '' }}>Admins</option>
        </select>

        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>

        <input type="text" name="search" placeholder="Search users..." class="filter-input" value="{{ request('search') }}">
    </form>
</div>

            <!-- Users Table -->
            <div class="stat-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.edit_user', $user->id) }}" class="action-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.delete_user', $user->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?')">
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
                                <td>{{ $user->created_at->format('M Y') }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($user->status ?? 'active') }}">
                                        {{ ucfirst($user->status ?? 'Active') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="role-badge role-{{ strtolower($user->role) }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden;">
                                            <!-- <img src="{{ asset($user->avatar_url ?? 'images/default-avatar.jpg') }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;"> -->
                                        </div>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
<div class="pagination-wrapper" style="margin-top: 40px; text-align: center;">
    {{ $users->links('vendor.pagination.custom') }}
</div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/templatemo-prism-scripts.js') }}" defer></script>
@endsection