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
                    <label cclass="form-label fw-bold">Categories (max 3)</label>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach($all_categories as $category)
                            <div class="form-check" style="width: 130px">
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
                <div class="mb-5">
                    <label class="form-label fw-bold">Images (max 3 total)</label>
                    <div class="d-flex flex-wrap gap-3" id="image-upload-area">
                        <div class="image-slot add-new-slot" id="add-slot" style="width:100px; height:100px;">
                            <label for="new_image_file_0">+ Add</label>
                            <input type="file" class="d-none new-image-input" name="image[]" id="new_image_file_0"
                                onchange="previewNewImage(this)" accept="image/*">
                        </div>
                    </div>
                     @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                     @error('image.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="text-end mt-4">
                    <a onclick="window.history.back()"
                       class="btn btn-cancel shadow-sm me-3"
                       style="min-width:150px; font-weight:bold;">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-outline shadow-sm"
                        style="min-width:150px; font-weight:bold; transition:0.3s;">
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.image-slot {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    width: 100px;
    height: 100px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.15);
}

.add-new-slot label {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    cursor: pointer;
    background-color: #f0f0f0;
    border: 1px solid #B0B0B0;
    color: #9F6B46;
    font-weight: bold;
    border-radius: inherit; 
}

.image-slot img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-slot button {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    updateAddSlotVisibility();

    document.querySelector('form').addEventListener('submit', function(e) {
        if (getCurrentImageCount() > 3) {
            alert('You can upload up to 3 images.');
            e.preventDefault();
        }
    });

    let newImageIndex = 0;

    function getCurrentImageCount() {
        return document.querySelectorAll('.new-image-slot').length;
    }

    function updateAddSlotVisibility() {
        const addSlot = document.getElementById('add-slot');
        if (addSlot) {
            getCurrentImageCount() >= 3 ? addSlot.classList.add('d-none') : addSlot.classList.remove('d-none');
        }
    }

    window.previewNewImage = function(input) {
        const file = input.files[0];
        const addSlot = input.closest('.add-new-slot');
        if (!file || !addSlot) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            addSlot.classList.remove('add-new-slot');
            addSlot.classList.add('new-image-slot');
            addSlot.style.position = 'relative';
            addSlot.innerHTML = `
                <img src="${e.target.result}" alt="new image">
                <button type="button" class="delete-new-image position-absolute"
                    style="top:4px; right:4px; width:20px; height:20px; font-size:0.8rem; border:none; border-radius:50%; background-color:#9F6B46; color:white; cursor:pointer;"
                    onclick="deleteNewImage(this)">&times;</button>
                <input type="file" class="d-none new-image-input" name="image[]" accept="image/*">
            `;

            const newFileInput = addSlot.querySelector('input[type="file"]');
            const dt = new DataTransfer();
            dt.items.add(file);
            newFileInput.files = dt.files;

            addSlot.removeAttribute('id');

            if (getCurrentImageCount() < 3) {
                newImageIndex++;
                const newAddSlot = document.createElement('div');
                newAddSlot.className = 'image-slot add-new-slot';
                newAddSlot.id = 'add-slot';
                newAddSlot.style.cssText = 'width:100px; height:100px;';
                newAddSlot.innerHTML = `<label for="new_image_file_${newImageIndex}">+ Add</label>
                    <input type="file" class="d-none new-image-input" name="image[]" id="new_image_file_${newImageIndex}" onchange="previewNewImage(this)" accept="image/*">`;
                document.getElementById('image-upload-area').appendChild(newAddSlot);
            }

            updateAddSlotVisibility();
        };
        reader.readAsDataURL(file);
    }

    window.deleteNewImage = function(button) {
        const slot = button.closest('.image-slot');
        slot.remove();
        if (!document.querySelector('.add-new-slot')) {
            newImageIndex++;
            const newAddSlot = document.createElement('div');
            newAddSlot.className = 'image-slot add-new-slot';
            newAddSlot.id = 'add-slot';
            newAddSlot.style.cssText = 'width:100px; height:100px;';
            newAddSlot.innerHTML = `<label for="new_image_file_${newImageIndex}">+ Add</label>
                <input type="file" class="d-none new-image-input" name="image[]" id="new_image_file_${newImageIndex}" onchange="previewNewImage(this)" accept="image/*">`;
            document.getElementById('image-upload-area').appendChild(newAddSlot);
        }
        updateAddSlotVisibility();
    }

    // Cost slider
    const costSlider = document.getElementById('cost-slider');
    const costDisplay = document.getElementById('cost-current');
   costSlider?.addEventListener('input', () => {
    if (costSlider.value == 10000) {
        costDisplay.textContent = '¥10000~';
    } else {
        costDisplay.textContent = '¥' + costSlider.value;
    }
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
