@extends('components.layout')

@section('title')
<title>Student Marketplace | {{$product->name}}</title>
@endsection

@section('styles')
    <script>
        const rating_product = {{$product->rating}};
    </script>
    <link rel="stylesheet" href="{{asset('css/product.css') }}">
    <script src="{{asset('js/product.js') }}" defer></script>
@endsection

@section('content')
    <div id="product-details">
        <div id="carousel" data-carousel>
            <button class="carousel-button prev" data-carousel-button="prev">&#60;</button>
            <button class="carousel-button next" data-carousel-button="next">&#62;</button>
            <ul data-slides>
                <li class="slide" data-active>
                    <img src="images/demo.png" alt="Image 1">
                </li>
                <li class="slide">
                    <img src="images/shoes.jpg" alt="Image 2">
                </li>
                <li class="slide">
                    <img src="images/glasses.jpg" alt="Image 3">
                </li>
            </ul>
        </div>

        <div id="details">
            <h1>{{$product->name}}</h1>
            <div class="rating">
                <div class="stars-outer">
                    <div class="stars-inner"></div>
                </div>
            </div>
            <p>Price : RM {{$product->price}}</p>
            <p>Quantity Available : {{$product->quantity_available}}</p>
            <div id="action-btn-container">
                <form method="post" action="">
                    <button type="submit" class="action-btn" id="buy-now">
                        <i class="fa-solid fa-money-bill-wave"></i> Buy Now
                    </button>
                </form>
                <form method="post" action="">
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
        <div class="contact-card">
            <ul>
                <li id="seller-name">
                    {{$seller->first_name . ' ' . $seller->last_name}}
                </li>
                <li><i class="fa-solid fa-phone"></i> Phone Number: {{$seller->phone_num}}</li>
                <li>
                    <i class="fa-solid fa-envelope"></i> Email: <a href="mailto:{{$seller->email}}"
                        title="Seller Contact Email">{{$seller->email}}</a>
                </li>
            </ul>
            <a aria-label="Chat on WhatsApp" href="https://wa.me/+6{{$seller->phone_num}}"><img alt="Chat on WhatsApp"
                    src="{{asset('images/WhatsAppButtonGreenLarge.svg')}}" />
            </a>
        </div>
    </div>

    <div class="section-container" id="description-section">
        <h1>Description</h1>
        <p><b>Category:</b> {{$product->category->name}}</p>
        <p>{{$product->description}}</p>
    </div>

    <div class="section-container" id="comments-section">
        <h1>Comments</h1>
        <div class="comment-card">
            <h3>Username</h3>
            <div class="rating">
                <div class="stars-outer">
                    <div class="stars-inner"></div>
                </div>
            </div>
            <p class="comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at tempor nunc, id aliquet
                turpis. Ut ac nulla sollicitudin, finibus diam vitae, porttitor tellus. Sed maximus orci non lectus porta,
                eleifend auctor mauris viverra. Etiam rutrum accumsan magna, rhoncus egestas risus pharetra sit amet.
                Aliquam sit amet tellus in nisl blandit pulvinar. Ut vehicula sodales velit, eu rutrum eros imperdiet sed.
                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam luctus,
                libero malesuada molestie interdum, erat leo pretium dolor, ut posuere nibh dolor nec ante. Aenean a ornare
                orci. Vivamus et lacus vel eros facilisis euismod.

                Suspendisse congue tortor ut nisi vehicula, non mollis est efficitur. Cras vel porttitor urna. Lorem ipsum
                dolor sit amet, consectetur adipiscing elit. Praesent rutrum egestas semper. In hac habitasse platea
                dictumst. Phasellus rhoncus augue purus, nec bibendum arcu dapibus ac. Pellentesque rutrum, tortor vel
                fringilla vulputate, massa felis finibus lacus, et viverra lorem urna sit amet sapien. Donec aliquet libero
                vel enim congue suscipit.</p>
            <p class="date">
                22/3/2024
            </p>
        </div>

        <div class="comment-card">
            <h3>Username</h3>
            <div class="rating">
                <div class="stars-outer">
                    <div class="stars-inner"></div>
                </div>
            </div>
            <p class="comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at tempor nunc, id aliquet
                turpis. Ut ac nulla sollicitudin, finibus diam vitae, porttitor tellus. Sed maximus orci non lectus porta,
                eleifend auctor mauris viverra. Etiam rutrum accumsan magna, rhoncus egestas risus pharetra sit amet.
                Aliquam sit amet tellus in nisl blandit pulvinar. Ut vehicula sodales velit, eu rutrum eros imperdiet sed.
                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam luctus,
                libero malesuada molestie interdum, erat leo pretium dolor, ut posuere nibh dolor nec ante. Aenean a ornare
                orci. Vivamus et lacus vel eros facilisis euismod.

                Suspendisse congue tortor ut nisi vehicula, non mollis est efficitur. Cras vel porttitor urna. Lorem ipsum
                dolor sit amet, consectetur adipiscing elit. Praesent rutrum egestas semper. In hac habitasse platea
                dictumst. Phasellus rhoncus augue purus, nec bibendum arcu dapibus ac. Pellentesque rutrum, tortor vel
                fringilla vulputate, massa felis finibus lacus, et viverra lorem urna sit amet sapien. Donec aliquet libero
                vel enim congue suscipit.</p>
            <p class="date">
                22/3/2024
            </p>
        </div>

        <div class="comment-card">
            <h3>Username</h3>
            <div class="rating">
                <div class="stars-outer">
                    <div class="stars-inner"></div>
                </div>
            </div>
            <p class="comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at tempor nunc, id aliquet
                turpis. Ut ac nulla sollicitudin, finibus diam vitae, porttitor tellus. Sed maximus orci non lectus porta,
                eleifend auctor mauris viverra. Etiam rutrum accumsan magna, rhoncus egestas risus pharetra sit amet.
                Aliquam sit amet tellus in nisl blandit pulvinar. Ut vehicula sodales velit, eu rutrum eros imperdiet sed.
                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam luctus,
                libero malesuada molestie interdum, erat leo pretium dolor, ut posuere nibh dolor nec ante. Aenean a ornare
                orci. Vivamus et lacus vel eros facilisis euismod.

                Suspendisse congue tortor ut nisi vehicula, non mollis est efficitur. Cras vel porttitor urna. Lorem ipsum
                dolor sit amet, consectetur adipiscing elit. Praesent rutrum egestas semper. In hac habitasse platea
                dictumst. Phasellus rhoncus augue purus, nec bibendum arcu dapibus ac. Pellentesque rutrum, tortor vel
                fringilla vulputate, massa felis finibus lacus, et viverra lorem urna sit amet sapien. Donec aliquet libero
                vel enim congue suscipit.</p>
            <p class="date">
                22/3/2024
            </p>
        </div>
    </div>

    <a href="cart.html" id="cart-button">
        <i class="fa-solid fa-cart-shopping"></i>
        <h2>My Cart</h2>
    </a>
@endsection

