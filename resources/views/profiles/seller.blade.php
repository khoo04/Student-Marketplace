@extends('components.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile_seller.css') }}">

    <script src="{{ asset('js/layout.js') }}" defer></script>
    <script src="{{ asset('js/profile.js') }}" defer></script>
    <script src="{{ asset('js/profile_seller.js') }}" defer></script>
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
        <!--My Product List-->
        <!--Manage Order-->
        <!--Sales Report-->
        <div class="control-panel">
            <x-profiles.profile-control :user=$user />
        </div>
    </div>

    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $("#my-profile").on("click", renderProfileControl);

            $("#manage-product").on("click", renderManageProductControl);

            $("#manage-order").on("click", renderManageOrderControl);

            $("#sales-report").on("click", renderSalesReportControl);

            $("#logout").on("click", logOut);

        });

        function renderProfileControl() {
            $.ajax({
                type: "GET",
                url: '{{ route('ajax.profile-control') }}',
                success: function(response) {
                    $(".control-panel").html(response.control);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function renderManageProductControl() {
            $.ajax({
                type: "GET",
                url: '{{ route('ajax.product-control') }}',
                success: function(response) {
                    $(".control-panel").html(response.control);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function renderManageOrderControl() {
            $.ajax({
                type: "GET",
                url: '{{ route('ajax.manage-order-control') }}',
                success: function(response) {
                    $(".control-panel").html(response.control);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function renderSalesReportControl() {
            $.ajax({
                type: "GET",
                url: '{{ route('ajax.sales-report-control') }}',
                success: function(response) {
                    $(".control-panel").html(response.control);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function logOut() {
            $("#logoutForm").submit();
        };
    </script>
@endsection
