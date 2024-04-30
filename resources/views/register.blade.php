@extends('components.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="form-container">
    <h2 class="form-title">Create an Account</h2>
    <form onsubmit="return validatePasswords()">

      <label for="fname">First name*</label>
      <input type="text" id="fname" name="fname" required>

      <label for="lname">Last name*</label>
      <input type="text" id="lname" name="lname" required>

      <label for="email">Email*</label>
      <input type="email" id="email" name="email" required>
      <br>

      <label for="pwd">Password*</label>
      <input type="password" id="pwd" name="pwd" required>
      <input type="checkbox" onclick="showPass1() ">Show Password
      <br><br>

      <label for="cpwd">Confirm password*</label>
      <input type="password" id="cpwd" name="cpwd" required>
      <input type="checkbox" onclick="showPass2()">Show Password

      <br><br>
      <label>Sign me up as *:</label>
      <div class="radio-container">
        <input type="radio" id="buyer" name="account" value="buyer" checked>
        <label for="buyer">Buyer</label>
        <input type="radio" id="seller" name="account" value="seller">
        <label for="seller">Seller</label>
      </div>

      <input type="submit" value="CONFIRM AND CONTINUE">

      <hr>
      <a href="test2.html">&nbsp;&nbsp;Already have an account? Login</a>

    </form>
  </div>
@endsection