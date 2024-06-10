@props(['product'])
<div class="result-card">
    @php
    if($product->images == null){
        $imagePaths = null;
    }else{
        $imagePaths = explode(',',$product->images);
    }
    @endphp
    @if ($imagePaths != null)
    <img src="{{asset('storage/'. $imagePaths[0])}}" class="product-image" alt="Product Image">
    @else
    <img src="{{asset('images/No-Image-Placeholder.svg')}}" class="product-image" alt="No Image Available">
    @endif
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