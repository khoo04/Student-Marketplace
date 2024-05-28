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
            <p><span class="bold">Name: </span> Khoo Zhen Xian</p>
            <p><span class="bold">Phone Number: </span> 60196043388</p>
            <p class="bold">Shipping Address</p>
            <select name="address" title="Shipping Address">
                <option value="address_id">9A, Jalan Ang Seng 3, Brickfields, 50470 Kuala Lumpur, Wilayah
                    Persekutuan Kuala Lumpur</option>
                <option value="address_id">9A, Jalan Ang Seng 3, Brickfields, 50470 Kuala Lumpur, Wilayah
                    Persekutuan Kuala Lumpur</option>
                <option value="address_id">9A, Jalan Ang Seng 3, Brickfields, 50470 Kuala Lumpur, Wilayah
                    Persekutuan Kuala Lumpur</option>
                <option value="address_id">9A, Jalan Ang Seng 3, Brickfields, 50470 Kuala Lumpur, Wilayah
                    Persekutuan Kuala Lumpur</option>
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
                <tr>
                    <td><img src="images/demo.png" class="product-image"></td>
                    <td>
                        <p class="product-name center">Dummy Product Name Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Atque nobis magni natus quam culpa nostrum dicta vel deserunt quis neque cumque, dolorem
                            dolores asperiores nisi tempora fugit cum omnis. Nulla! Lorem ipsum dolor sit amet consectetur
                            adipisicing elit. Eveniet repudiandae amet praesentium autem quis perspiciatis fugiat ratione,
                            nostrum cum nulla. Facilis in esse iste harum quibusdam non necessitatibus inventore eius. Lorem
                            ipsum dolor sit amet, consectetur adipisicing elit. Quam velit excepturi molestiae tempore cum
                            harum assumenda sapiente ut ipsa accusantium ad totam veniam odio perspiciatis doloremque
                            officia minus, maiores aperiam?</p>
                    </td>
                    <td>
                        <p class="center">1</p>
                    </td>
                    <td>
                        <p class="center">RM 15.00</p>
                    </td>
                    <td>
                        <p class="center">RM 15.00</p>
                    </td>
                </tr>
                <tr>
                    <td><img src="images/demo.png" class="product-image"></td>
                    <td>
                        <p class="product-name center">Dummy Product Name 2</p>
                    </td>
                    <td>
                        <p class="center">2</p>
                    </td>
                    <td>
                        <p class="center">RM 10.00</p>
                    </td>
                    <td>
                        <p class="center">RM 20.00</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr />
        <div class="total-details">
            <p class="grand-total-label">Grand Total</p>
            <p class="grand-total">RM 35.00</p>
        </div>
        <div class="action-section">
            <form>
                <button type="submit" class="button secondary">Cancel Order</button>
            </form>
            <form>
                <button type="submit" class="button primary">Checkout</button>
            </form>
        </div>
    </div>
@endsection
