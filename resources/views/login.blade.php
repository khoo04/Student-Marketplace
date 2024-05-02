@extends('components.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="form-container">
    <h2 class="form-title">Log In</h2>
    <div class="title-line"></div>
    <form method="POST" action="/login" id="login-form">
    @csrf
    <div class="field-container">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="field-container">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        @error('email')
        <p class="error-message">{{$message}}</p>
        @enderror
    </div>
    <button type="submit" class="submit-btn">LOGIN</button>
    <p class="register-link">Don't have an account? <a href="/register">Sign Up</a></p>

    </form>
</div>
@endsection