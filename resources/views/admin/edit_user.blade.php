@extends('layout.admin_master')

@section('page_title', 'Edit User')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <div class="stat-card centered-form-card">
                <form id="editUserForm" method="POST" action="{{ route('admin.update_user', $user->id) }}">
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
                                <label for="userName" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Full Name</label>
                                <input type="text" id="userName" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="userEmail" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Email Address</label>
                                <input type="email" id="userEmail" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                        </div>

                        <div>
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="userRole" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">User Role</label>
                                <select id="userRole" name="role" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Regular User</option>
                                    <option value="host" {{ old('role', $user->role) === 'host' ? 'selected' : '' }}>Activity Host</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="userStatus" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Account Status</label>
                                <select id="userStatus" name="status" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-top: 20px;">
                        <button type="submit" class="card-cta" style="flex: 1; padding: 12px;">Update User</button>
                        <a href="{{ route('admin.users') }}" class="card-cta" style="flex: 1; padding: 12px; background: linear-gradient(135deg, var(--metal-dark), var(--carbon-medium));">Cancel</a>
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