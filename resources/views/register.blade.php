@extends('components.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="form-container">
  <h2 class="form-title">Create an Account</h2>
  <form method="POST" action="/register" id="register-form">
    @csrf
    <div class="field-container">
      <label for="first_name">First name </label>
      <input type="text" id="first_name" name="first_name" required>
    </div>
    @error('fname')
      <p>{{$message}}</p>
    @enderror

    <div class="field-container">
      <label for="last_name">Last name*</label>
      <input type="text" id="last_name" name="last_name" required>
    </div>
    @error('lname')
      <p>{{$message}}</p>
    @enderror

    <div class="field-container">
      <label for="email">Email*</label>
      <input type="email" id="email" name="email" required>
    </div>
    @error('email')
    <p>{{$message}}</p>
    @enderror
  
    <div class="field-container">
      <label for="phone_num">Phone Number</label>
      <input type="text" id="phone_num" name="phone_num" required>
    </div>
    @error('phone_num')
    <p>{{$message}}</p>
    @enderror

    <div class="field-container">
      <label for="password">Password*</label>
      <input type="password" id="pasword" name="password" required>
      <input type="checkbox" onclick="showPass1()" id="pwd1">
      <label for="pwd1" class="checkboxLabel">Show Password</label>
    </div>
    @error('password')
    <p class="error-message">{{$message}}</p>
    @enderror

    <div class="field-container">
      <label for="password_confirmation">Confirm password*</label>
      <input type="password" id="password_confirmation" name="password_confirmation" required>
      <input type="checkbox" onclick="showPass2()" id="pwd2">
      <label for="pwd2" class="checkboxLabel">Show Password</label>
    </div>
    @error('password_confirmation')
      <p>{{$message}}</p>
    @enderror
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
    </div>
    @error('types')
    <p class="error-message">{{$message}}</p>
    @enderror
    <button type="submit" class="submit-btn">CONFIRM AND CONTINUE</button>
    <p>Already have an account? <a href="/login">Login</a></p>

  </form>
</div>
@endsection