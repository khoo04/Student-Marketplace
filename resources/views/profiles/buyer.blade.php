@extends('components.layout')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<link rel="stylesheet" href="{{asset('css/profile_buyer.css')}}">

<script src="{{asset('js/layout.js')}}" defer></script>
<script src="{{asset('js/profile.js')}}" defer></script>
<script src="{{asset('js/profile_buyer.js')}}" defer></script>
@endsection

@section('title')
<title>Student Marketplace | My Profile</title>
@endsection

@section('content')
<div id="profile-section">
    <div id="navigate">
        <button id="my-profile" data-index="0" data-active>My Profile</button>
        <button id="my-address" data-index="1">My Address</button>
        <button id="my-order" data-index="2">My Order</button>
        <button id="logout" data-index="3">Log out</button>
    </div>
    
    <!-- My Profile (User / Seller)-->
    <!--My Address-->
    <!--My Order-->

    <div class="control-panel">
        <x-profiles.profile-control :user=$user />
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        
        $("#my-profile").on("click",renderProfileControl);

        $("#my-address").on("click",renderAddressControl);

        $("#my-order").on("click",renderUserOrderControl);
    });

    function renderProfileControl() {
        $.ajax({
            type: "GET",
            url: '{{route("ajax.profile-control")}}',
            success: function (response) {
                $(".control-panel").html(response.control);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function renderAddressControl(){
        $.ajax({
            type: "GET",
            url: '{{route("ajax.address-control")}}',
            success: function (response) {
                $(".control-panel").html(response.control);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function renderUserOrderControl(){
        $.ajax({
            type: "GET",
            url: '{{route("ajax.user-order-control")}}',
            success: function (response) {
                $(".control-panel").html(response.control);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
@endsection