@props(['product'])
<div class="result-card">
    <img src="images/demo.png" class="product-image" alt="demo">
    <div class="product-details">
        <h3 class="name">{{$product->name}}</h3>
        <p class=category>Category: {{$product->category->name}}</p>
        <p class="description">{{$product->description}}</p>
    </div>
    <div class="product-ratings" data-product-rating="{{$product->rating}}">
        <div class="stars-outer">
            <div class="stars-inner"></div>
        </div>
    </div>
    <p class="price">RM {{$product->price}}</p>
    <div class="view-button">
        <a href="/products/{{$product->id}}">View More</a>
    </div>
    <a href="/products/{{$product->id}}" class="tap-card" alt="">
    </a>
</div>