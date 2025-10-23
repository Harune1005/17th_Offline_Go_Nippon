@extends('layouts.app')

@section('content')

<style>
    /* -------------------------------------- */
    /* ** CUSTOM CSS FOR UNIFIED DESIGN ** */
    /* -------------------------------------- */

    /* Global Fonts and Background */
    body, html {
        font-family: 'Source Serif Pro', serif; 
        background-color: white; 
    }

    /* Page Container for Centering */
    .full-page-container {
        display: flex;
        justify-content: center;
        align-items: flex-start; 
        min-height: 100vh;
        padding-top: 80px;
        position: relative; 
        background-color: white; 
    }

    /* Form Container (Wide Card) */
    .post-container {
        width: 100%;
        max-width: 760px; /* Maintains the double-width requirement */
        padding: 40px 30px;
        background-color: white; 
        border: 1px solid #9F6B46; /* Brown border */
        border-radius: 5px;
        box-sizing: border-box;
    }

    /* Header Styling */
    .post-header {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem; 
        color: #9F6B46;
        font-weight: 700;
        margin-bottom: 2rem;
        padding-bottom: 15px;
        border-bottom: 1px solid  #9F6B46; 
    }
    .post-header i {
        font-size: 1.5em;
        margin-right: 10px;
    }

    /* Form Labels (Brown) */
    .post-label {
        font-weight: 600; 
        margin-bottom: 0.3rem; 
        display: block;
        text-align: left;
        font-size: 1rem;
        color: #9F6B46; 
    }

    /* Input/Select/Textarea Common Style (100% width, Brown Text) */
    .post-input, .form-select.post-input {
        height: 40px; 
        border-radius: 5px;
        padding: 0.375rem 1rem;
        border: 1px solid #ced4da; 
        font-size: 1rem;
        width: 100%;
        color: #9F6B46; /* Text color is brown */
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

    /* Placeholder Text (Brown) */
    .post-input::placeholder {
        color: #9F6B46 !important;
        opacity: 0.8;
    }
    
    /* Select Dropdown Arrow Customization */
    .form-select.post-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239F6B46' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }


    /* Time Input Specifics */
    .time-input {
        width: 60px !important;
        text-align: center;
        padding: 0.375rem 0.5rem;
    }
    .time-unit {
        margin: 0 5px;
        color: #9F6B46;
    }
    
    /* Cost Display */
    .cost-display {
        color: #9F6B46;
        font-weight: 600;
        margin-left: 10px;
        min-width: 60px;
    }
    
    /* Range Input (Slider) Customization */
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
    .image-error {
        background-color: #fce8e6;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #db4437;
        font-size: 2rem;
    }
    .image-loading {
        background: linear-gradient(90deg, #eee 25%, #ddd 50%, #eee 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    

    /* Footer Buttons (Cancel / Post) */
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

</style>

<div class="full-page-container">
    
    <div class="post-container">
        
        <div class="post-header">
            <i class="fa-solid fa-circle-plus"></i> Create Post
        </div>

        {{-- Set the action to the 'post.store' route defined in your routes/web.php --}}
        <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label post-label">Title</label>
                <input id="title" type="text" class="form-control post-input @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus placeholder="Arakurayamasengen Park">

                @error('title')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label post-label">Description</label>
                <textarea id="content" class="form-control post-input @error('description') is-invalid @enderror" name="content" rows="4" required placeholder="Approximately 650 cherry trees are planted in the park, and in the spring a cherry blossom festival is held, attracting many visitors.">{{ old('content') }}</textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{--Date & Time--}}  
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date" class="form-label post-label">Date</label>
                    <input id="date" type="date" class="form-control post-input @error('date') is-invalid @enderror" name="date" value="{{ old('date', date('Y-m-d')) }}">
                    @error('visited_at')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="time" class="form-label post-label">Time</label>
                    <div class="d-flex align-items-center">
                        <input type="number" class="form-control post-input time-input @error('time_hour') is-invalid @enderror" name="time_hour" value="{{ old('time_hour', '0') }}" min="0" max="23">
                        <span class="time-unit">hour</span>
                          @error('time_hour')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
                        <input type="number" class="form-control post-input time-input @error('time_min') is-invalid @enderror" name="time_min" value="{{ old('time_min', '50') }}" min="0" max="59">
                        <span class="time-unit">min</span>
                          @error('time_min')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                    <label for="categories" class="form-label post-label">Categories</label>

                    <div id="category-checkboxes" class="d-flex flex-wrap gap-3">
                        @foreach ($all_categories as $category)
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input category-checkbox @error('category') is-invalid @enderror"
                                    name="category[]" 
                                    id="category_{{ $category->id }}" 
                                    value="{{ $category->id }}"
                                    {{ in_array($category->id, old('category', [])) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="category_{{ $category->id }}">
                                    {{ ucfirst($category->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    @error('category')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                
               {{-- Prefecture Field (47 Prefectures) --}}
        <div class="col-md-5">
            <label for="prefecture_id" class="form-label post-label">Prefecture</label>
            <select class="form-select post-input @error('prefecture_id') is-invalid @enderror" 
                    name="prefecture_id" id="prefecture_id" required>
                <option value="">Select Prefecture</option>
                @foreach ($prefectures as $prefecture)
                    <option value="{{ $prefecture->id }}" 
                        {{ old('prefecture_id') == $prefecture->id ? 'selected' : '' }}>
                        {{ $prefecture->name }}
                    </option>
                @endforeach
            </select>

            @error('prefecture_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

           {{-- Cost --}}
            <div class="mb-4" style="width: 60%;">
                <label class="post-label" for="cost-slider">Cost</label>
                <div class="range-wrap">
                    <span class="cost-display" id="cost-current">¥100</span>
                    <input id="cost-slider" name="cost" type="range" min="0" max="10000" step="100" value="100" class="range-input">
                </div>
                  @error('cost')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
            </div>

            {{-- Images --}}
            <div class="mb-4">
                <label class="post-label" for="file-upload">Images (up to 3)</label>

                <div class="image-controls">
                    <label for="file-upload" class="image-btn">+ Add</label>
                    <input 
                        id="file-upload" 
                        name="image[]" 
                        type="file" 
                        accept="image/*" 
                        multiple 
                        hidden
                    >
                </div>

                <div id="image-previews" class="image-preview-area"></div>

                @error('image')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>


            {{-- Footer --}}
            <div class="form-footer">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn-post">Post</button>
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

    // コストスライダー更新
    costSlider?.addEventListener('input', () => {
        costDisplay.textContent = '¥' + costSlider.value;
    });

    // 画像プレビュー処理
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

                const removeBtn = document.createElement('span');
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

    // カテゴリ選択（最大3つまで）
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
<style>
 .image-item {
    position: relative;
    display: inline-block;
    margin: 5px;
  }
  .image-item img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
  }
  .remove-btn {
    position: absolute;
    top: 3px;
    right: 3px;
    background: #9F6B46;
    color: #fff;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-weight: bold;
  }
  </style>

@endsection