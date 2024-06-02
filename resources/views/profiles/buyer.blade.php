@extends('components.layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile_buyer.css') }}">
@endsection

@section('title')
    <title>Student Marketplace | My Profile</title>
@endsection

@section('content')
    <div id="profile-section">
        <div id="navigate">
            <button id="my-profile" class="navigation-btn" data-index="0" data-active>My Profile</button>
            <button id="my-address" class="navigation-btn" data-index="1">My Address</button>
            <button id="my-order" class="navigation-btn" data-index="2">My Order</button>
            <button id="logout" class="navigation-btn" data-index="3">Log out</button>
        </div>

        <!-- My Profile (User / Seller)-->
        <!--My Address-->
        <!--My Order-->

        <div class="control-panel">
            @if (session()->has('pageIndex'))
                @switch($pageIndex)
                    @case(0)
                        <x-profiles.profile-control :user=$user />
                    @break

                    @case(1)
                        <x-profiles.address-control />
                    @break

                    @case(2)
                        <x-profiles.user-order-control />
                    @break

                    @default
                        <x-profiles.profile-control />
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
            var pages = [renderProfileControl, renderAddressControl, renderUserOrderControl, logOut];
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

        function renderAddressControl() {
            $.ajax({
                type: "GET",
                url: '{{ route('ajax.address-control') }}',
                success: function(response) {
                    $(".control-panel").html(response.control);
                    attachAddressControlEventListener();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function renderUserOrderControl() {
            $.ajax({
                type: "GET",
                url: '{{ route('ajax.user-order-control') }}',
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

        function showModal() {
            console.log("called")
            const modal = document.querySelector("[data-modal]")
            modal.showModal();
        }

        function attachAddressControlEventListener() {
            //My Address Page
            //Change default button state when user click it
            default_buttons = document.querySelectorAll(".default-btn")

            default_buttons.forEach((default_button) =>
                default_button.addEventListener("click", (e) => {
                    activeDefaultButton = document.querySelector(".default-btn[disabled]")
                    inactiveDefaultButton = document.querySelectorAll(".default-btn:not([disabled]")

                    if (e.target != activeDefaultButton) {
                        activeDefaultButton.innerHTML = "Set as Default"
                        activeDefaultButton.removeAttribute("disabled")
                        delete activeDefaultButton.dataset.active
                        e.target.innerHTML = "Default"
                        e.target.setAttribute("disabled", "")
                        e.target.dataset.active = ""
                    }
                })
            )


            //Add New Address Modal
            const openModalButton = document.querySelector("[data-open-modal]")
            const closeModalButton = document.querySelector("[data-close-modal]")
            const modal = document.querySelector("[data-modal]")

            openModalButton.addEventListener("click", () => {
                modal.showModal()
            })

            closeModalButton.addEventListener("click", () => {
                modal.close()
            })
        }
    </script>
    <script src="{{ asset('js/layout.js') }}" defer></script>
    <script src="{{ asset('js/profile.js') }}" defer></script>
    <script src="{{ asset('js/profile_buyer.js') }}" defer></script>
@endsection