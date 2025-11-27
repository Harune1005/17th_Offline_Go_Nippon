@extends('layouts.app')

@section('title', 'Interest')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-4 text-decoration-underline">{{ __('messages.interest.title') }}</h2>

    <form action="{{ route('interests.store') }}" method="POST" id="interestForm">
        @csrf

        <div class="row g-3">
            @foreach($categories as $category)
                @php
                    $imagePath = asset($category->image ?? 'images/default.jpeg');
                @endphp
                <div class="col-md-4">
                    <div class="form-check border rounded p-3 h-100">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $category->id }}" class="form-check-input category-checkbox">
                        <label for="cat{{ $category->id }}" class="form-check-label ms-2 text-light fw-semibold category-label" style="background-image: url('{{ $imagePath }}')">
                            <div class="bg-dark bg-opacity-50 px-3 py-2 rounded">{{ $category->name }}</div>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        @error('categories')
            <div class="text-danger mt-3 text-center">{{ $message }}</div>
        @enderror

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-outline px-4 py-2 w-25">{{ __('messages.interest.save') }}</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('.category-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const checked = document.querySelectorAll('.category-checkbox:checked');
                if (checked.length > 3) {
                    checkbox.checked = false;
                    alert('You can select up to 3 categories.');
                }
            });
        });
    });
</script>
@endsection