@extends('components.layout')

@section('title')
    <title>Student Marketplace | {{ $product->name }}</title>
@endsection

@section('head')
    <script>
        const rating_product = {{ $product->rating }};
    </script>
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <script src="{{ asset('js/product.js') }}" defer></script>
@endsection

@section('content')
    @include('components.flash-message')

    @php
        if ($product->images == null) {
            $imagePaths = [];
        } else {
            $imagePaths = explode(',', $product->images);
        }
    @endphp
    <div id="product-details">
        <div id="carousel" data-carousel>
            @if (count($imagePaths) > 1)
                <button class="carousel-button prev" data-carousel-button="prev">&#60;</button>
                <button class="carousel-button next" data-carousel-button="next">&#62;</button>
                <ul data-slides>
                    @for ($i = 0; $i < count($imagePaths); $i++)
                        @if ($i == 0)
                            <li class="slide" data-active>
                                <img src="{{ asset('storage/' . $imagePaths[$i]) }}" alt="Image {{ $i + 1 }}">
                            </li>
                        @else
                            <li class="slide">
                                <img src="{{ asset('storage/' . $imagePaths[$i]) }}" alt="Image {{ $i + 1 }}">
                            </li>
                        @endif
                    @endfor
                </ul>
            @else
                <ul data-slides>
                    <li class="slide" data-active>
                        <img src=" {{ $imagePaths == [] ? asset('images/No-Image-Placeholder.svg') : asset('storage/' . $imagePaths[0]) }}"
                            alt="Image 1">
                    </li>
                </ul>
            @endif
        </div>

        <div id="details">
            <h1>{{ $product->name }}</h1>
            <div class="rating">
                <div class="stars-outer">
                    <div class="stars-inner" style="width: {{ round((($product->rating / 5) * 100) / 10) * 10 }}%"></div>
                </div>
            </div>
            <p><b>Price : </b> RM {{ $product->price }}</p>
            <p><b> Quantity Available : </b> {{ $product->quantity_available }}</p>
            <div id="action-btn-container">
                <form method="post" action="{{ route('order.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="action-btn" id="buy-now">
                        <i class="fa-solid fa-money-bill-wave"></i> Buy Now
                    </button>
                </form>
                <form method="post" action="{{route('cart.update')}}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="action-btn" id="add-to-cart">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!--Seller Contact Section-->
    <div class="section-container" id="contact-section">
        <h1>Contact Seller</h1>
        <hr>
        <div class="contact-card">
            <ul>
                <li id="seller-name">
                    {{ $seller->first_name . ' ' . $seller->last_name }}
                </li>
                <li><i class="fa-solid fa-phone"></i> Phone Number: {{ $seller->phone_num }}</li>
                <li>
                    <i class="fa-solid fa-envelope"></i> Email: <a href="mailto:{{ $seller->email }}"
                        title="Seller Contact Email">{{ $seller->email }}</a>
                </li>
            </ul>
            <a aria-label="Chat on WhatsApp" href="https://wa.me/+6{{ preg_replace('/\D+/', '',"012-234 3233") }}"><img alt="Chat on WhatsApp"
                    src="{{ asset('images/WhatsAppButtonGreenLarge.svg') }}" />
            </a>
        </div>
    </div>

    <div class="section-container" id="description-section">
        <h1>Description</h1>
        <hr>
        <p style="margin-bottom:1rem; font-size:1.25rem;"><b>Category:</b> {{ $product->category->name }}</p>
        <p>{{ $product->description }}</p>
    </div>

    <div class="section-container" id="comments-section">
        <h1>Comments</h1>
        <hr>
        @if ($comments->isNotEmpty())
            @foreach ($comments as $comment)
                <x-comment-card :comment=$comment />
            @endforeach
        @else
            <p style="text-align: center; padding: 1.5rem 0">No Comment Yet</p>
        @endif
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
