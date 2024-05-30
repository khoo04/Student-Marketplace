@extends('components.layout')

@section('head')
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

@include('components.flash-message')
@section('content')
    <div id="profile-section">
        <!--Side Navigation Bar-->
        <div id="navigate">
            <button id="my-profile" class="navigation-btn" data-index="0" data-active>My Profile</button>
            <button id="manage-product" class="navigation-btn" data-index="1">Manage Product</button>
            <button id="manage-order"" class="navigation-btn" data-index="2">Manage Order</button>
            <button id="sales-report" class="navigation-btn" data-index="3">Sales Report</button>
            <button id="logout" class="navigation-btn" data-index="4">Log out</button>
        </div>

        <!--My Profile-->
        <!--My Product List-->
        <!--Manage Order-->
        <!--Sales Report-->
        <div class="control-panel">
            @if (session()->has('pageIndex'))
                @switch(session('pageIndex'))
                    @case(0)
                        <x-profiles.profile-control :user=$user />
                    @break

                    @case(1)
                        <x-profiles.product-control :products='$user->products'/>
                    @break

                    @case(2)
                        <x-profiles.manage-order-control />
                    @break

                    @case(3)
                        <x-profiles.sales-report-control />
                    @break

                    @default
                        <x-profiles.profile-control :user=$user />
                @endswitch
            @else
                <x-profiles.profile-control :user=$user />
            @endif
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
            
            @if (session()->has('pageIndex'))
            function redirectActivePage(index) {
            $(".navigation-btn").removeAttr('data-active');
            $(".navigation-btn[data-index='" + index + "']").attr('data-active', '');
            }
            
            redirectActivePage({{session('pageIndex')}});
            @endif

            $(".navigation-btn").click(function() {
                const dataIndex = $(this).data('index');
                $(".navigation-btn").removeAttr('data-active');
                $(this).attr('data-active', '');
                handleNavigation(dataIndex);
            });
        });

        function handleNavigation(index) {
            var pages = [renderProfileControl, renderManageProductControl, renderManageOrderControl,
                renderSalesReportControl, logOut
            ];
            pages[index].call();
        }

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
