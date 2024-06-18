@extends('components.layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/category_page.css') }}">
@endsection

@section('title')
    <title>Student Marketplace | {{ $category->name }}</title>
@endsection

@section('content')
    <div class="container">
        <h2>Category: <span class="category-name">{{ $category->name }}</span></h2>
        <hr />
        <div class="filter-row">
            <div class="filter-operator-container">
                <!-- BEGIN FILTER BY PRICE -->
                <div class="price-filter">
                    <h3>Filter by Price:</h3>
                    <div class="input-box">
                        <label for="lower-value">Lower Price</label>
                        <input type="text" id="lower-value" class="price-input-box">
                    </div>
                    <div class="input-box">
                        <label for="highest-value">Highest Price</label>
                        <input type="text" id="highest-value" class="price-input-box">
                    </div>
                </div>
                <!-- END FILTER BY PRICE -->
                <!-- START FILTER BY NAME-->
                <div class="search-filter">
                    <h3>Filter by Name:</h3>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Enter keyword...">
                    </div>
                </div>
                <!-- END FILTER BY NAME -->
                <!-- START FILTER BY CONDITION -->
                <div class="condition-filter">
                    <h3>Filter by Condition:</h3>
                    <label><input type="radio" name="condition" value="new"> New</label>
                    <label><input type="radio" name="condition" value="used"> Used</label>
                </div>
                <!--END FILTER BY CONDITION -->
            </div>
            <div class="button-container">
                <button type="button" class="apply-filter-btn">Apply Filter</button>
                <button type="button" class="reset-filter-btn">Reset Filter</button>
            </div>
        </div>
        <hr />
        <div class="result-row">
            <div class="result-container">
                @foreach ($products as $product)
                    <x-product-card :product=$product />
                @endforeach
            </div>
            <div id="pagination">
                {{ $products->links() }}
            </div>
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
@endsection

@section('js')
    <script src="{{ asset('js/category_page.js') }}"></script>
@endsection
