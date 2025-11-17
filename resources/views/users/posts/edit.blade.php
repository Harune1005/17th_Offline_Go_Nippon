@extends('layouts.app')

@section('content')
<style>
/* --- Global --- */
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
}
.post-container {
    width: 100%;
    max-width: 760px;
    padding: 40px 30px;
    background-color: white;
    border: 1px solid #9F6B46;
    border-radius: 5px;
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
    color: #9F6B46;
}
.post-input {
    width: 100%;
    padding: 0.375rem 1rem;
    border-radius: 5px;
    border: 1px solid #ced4da;
    color: #9F6B46;
}
textarea.post-input {
    height: 120px;
    padding: 1rem;
    resize: vertical;
}
.post-input:focus {
    border-color: #9F6B46;
    box-shadow: 0 0 0 0.25rem rgba(159,107,70,0.25);
}
.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    padding-top: 20px;
}
.btn-cancel {
    background: white;
    border: 1px solid #F8C7B3;
    color: #F8C7B3;
    padding: 8px 25px;
    font-weight: 600;
    border-radius: 5px;
}
.btn-post {
    background: #F8C7B3;
    border: 1px solid #F8C7B3;
    color: white;
    padding: 8px 25px;
    font-weight: 600;
    border-radius: 5px;
}

/* --- Images --- */
.image-preview-area {
    display: flex;
    gap: 15px;
    margin-top: 10px;
    overflow-x: auto;
    padding-bottom: 10px;
}
.image-item {
    position: relative;
    width: 100px;
    height: 100px;
    border-radius: 8px;
    overflow: hidden;
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
    right: 3px;
    background: #9F6B46;
    color: #fff;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-weight: bold;
}
.image-btn {
    background-color: #F8F8F8;
    border: 1px solid #9F6B46;
    color: #9F6B46;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    display: inline-block;
}

/* --- Cost Slider --- */
#cost-slider {
    width: 100%;
    height: 6px;
    border-radius: 5px;
    appearance: none;
    background: transparent;
}
#cost-slider::-webkit-slider-runnable-track {
    height: 6px;
    background: #F8C7B3;
    border-radius: 5px;
}
#cost-slider::-webkit-slider-thumb {
    appearance: none;
    width: 18px;
    height: 18px;
    margin-top: -6px;
    border-radius: 50%;
    background-color: #9F6B46;
    border: 2px solid white;
    cursor: pointer;
    transition: transform 0.2s ease;
}
#cost-slider::-webkit-slider-thumb:hover {
    transform: scale(1.1);
}
#cost-slider::-moz-range-thumb {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background-color: #9F6B46;
    border: 2px solid white;
    cursor: pointer;
    transition: transform 0.2s ease;
}
#cost-slider::-moz-range-thumb:hover {
    transform: scale(1.1);
}
</style>

<div class="full-page-container">
    <div class="post-container">
        <div class="post-header">
            <i class="fa-solid fa-pen-to-square"></i> Edit Post
        </div>

        <form id="edit-form" method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Title --}}
            <div class="mb-3">
                <label class="form-label post-label">Title</label>
                <input type="text" name="title" class="form-control post-input" value="{{ old('title', $post->title) }}" required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label post-label">Description</label>
                <textarea name="content" class="form-control post-input" rows="4" required>{{ old('content', $post->content) }}</textarea>
            </div>

            {{-- Date & Time --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label post-label">Date</label>
                    <input type="date" name="date" class="form-control post-input" value="{{ old('date', \Carbon\Carbon::parse($post->visited_at)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label post-label">Time</label>
                    <div class="d-flex align-items-center gap-1">
                        <input type="number" name="time_hour" class="form-control post-input" min="0" max="23" value="{{ old('time_hour', $post->time_hour) }}">
                        <span>hour</span>
                        <input type="number" name="time_min" class="form-control post-input" min="0" max="59" value="{{ old('time_min', $post->time_min) }}">
                        <span>min</span>
                    </div>
                </div>
            </div>

            {{-- Categories --}}
            @php $old_categories = old('category', $post->categories->pluck('id')->toArray()); @endphp
            <div class="mb-3">
                <label class="post-label">Categories (max 3)</label>
                <div id="category-checkboxes" class="d-flex flex-wrap gap-3">
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
            <div class="mb-3" style="width:48%;">
                <label class="form-label post-label">Prefecture</label>
                <select name="prefecture_id" class="form-select post-input" required>
                    <option value="">Select Prefecture</option>
                    @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->id }}" {{ old('prefecture_id', $post->prefecture_id)==$prefecture->id ? 'selected' : '' }}>
                            {{ $prefecture->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Cost --}}
            <div class="mb-4" style="width:60%;">
                <label class="post-label">Cost</label>
                <div class="d-flex align-items-center gap-2">
                    <span id="cost-current">¥{{ old('cost', $post->cost) }}</span>
                    <input type="range" name="cost" min="0" max="10000" step="100" value="{{ old('cost', $post->cost) }}" id="cost-slider" class="form-range">
                </div>
            </div>

            {{-- Existing Images --}}
            <div class="mb-3">
                <label class="post-label">Current Images</label>
                <div id="existing-images" class="image-preview-area">
                    @foreach($post->images as $image)
                        <div class="image-item" data-id="{{ $image->id }}">
                            <img src="{{ asset('storage/' . $image->image) }}" alt="">
                            <span class="remove-btn">×</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- New Images --}}
            <div class="mb-3">
                <label class="post-label">Add New Images (max 3 total)</label>
                <div id="image-inputs"></div>
                <div id="image-previews" class="image-preview-area"></div>
            </div>

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
