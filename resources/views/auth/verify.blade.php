@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow border-0 p-4" style="max-width: 480px; width: 100%;">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Verify Your Email</h3>
            <p class="text-muted mb-0">Check your email for the verification link</p>
        </div>

        @if (session('resent'))
            <div class="alert alert-success text-center" role="alert">
                A fresh verification link has been sent to your email address.
            </div>
        @endif

        <p class="text-center text-muted">
            Didn't receive the email?
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="d-flex justify-content-center">
            @csrf
            <button type="submit" class="btn btn-outline">
                Request Another
            </button>
        </form>
    </div>
</div>
@endsection