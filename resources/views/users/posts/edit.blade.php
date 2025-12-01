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
                    <div id="existing-media" class="media-preview-area">
                        @foreach($post->media as $media)
                            <div class="media-item" data-id="{{ $media->id }}">
                                @if ($media->type === 'image')
                                    <img src="{{ asset('storage/' . $media->path) }}" alt="">
                                @else
                                    <video 
                                        src="{{ asset('storage/' . $media->path) }}" 
                                        controls 
                                        muted 
                                        playsinline
                                        style="max-height:160px;">
                                    </video>
                                @endif

                                <span class="remove-btn">×</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Add new images --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Add New Media (max 3 total)</label>
                    <div id="media-inputs"></div>
                    <div id="media-previews" class="media-preview-area"></div>
                </div>

                {{-- Buttons --}}
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
    const MAX_MEDIA = 3;

    const form = document.getElementById('edit-form');
    const existing = document.getElementById('existing-media');
    const inputs = document.getElementById('media-inputs');
    const previews = document.getElementById('media-previews');

    let count = existing.querySelectorAll('.media-item').length;

    // --- 既存メディア削除 ---
    existing.addEventListener('click', function(e) {
        if (!e.target.classList.contains('remove-btn')) return;

        const item = e.target.closest('.media-item');
        const id = item.dataset.id;

        if (id) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_media[]';
            input.value = id;
            form.appendChild(input);
        }

        item.remove();
        count--;
        if (!document.querySelector('.media-add-btn') && count < MAX_MEDIA) {
            addMediaInput();
        }
    });

    // --- 新規メディア入力を追加 ---
    function addMediaInput() {

        if (count >= MAX_MEDIA) return;
        if (document.querySelector('.media-add-btn')) return;

        const wrapper = document.createElement('div');
        wrapper.classList.add('media-controls');

        const label = document.createElement('label');
        label.textContent = '+ Add';
        label.classList.add('media-btn', 'media-add-btn');

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'new_media[]';
        input.accept = 'image/*,video/*';
        input.style.display = 'none';

        wrapper.append(label, input);
        inputs.appendChild(wrapper);

        label.addEventListener('click', () => input.click());

        // --- プレビュー & カウント管理 ---
        input.addEventListener('change', function () {

            if (!this.files[0]) return;
            count++;

            const file = this.files[0];
            const mime = file.type;
            const preview = document.createElement('div');
            preview.classList.add('media-item');

            // 削除ボタン
            const removeBtn = document.createElement('span');
            removeBtn.classList.add('remove-btn');
            removeBtn.textContent = '×';

            removeBtn.onclick = () => {
                preview.remove();
                wrapper.remove();
                count--;
                if (!document.querySelector('.media-add-btn') && count < MAX_MEDIA) {
                    addMediaInput();
                }
            };

            // 画像の場合
            if (mime.startsWith('image')) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }

            // 動画の場合
            else if (mime.startsWith('video')) {
                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.controls = true;
                video.muted = true;
                video.playsinline = true;
                video.style.maxHeight = '160px';
                preview.appendChild(video);
            }

            preview.appendChild(removeBtn);
            previews.appendChild(preview);

            label.remove();

            if (!document.querySelector('.media-add-btn') && count < MAX_MEDIA) {
                addMediaInput();
            }
        });
    }

    if (count < MAX_MEDIA) {
        addMediaInput();
    }

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
