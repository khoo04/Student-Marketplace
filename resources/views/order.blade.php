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
            <p><span class="bold">Name: </span> {{ $full_name }}</p>
            <p><span class="bold">Phone Number: </span> {{ $user->phone_num }}</p>
            <p class="bold">Shipping Address</p>
            <select name="address" title="Shipping Address">
                @foreach ($user->addresses as $address)
                    @php
                        $full_address = $address->address_line_1 . ', ';
                        $full_address .= $address->address_line_2 == null ? '' : $address->address_line_2 . ', ';
                        $full_address .= $address->zip_code . ' ';
                        $full_address .= $address->city . ', ';
                        $full_address .= $address->state;
                    @endphp
                    @if ($address->default)
                        <option value="{{ $address->id }}" selected>{{ $full_address }}</option>
                    @else
                        <option value="{{ $address->id }}">{{ $full_address }}</option>
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
                @php
                    if ($order->product->images == null) {
                        $images = [];
                    } else {
                        $images = explode(',', $order->product->images);
                    }
                @endphp
                <tr>
                    <td>
                        @if ($images == [])
                            <img src="{{ asset('images/No-Image-Placeholder.svg') }}" class="product-image">
                        @else
                            <img src="{{ asset('storage/' . $images[0]) }}" class="product-image">
                        @endif
                    </td>
                    <td>
                        <p class="product-name center">{{ $order->product->name }}</p>
                    </td>
                    <td>
                        <p class="center">{{ $order->quantity }}</p>
                    </td>
                    <td>
                        <p class="center">RM {{ $order->product->price }}</p>
                    </td>
                    <td>
                        <p class="center">RM {{ number_format($price_total, 2, '.') }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr />
        <div class="total-details">
            @php
                $service_charge = 0.7;
                $grand_total = $price_total + $service_charge;
            @endphp
            <div class="price-section">
                <p class="small-title">Total Price</p>
                <p class="price">RM {{ number_format($price_total, 2, '.') }}</p>
            </div>
            <div class="price-section">
                <p class="small-title">Service Charge</p>
                <p class="price">RM {{ number_format($service_charge, 2, '.') }}</p>
            </div>
            <div class="price-section grand">
                <p class="grand-total-label">Grand Total</p>
                <p class="grand-total">RM {{ number_format($grand_total, 2, '.') }}</p>
            </div>
        </div>
        <div class="action-section">
            <form method="POST" action="{{ route('order.delete') }}">
                @csrf
                @method('delete')
                <input type="hidden" value="{{ $order->id }}" name="Oid">
                <button type="submit" class="button secondary">Cancel Order</button>
            </form>
            <form method="POST" action="{{ route('payments.create') }}" id="submit-form">
                @csrf
                <input type="hidden" name="name" value="{{ $full_name }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="amount" value="{{ $grand_total }}">
                <input type="hidden" name="addressID">
                <input type="hidden" name="Oid" value="{{ $order->id }}">
                <button type="submit" class="button primary">Checkout</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            addressID = $("select[name=address]").val();
            $("#submit-form input[name=addressID]").val(addressID);

            $("select[name=address]").change(function() {
                addressID = $(this).val();
                $("#submit-form input[name=addressID]").val(addressID);
            });
        });
    </script>
@endsection
