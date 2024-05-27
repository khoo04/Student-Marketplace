@extends('components.layout')

@section('styles')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<link rel="stylesheet" href="{{asset('css/profile_seller.css')}}">

<script src="{{asset('js/layout.js')}}" defer></script>
<script src="{{asset('js/profile.js')}}" defer></script>
<script src="{{asset('js/profile_seller.js')}}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('title')
<title>Student Marketplace | My Profile</title>
@endsection

@section('content')
<div id="profile-section">
    <!--Side Navigation Bar-->
    <div id="navigate">
        <button id="my-profile" data-index="0" data-active>My Profile</button>
        <button id="manage-product" data-index="1">Manage Product</button>
        <button id="manage-order"" data-index="2">Manage Order</button>
        <button id="sales-report" data-index="3">Sales Report</button>
        <button id="logout" data-index="4">Log out</button>
    </div>

    <!--My Profile-->
    <div class="control-panel" data-active>

    </div>

    <!--My Product List-->
    <div class="control-panel">
       
    </div>

    <!--Manage Order-->
    <div class="control-panel">
       
    </div>

    <!--Sales Report-->
    <div class="control-panel">
      
    </div>
</div>
@endsection