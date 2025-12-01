@extends('layouts.app')

@section('content')

<style>
    .full-page-container {
        display: flex;
        justify-content: center;
        align-items: flex-start; 
        min-height: 100vh;
        position: relative; 
        background-color: white; 
    }

    .register-container {
        width: 100%;
        max-width: 760px; 
        padding: 40px 20px;
        background-color: white; 
    }

    .register-title {
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

    
    .register-label {
        font-weight: 600; 
        margin-bottom: 0.3rem; 
        display: block;
        text-align: left;
        font-size: 1rem;
        color: #9F6B46; 
    }

    .register-input {
        height: 50px; 
        border-radius: 5px;
        padding: 0.375rem 1rem;
        border: 1px solid #ced4da; 
        font-size: 1rem;
        width: 100%;
        color: #9F6B46; 
    }

    .register-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(159, 107, 70, 0.25);
        border-color: #9F6B46;
    }

    .register-input::placeholder {
        color: #9F6B46 !important;
        opacity: 0.8;
    }
    
    .form-select.register-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239F6B46' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
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

    .custom-sign-up-btn {
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

    .custom-sign-up-btn:hover {
        background-color: #f5bba7; 
        border-color: #f5bba7;
        color: #9F6B46;
    }

    .google-sign-up-btn {
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

    .google-sign-up-btn:hover {
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

    .signin-text {
        color: #9F6B46;
        font-size: 1rem;
        margin-top: 2rem;
    }
    .signin-link {
        color: #9F6B46;
        text-decoration: underline;
        font-weight: 600;
    }
    .signin-link:hover {
        text-decoration: underline;
    }
    
    .d-flex.flex-column.align-items-center > div {
        width: 100% !important; 
    }

</style>

<div class="full-page-container">
    
    <div class="register-container">
        
        <div class="text-center">
            <h2 class="register-title">{{ __('messages.register.title') }}</h2>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="d-flex flex-column align-items-center">

                <div class="mb-3">
                    <label for="name" class="form-label register-label">{{ __('messages.register.name') }}</label>
                    <input id="name" type="text" class="form-control register-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('messages.register.name_placeholder') }}">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label register-label">{{ __('messages.register.email') }}</label>
                    <input id="email" type="email" class="form-control register-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('messages.register.email_placeholder') }}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                @php
                    $groupedCountries = collect($countries)
                        ->sortBy('name')
                        ->groupBy(function ($country) {
                            return strtoupper(substr($country['name'], 0, 1));
                        });
                @endphp

                <div class="mb-3">
                    <label for="country" class="form-label register-label">{{ __('messages.register.country') }}</label>
                    <select id="country" name="country" class="form-select register-input @error('country') is-invalid @enderror" required>
                        <option value="" disabled selected>{{ __('messages.register.country_placeholder') }}</option>

                        @foreach ($groupedCountries as $letter => $group)
                            <optgroup label="{{ $letter }}">
                                @foreach ($group as $country)
                                    <option value="{{ $country['name'] }}" {{ old('country') == $country['name'] ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>

                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label register-label">{{ __('messages.register.password') }}</label>
                    <div class="password-field-container">
                        <input id="password" type="password" class="form-control register-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('messages.register.password_placeholder') }}">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('password', 'passwordIcon')">
                            <i id="passwordIcon" class="fa-solid fa-eye-slash text-secondary"></i>
                        </span>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label register-label">{{ __('messages.register.password_confirm') }}</label>
                    <div class="password-field-container">
                        <input id="password-confirm" type="password" class="form-control register-input" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('messages.register.password_confirm_placeholder') }}">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('password-confirm', 'confirmPasswordIcon')">
                             <i id="confirmPasswordIcon" class="fa-solid fa-eye-slash text-secondary"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn custom-sign-up-btn text-white">
                        {{ __('messages.register.submit') }}
                    </button>
                </div>

                <div class="d-grid mb-4">
                    <a href="{{ route('social.redirect', 'google') }}" 
                    class="btn google-sign-up-btn d-flex justify-content-center align-items-center">
                        <i class="fa-brands fa-google me-2"></i> {{ __('messages.register.submit_google') }}
                    </a>
                </div>
            </div>
            
            <div class="text-center signin-text text-secondary">
                {{ __('messages.register.to_signin') }} <a href="{{ route('login') ?? '#' }}" class="signin-link">{{ __('messages.register.signin') }}</a>
            </div>
        </form>
    </div>
</div>

<script>

    function togglePasswordVisibility(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        
        
        if (!icon) return; 

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye-slash'); 
            icon.classList.add('fa-eye'); 
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye'); 
            icon.classList.add('fa-eye-slash'); 
        }
    }
</script>
@endsection