@extends('layouts.app')

@section('content')

<style>
    body, html {
        font-family: 'Source Serif Pro', serif; 
        background-color: white; 
    }

    .full-page-container {
        display: flex;
        justify-content: center;
        align-items: flex-start; 
        min-height: 100vh;
        padding-top: 80px;
        background-color: white; 
    }

    .post-container {
        width: 100%;
        max-width: 760px;
        padding: 40px 30px;
        background-color: white; 
        border: 1px solid #9F6B46;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .post-header {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem; 
        color: #9F6B46;
        font-weight: 700;
        margin-bottom: 2rem;
        padding-bottom: 15px;
        border-bottom: 1px solid #9F6B46; 
    }
     .post-header i {
        font-size: 1.5em;
        margin-right: 10px;
    }

    .post-label {
        font-weight: 600; 
        margin-bottom: 0.3rem; 
        display: block;
        text-align: left;
        font-size: 1rem;
        color: #9F6B46; 
    }

    .post-input, .form-select.post-input {
        height: 40px; 
        border-radius: 5px;
        padding: 0.375rem 1rem;
        border: 1px solid #ced4da; 
        font-size: 1rem;
        width: 100%;
        color: #9F6B46;
    }

    textarea.post-input {
        height: 120px; 
        resize: vertical;
        padding: 1rem;
    }

    .post-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(159, 107, 70, 0.25);
        border-color: #9F6B46;
    }

    /* Range Input (Slider) */
    .range-wrap {
        display: flex;
        align-items: center;
        padding: 5px 0;
    }
    .range-input {
        width: 100%;
        height: 5px;
        background: #F8C7B3;
        border-radius: 5px;
        appearance: none;
        cursor: pointer;
    }
    .range-input::-webkit-slider-thumb {
        appearance: none;
        width: 15px;
        height: 15px;
        background: #9F6B46;
        border-radius: 50%;
    }
    .cost-display {
        color: #9F6B46;
        font-weight: 600;
        margin-left: 10px;
        min-width: 60px;
    }

    /* Image Section */
    .image-controls {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .image-btn {
        background-color: #F8F8F8;
        border: 1px solid #9F6B46;
        color: #9F6B46;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
        font-weight: 500;
    }
    .image-preview-area {
        display: flex;
        gap: 15px;
        margin-top: 10px;
        overflow-x: auto; 
        padding-bottom: 10px;
    }
    .image-item {
        width: 100px;
        height: 100px;
        border-radius: 5px;
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
        border: 1px solid #ccc;
    }
    .image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .remove-btn {
        position: absolute;
        top: 3px;
        right: 5px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Footer Buttons */
    .form-footer {
        display: flex;
        justify-content: flex-end; 
        gap: 15px;
        padding-top: 20px;
    }
    .btn-cancel {
        background-color: white;
        color: #F8C7B3;
        border: 1px solid  #F8C7B3;
        padding: 8px 25px;
        font-weight: 600;
        border-radius: 5px;
    }
    .btn-post {
        background-color: #F8C7B3;
        color: white;
        border: 1px solid #F8C7B3;
        padding: 8px 25px;
        font-weight: 600;
        border-radius: 5px;
    }

    @media (max-width: 600px) {
        .post-container {
            padding: 25px 15px;
            border: none;
        }
    }
</style>

<div class="full-page-container">
    <div class="post-container">
        <div class="post-header">
            <i class="fa-solid fa-pen-to-square"></i> Edit Post
        </div>

        <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label post-label">Title</label>
                <input id="title" type="text" class="form-control post-input @error('title') is-invalid @enderror" 
                    name="title" value="{{ old('title', $post->title) }}" required>
                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label for="content" class="form-label post-label">Description</label>
                <textarea id="content" class="form-control post-input @error('content') is-invalid @enderror" 
                    name="content" rows="4" required>{{ old('content', $post->content) }}</textarea>
                @error('content') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            {{-- Date & Time --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date" class="form-label post-label">Date</label>
                    <input id="date" type="date" 
                        class="form-control post-input @error('date') is-invalid @enderror"
                        name="date"
                        value="{{ old('date', $post->visited_at) }}">
                    @error('date') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label for="time" class="form-label post-label">Time</label>
                    <div class="d-flex align-items-center">
                        <input type="number" name="time_hour" min="0" max="23"
                            class="form-control post-input time-input @error('time_hour') is-invalid @enderror"
                            value="{{ old('time_hour', $post->time_hour ?? 0) }}">
                        <span class="time-unit ms-1">hour</span>

                        <input type="number" name="time_min" min="0" max="59"
                            class="form-control post-input time-input ms-3 @error('time_min') is-invalid @enderror"
                            value="{{ old('time_min', $post->time_min ?? 0) }}">
                        <span class="time-unit ms-1">min</span>
                    </div>
                </div>
            </div>

            {{-- Categories --}}
            <div class="mb-3">
                <label class="form-label post-label">Categories</label>
                <div id="category-checkboxes" class="d-flex flex-wrap gap-3">
                    @foreach ($all_categories as $category)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input category-checkbox"
                                name="category[]" id="category_{{ $category->id }}" value="{{ $category->id }}"
                                {{ in_array($category->id, old('category', $post->categories->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category_{{ $category->id }}">
                                {{ ucfirst($category->name) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Prefecture --}}
            <div class="col-md-5 mb-4">
                <label for="prefecture_id" class="form-label post-label">Prefecture</label>
                <select class="form-select post-input @error('prefecture_id') is-invalid @enderror" 
                        name="prefecture_id" required>
                    <option value="">Select Prefecture</option>
                    @foreach ($prefectures as $prefecture)
                        <option value="{{ $prefecture->id }}" 
                            {{ old('prefecture_id', $post->prefecture_id) == $prefecture->id ? 'selected' : '' }}>
                            {{ $prefecture->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Cost --}}
            <div class="mb-4" style="width: 60%;">
                <label class="post-label" for="cost-slider">Cost</label>
                <div class="range-wrap">
                    <span class="cost-display" id="cost-current">¥{{ number_format(old('cost', $post->cost)) }}</span>
                    <input id="cost-slider" name="cost" type="range" min="0" max="10000" step="100"
                        value="{{ old('cost', $post->cost) }}" class="range-input">
                </div>
            </div>

            {{-- Images --}}
            <div class="mb-4">
                <label class="post-label" for="file-upload">Images (up to 3)</label>
                <div class="image-controls">
                    <label for="file-upload" class="image-btn">+ Add</label>
                    <input id="file-upload" name="image[]" type="file" accept="image/*" multiple hidden>
                </div>

                @php
                    $images = $post->image;
                    if (is_string($images)) {
                        $decoded = json_decode($images, true);
                        $images = $decoded ?: [$images];
                    }
                @endphp

                <div id="image-previews" class="image-preview-area">
                    @if(!empty($images))
                        @foreach($images as $image)
                            <div class="image-item">
                                <img src="data:image/jpeg;base64,{{ $image }}" alt="Post Image">
                                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn-post">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const MAX_IMAGES = 3;
    const input = document.getElementById('file-upload');
    const previewArea = document.getElementById('image-previews');
    const costSlider = document.getElementById('cost-slider');
    const costDisplay = document.getElementById('cost-current');
    const checkboxes = document.querySelectorAll('.category-checkbox');

    costSlider?.addEventListener('input', () => {
        costDisplay.textContent = '¥' + Number(costSlider.value).toLocaleString();
    });

    input?.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const existing = previewArea.querySelectorAll('.image-item').length;
        const addable = Math.min(files.length, MAX_IMAGES - existing);

        files.slice(0, addable).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const div = document.createElement('div');
                div.classList.add('image-item');
                const img = document.createElement('img');
                img.src = ev.target.result;
                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-btn');
                removeBtn.textContent = '×';
                removeBtn.onclick = () => div.remove();
                div.appendChild(img);
                div.appendChild(removeBtn);
                previewArea.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
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
