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
        padding-top: 80px;
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
            <h2 class="register-title">Register</h2>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="d-flex flex-column align-items-center">

                <div class="mb-3">
                    <label for="name" class="form-label register-label">Name</label>
                    <input id="name" type="text" class="form-control register-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your name">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label register-label">Email</label>
                    <input id="email" type="email" class="form-control register-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="country" class="form-label register-label">Country</label>
                    <select id="country" class="form-select register-input @error('country') is-invalid @enderror" name="country" required autocomplete="country">
                        <option value="" disabled selected>Select your country</option>
                        
                        <optgroup label="A">
                            <option value="Afghanistan" {{ old('country') == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                            <option value="Algeria" {{ old('country') == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                            <option value="Argentina" {{ old('country') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                            <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                            <option value="Austria" {{ old('country') == 'Austria' ? 'selected' : '' }}>Austria</option>
                        </optgroup>

                        <optgroup label="B">
                            <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                            <option value="Belgium" {{ old('country') == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                            <option value="Brazil" {{ old('country') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                        </optgroup>
                        
                        <optgroup label="C">
                            <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Chile" {{ old('country') == 'Chile' ? 'selected' : '' }}>Chile</option>
                            <option value="China" {{ old('country') == 'China' ? 'selected' : '' }}>China</option>
                            <option value="Colombia" {{ old('country') == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                        </optgroup>
                        
                        <optgroup label="D">
                            <option value="Denmark" {{ old('country') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                        </optgroup>

                        <optgroup label="E">
                            <option value="Egypt" {{ old('country') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                        </optgroup>
                        
                        <optgroup label="F">
                            <option value="Finland" {{ old('country') == 'Finland' ? 'selected' : '' }}>Finland</option>
                            <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                        </optgroup>

                        <optgroup label="G">
                            <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                            <option value="Ghana" {{ old('country') == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                            <option value="Greece" {{ old('country') == 'Greece' ? 'selected' : '' }}>Greece</option>
                        </optgroup>

                        <optgroup label="I">
                            <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                            <option value="Indonesia" {{ old('country') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                            <option value="Ireland" {{ old('country') == 'Ireland' ? 'selected' : '' }}>Ireland</option>
                            <option value="Israel" {{ old('country') == 'Israel' ? 'selected' : '' }}>Israel</option>
                            <option value="Italy" {{ old('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
                        </optgroup>

                        <optgroup label="J">
                            <option value="Japan" {{ old('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
                            <option value="Jordan" {{ old('country') == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                        </optgroup>

                        <optgroup label="K">
                            <option value="Kenya" {{ old('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                            <option value="Kuwait" {{ old('country') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                        </optgroup>

                        <optgroup label="M">
                            <option value="Malaysia" {{ old('country') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                            <option value="Mexico" {{ old('country') == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                            <option value="Morocco" {{ old('country') == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                        </optgroup>

                        <optgroup label="N">
                            <option value="Netherlands" {{ old('country') == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                            <option value="New Zealand" {{ old('country') == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                            <option value="Nigeria" {{ old('country') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                            <option value="Norway" {{ old('country') == 'Norway' ? 'selected' : '' }}>Norway</option>
                        </optgroup>

                        <optgroup label="P">
                            <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                            <option value="Peru" {{ old('country') == 'Peru' ? 'selected' : '' }}>Peru</option>
                            <option value="Philippines" {{ old('country') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                            <option value="Poland" {{ old('country') == 'Poland' ? 'selected' : '' }}>Poland</option>
                            <option value="Portugal" {{ old('country') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                        </optgroup>

                        <optgroup label="R">
                            <option value="Romania" {{ old('country') == 'Romania' ? 'selected' : '' }}>Romania</option>
                            <option value="Russia" {{ old('country') == 'Russia' ? 'selected' : '' }}>Russia</option>
                        </optgroup>

                        <optgroup label="S">
                            <option value="Saudi Arabia" {{ old('country') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                            <option value="Singapore" {{ old('country') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                            <option value="South Africa" {{ old('country') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                            <option value="South Korea" {{ old('country') == 'South Korea' ? 'selected' : '' }}>South Korea</option>
                            <option value="Spain" {{ old('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
                            <option value="Sweden" {{ old('country') == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                            <option value="Switzerland" {{ old('country') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                        </optgroup>

                        <optgroup label="T">
                            <option value="Taiwan" {{ old('country') == 'Taiwan' ? 'selected' : '' }}>Taiwan</option>
                            <option value="Thailand" {{ old('country') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                            <option value="Turkey" {{ old('country') == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                        </optgroup>

                        <optgroup label="U">
                            <option value="United Arab Emirates" {{ old('country') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                            <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                            <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                        </optgroup>

                        <optgroup label="V">
                            <option value="Venezuela" {{ old('country') == 'Venezuela' ? 'selected' : '' }}>Venezuela</option>
                            <option value="Vietnam" {{ old('country') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                        </optgroup>

                        <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>--- Other / その他 ---</option>
                    </select>

                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label register-label">Password</label>
                    <div class="password-field-container">
                        <input id="password" type="password" class="form-control register-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
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
                    <label for="password-confirm" class="form-label register-label">Confirm Password</label>
                    <div class="password-field-container">
                        <input id="password-confirm" type="password" class="form-control register-input" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('password-confirm', 'confirmPasswordIcon')">
                             <i id="confirmPasswordIcon" class="fa-solid fa-eye-slash text-secondary"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn custom-sign-up-btn text-white">
                        Sign up
                    </button>
                </div>

                <div class="d-grid mb-4">
                    <button type="button" class="btn google-sign-up-btn">
                       <i class="fa-brands fa-google"></i> Sign up with Google
                    </button>
                </div>
            </div>
            
            <div class="text-center signin-text text-secondary">
                Already have an account? <a href="{{ route('login') ?? '#' }}" class="signin-link">Sign in</a>
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