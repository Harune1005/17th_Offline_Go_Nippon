@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow border-0 p-4" style="max-width: 480px; width: 100%;">
        <div class="text-center mb-4">
            <h3 class="fw-bold">{{ __('messages.verify_email.title') }}</h3>
            <p class="text-muted mb-0">{{ __('messages.verify_email.text') }}</p>
        </div>

        @if (session('resent'))
            <div class="alert alert-success text-center" role="alert">
                {{ __('messages.verify_email.text') }}
            </div>
        @endif

        <p class="text-center text-muted">
            {{ __('messages.verify_email.text_2') }}
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="d-flex justify-content-center">
            @csrf
            <button type="submit" class="btn btn-outline">
                {{ __('messages.verify_email.request') }}
            </button>
        </form>
    </div>
</div>
@endsection