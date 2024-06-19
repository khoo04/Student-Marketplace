@extends('components.layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile_seller.css') }}">

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
            <button id="my-profile" class="navigation-btn" data-index="0" data-active><i class="fa-solid fa-user"></i> My Profile</button>
            <button id="manage-product" class="navigation-btn" data-index="1"><i class="fa-solid fa-briefcase"></i> Manage Product</button>
            <button id="manage-order"" class="navigation-btn" data-index="2"><i class="fa-solid fa-clipboard-list"></i> Manage Order</button>
            <button id="sales-report" class="navigation-btn" data-index="3"><i class="fa-solid fa-chart-simple"></i> Sales Report</button>
            <button id="logout" class="navigation-btn" data-index="4"><i class="fa-solid fa-right-from-bracket"></i> Log out</button>
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
                        <x-profiles.product-control :products='$user->products' />
                    @break

                    @case(2)
                        @php
                            $orders = \App\Models\Order::with(['address', 'product.seller', 'buyer', 'payment'])
                                ->whereHas('product.seller', function ($query) {
                                    $query->where('user_id', auth()->user()->id); // user_id here refers to the seller_id
                                })
                                //Check whether the payment is success or not, only order with success payment will show on seller view
                                ->whereHas('payment', function ($query) {
                                    $query->where('payment_status', '=', 'success');
                                })
                                ->orderByRaw('created_at DESC')
                                ->whereNotNull('order_status')
                                ->get();
                        @endphp
                        <x-profiles.manage-order-control :orders=$orders />
                    @break

                    @case(3)
                        @php
                            $currentUser = Auth::user();

                            $products = auth()->user()->products;

                            $ordersQuery = \App\Models\Order::with(['product', 'payment'])
                                ->whereHas('product', function ($query) use ($currentUser) {
                                    $query->where('user_id', $currentUser->id);
                                })
                                ->whereHas('payment', function ($query) {
                                    $query->where('payment_status', 'success');
                                });

                            // Get the first and last order dates
                            $firstOrderDate =
                                $ordersQuery->orderBy('created_at', 'asc')->first()->created_at ?? Carbon::now();
                            $lastOrderDate =
                                $ordersQuery->orderBy('created_at', 'desc')->first()->created_at ?? Carbon::now();

                            //Generate the year range
                            $startYear = $firstOrderDate->year;
                            $endYear = $lastOrderDate->year;
                            $years = range($startYear, $endYear);
                        @endphp
                        <x-profiles.sales-report-control :products=$products :years=$years />
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

                redirectActivePage({{ session('pageIndex') }});
            @endif

            @if (session()->has('pageIndex'))
                function redirectActivePage(index) {
                    $(".navigation-btn").removeAttr('data-active');
                    $(".navigation-btn[data-index='" + index + "']").attr('data-active', '');
                }

                redirectActivePage({{ session('pageIndex') }});
            @endif

            @if (session()->has('pageIndex'))
                function redirectActivePage(index) {
                    $(".navigation-btn").removeAttr('data-active');
                    $(".navigation-btn[data-index='" + index + "']").attr('data-active', '');
                }

                redirectActivePage({{ session('pageIndex') }});
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
