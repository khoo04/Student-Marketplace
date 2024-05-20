@extends('components.layout')

@section('title')
    <title>Student Marketplace | Search</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/search_page.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="filter-column">
        <h2 class="filter-title"><i class="fa fa-filter"></i> Filters</h2>
        <hr />
        <!-- BEGIN FILTER BY CATEGORY -->
        <h4>By category:</h4>
        <div class="checkbox">
            <label><input type="checkbox" class="icheck"> Application</label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" class="icheck"> Design</label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" class="icheck"> Desktop</label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" class="icheck"> Management</label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" class="icheck"> Mobile</label>
        </div>
        <!-- END FILTER BY CATEGORY -->

        <!-- BEGIN FILTER BY PRICE -->
        <h4>By Price:</h4>
        <p>Between <span class="filter-price">$300</span> to <span class="filter-price">$800</span></p>
        <div class="price-filter">
            <input type="number" placeholder="Lower Value" class="price-input-box">
            <input type="number" placeholder="Highest Value" class="price-input-box">
        </div>
        <!-- END FILTER BY PRICE -->
        <div>
            <button class="apply-filter-btn">Apply Filter</button>
        </div>
    </div>
    <!-- END FILTERS -->
    <!-- BEGIN SEARCH RESULT -->
    <div class="search-column">
        <!-- BEGIN RESULT -->
        <div class="search-result">
            <h2 class="search-title">Search Result Of : keyword </h2>
            <hr>
            <!-- BEGIN SEARCH INPUT -->
            <div class="input-box">
                <input type="text" class="input-field" value="Keyword" placeholder="Search something...">
                <span class="search-btn">
                    <button title="search button" type="button"><i class="fa fa-search"></i></button>
                </span>
            </div>
            <!-- END SEARCH INPUT -->

            <!-- BEGIN RESULT -->
            <div class="result-container">
                <div class="result-card">
                    <img src="images/demo.png" class="product-image" alt="demo">
                    <div class="product-details">
                        <h3 class="name">Product Name</h3>
                        <p class=category>Category</p>
                        <p class="description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad et
                            velit, anim Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus alias
                            saepe dolorum voluptas exercitationem a, nostrum ex voluptatem voluptatum. Cum
                            voluptas tempore quaerat corrupti repellendus pariatur, consequatur modi cumque
                            aperiam.i, error corrupti assumenda commodi consectetur numquam ipsam, earum rerum
                            nesciunt non vitae a ipsum amet ullam aspernatur quam?</p>
                    </div>
                    <div class="product-ratings" data-product-id>
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                    </div>
                    <p class="price">RM100</p>
                    <div class="view-button">
                        <a href="product.html">View More</a>
                    </div>
                    <a href="product.html" class="tap-card" alt="">
                    </a>
                </div>
                <div class="result-card">
                    <img src="images/demo.png" class="product-image" alt="demo">
                    <div class="product-details">
                        <h3 class="name">Product Name</h3>
                        <p class=category>Men's Fashion</p>
                        <p class="description">description</p>
                    </div>
                    <div class="product-ratings" data-product-id>
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                    </div>
                    <p class="price">RM100</p>
                    <div class="view-button">
                        <a href="product.html">View More</a>
                    </div>
                    <a href="product.html" class="tap-card" alt="">
                    </a>
                </div>
                <div class="result-card">
                    <img src="images/demo.png" class="product-image" alt="demo">
                    <div class="product-details">
                        <h3 class="name">Product Name</h3>
                        <p class=category>Stationary</p>
                        <p class="description">description</p>
                    </div>
                    <div class="product-ratings" data-product-id>
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                    </div>
                    <p class="price">RM100</p>
                    <div class="view-button">
                        <a href="product.html">View More</a>
                    </div>
                    <a href="product.html" class="tap-card" alt="">
                    </a>
                </div>
                <div class="result-card">
                    <img src="images/demo.png" class="product-image" alt="demo">
                    <div class="product-details">
                        <h3 class="name">Product Name</h3>
                        <p class=category>Men's Fashion</p>
                        <p class="description">description</p>
                    </div>
                    <div class="product-ratings" data-product-id>
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                    </div>
                    <p class="price">RM100</p>
                    <div class="view-button">
                        <a href="product.html">View More</a>
                    </div>
        
                </div>
                </div>
            </div>
            <!-- END TABLE RESULT -->

            <!-- BEGIN PAGINATION -->
            <!-- TODO: ADD PAGINATION-->
            <!-- END PAGINATION -->
        </div>
        <!-- END RESULT -->
    </div>
</div>
<a href="cart.html" id="cart-button">
    <i class="fa-solid fa-cart-shopping"></i>
    <h2>My Cart</h2>
</a>
@endsection
