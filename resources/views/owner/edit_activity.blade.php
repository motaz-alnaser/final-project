@extends('layout.admin_master')

@section('page_title', 'Edit Activity')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            
            <div class="stat-card centered-form-card">
                <form id="editActivityForm" method="POST" action="{{ route('owner.update_activity', $activity->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Display Success Message -->
                    @if(session('success'))
                        <div style="background: var(--accent-green); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Left Column -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div>
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="activityTitle" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Activity Title</label>
                                <input type="text" id="activityTitle" name="title" required value="{{ old('title', $activity->title) }}" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="category" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Category</label>
                                <select id="category" name="category_id" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == old('category_id', $activity->category_id) ? 'selected' : '' }}>
                                            {{ $cat->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="location" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Location</label>
                                <input type="text" id="location" name="location" required value="{{ old('location', $activity->location) }}" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;" placeholder="e.g., King Abdullah Park, Amman">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="price" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Price (JOD)</label>
                                <input type="number" id="price" name="price" required min="0" step="0.01" value="{{ old('price', $activity->price) }}" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="capacity" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Max Capacity</label>
                                <input type="number" id="capacity" name="max_participants" required min="1" value="{{ old('max_participants', $activity->max_participants) }}" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div>
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="description" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Description</label>
                                <textarea id="description" name="description" rows="6" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px; resize: vertical;" placeholder="Describe your activity in detail...">{{ old('description', $activity->description) }}</textarea>
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Activity Images</label>
                                <div style="border: 2px dashed var(--metal-dark); border-radius: 10px; padding: 30px; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 15px; color: var(--text-secondary);">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <p style="color: var(--text-secondary); margin-bottom: 10px;">Drag & drop images here</p>
                                    <p style="color: var(--text-dim); font-size: 12px;">or click to browse files</p>
                                    <input type="file" name="image_url" accept="image/*" style="display: none;">
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 15px;">
                                <button type="submit" class="card-cta" style="flex: 1; padding: 12px;">Update Activity</button>
                                <a href="{{ route('owner.dashboard') }}" class="card-cta" style="flex: 1; padding: 12px; background: linear-gradient(135deg, var(--metal-dark), var(--carbon-medium));">Cancel</a>
                            </div>
                        </div>
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

        
        const imageUploadArea = document.querySelector('[style*="border: 2px dashed"]');
        if (imageUploadArea) {
            imageUploadArea.addEventListener('click', () => {
                imageUploadArea.querySelector('input[type="file"]').click();
            });
        }
    </script>
@endsection