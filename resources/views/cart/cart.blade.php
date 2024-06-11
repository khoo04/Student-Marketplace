@extends('components.layout')

@section('head')
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        .cart-items {
            list-style-type: none;
            padding: 0;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .cart-item img {
            width: 150px;
            height: 150px;
            margin-right: 20px;
            border-radius: 5px;
        }

        .cart-item div {
            flex-grow: 1;
        }

        .cart-total {
            margin-top: 20px;
            text-align: right;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-remove {
            background-color: #ff4d4d;
            float: right;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .total {
            font-size: 18px;
            margin: 10px 0;
        }

        .total::before {
            content: "Total: $";
            font-weight: bold;
        }
    </style>
@endsection

@section('title')
    <title>Shopping Cart</title>
@endsection

@section('content')
    <div class="container">
        <h2>Your Shopping Cart</h2>
        <ul class="cart-items" id="cart-items">
            @foreach ($cartItems as $item)
                <li class="cart-item">
                    <!-- Cart item HTML structure -->
                    <img src="{{ $item->image }}" alt="{{ $item->name }}">
                    <div>
                        <h3>{{ $item->name }}</h3>
                        <p>{{ $item->description }}</p>
                        <p>${{ $item->price }} x <span id="quantity{{ $item->id }}">{{ $item->quantity }}</span></p>
                        <p>Total: ${{ $item->price * $item->quantity }}</p>
                        <button class="btn" onclick="increaseQuantity({{ $item->id }})">+</button>
                        <button class="btn" onclick="decreaseQuantity({{ $item->id }})">-</button>
                        <button class="btn" onclick="checkout({{ $item->id }})">Checkout</button>
                        <button class="btn btn-remove" onclick="promptRemoveItem({{ $item->id }})">Remove</button>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="cart-total" id="cart-total">
            <p id="total">Total: ${{ $total }}</p>
        </div>
    </div>
@endsection

@section('js')
<script>
    function increaseQuantity(id) {
        // Make an AJAX request to increase the quantity of the cart item
        fetch(`/cart/${id}/increase`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                // If the request is successful, reload the page to update the cart
                location.reload();
            } else {
                // Handle errors
                console.error('Error increasing quantity');
            }
        }).catch(error => {
            console.error('Error increasing quantity:', error);
        });
    }

    function decreaseQuantity(id) {
        // Make an AJAX request to decrease the quantity of the cart item
        fetch(`/cart/${id}/decrease`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                // If the request is successful, reload the page to update the cart
                location.reload();
            } else {
                // Handle errors
                console.error('Error decreasing quantity');
            }
        }).catch(error => {
            console.error('Error decreasing quantity:', error);
        });
    }

    function removeItem(id) {
        // Make an AJAX request to remove the cart item
        fetch(`/cart/${id}/remove`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                // If the request is successful, reload the page to update the cart
                location.reload();
            } else {
                // Handle errors
                console.error('Error removing item');
            }
        }).catch(error => {
            console.error('Error removing item:', error);
        });
    }

    function checkout(id) {
        // Make an AJAX request to checkout the cart
        fetch(`/cart/checkout`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                // If the request is successful, redirect to the thank you page
                window.location.href = '{{ route("thank-you") }}';
            } else {
                // Handle errors
                console.error('Error checking out');
            }
        }).catch(error => {
            console.error('Error checking out:', error);
        });
    }
</script>
@endsection

{{-- //this is where you want to add an item to cart page --}}
{{-- <form action="{{ route('cart.add') }}" method="post">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="quantity" value="1"> <!-- Default quantity, can be adjusted -->
    <button type="submit">Add to Cart</button>
</form> --}}

