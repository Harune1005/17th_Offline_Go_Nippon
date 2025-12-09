@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card shadow border-0 rounded-4 p-4 mx-auto fade-in" style="max-width: 800px;">
        <div class="card-header bg-transparent">
            <h2 class="fw-bold text-center mb-4" style="color:#9F6B46;">
                <i class="fa-solid fa-pen-to-square"></i> Edit Post
            </h2>
        </div>

        <div class="card-body">
            <form id="edit-form" method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control post-input"
                        value="{{ old('title', $post->title) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="content" class="form-control post-input" rows="4" required>{{ old('content', $post->content) }}</textarea>
                </div>

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

                @php
                    $old_categories = old('category', $post->categories->pluck('id')->toArray());
                @endphp
                <div class="mb-4">
                    <label class="form-label fw-bold">Categories (max 3)</label>
                    <div class="d-flex flex-wrap gap-2" >
                        @foreach ($all_categories as $category)
                            <div class="form-check" style="width: 130px">
                                <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                    class="form-check-input category-checkbox"
                                    {{ in_array($category->id, $old_categories) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ ucfirst($category->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

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

                <div class="mb-4" style="max-width:350px;">
                    <label class="form-label fw-bold">Cost</label>
                    <div class="d-flex align-items-center gap-2">
                        <span id="cost-current">¥{{ old('cost', $post->cost) }}</span>
                        <input type="range" name="cost" min="0" max="10000" step="100"
                            value="{{ old('cost', $post->cost) }}" id="cost-slider" class="form-range">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">Images (max 3 total)</label>
                    <div class="d-flex gap-3" id="image-upload-area">
                        @foreach ($post->images as $image)
                        <div class="image-slot existing-image position-relative" data-image-id="{{ $image->id }}" 
                            style="width: 100px; height: 100px; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.15);">
                            <img src="{{ asset('storage/' . $image->image) }}" alt="existing image" 
                                style="width:100%; height:100%; object-fit:cover;">
                            <button type="button"
                                class="delete-existing-image position-absolute"
                                style="top: 4px;right: 4px; width: 20px; height: 20px; font-size: 0.8rem; border: none; border-radius: 50%;
                                    background-color: #9F6B46; color: white; cursor: pointer; display: flex; align-items: center;justify-content: center;opacity: 1;"
                                aria-label="Delete Image"
                                data-image-id="{{ $image->id }}"
                                onclick="deleteExistingImage(this)"
                            >
                                &times;
                            </button>
                            <input type="hidden" name="deleted_images[]" class="deleted-image-input" value="" disabled>
                        </div>
                        @endforeach

                        <div class="image-slot add-new-slot" id="add-slot" style="width: 100px; height: 100px;">
                            <label class="d-flex justify-content-center align-items-center rounded-3 h-100 w-100"
                                style="cursor: pointer; background-color: #f0f0f0; border: 1px solid #B0B0B0; color: #555;"
                                for="new_image_file_0">
                                <span class="small font-weight-bold">+ Add</span>
                            </label>
                            <input type="file" class="d-none new-image-input" name="new_image[]" id="new_image_file_0" onchange="previewNewImage(this)" accept="image/*">
                        </div>
                    </div>
                    @error('new_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    @error('new_image.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
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
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    updateAddSlotVisibility();

    document.querySelector('form').addEventListener('submit', function(e) {
        if (getCurrentImageCount() > 3) {
            alert('You can upload up to 3 images.');
            e.preventDefault();
        }
    });
});

function getCurrentImageCount() {
    const existingCount = document.querySelectorAll('.existing-image:not(.d-none)').length;
    const newCount = document.querySelectorAll('.new-image-slot').length;
    return existingCount + newCount;
}

function updateAddSlotVisibility() {
    const addSlot = document.getElementById('add-slot');
    if (addSlot) {
        getCurrentImageCount() >= 3 ? addSlot.classList.add('d-none') : addSlot.classList.remove('d-none');
    }
}

let newImageIndex = 0;

function previewNewImage(input) {
    const file = input.files[0];
    const addSlot = input.closest('.add-new-slot');
    if (!file || !addSlot) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        addSlot.classList.remove('add-new-slot');
        addSlot.classList.add('new-image-slot');
        addSlot.style.position = 'relative';
        addSlot.innerHTML = `
            <img src="${e.target.result}" alt="new image" class="rounded-3" style="width: 100%; height: 100%; object-fit: cover; border: 1px solid #ccc;">
            <button type="button" class="delete-new-image position-absolute"
                style="top:4px; right:4px; width:20px; height:20px; font-size:0.8rem; border:none; border-radius:50%; background-color:#9F6B46; color:white; cursor:pointer; display:flex; align-items:center; justify-content:center; opacity:1;"
                aria-label="Delete Image"
                onclick="deleteNewImage(this)">&times;</button>
            <input type="file" class="d-none new-image-input" name="new_image[]" accept="image/*">
        `;

        const newFileInput = addSlot.querySelector('input[type="file"]');
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        newFileInput.files = dataTransfer.files;

        addSlot.removeAttribute('id');

        if (getCurrentImageCount() < 3) {
            newImageIndex++;
            const newAddSlot = document.createElement('div');
            newAddSlot.className = 'image-slot add-new-slot';
            newAddSlot.id = 'add-slot';
            newAddSlot.style.cssText = 'width:100px; height:100px;';
            newAddSlot.innerHTML = `
                <label class="d-flex justify-content-center align-items-center rounded-3 h-100 w-100"
                    style="cursor:pointer; background-color:#f0f0f0; border:1px solid #ccc; color:#555;"
                    for="new_image_file_${newImageIndex}">
                    <span class="small font-weight-bold">+ Add</span>
                </label>
                <input type="file" class="d-none new-image-input" name="new_image[]" id="new_image_file_${newImageIndex}" onchange="previewNewImage(this)" accept="image/*">
            `;
            document.getElementById('image-upload-area').appendChild(newAddSlot);
        }

        updateAddSlotVisibility();
    };
    reader.readAsDataURL(file);
}

function deleteExistingImage(button) {
    const slot = button.closest('.image-slot');
    const imageId = button.getAttribute('data-image-id');
    const hiddenInput = slot.querySelector('.deleted-image-input');
    hiddenInput.value = imageId;
    hiddenInput.disabled = false;
    slot.classList.add('d-none');
    updateAddSlotVisibility();
}

function deleteNewImage(button) {
    const slot = button.closest('.image-slot');
    slot.remove();
    if (!document.querySelector('.add-new-slot')) {
        newImageIndex++;
        const newAddSlot = document.createElement('div');
        newAddSlot.className = 'image-slot add-new-slot';
        newAddSlot.id = 'add-slot';
        newAddSlot.style.cssText = 'width:100px; height:100px;';
        newAddSlot.innerHTML = `
            <label class="d-flex justify-content-center align-items-center rounded-3 h-100 w-100"
                style="cursor:pointer; background-color:#f0f0f0; border:1px solid #ccc; color:#555;"
                for="new_image_file_${newImageIndex}">
                <span class="small font-weight-bold">+ Add</span>
            </label>
            <input type="file" class="d-none new-image-input" name="new_image[]" id="new_image_file_${newImageIndex}" onchange="previewNewImage(this)" accept="image/*">
        `;
        document.getElementById('image-upload-area').appendChild(newAddSlot);
    }
    updateAddSlotVisibility();
}

const costSlider = document.getElementById('cost-slider');
const costDisplay = document.getElementById('cost-current');
costSlider?.addEventListener('input', () => {
    if (costSlider.value == 10000) {
        costDisplay.textContent = '¥10000~';
    } else {
        costDisplay.textContent = '¥' + costSlider.value;
    }
});


document.querySelectorAll('.category-checkbox').forEach(cb => {
    cb.addEventListener('change', function() {
        if (document.querySelectorAll('.category-checkbox:checked').length > 3) {
            this.checked = false;
            alert('You can select up to 3 categories.');
        }
    });
});
</script>
@endsection
