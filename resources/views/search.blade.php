@extends('components.layout')

@section('title')
    <title>Student Marketplace | Search</title>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/search_page.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="filter-column">
            <h2 class="filter-title"><i class="fa fa-filter"></i> Filters</h2>
            <hr />
            <!-- BEGIN FILTER BY CATEGORY -->
            <h4>By Category:</h4>
            @foreach ($categories as $category)
                <div class="checkbox">
                    <label><input type="radio" name="category" data-category-id="{{ $category->id }}">
                        {{ $category->name }}</label>
                </div>
            @endforeach

            <!-- END FILTER BY CATEGORY -->
            <!-- BEGIN FILTER BY CONDITION -->
            <h4>By Condition:</h4>
            <label class="condition-label"><input type="radio" name="condition" value="new"> New</label>
            <label class="condition-label"><input type="radio" name="condition" value="used"> Used</label>
            <!-- END FILTER BY CONDITION -->

            <!-- BEGIN FILTER BY PRICE -->
            <h4>By Price:</h4>
            <p>Between <span class="filter-price" id="lower-label">RM 0</span> to <span class="filter-price"
                    id="highest-label">RM <i class="fa-solid fa-infinity"></i></span></p>
            <div class="price-filter">
                <input type="text" placeholder="Lower Price" id="lower-price" class="price-input-box">
                <input type="text" placeholder="Highest Price" id="highest-price" class="price-input-box">
            </div>
            <!-- END FILTER BY PRICE -->

            <div>
                <button class="apply-filter-btn">Apply Filter</button>
                <button class="reset-filter-btn">Reset Filter</button>
            </div>

        </div>
        <!-- END FILTERS -->
        <!-- BEGIN SEARCH RESULT -->
        <div class="search-column">
            <!-- BEGIN RESULT -->
            <div class="search-result">
                <h2 class="search-title">Search Result Of : {{ $keyword }} </h2>
                <hr>
                <!-- BEGIN SEARCH INPUT -->
                <form action="/search" method="GET">
                    <div class="input-box">
                        <input type="text" class="input-field" name="keyword" value="{{ $keyword }}"
                            placeholder="Search something...">
                        <span class="search-btn">
                            <button title="search button" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
                <!-- END SEARCH INPUT -->

                <!-- BEGIN RESULT -->
                <div class="result-container">
                    @if ($results->isEmpty())
                        <p>No result found</p>
                    @else
                        @foreach ($results as $result)
                            <x-search-card :product=$result />
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- END TABLE RESULT -->

            <!-- BEGIN PAGINATION -->
            <div id="pagination">
                {{ $results->links() }}
            </div>
            <!-- END PAGINATION -->
        </div>
        <!-- END RESULT -->
    </div>
    </div>
    @if (auth()->user() != null)
        @if (auth()->user()->types == 'buyer')
            <a href="{{route('cart')}}" id="cart-button">
                <i class="fa-solid fa-cart-shopping"></i>
                <h2>My Cart</h2>
            </a>
        @endif
    @else
        <a href="{{route('cart')}}" id="cart-button">
            <i class="fa-solid fa-cart-shopping"></i>
            <h2>My Cart</h2>
        </a>
    @endif
@endsection

@section('js')
    <script>
        const keyword = "{{ $keyword }}"
    </script>
    <script src="{{ asset('js/search_page.js') }}"></script>
@endsection
