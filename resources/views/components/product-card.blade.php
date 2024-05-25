@props(['product'])
<div class="card">
    <div class="image">
        <img src="{{$product->image ? asset("storage/". $product->image) : asset("images/demo.png")}}" alt="No Image Available">
    </div>
    <div class="card-body">
        <h1>{{$product->name}}</h1>
        <div class="rating" data-product-rating="{{$product->rating}}">
            <div class="stars-outer">
                <div class="stars-inner"></div>
            </div>
        </div>
        <p>Price : {{$product->price}}</p>
        <p>Quantity Available : {{$product->quantity_available}}</p>
    </div>
    <div class="hidden">
        <a href="/products/{{$product->id}}">View More</a>
    </div>
</div>