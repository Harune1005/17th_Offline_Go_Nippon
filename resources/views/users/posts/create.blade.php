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
                        <span id="cost-current">{{ __('messages.create_post.$') }}{{ old('cost',100) }}</span>
                        <input type="range" name="cost" min="0" max="10000" step="100" value="{{ old('cost',100) }}" id="cost-slider" class="form-range">
                    </div>
                    @error('cost') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Images + Videos --}}
                <div class="mb-5">
                    <label class="form-label">{{ __('messages.create_post.image') }}</label>
                    <div class="d-flex flex-wrap gap-3" id="media-upload-area">
                        <div class="media-slot add-new-slot" id="add-slot" style="width:100px; height:100px;">
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
                    <a onclick="window.history.back()"
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

<style>
.media-slot {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    width: 100px;
    height: 100px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.15);
}

.add-new-slot .add-label {
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

.image-slot img,
.media-slot video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-btn {
    position: absolute;
    top: 3px;
    right: 3px;
    background: rgba(0,0,0,0.6);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 16px;
    cursor: pointer;
    line-height: 24px;
    text-align: center;
}

.image-slot button {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
    let mediaIndex = 0;
    const MAX_MEDIA = 3;

    // 現在のメディア数（add-slot を除く）
    function getMediaCount() {
        return document.querySelectorAll(".media-slot:not(.add-new-slot)").length;
    }

    // add-slot を一度全削除 → 新しく1つだけ作り直す
    function redrawAddSlot() {
        // 既存の add-slot を削除
        const oldSlots = document.querySelectorAll(".add-new-slot");
        oldSlots.forEach(s => s.remove());

        // MAX に達したら作らない
        if (getMediaCount() >= MAX_MEDIA) return;

        // 新しい add-slot を作る
        mediaIndex++;

        const newSlot = document.createElement("div");
        newSlot.className = "media-slot add-new-slot";
        newSlot.id = "add-slot";
        newSlot.style.cssText = "width:100px; height:100px;";

        newSlot.innerHTML = `
            <label for="new_media_file_${mediaIndex}" class="add-label">＋</label>
            <input type="file"
                class="d-none"
                id="new_media_file_${mediaIndex}"
                name="media[]"
                accept="image/*,video/*"
                onchange="previewNewMedia(this)">
        `;

        document.getElementById("media-upload-area").appendChild(newSlot);
    }

    // メディアの追加処理
    window.previewNewMedia = function (input) {
        const file = input.files[0];
        if (!file) return;

        const slot = input.closest(".add-new-slot"); // 今の add-slot
        if (!slot) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            // add-slot を通常スロット化
            slot.classList.remove("add-new-slot");
            slot.classList.add("media-slot");
            slot.removeAttribute("id");
            slot.innerHTML = "";
            slot.style.position = "relative";

            let preview;

            // --- 画像 ---
            if (file.type.startsWith("image/")) {
                preview = document.createElement("img");
                preview.src = e.target.result;
            }
            // --- 動画 ---
            else if (file.type.startsWith("video/")) {
                preview = document.createElement("video");
                preview.src = e.target.result;
                preview.muted = true;
                preview.playsInline = true;
            }

            slot.appendChild(preview);

            // 削除ボタン
            const removeBtn = document.createElement("button");
            removeBtn.classList.add("remove-btn");
            removeBtn.innerHTML = "&times;";
            removeBtn.onclick = () => deleteMedia(removeBtn);
            slot.appendChild(removeBtn);

            // input を slot 内に保持する
            const newInput = document.createElement("input");
            newInput.type = "file";
            newInput.name = "media[]";
            newInput.classList.add("d-none");

            const dt = new DataTransfer();
            dt.items.add(file);
            newInput.files = dt.files;

            slot.appendChild(newInput);

            // 🔥 add-slot を完全再描画する
            redrawAddSlot();
        };

        reader.readAsDataURL(file);
    };

    // メディア削除
    window.deleteMedia = function (button) {
        const slot = button.closest(".media-slot");
        slot.remove();

        // 再描画
        redrawAddSlot();
    };
</script>

@endsection
