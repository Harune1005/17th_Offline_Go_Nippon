@extends('layouts.app')

@section('content')

<style>
    
    body, html {
        font-family: 'Source Serif Pro', serif; 
        background-color: white; 
        
    }

    .full-page-container {
        display: flex;
        justify-content: center;
        align-items: flex-start; 
        min-height: 100vh;
        position: relative; 
        background-color: white; 
    }

    .login-container {
        width: 100%;
        max-width: 760px;
        padding: 40px 20px;
        background-color: white; 
    }

    .log-in-title {
        font-size: 2.2rem; 
        color: #9F6B46; 
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-message {
        margin-bottom: 0.2rem;
        font-size: 1.1rem;
        color: #9F6B46; 
    }

    .stay-connected-message {
        color: #9F6B46; 
        font-size: 1rem;
        margin-bottom: 3rem; 
    }

    
    .login-label {
        font-weight: 600; 
        margin-bottom: 0.3rem; 
        display: block;
        text-align: left;
        font-size: 1rem;
        color: #9F6B46; 
    }

    .login-input {
        height: 50px; 
        border-radius: 5px;
        padding: 0.375rem 1rem;
        border: 1px solid #ced4da; 
        font-size: 1rem;
        width: 100%; 
    }

    .login-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(159, 107, 70, 0.25);
        border-color: #9F6B46;
    }

    .login-input::placeholder {
        color: #9F6B46 !important;
        opacity: 0.8;
    }

    .password-field-container {
        position: relative;
        width: 100%; 
    }

    .password-toggle-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #9F6B46;
        font-size: 1.1rem;
    }

    .custom-sign-in-btn {
        background-color: #F8C7B3; 
        color: #9F6B46; 
        border: 1px solid #F8C7B3;
        height: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        border-radius: 5px;
        transition: background-color 0.2s;
        width: 100%; 
    }

    .custom-sign-in-btn:hover {
        background-color: #f5bba7; 
        border-color: #f5bba7;
        color: #9F6B46;
    }

    .google-sign-in-btn {
        background-color: white;
        color: #9F6B46; 
        border: 1px solid #ced4da;
        height: 50px;
        font-weight: 500;
        font-size: 1rem;
        border-radius: 5px;
        position: relative;
        padding-left: 45px;
        transition: background-color 0.2s;
        width: 100%; 
    }

    .google-sign-in-btn:hover {
        background-color: #f8f8f8;
        border-color: #ced4da;
        color: #9F6B46;
    }

    .google-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: bold;
        color: #4285F4;
        font-size: 1.2rem;
    }

    .signup-text {
        color: #9F6B46;
        font-size: 1rem;
        margin-top: 2rem;
    }
    .signup-link {
        color: #9F6B46;
        text-decoration: underline;
        font-weight: 600;
    }
    .signup-link:hover {
        text-decoration: underline;
    }

</style>

<div class="full-page-container">
    
    <div class="login-container">
        
        <div class="text-center">
            <h2 class="log-in-title">Log in</h2>
            <p class="welcome-message">Welcome back!</p>
            <p class="stay-connected-message">To stay connected, please login with your details.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label login-label">Email</label>
                <input id="email" type="email" class="form-control login-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label login-label">Password</label>
                <div class="password-field-container">
                    <input id="password" type="password" class="form-control login-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    <span class="password-toggle-icon" onclick="togglePasswordVisibility()">
                       <i class="fa-solid fa-eye-slash text-secondary"></i>
                    </span>
                </div>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn custom-sign-in-btn text-white">
                    Sign in
                </button>
            </div>

            <div class="d-grid mb-4">
                <button type="button" class="btn google-sign-in-btn">
                    <i class="fa-brands fa-google"></i>  Sign in with Google
                </button>
            </div>

            <div class="text-center signup-text text-secondary">
                Don't have an account? <a href="{{ route('register') ?? '#' }}" class="signup-link">Sign up</a>
            </div>

        </form>
    </div>
</div>
@endsection