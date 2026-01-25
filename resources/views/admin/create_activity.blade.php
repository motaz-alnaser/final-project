@extends('layout.admin_master')
@section('page_title', 'Create Activity')
@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <div class="stat-card centered-form-card">
                <form id="createActivityForm" method="POST" action="{{ route('admin.store_activity') }}">
                    @csrf

                   
                    @if(session('success'))
                        <div style="background: var(--accent-green); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                            {{ session('success') }}
                        </div>
                    @endif

                 
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div>
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityTitle" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Activity Title</label>
                                <input type="text" id="activityTitle" name="title" value="{{ old('title') }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityLocation" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Location</label>
                                <input type="text" id="activityLocation" name="location" value="{{ old('location') }}" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityPrice" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Price (JOD)</label>
                                <input type="number" id="activityPrice" name="price" value="{{ old('price') }}" required min="0" step="0.01" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityCapacity" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Max Capacity</label>
                                <input type="number" id="activityCapacity" name="max_participants" value="{{ old('max_participants') }}" required min="1" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div>
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityCategory" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Category</label>
                                <select id="activityCategory" name="category_id" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityHost" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Host</label>
                                <select id="activityHost" name="host_id" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    <option value="">Select Host</option>
                                    @foreach($hosts as $host)
                                        <option value="{{ $host->id }}" {{ old('host_id') == $host->id ? 'selected' : '' }}>
                                            {{ $host->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityStatus" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Status</label>
                                <select id="activityStatus" name="status" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityImageUrl" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Image URL</label>
                                <input type="url" id="activityImageUrl" name="image_url" value="{{ old('image_url') }}" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="activityDescription" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Description</label>
                        <textarea id="activityDescription" name="description" rows="6" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px; resize: vertical;">{{ old('description') }}</textarea>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <button type="submit" class="card-cta" style="flex: 1; padding: 12px;">Publish Activity</button>
                        <a href="{{ route('admin.activities') }}" class="card-cta" style="flex: 1; padding: 12px; background: linear-gradient(135deg, var(--metal-dark), var(--carbon-medium));">Cancel</a>
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

       
        document.getElementById('addActivityForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Activity published successfully!');
        });

        
        const imageUploadArea = document.querySelector('.image-upload-area-vertical');
        if (imageUploadArea) {
            imageUploadArea.addEventListener('click', () => {
                imageUploadArea.querySelector('input[type="file"]').click();
            });
        }
    </script>
@endsection