@extends('layouts.app')

@section('content')

<div class="container mt-3">
    <div class="card shadow border-0 rounded-4 p-4 mx-auto fade-in" style="max-width: 800px;">
        <!-- Header -->
        <div class="card-header bg-transparent">
            <h2 class="fw-bold text-center mb-4" style="color:#9F6B46;">
                <i class="fa-solid fa-pen-to-square"></i> Edit Post
            </h2>
        </div>

        <div class="card-body">
            <form id="edit-form" method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Title --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control post-input"
                        value="{{ old('title', $post->title) }}" required>
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="content" class="form-control post-input" rows="4" required>{{ old('content', $post->content) }}</textarea>
                </div>

                {{-- Date / Time --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date</label>
                        <input type="date" name="date" class="form-control post-input"
                            value="{{ old('date', \Carbon\Carbon::parse($post->visited_at)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Time</label>
                        <div class="d-flex align-items-center gap-1">
                            <input type="number" name="time_hour" class="form-control post-input"
                                min="0" max="23" value="{{ old('time_hour', $post->time_hour) }}">
                            <span>hour</span>

                            <input type="number" name="time_min" class="form-control post-input"
                                min="0" max="59" value="{{ old('time_min', $post->time_min) }}">
                            <span>min</span>
                        </div>
                    </div>
                </div>

                {{-- Categories --}}
                @php
                    $old_categories = old('category', $post->categories->pluck('id')->toArray());
                @endphp

                <div class="mb-4">
                    <label class="form-label fw-bold">Categories (max 3)</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($all_categories as $category)
                            <div class="form-check">
                                <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                    class="form-check-input category-checkbox"
                                    {{ in_array($category->id, $old_categories) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ ucfirst($category->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Prefecture --}}
                <div class="mb-4" style="max-width:300px;">
                    <label class="form-label fw-bold">Prefecture</label>
                    <select name="prefecture_id" class="form-select post-input" required>
                        <option value="">Select Prefecture</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}"
                                {{ old('prefecture_id', $post->prefecture_id) == $prefecture->id ? 'selected' : '' }}>
                                {{ $prefecture->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Cost --}}
                <div class="mb-4" style="max-width:350px;">
                    <label class="form-label fw-bold">Cost</label>
                    <div class="d-flex align-items-center gap-2">
                        <span id="cost-current">¥{{ old('cost', $post->cost) }}</span>
                        <input type="range" name="cost" min="0" max="10000" step="100"
                            value="{{ old('cost', $post->cost) }}" id="cost-slider" class="form-range">
                    </div>
                </div>

                {{-- Existing Images --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Current Images</label>
                    <div id="existing-images" class="image-preview-area">
                        @foreach($post->images as $image)
                            <div class="image-item" data-id="{{ $image->id }}">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="">
                                <span class="remove-btn">×</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Add new images --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Add New Images (max 3 total)</label>
                    <div id="image-inputs"></div>
                    <div id="image-previews" class="image-preview-area"></div>
                </div>

                {{-- Buttons --}}
                <div class="text-end mt-4">
                    <a onclick="window.history.back()"
                       class="btn shadow-sm me-3"
                       style="min-width:150px; border:2px solid #B0B0B0; color:white; font-weight:bold; background-color:#B0B0B0; transition:0.3s;"
                       onmouseover="this.style.backgroundColor='white'; this.style.color='#B0B0B0';"
                       onmouseout="this.style.backgroundColor='#B0B0B0'; this.style.color='white';">
                        Cancel
                    </a>

                    <button type="submit"
                        class="btn btn-outline shadow-sm"
                        style="min-width:150px; font-weight:bold; transition:0.3s;">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const MAX_IMAGES = 3;
    const form = document.getElementById('edit-form');
    const existingImages = document.querySelector('#existing-images');
    const container = document.getElementById('image-inputs');
    const previewArea = document.getElementById('image-previews');
    let count = existingImages.querySelectorAll('.image-item').length;

    // --- 既存画像削除 ---
    existingImages.addEventListener('click', function(e) {
        if (!e.target.classList.contains('remove-btn')) return;

        const imageDiv = e.target.closest('.image-item');
        const imageId = imageDiv.dataset.id;

        if (imageId) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_images[]';
            input.value = imageId;
            form.appendChild(input);
        }

        imageDiv.remove();
        count--;
        if (count < MAX_IMAGES && !container.querySelector('input[type=file]')) addInput();
    });

    // --- 新規画像追加 ---
    function addInput() {
        if (count >= MAX_IMAGES) return;

        const wrapper = document.createElement('div');
        const label = document.createElement('label');
        const input = document.createElement('input');

        wrapper.classList.add('image-controls');
        label.textContent = '+ Add';
        label.classList.add('image-btn');
        input.type = 'file';
        input.name = 'new_image[]';
        input.accept = 'image/*';
        input.style.display = 'none';

        label.addEventListener('click', () => input.click());
        wrapper.append(label, input);
        container.appendChild(wrapper);

        input.addEventListener('change', function() {
            if (!this.files[0]) return;
            count++;

            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.classList.add('image-item');
                const img = document.createElement('img');
                img.src = e.target.result;
                const removeBtn = document.createElement('span');
                removeBtn.classList.add('remove-btn');
                removeBtn.textContent = '×';

                removeBtn.addEventListener('click', () => {
                    div.remove();
                    input.remove();
                    count--;
                    if (count < MAX_IMAGES && !container.querySelector('input[type=file]')) addInput();
                });

                div.append(img, removeBtn);
                previewArea.appendChild(div);
            };
            reader.readAsDataURL(this.files[0]);
            label.style.display = 'none';

            if (count < MAX_IMAGES) addInput();
        });
    }
    if (count < MAX_IMAGES) addInput();

    // --- コストスライダー ---
    const costSlider = document.getElementById('cost-slider');
    const costDisplay = document.getElementById('cost-current');
    costSlider?.addEventListener('input', () => {
        costDisplay.textContent = '¥' + costSlider.value;
    });

    // --- カテゴリ最大3制限 ---
    document.querySelectorAll('.category-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const checked = document.querySelectorAll('.category-checkbox:checked');
            if (checked.length > 3) {
                this.checked = false;
                alert('You can select up to 3 categories.');
            }
        });
    });
});
</script>
@endsection
