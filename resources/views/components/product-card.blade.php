@props(['product'])
<div class="card">
    <div class="image">
        @php
        if($product->images == null){
            $imagePaths = null;
        }else{
            $imagePaths = explode(',',$product->images);
        }
        @endphp
        @if ($imagePaths != null)
        <img src="{{asset('storage/'. $imagePaths[0])}}" alt="Product Image">
        @else
        <img src="{{asset('images/No-Image-Placeholder.svg')}}" alt="No Image Available">
        @endif
        
    </div>
    <div class="card-body">
        <h1>{{$product->name}}</h1>
        <div class="rating" data-product-rating="{{$product->rating}}">
            <div class="stars-outer">
                <div class="stars-inner"></div>
            </div>
        </div>
        <p>Price : RM {{$product->price}}</p>
        <p>Quantity Available : {{$product->quantity_available}}</p>
    </div>
    <div class="hidden">
        <a href="/products/{{$product->id}}">View More</a>
    </div>
</div>