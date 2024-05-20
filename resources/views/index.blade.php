@extends('components.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('title')
<title>Student Marketplace | Main Page</title>
@endsection

@section('content')
    <section id="hero">
        <h1>Student <span>Marketplace</span></h1>
        <p>Find What Your Love, Sell What You Make.</p>
    </section>

    <div id="category-section">
        <h1>Categories</h1>
        <div id="category-container">
            @foreach ($categories as $category)
                <x-category-card :category=$category :icon="$icons[$category->id]"/>
            @endforeach
        </div>
    </div>
    <div id="product-section">
        <h1>Latest Product</h1>

        <div id="card-container">
        </div>
    </div>

    <a href="cart.html" id="cart-button">
        <i class="fa-solid fa-cart-shopping"></i><h2>My Cart</h2>
    </a>

    <div id="pagination"></div>
@endsection


@section('js')
<script src="{{ asset('js/index.js') }}""></script>
@endsection