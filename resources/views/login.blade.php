@extends('components.layout')

@section('title')
<title>Student Marketplace | Login</title>
@endsection

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
        <div class="input-box">
            <input type="text" id="email" name="email" required>
        </div>
    </div>
    <div class="field-container">
        <label for="password">Password</label>
        <div class="input-box">
            <input type="password" name="password" id="password" required>
            <i class="fa-solid fa-eye-slash"></i>
        </div>
        @error('email')
        <p class="form-error-message">{{$message}}</p>
        @enderror
    </div>
    <button type="submit" class="submit-btn">LOGIN</button>
    <p class="register-link">Don't have an account? <a href="/register">Sign Up</a></p>
    </form>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){

    $("input").on("focus",function(){
      $(this).parent().addClass("focused");
    })

    $("input").on("blur",function(){
      $(this).parent().removeClass("focused");
    })

    $(".input-box i").on("mousedown", function(event) {
      event.preventDefault();
      event.stopPropagation();
    })
    .on("click", function() {
      let passwordInput = $(this).prev("input");
      if (passwordInput.attr("type") === "password") {
          passwordInput.attr("type", "text");
          $(this).removeClass("fa-eye-slash").addClass("fa-eye");
      } else {
          passwordInput.attr("type", "password");
          $(this).removeClass("fa-eye").addClass("fa-eye-slash");
      }
  });
});
</script>
@endsection