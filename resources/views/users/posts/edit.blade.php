@extends('layouts.app')

@section('content')

<div class="container mt-3">
    <div class="card shadow border-0 rounded-4 p-4 mx-auto fade-in" style="max-width: 800px;">
        <div class="card-header bg-transparent">
            <h2 class="fw-bold text-center mb-4" style="color:#9F6B46;">
                <i class="fa-solid fa-pen-to-square"></i> {{ __('messages.edit_post.main_title') }}
            </h2>
        </div>

        <div class="card-body">
            <form id="edit-form" method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="form-label fw-bold">{{ __('messages.edit_post.title') }}</label>
                    <input type="text" name="title" class="form-control post-input"
                        value="{{ old('title', $post->title) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">{{ __('messages.edit_post.description') }}</label>
                    <textarea name="content" class="form-control post-input" rows="4" required>{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('messages.edit_post.date') }}</label>
                        <input type="date" name="date" class="form-control post-input"
                            value="{{ old('date', \Carbon\Carbon::parse($post->visited_at)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('messages.edit_post.time') }}</label>
                        <div class="d-flex align-items-center gap-1">
                            <input type="number" name="time_hour" class="form-control post-input"
                                min="0" max="23" value="{{ old('time_hour', $post->time_hour) }}">
                            <span>{{ __('messages.edit_post.hour') }}</span>
                            <input type="number" name="time_min" class="form-control post-input"
                                min="0" max="59" value="{{ old('time_min', $post->time_min) }}">
                            <span>{{ __('messages.edit_post.min') }}</span>
                        </div>
                    </div>
                </div>

                @php
                    $old_categories = old('category', $post->categories->pluck('id')->toArray());
                @endphp
                <div class="mb-4">
                    <label class="form-label fw-bold">{{ __('messages.edit_post.categories') }}</label>
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
                    <label class="form-label fw-bold">{{ __('messages.edit_post.prefecture') }}</label>
                    <select name="prefecture_id" class="form-select post-input" required>
                        <option value="">{{ __('messages.edit_post.prefecture_placeholder') }}</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}"
                                {{ old('prefecture_id', $post->prefecture_id) == $prefecture->id ? 'selected' : '' }}>
                                {{ $prefecture->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4" style="max-width:350px;">
                    <label class="form-label fw-bold">{{ __('messages.edit_post.cost') }}</label>
                    <div class="d-flex align-items-center gap-2">
                        <span id="cost-current">{{ __('messages.edit_post.$') }}{{ old('cost', $post->cost) }}</span>
                        <input type="range" name="cost" min="0" max="10000" step="100"
                            value="{{ old('cost', $post->cost) }}" id="cost-slider" class="form-range">
                    </div>
                </div>

                
                <div class="mb-5">
                    <label class="form-label fw-bold">{{ __('messages.edit_post.image') }}</label>
                    
                     <div class="d-flex flex-wrap gap-3 mb-2" id="media-upload-area">
                        {{-- show existing Media --}}
                        @foreach ($post->media as $media)
                            <div class="media-slot existing-media" data-id="{{ $media->id }}">
                                @if ($media->type === 'image')
                                    <img src="{{ asset('storage/'.$media->path) }}" alt="existing image">
                                @else
                                    <video src="{{ asset('storage/'.$media->path) }}" muted playsinline></video>
                                @endif
                                {{-- remove button --}}
                                 <button type="button"
                                    class="delete-existing-media"
                                    onclick="deleteExistingMedia(this)"
                                    data-id="{{ $media->id }}">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                        {{-- add slot --}}
                        <div class="media-slot add-new-slot" id="add-slot">
                            <label class="d-flex justify-content-center align-items-center h-100 w-100"
                                style="cursor:pointer; background:#f0f0f0; border:1px solid #B0B0B0; color:#9F6B46; font-weight:bold;"
                                for="new_media_file_0">
                                + Add
                            </label>
                            <input type="file" class="d-none new-media-input" 
                                name="new_media[]" id="new_media_file_0"
                                accept="image/*,video/*"
                                onchange="previewNewMedia(this)">
                        </div>
                     </div>

                    @error('new_media') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    @error('new_media.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                </div>

                {{-- Buttons --}}
                <div class="text-end mt-4">
                    <a type="button"
                       onclick="window.history.back()"
                       class="btn btn-cancel shadow-sm me-3"
                       style="min-width:150px; font-weight:bold;">
                        {{ __('messages.edit_post.cancel') }}
                    </a>

                    <button type="submit"
                        class="btn btn-outline shadow-sm"
                        style="min-width:150px; font-weight:bold; transition:0.3s;">
                        {{ __('messages.edit_post.button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let mediaIndex = 0;
const MAX_MEDIA = 3;

function getTotalMediaCount() {
    return document.querySelectorAll(".media-slot:not(.add-new-slot)").length;
}

function redrawAddSlot() {
    // 既存の add-slot を削除
    document.querySelectorAll(".add-new-slot").forEach(e => e.remove());

    // MAX に達していたら作らない
    if (getTotalMediaCount() >= MAX_MEDIA) return;

    mediaIndex++;

    let addSlot = document.createElement("div");
    addSlot.className = "media-slot add-new-slot";
    addSlot.id = "add-slot";

    addSlot.innerHTML = `
        <label class="d-flex justify-content-center align-items-center h-100 w-100"
            style="cursor:pointer; background:#f0f0f0; border:1px solid #B0B0B0; color:#9F6B46; font-weight:bold;"
            for="new_media_file_${mediaIndex}">
            + Add
        </label>
        <input type="file" class="d-none new-media-input"
            name="new_media[]" id="new_media_file_${mediaIndex}"
            accept="image/*,video/*" 
            onchange="previewNewMedia(this)">
    `;

    document.querySelector("#media-upload-area").appendChild(addSlot);
}

window.previewNewMedia = function(input) {
    const file = input.files[0];
    const slot = input.closest(".add-new-slot");
    if (!file || !slot) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        slot.classList.remove("add-new-slot");
        slot.removeAttribute("id");
        slot.innerHTML = "";

        let preview;
        if (file.type.startsWith("image/")) {
            preview = document.createElement("img");
            preview.src = e.target.result;
        } else {
            preview = document.createElement("video");
            preview.src = e.target.result;
            preview.muted = true;
            preview.playsInline = true;
        }
        preview.style.cssText = "width:100%; height:100%; object-fit:cover;";
        slot.appendChild(preview);

        const delBtn = document.createElement("button");
        delBtn.className = "delete-new-media";
        delBtn.innerHTML = "&times;";
        delBtn.style.cssText = `
            top:4px; right:4px; position:absolute;
            width:20px;height:20px;border-radius:50%;
            background:#9F6B46;color:#fff;border:none;cursor:pointer;
        `;
        delBtn.onclick = () => deleteNewMedia(delBtn);
        slot.appendChild(delBtn);

        // file input を保持
        const newInput = document.createElement("input");
        newInput.type = "file";
        newInput.classList.add("d-none");
        newInput.name = "new_media[]";

        const dt = new DataTransfer();
        dt.items.add(file);
        newInput.files = dt.files;

        slot.appendChild(newInput);

        redrawAddSlot();
    };

    reader.readAsDataURL(file);
};

window.deleteNewMedia = function(btn) {
    btn.closest(".media-slot").remove();
    redrawAddSlot();
};

window.deleteExistingMedia = function(btn) {
    const slot = btn.closest(".media-slot");
    const id = slot.dataset.id;

    // hidden input を form に直接追加（slot の外へ）
    const form = document.getElementById("edit-form");
    const hidden = document.createElement("input");
    hidden.type = "hidden";
    hidden.name = "deleted_media[]";
    hidden.value = id;
    form.appendChild(hidden);

    // slot は削除
    slot.remove();

    redrawAddSlot();
}

const costSlider = document.getElementById('cost-slider');
const costDisplay = document.getElementById('cost-current');
costSlider?.addEventListener('input', () => {
    costDisplay.textContent = '¥' + costSlider.value;
});

document.querySelectorAll('.category-checkbox').forEach(cb => {
    cb.addEventListener('change', function() {
        if (document.querySelectorAll('.category-checkbox:checked').length > 3) {
            this.checked = false;
            alert('You can select up to 3 categories.');
        }
    });

    // at least 1 media
    form.addEventListener('submit', function(e) {
        const existingCount = existing.querySelectorAll('.media-item').length;
        const newCount = previews.querySelectorAll('.media-item').length;

        if (existingCount + newCount === 0) {
            e.preventDefault();
            alert('You must have at least 1 image or video.');
        }
    });
});
</script>
@endsection
