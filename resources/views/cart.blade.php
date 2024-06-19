@extends('components.layout')

@include('components.flash-message')
@section('content')
    <div class="container">
        <h2>Your Shopping Cart</h2>
        <ul class="cart-items" id="cart-items">
        </ul>
        <div id="cart-total" class="cart-total"></div>
    </div>

    <form method="post" action="{{ route('order.store') }}" id="checkoutForm">
        @csrf
        <input type="hidden" name="product_id" value="">
        <input type="hidden" name="quantity" value="">
    </form>
@endsection

@section('js')
    <script>
        const cartItems = @json($arrayItems);
        const cartList = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');

        function renderCart() {
            cartList.innerHTML = '';
            let total = 0;

            if (cartItems.length == 0) {
                const li = document.createElement('li');
                li.innerHTML = `
                <div>
                    <p style="text-align:center; color: var(--clr-secondary-600)"> No Items Found </p>
                </div>
                `;
                cartList.appendChild(li);
            } else {
                cartItems.forEach(item => {
                    const itemTotal = item.price * item.order_quantity;
                    total += itemTotal;
                    const li = document.createElement('li');
                    li.classList.add('cart-item');
                    li.innerHTML = `
            <img src="${item.images[0]}" alt="${item.name}">
            <div>
                <h3>${item.name}</h3>
                <p class="price">RM ${item.price}</p>
                <p class="stock-info">Stock left: <span id="stock${item.id}" class="stock">${Number(item.stock) - Number(item.order_quantity)}</span></p>

                <div class="quantity-control">
                    <button class="btn btn-sm" onclick="decreaseQuantity(${item.id})">-</button>
                    <span id="quantity${item.id}" class="quantity">${item.order_quantity}</span>
                    <button class="btn btn-sm" onclick="increaseQuantity(${item.id})">+</button>
                </div>
                <h4 class="item-total"><b>Total: RM ${itemTotal}</b></h4>
                <div class="button-group">
                    <button class="btn btn-checkout" onclick="checkout(${item.id})">Checkout</button>
                    <button class="btn btn-remove" data-pid=${item.id} onclick="removeItem(${item.id})">Remove</button>
                </div>
            </div>
        `;
                    cartList.appendChild(li);
                });
            }
        }



        function increaseQuantity(id) {
            const selectedItem = cartItems.find(item => item.id === id);
            if (selectedItem.order_quantity < selectedItem.stock) {
                selectedItem.order_quantity++; // Update order quantity
                document.getElementById(`quantity${id}`).textContent = selectedItem.order_quantity;
                document.getElementById(`stock${id}`).textContent = selectedItem.stock - selectedItem.order_quantity;
                renderCart();
                $.ajax({
                    type: "POST",
                    url: "{{ route('cart.updateQuantity') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        productID: selectedItem.id,
                        quantity: selectedItem.order_quantity,
                    },
                    success: function(response) {
                        if (response.status == 'failed') {
                            alert(response.message);
                        }
                    }
                });
            } else {
                alert('Not enough stock available');
            }
        }

        function decreaseQuantity(id) {
            const selectedItem = cartItems.find(item => item.id === id);
            if (selectedItem.order_quantity > 1) {
                selectedItem.order_quantity--; // Update order quantity
                document.getElementById(`quantity${id}`).textContent = selectedItem.order_quantity;
                document.getElementById(`stock${id}`).textContent = selectedItem.stock - selectedItem.order_quantity;
                renderCart();
                $.ajax({
                    type: "POST",
                    url: "{{ route('cart.updateQuantity') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        productID: selectedItem.id,
                        quantity: selectedItem.order_quantity,
                    },
                    success: function(response) {
                        if (response.status == 'failed') {
                            alert(response.message);
                        }
                    }
                });
            }
        }

        function removeItem(id) {
            let productID = id;

            if (confirm('Are you sure you want to remove this item from your cart?')) {
                $.ajax({
                    url: "{{ route('cart.destroy') }}",
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                        productID: productID,
                    },
                    success: function(response) {
                        console.log('Item deleted successfully');
                        $(`.btn-remove[data-pid=${productID}]`).closest('.cart-item').remove();
                    },
                    error: function(xhr) {
                        console.error('Error deleting item:', xhr.responseText);
                    }
                });
            }
        }

        function checkout(id) {
            const selectedItem = cartItems.find(item => item.id === id);
            $("#checkoutForm input[name=product_id]").val(selectedItem.id);
            $("#checkoutForm input[name=quantity]").val(selectedItem.order_quantity);
            $('#checkoutForm').submit();
        }

        renderCart();
    </script>
@endsection

@section('head')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .cart-items {
            list-style-type: none;
            padding: 0;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background-color: #f9f9f9;
        }

        .cart-item img {
            width: 150px;
            height: 150px;
            margin-right: 20px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .cart-item img:hover {
            transform: scale(1.05);
        }

        .cart-item div {
            flex-grow: 1;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .quantity-control .btn {
            margin: 0 5px;
        }

        .quantity {
            display: inline-block;
            min-width: 30px;
            text-align: center;
        }

        .btn {
            background-color: var(--clr-primary);
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-sm {
            padding: 5px 10px;
        }

        .btn-remove {
            background-color: var(--danger);
            float: right;
        }

        .btn-checkout {
            background-color: var(--success);
            float: right;
        }

        .btn:hover {
            background-color: var(--clr-primary-dark);
            transform: scale(1.05);
        }

        .btn-remove:hover {
            background-color: var(--danger_hover);
            transform: scale(1.05);
        }

        .btn-checkout:hover {
            background-color: var(--success_hover);
            transform: scale(1.05);
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-control .btn {
            padding: 5px 10px;
        }

        .quantity-control span {
            margin: 0 10px;
        }

        .price {
            font-size: 1.2em;
            margin-top: 15px;
            color: #000;
        }

        .stock-info {
            margin-top: 15px;
            font-size: 0.9em;
            color: #777;
        }

        .item-total {
            font-size: 1.1em;
            color: #000;
            margin-top: 15px;
        }

        .cart-total {
            margin-top: 20px;
            text-align: right;
        }
    </style>
@endsection
