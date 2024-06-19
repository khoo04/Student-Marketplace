@extends('components.layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        #hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('images/marketplace_hero.png') }}') no-repeat center center/cover;
            filter: blur(6px);
            z-index: 0;
        }

        #hero-background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
    </style>
@endsection

@section('title')
    <title>Student Marketplace | Main Page</title>
@endsection

@section('content')
    @include('components.flash-message')
    <section id="hero">
        <div id="hero-background"></div>
        <div id="hero-content">
            <h1>Student <span>Marketplace</span></h1>
            <p>Find What You <span style="color: #FF3131;">Love</span>, Sell What You <span style="color:#76FF7A;">Make</span></p>
        </div>
    </section>
    <div id="category-section">
        <h1>Categories</h1>
        <div id="category-container">
            @foreach ($categories as $category)
                <x-category-card :category=$category :icon="$icons[$category->id]" />
            @endforeach
        </div>
    </div>
    <div id="product-section">
        <h1>Latest Product</h1>

        <div id="card-container">
        </div>
    </div>

    @if (auth()->user() != null)
        @if (auth()->user()->types == 'buyer')
            <a href="{{ route('cart') }}" id="cart-button">
                <i class="fa-solid fa-cart-shopping"></i>
                <h2>My Cart</h2>
            </a>
        @endif
    @else
        <a href="{{ route('cart') }}" id="cart-button">
            <i class="fa-solid fa-cart-shopping"></i>
            <h2>My Cart</h2>
        </a>
    @endif
    <div id="pagination"></div>
@endsection


@section('js')
    <script src="{{ asset('js/index.js') }}""></script>
@endsection
