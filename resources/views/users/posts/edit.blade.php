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
                        value="{{ old('title', $post->title) }}">
                    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">{{ __('messages.edit_post.description') }}</label>
                    <textarea name="content" class="form-control post-input" rows="4">{{ old('content', $post->content) }}</textarea>
                    @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('messages.edit_post.date') }}</label>
                        <input type="date" name="date" class="form-control post-input"
                            value="{{ old('date', \Carbon\Carbon::parse($post->visited_at)->format('Y-m-d')) }}">
                        @error('date') <div class="text-danger small">{{ $message }}</div> @enderror
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
                        @error('time_hour') <div class="text-danger small">{{ $message }}</div> @enderror
                        @error('time_min') <div class="text-danger small">{{ $message }}</div> @enderror
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
                    @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4" style="max-width:300px;">
                    <label class="form-label fw-bold">{{ __('messages.edit_post.prefecture') }}</label>
                    <select name="prefecture_id" class="form-select post-input">
                        <option value="">{{ __('messages.edit_post.prefecture_placeholder') }}</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->id }}"
                                {{ old('prefecture_id', $post->prefecture_id) == $prefecture->id ? 'selected' : '' }}>
                                {{ $prefecture->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('prefecture_id') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4" style="max-width:350px;">
                    <label class="form-label fw-bold">{{ __('messages.edit_post.cost') }}</label>
                    <div class="d-flex align-items-center gap-2">
                        <span id="cost-current">¥{{ old('cost', $post->cost) }}</span>
                        <input type="range" name="cost" min="0" max="10000" step="100"
                            value="{{ old('cost', $post->cost) }}" id="cost-slider" class="form-range">
                    </div>
                    @error('cost') <div class="text-danger small">{{ $message }}</div> @enderror
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
                                    <video src="{{ asset('storage/'.$media->path) }}" muted playsinline controls></video>
                                @endif
                                <button type="button"
                                        class="remove-btn"
                                        onclick="deleteExistingMedia(this)">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                        {{-- add slot --}}
                        <div class="media-slot add-new-slot" id="add-slot">
                            <label class="d-flex justify-content-center align-items-center h-100 w-100"
                                for="new_media_file_0">
                                +
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
                       href="{{ route('home') }}"
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


{{-- HEIC converter --}}
<script src="https://unpkg.com/heic2any/dist/heic2any.min.js"></script>

<script>
let mediaIndex = 0;
const MAX_MEDIA = 3;

/* ===============================
合計メディア数（既存 + 新規）
=============================== */
function getTotalMediaCount() {
    return document.querySelectorAll(".media-slot:not(.add-new-slot)").length;
}

/* ===============================
add-slot（＋）再描画
=============================== */
function redrawAddSlot() {
    document.querySelectorAll(".add-new-slot").forEach(e => e.remove());

    if (getTotalMediaCount() >= MAX_MEDIA) return;

    mediaIndex++;

    const slot = document.createElement("div");
    slot.className = "media-slot add-new-slot";
    slot.id = "add-slot";

    slot.innerHTML = `
        <label class="d-flex justify-content-center align-items-center h-100 w-100"
            style="cursor:pointer;background:#f0f0f0;border:1px solid #B0B0B0;color:#9F6B46;font-weight:bold;"
            for="new_media_file_${mediaIndex}">
            +
        </label>
        <input type="file" class="d-none new-media-input"
            name="new_media[]" id="new_media_file_${mediaIndex}"
            accept="image/*,video/*"
            onchange="previewNewMedia(this)">
    `;

    document.querySelector("#media-upload-area").appendChild(slot);
}

/* ===============================
MOV / QuickTime 判定
=============================== */
function isQuickTimeVideo(file) {
    return (
        file.name.toLowerCase().endsWith(".mov") ||
        file.type === "video/quicktime"
    );
}

/* ===============================
HEIC → JPEG 変換
=============================== */
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
    } catch (error) {
        console.error("HEIC → JPG 変換失敗:", error);
        return null;
    }
}

/* ===============================
新規メディアプレビュー
=============================== */
window.previewNewMedia = async function (input) {
    const file = input.files[0];
    if (!file) return;

    const slot = input.closest(".add-new-slot");
    if (!slot) return;

    let previewFile = file;
    const ext = file.name.toLowerCase();
    const isHeic = ext.endsWith(".heic");
    const isMov = isQuickTimeVideo(file);

    // HEIC → JPEG 自動変換
    if (isHeic) {
        const converted = await convertHeicToJpeg(file);
        if (converted) {
            previewFile = converted;
        } else {
            // fallback → HEIC アイコン表示
            renderPreviewSlot(slot, "/images/heic-placeholder.png", file, true);
            return;
        }
    }

    // createObjectURL でプレビュー
    const previewSrc = URL.createObjectURL(previewFile);

    // 画像判定
    const isImage = !isMov && previewFile.type.startsWith("image/");

    renderPreviewSlot(slot, previewSrc, previewFile, isImage);
};

/* ===============================
プレビュー描画（動画 / 画像 / HEICアイコン）
=============================== */
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

    addDeleteButton(slot);
    addHiddenInput(slot, fileToSend);

    redrawAddSlot();
}

/* ===============================
新規メディア削除ボタン
=============================== */
function addDeleteButton(slot) {
    const btn = document.createElement("button");
    btn.innerHTML = "&times;";
    btn.className = "remove-btn";
    btn.onclick = () => {
        slot.remove();
        redrawAddSlot();
    };
    slot.appendChild(btn);
}

/* ===============================
hidden input 追加（サーバー送信用）
=============================== */
function addHiddenInput(slot, file) {
    const input = document.createElement("input");
    input.type = "file";
    input.name = "new_media[]";
    input.classList.add("d-none");

    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;

    slot.appendChild(input);
}

/* ===============================
既存メディア削除（DB削除依頼）
=============================== */
window.deleteExistingMedia = function (btn) {
    const slot = btn.closest(".media-slot");
    const id = slot.dataset.id;

    const hidden = document.createElement("input");
    hidden.type = "hidden";
    hidden.name = "deleted_media[]";
    hidden.value = id;

    document.querySelector("#edit-form").appendChild(hidden);

    slot.remove();
    redrawAddSlot();
};

/* ===============================
初期化
=============================== */
document.addEventListener("DOMContentLoaded", () => {
    redrawAddSlot();

    // cost slider
    const costSlider = document.getElementById('cost-slider');
    const costDisplay = document.getElementById('cost-current');
    costSlider?.addEventListener('input', () => {
        if (costSlider.value == 10000) {
            costDisplay.textContent = '¥10000~';
        } else {
            costDisplay.textContent = '¥' + costSlider.value;
        }
    });

    // category checkbox
    document.querySelectorAll('.category-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            if (document.querySelectorAll('.category-checkbox:checked').length > 3) {
                this.checked = false;
                alert('You can select up to 3 categories.');
            }
        });
    });

});
</script>

@endsection
