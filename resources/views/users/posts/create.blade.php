@extends('layouts.app')

@section('content')

<div class="container mt-3">
    <div class="card shadow border-0 rounded-4 p-4 mx-auto fade-in" style="max-width: 800px;">
        <div class="card-header bg-transparent">
            <h2 class="fw-bold text-center mb-4" style="color:#9F6B46;">
                <i class="fa-solid fa-circle-plus"></i> Create Post
            </h2>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control post-input" value="{{ old('title') }}" required>
                    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="content" class="form-control post-input" rows="4" required>{{ old('content') }}</textarea>
                    @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Date / Time --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date</label>
                        <input type="date" name="date" class="form-control post-input" value="{{ old('date', date('Y-m-d')) }}">
                        @error('date') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Time</label>
                        <div class="d-flex align-items-center gap-1">
                            <input type="number" name="time_hour" class="form-control post-input" min="0" max="23" value="{{ old('time_hour',0) }}">
                            <span>hour</span>
                            <input type="number" name="time_min" class="form-control post-input" min="0" max="59" value="{{ old('time_min',0) }}">
                            <span>min</span>
                        </div>
                        @error('time_hour') <div class="text-danger small">{{ $message }}</div> @enderror
                        @error('time_min') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Categories --}}
                <div class="mb-4">
                    <label cclass="form-label fw-bold">Categories</label>
                    <div class="d-flex flex-wrap gap-3 mt-2">
                        @foreach($all_categories as $category)
                            <div class="form-check">
                                <input type="checkbox" name="category[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" class="form-check-input category-checkbox"
                                {{ in_array($category->id, old('category',[])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_{{ $category->id }}">{{ ucfirst($category->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Prefecture --}}
                <div class="mb-4" style="max-width:300px;">
                    <label class="form-label fw-bold">Prefecture</label>
                    <select name="prefecture_id" class="form-select post-input" required>
                        <option value="">Select Prefecture</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}" {{ old('prefecture_id')==$prefecture->id ? 'selected' : '' }}>
                                {{ $prefecture->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('prefecture_id') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Cost --}}
                <div class="mb-4" style="max-width:350px;">
                    <label class="form-label fw-bold">Cost</label>
                    <div class="d-flex align-items-center gap-2">
                        <span id="cost-current">¥{{ old('cost',100) }}</span>
                        <input type="range" name="cost" min="0" max="10000" step="100" value="{{ old('cost',100) }}" id="cost-slider" class="form-range">
                    </div>
                    @error('cost') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Images --}}
                <div class="mb-4">
                    <label class="form-label">Images (up to 3)</label>
                    <div id="image-inputs"></div>
                    <div id="image-previews" class="image-preview-area"></div>
                    @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="text-end mt-4">
                    <a onclick="window.history.back()"
                       class="btn btn-cancel shadow-sm me-3"
                       style="min-width:150px; font-weight:bold;">
                        Cancel
                    </a>

                    <button type="submit"
                        class="btn btn-outline shadow-sm"
                        style="min-width:150px; font-weight:bold; transition:0.3s;">
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const MAX_IMAGES = 3;
    const container = document.getElementById('image-inputs');
    const previewArea = document.getElementById('image-previews');
    let count = 0;

    function addInput() {
        if (count >= MAX_IMAGES) return;
        count++;

        const wrapper = document.createElement('div');
        wrapper.classList.add('image-controls');

        const label = document.createElement('label');
        label.textContent = '+ Add';
        label.classList.add('image-btn');

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'image[]';
        input.accept = 'image/*';
        input.style.display = 'none';

        wrapper.appendChild(label);
        wrapper.appendChild(input);
        container.appendChild(wrapper);

        label.addEventListener('click', () => input.click());

        input.addEventListener('change', function() {
            if (!this.files[0]) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.classList.add('image-item');

                const img = document.createElement('img');
                img.src = e.target.result;

                const removeBtn = document.createElement('span');
                removeBtn.classList.add('remove-btn');
                removeBtn.textContent = '×';
                removeBtn.onclick = () => {
                    div.remove();
                    wrapper.remove();
                    count--;
                    if (count < MAX_IMAGES) addInput();
                };

                div.appendChild(img);
                div.appendChild(removeBtn);
                previewArea.appendChild(div);
            };
            reader.readAsDataURL(this.files[0]);

            label.style.display = 'none';
            if (count < MAX_IMAGES) addInput();
        });
    }

    addInput();

    // Cost slider update
    const costSlider = document.getElementById('cost-slider');
    const costDisplay = document.getElementById('cost-current');
    costSlider?.addEventListener('input', () => {
        costDisplay.textContent = '¥' + costSlider.value;
    });

    // Categories max 3
    const checkboxes = document.querySelectorAll('.category-checkbox');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const checked = document.querySelectorAll('.category-checkbox:checked');
            if (checked.length > 3) {
                this.checked = false;
                alert('Up to 3 categories allowed.');
            }
        });
    });
});
</script>

@endsection
