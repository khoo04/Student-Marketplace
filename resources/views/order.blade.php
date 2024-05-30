@extends('components.layout')

@section('title')
    <title> Student Marketplace | Order </title>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>Order Details</h1>
        <hr>
        <section class="customer-details">
            <h2>Customer Details</h2>
            <p><span class="bold">Name: </span> {{$full_name}}</p>
            <p><span class="bold">Phone Number: </span> {{$user->phone_num}}</p>
            <p class="bold">Shipping Address</p>
            <select name="address" title="Shipping Address">
                @foreach ($user->addresses as $address)
                @php
                    $full_address = $address->address_line_1 . ', ';
                    $full_address .= ($address->address_line_2 == null) ? '' : $address->address_line_2 . ', ';
                    $full_address .= $address->zip_code . ' ';
                    $full_address .= $address->city . ', ';
                    $full_address .= $address->state;
                @endphp
                @if ($address->default)
                <option value="{{$address->id}}" selected>{{$full_address}}</option>
                @else
                <option value="{{$address->id}}">{{$full_address}}</option>
                @endif
                @endforeach
            </select>
        </section>
        <hr />
        <table class="order-details">
            <thead>
                <tr>
                    <th style="width: 30%;">Image</th>
                    <th style="width: 20%;">Product Name</th>
                    <th style="width: 15%;">Quantity</th>
                    <th style="width: 15%;">Unit Price</th>
                    <th style="width: 20%;">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                @php
                    $images = explode(",",$product->images)
                @endphp
                <tr>
                    <td><img src="{{$images[0]}}" class="product-image"></td>
                    <td>
                        <p class="product-name center">{{$product->name}}</p>
                    </td>
                    <td>
                        <p class="center">{{$product->pivot->quantity}}</p>
                    </td>
                    <td>
                        <p class="center">RM {{$product->price}}</p>
                    </td>
                    <td>
                        <p class="center">RM {{$product->price * $product->pivot->quantity}}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr />
        <div class="total-details">
            <p class="grand-total-label">Grand Total</p>
            <p class="grand-total">RM {{$grand_total}}</p>
        </div>
        <div class="action-section">
            <form method="POST" action="{{route('order.delete')}}">
                @csrf
                @method('delete')
                <input type="hidden" value="{{$order->id}}" name="Oid">
                <button type="submit" class="button secondary">Cancel Order</button>
            </form>
            <form method="POST" action="{{route('payment.create')}}">
                @csrf
                <input type="hidden" name="name" value="{{$full_name}}">
                <input type="hidden" name="email" value="{{$email}}">
                <input type="hidden" name="amount" value="{{$grand_total}}">
                <input type="hidden" name="Oid" value="{{$order->id}}">
                <button type="submit" class="button primary">Checkout</button>
            </form>
        </div>
    </div>
@endsection
