@extends('components.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <section id="hero">
        <h1>Student <span>Marketplace</span></h1>
        <p>Find What Your Love, Sell What You Make.</p>
    </section>

    <div id="category-section">
        <h1>Categories</h1>
        <div id="category-container">
            <div class="category-item">
                <a href="">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Category Name</p>
                </a>
            </div>

            <div class="category-item">
                <a href="">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Category Name</p>
                </a>
            </div>
            <div class="category-item">
                <a href="">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Category Name</p>
                </a>
            </div>
            <div class="category-item">
                <a href="">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Category Name</p>
                </a>
            </div>
            <div class="category-item">
                <a href="">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Category Name</p>
                </a>
            </div>
            <div class="category-item">
                <a href="">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Category Name</p>
                </a>
            </div>
            <div class="category-item">
                <a href="">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Category Name</p>
                </a>
            </div>
            <div class="category-item">
                <a href="">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Category Name</p>
                </a>
            </div>
            <div class="category-item">
                <a href="category/used">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Used Item</p>
                </a>
            </div>
        </div>
    </div>

    <div id="product-section">
        <h1>Latest Product</h1>

        <div id="card-container">
            <div class="card" id="product-id-1">
                <div class="image">
                    <img src="images/demo.png" alt="No Image Available">
                </div>
                <div class="card-body">
                    <h1>Product Title</h1>
                    <div class="rating">
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                    </div>
                    <p>Price : RM 99.99</p>
                    <p>Quantity Available : 55</p>
                </div>
                <div class="hidden">
                    <a href="/product">View More</a>
                </div>
            </div>

            <div class="card" id="product-id-2">
                <div class="image">
                    <img src="images/demo.png" alt="No Image Available">
                </div>
                <div class="card-body">
                    <h1>Product Titledddddddddddddddddddddddddddddddd</h1>
                    <div class="rating">
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                    </div>
                    <p>Price : RM 99.99</p>
                    <p>Quantity Available : 55</p>
                </div>
                <div class="hidden">
                    <a href="/product">View More</a>
                </div>
            </div>

            <div class="card" id="product-id-3">
                <div class="image">
                    <img src="images/demo.png" alt="No Image Available">
                </div>
                <div class="card-body">
                    <h1>Product Title</h1>
                    <div class="rating">
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                    </div>
                    <p>Price : RM 99.99</p>
                    <p>Quantity Available : 55</p>
                </div>
                <div class="hidden">
                    <a href="/product">View More</a>
                </div>
            </div>

            <div class="card" id="product-id-4">
                <div class="image">
                    <img src="images/demo.png" alt="No Image Available">
                </div>
                <div class="card-body">
                    <h1>Product Title</h1>
                    <div class="rating">
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                    </div>
                    <p>Price : RM 99.99</p>
                    <p>Quantity Available : 55</p>
                </div>
                <div class="hidden">
                    <a href="/product">View More</a>
                </div>
            </div>
        </div>
    </div>

    <a href="cart.html" id="cart-button">
        <i class="fa-solid fa-cart-shopping"></i><h2>My Cart</h2>
    </a>
@endsection


@section('js')
<script src="{{ asset('js/index.js') }}""></script>
@endsection