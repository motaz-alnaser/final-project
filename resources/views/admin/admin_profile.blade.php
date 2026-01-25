@extends('layout.admin_master')
@section('page_title', 'Admin Profile')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <div class="profile-layout">
                <div class="profile-content">
                    <h2 class="section-title">Account Information</h2>
                    <form id="profileForm" method="POST" action="{{ route('admin.update_profile') }}">
                        @csrf
                        @method('PUT')

                        <!-- Display Success Message -->
                        @if(session('success'))
                            <div style="background: var(--accent-green); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                            <div class="form-group">
                                <label for="firstName" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">First Name</label>
                                <input type="text" id="firstName" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                            <div class="form-group">
                                <label for="lastName" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Last Name</label>
                                <input type="text" id="lastName" name="last_name" value="{{ old('last_name', explode(' ', $user->name)[1] ?? '') }}" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                        </div>
                        <div class="form-group">
                            <label for="phone" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                        </div>
                        <div class="form-group">
                            <label for="bio" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Bio</label>
                            <textarea id="bio" name="bio" rows="4" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px; resize: vertical;">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                        <button type="submit" class="card-cta">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <p>&copy; 2026 PRISM FLUX Admin Panel. All rights reserved.</p>
@endsection