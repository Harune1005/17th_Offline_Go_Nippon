@extends('layouts.app')

@section('content')

<div class="container mt-3">
    <div class="card shadow border-0 rounded-4 p-4 mx-auto fade-in" style="max-width: 800px;">
        <div class="card-header bg-transparent">
            <h2 class="fw-bold text-center mb-4" style="color:#9F6B46;">
                <i class="fa-solid fa-circle-plus"></i> {{ __('messages.create_post.main_title') }}
            </h2>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">{{ __('messages.create_post.title') }}</label>
                    <input type="text" name="title" class="form-control post-input" value="{{ old('title') }}">
                    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">{{ __('messages.create_post.description') }}</label>
                    <textarea name="content" class="form-control post-input" rows="4">{{ old('content') }}</textarea>
                    @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Date / Time --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('messages.create_post.date') }}</label>
                        <input type="date" name="date" class="form-control post-input" value="{{ old('date', date('Y-m-d')) }}">
                        @error('date') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('messages.create_post.time') }}</label>
                        <div class="d-flex align-items-center gap-1">
                            <input type="number" name="time_hour" class="form-control post-input" min="0" max="23" value="{{ old('time_hour',0) }}">
                            <span>{{ __('messages.create_post.hour') }}</span>
                            <input type="number" name="time_min" class="form-control post-input" min="0" max="59" value="{{ old('time_min',0) }}">
                            <span>{{ __('messages.create_post.min') }}</span>
                        </div>
                        @error('time_hour') <div class="text-danger small">{{ $message }}</div> @enderror
                        @error('time_min') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Categories --}}
                <div class="mb-4">
                    <label cclass="form-label fw-bold">{{ __('messages.create_post.categories') }}</label>
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
                    <label class="form-label fw-bold">{{ __('messages.create_post.prefecture') }}</label>
                    <select name="prefecture_id" class="form-select post-input">
                        <option value="">{{ __('messages.create_post.prefecture_placeholder') }}</option>
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
                    <label class="form-label fw-bold">{{ __('messages.create_post.cost') }}</label>
                    <div class="d-flex align-items-center gap-2">
                        <span id="cost-current">{{ old('cost',100) }}</span>
                        <input type="range" name="cost" min="0" max="10000" step="100" value="" id="cost-slider" class="form-range">
                    </div>
                    @error('cost') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Images + Videos --}}
                <div class="mb-5">
                    <label class="form-label">{{ __('messages.create_post.image') }}</label>
                    <div class="d-flex flex-wrap gap-3" id="media-upload-area">
                        <div class="media-slot add-new-slot" id="add-slot">
                            <label for="new_media_file_0" class="add-label">＋</label>
                            <input type="file"
                                class="d-none new-media-input"
                                name="media[]"
                                id="new_media_file_0"
                                accept="image/*,video/*"
                                onchange="previewNewMedia(this)">
                        </div>
                    </div>
                    @error('media') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    @error('media.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('home') }}"
                       class="btn btn-cancel shadow-sm me-3"
                       style="min-width:150px; font-weight:bold;">
                        {{ __('messages.create_post.cancel') }}
                    </a>

                    <button type="submit" class="btn btn-outline shadow-sm"
                        style="min-width:150px; font-weight:bold; transition:0.3s;">
                        {{ __('messages.create_post.button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- HEIC converter --}}
<script src="https://cdn.jsdelivr.net/npm/heic2any/dist/heic2any.min.js"></script>

{{-- cost slider --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slider = document.getElementById("cost-slider");
        const display = document.getElementById("cost-current");

        if (costSlider && costDisplay) {
    // 初期表示
    costDisplay.textContent = 
        costSlider.value == 10000 ? '¥10000~' : '¥' + costSlider.value;

    // スライダー変更時
    costSlider.addEventListener('input', () => {
        costDisplay.textContent = 
            costSlider.value == 10000 ? '¥10000~' : '¥' + costSlider.value;
    });
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
</script>

{{-- for media slot --}}
<script>
    let mediaIndex = 0;
    const MAX_MEDIA = 3;

    function getMediaCount() {
        return document.querySelectorAll(".media-slot:not(.add-new-slot)").length;
    }

    function redrawAddSlot() {
        document.querySelectorAll(".add-new-slot").forEach(s => s.remove());
        if (getMediaCount() >= MAX_MEDIA) return;

        mediaIndex++;
        const slot = document.createElement("div");
        slot.className = "media-slot add-new-slot";
        slot.id = "add-slot";
        slot.style.cssText = "width:100px; height:100px;";

        slot.innerHTML = `
            <label for="new_media_file_${mediaIndex}" class="add-label">＋</label>
            <input type="file"
                class="d-none new-media-input"
                id="new_media_file_${mediaIndex}"
                name="media[]"
                accept="image/*,video/*"
                onchange="previewNewMedia(this)">
        `;
        document.getElementById("media-upload-area").appendChild(slot);
    }

    function isQuickTimeVideo(file) {
        return (
            file.name.toLowerCase().endsWith(".mov") ||
            file.type === "video/quicktime"
        );
    }

    async function convertHeicToJpeg(file) {
        try {
            const convertedBlob = await heic2any({
                blob: file,
                toType: "image/jpeg",
                quality: 0.9
            });

            return new File([convertedBlob], file.name.replace(/\.heic/i, ".jpg"), {
                type: "image/jpeg"
            });
        } catch (err) {
            console.error("Failed HEIC → JPG:", err);
            return null;
        }
    }

    /* ===============================
        メディアプレビュー処理（MOV 対応版）
    ================================ */
    window.previewNewMedia = async function (input) {
        const file = input.files[0];
        if (!file) return;

        const slot = input.closest(".add-new-slot");
        if (!slot) return;

        let previewFile = file;
        const ext = file.name.toLowerCase();
        const isHeic = ext.endsWith(".heic");
        const isMov = isQuickTimeVideo(file);

        /* ---------- HEIC 自動変換 ---------- */
        if (isHeic) {
            const converted = await convertHeicToJpeg(file);

            if (converted) {
                previewFile = converted; // JPEG に置き換え
            } else {
                // 変換失敗 → HEIC アイコン
                renderPreviewSlot(slot, "/images/heic-placeholder.png", file, true);
                return;
            }
        }

        /* ---------- プレビュー URL 生成 ---------- */

        let previewSrc = URL.createObjectURL(previewFile);

        let isImage = false;
        if (isMov) isImage = false;
        else if (previewFile.type.startsWith("image/")) isImage = true;
        else isImage = false;

        renderPreviewSlot(slot, previewSrc, previewFile, isImage);
    };

    /* ===============================
        スロット描画
    ================================ */
    function renderPreviewSlot(slot, src, fileToSend, isImage) {
        slot.classList.remove("add-new-slot");
        slot.classList.add("media-slot");
        slot.removeAttribute("id");
        slot.innerHTML = "";
        slot.style.position = "relative";

        let el;
        if (isImage) {
            el = document.createElement("img");
            el.src = src;
        } else {
            el = document.createElement("video");
            el.src = src;
            el.muted = true;
            el.playsInline = true;
            el.controls = true; 
        }

        el.style.cssText = "width:100%;height:100%;object-fit:cover;";
        slot.appendChild(el);

        const removeBtn = document.createElement("button");
        removeBtn.classList.add("remove-btn");
        removeBtn.innerHTML = "&times;";
        removeBtn.style.cssText = `position:absolute; top:4px; right:4px; width:24px; height:24px;
                            background: #9F6B46;
                            border-radius:50%; color:#fff; border:none; cursor:pointer;
                            line-height:24px; text-align:center; font-weight:bold;`
        removeBtn.onclick = () => deleteMedia(removeBtn);
        slot.appendChild(removeBtn);

        const hiddenInput = document.createElement("input");
        hiddenInput.type = "file";
        hiddenInput.name = "media[]";
        hiddenInput.classList.add("d-none");

        const dt = new DataTransfer();
        dt.items.add(fileToSend);
        hiddenInput.files = dt.files;

        slot.appendChild(hiddenInput);

        redrawAddSlot();
    }

    window.deleteMedia = function (btn) {
        btn.closest(".media-slot").remove();
        redrawAddSlot();
    };
</script>


@endsection
