@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <style>
        .card {
            max-width: 800px;
            margin: auto;
        }

        .interest-label {
            margin-right: 2rem;
            color: #9F6B46;
            font-weight: bold;
        }

        .editbtn {
            min-width: 150px;
        }

        .form-control::placeholder {
            color: #C9A28C !important;
        }

        body {
            font-family: 'Source Serif Pro', serif;
        }
    </style>

    <div class="container mt-3">
        <div class="justify-content-center">  
            <div class="card shadow border-0 rounded-4 p-4">
                <div class="card-header bg-transparent">
                    <h2 class="fw-bold mb-4 text-center" style="color:#9F6B46;">
                        <i class="fa-solid fa-pen-to-square"></i> Update Profile
                    </h2>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                        <div class="row mb-4 align-items-center">
                            <div class="col-auto me-4">
                                @if ($user->avatar)
                                    <img id="avatar-preview-existing" src="{{ asset($user->avatar) }}" 
                                        alt="{{ $user->name }}" 
                                        class="rounded-circle shadow-sm mb-3"
                                        style="width:120px; height:120px; object-fit:cover; border:4px solid #C8A27A;">
                                @else
                                    <i id="avatar-preview-existing" class="fa-solid fa-circle-user mb-3" 
                                        style="font-size:120px; color:#9F6B46; text-shadow: 3px 3px 6px rgba(0,0,0,0.3);"></i>
                                @endif
                            </div>
                            <div class="col">
                                <input type="file" name="avatar" id="avatar" 
                                        class="form-control shadow-sm border-0 w-75" accept="image/*">
                                <div class="form-text small mt-1" style="color:#9F6B46;">
                                    Acceptable formats: jpeg, jpg, png, gif <br>
                                    Max file size: 1048kb
                                </div>
                            </div>
                                @error('avatar')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                {{-- New preview will appear here --}}
                                <div id="avatar-preview-wrapper" class="mt-3"></div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold" style="color:#9F6B46;">Name</label>
                            <input type="text" name="name" id="name" class="form-control shadow-sm border-0" value="{{ old('name', $user->name) }}" autofocus>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold" style="color:#9F6B46;">Email</label>
                            <input type="email" name="email" id="email" class="form-control shadow-sm border-0" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="country" class="form-label fw-bold" style="color:#9F6B46;">Country</label>
                            <select name="country" class="form-control shadow-sm border-0">
                                @foreach($countries as $code => $country)
                                    <option value="{{ $country['name'] }}" 
                                        {{ old('country', $user->country) == $code ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="introduction" class="form-label fw-bold" style="color:#9F6B46;">Introduction</label>
                            <textarea name="introduction" id="introduction" rows="5" 
                                        class="form-control shadow-sm border-0" 
                                        placeholder="Describe yourself">{{ old('introduction', $user->introduction) }}</textarea>
                            @error('introduction')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category" class="form-label fw-bold" style="color:#9F6B46;">
                                Interest <span class="fw-normal small">(choose up to 3)</span>
                            </label>
                            <div>
                                @foreach ($categories as $category)
                                    <div class="form-check form-check-inline">
                                        <input 
                                            type="checkbox"
                                            name="category[]"
                                            id="category-{{ $category->id }}"
                                            value="{{ $category->id }}"
                                            class="form-check-input accent-color"
                                            style="border-color: #776B5D"
                                            {{ in_array($category->id, old('category', $user->categories->pluck('id')->toArray())) ? 'checked' : '' }}>

                                        <label for="category-{{ $category->id }}" class="form-check-label">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                            <label for="current_password" class="form-label fw-bold" style="color:#9F6B46;">Change Password</label>

                        <div class="mb-4">             
                            <input type="password" name="current_password" id="current_password" 
                                class="form-control shadow-sm border-0" placeholder="Current Password">
                            @error('current_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <input type="password" name="password" id="password" 
                                class="form-control shadow-sm border-0" placeholder="New Password">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                class="form-control shadow-sm border-0" placeholder="Confirm New Password">
                        </div>

                        <div class="text-end">
                           <a href="{{ route('profile.show', $user->id) }}" 
                                class="btn editbtn shadow-sm me-3"
                                style="border: 2px solid #B0B0B0; color: white; font-weight: bold; background-color: #B0B0B0; transition: 0.3s;"
                                onmouseover="this.style.backgroundColor='white'; this.style.color='#B0B0B0';"
                                onmouseout="this.style.backgroundColor='#B0B0B0'; this.style.color='white';">
                                Cancel
                            </a>

                            <button type="submit" class="btn editbtn shadow-sm"
                                style="background-color:#F1BDB2; color:white; font-weight:bold; border:2px solid #F1BDB2; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='transparent'; this.style.color='#F1BDB2';"
                                onmouseout="this.style.backgroundColor='#F1BDB2'; this.style.color='white';">
                                Save
                            </button>
                        </div>
                    </form>
                </div>           
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('avatar').addEventListener('change', function(event) {
            const previewWrapper = document.getElementById('avatar-preview-wrapper');
            previewWrapper.innerHTML = ''; 

            const file = event.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                previewWrapper.innerHTML = '<p class="text-danger small">画像ファイルを選択してください。</p>';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded-circle shadow-sm';
                img.style.width = '120px';
                img.style.height = '120px';
                img.style.objectFit = 'cover';
                img.style.border = '4px solid #C8A27A';
                previewWrapper.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    </script>
    <script>
        document.querySelectorAll('input[name="category[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checked = document.querySelectorAll('input[name="category[]"]:checked');
                if (checked.length > 3) {
                    this.checked = false;
                    alert('You can select up to 3 interests only.');
                }
            });
        });
    </script>
@endpush