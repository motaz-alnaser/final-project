@extends('layout.admin_master')

@section('page_title', 'Edit Review')

@section('content')
    <section class="stats-section">
        <div class="philosophy-container">
            <div class="stat-card centered-form-card">
                <form id="editReviewForm" method="POST" action="{{ route('admin.update_review', $review->id) }}">
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
                                <label for="reviewRating" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Rating (1-5)</label>
                                <input type="number" id="reviewRating" name="rating" value="{{ old('rating', $review->rating) }}" required min="1" max="5" style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="reviewStatus" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Status</label>
                                <select id="reviewStatus" name="status" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px;">
                                    <option value="approved" {{ old('status', $review->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ old('status', $review->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ old('status', $review->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="reviewActivity" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Activity</label>
                                <input type="text" id="reviewActivity" value="{{ $review->activity->title }}" disabled style="width: 100%; padding: 15px; background: var(--metal-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-secondary); font-size: 14px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="reviewUser" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">User</label>
                                <input type="text" id="reviewUser" value="{{ $review->user->name }}" disabled style="width: 100%; padding: 15px; background: var(--metal-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-secondary); font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="reviewComment" style="display: block; color: var(--text-secondary); margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Review Comment</label>
                        <textarea id="reviewComment" name="comment" rows="6" required style="width: 100%; padding: 15px; background: var(--carbon-dark); border: 1px solid var(--metal-dark); border-radius: 8px; color: var(--text-primary); font-size: 14px; resize: vertical;">{{ old('comment', $review->comment) }}</textarea>
                    </div>

                    <div style="display: flex; gap: 15px; margin-top: 20px;">
                        <button type="submit" class="card-cta" style="flex: 1; padding: 12px;">Update Review</button>
                        <a href="{{ route('admin.reviews') }}" class="card-cta" style="flex: 1; padding: 12px; background: linear-gradient(135deg, var(--metal-dark), var(--carbon-medium));">Cancel</a>
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