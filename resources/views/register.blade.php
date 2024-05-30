@extends('components.layout')

@section('title')
    <title>Student Marketplace | Register</title>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="form-container">
        <h2 class="form-title">Create an Account</h2>
        <form method="POST" action="/register" id="register-form">
            @csrf
            <div class="field-container">
                <label for="first_name">First name </label>
                <div class="input-box">
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                </div>
                @error('first_name')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="field-container">
                <label for="last_name">Last name</label>
                <div class="input-box">
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                </div>
                @error('last_name')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>


            <div class="field-container">
                <label for="email">Email</label>
                <div class="input-box">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>


            <div class="field-container">
                <label for="phone_num">Phone Number</label>
                <div class="input-box">
                    <input type="text" id="phone_num" name="phone_num" value="{{ old('phone_num') }}" required>
                </div>
                @error('phone_num')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>


            <div class="field-container">
                <label for="password">Password</label>
                <div class="input-box">
                    <input type="password" id="password" name="password" required>
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
                @error('password')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>


            <div class="field-container">
                <label for="password_confirmation">Confirm password</label>
                <div class="input-box">
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
                @error('password_confirmation')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="sign-up-container">
                <p>Sign me up as:</p>
                <div class="radio-container">
                    <div class="buyer-radio-container">
                        <input type="radio" id="buyer" name="types" value="buyer">
                        <label for="buyer">Buyer</label>
                    </div>
                    <div class="seller-radio-container">
                        <input type="radio" id="seller" name="types" value="seller">
                        <label for="seller">Seller</label>
                    </div>
                </div>
                @error('types')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="submit-btn">CONFIRM AND CONTINUE</button>
            <p>Already have an account? <a href="/login">Login</a></p>

        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/register.js') }}"></script>
@endsection
