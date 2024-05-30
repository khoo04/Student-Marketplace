<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\ShippingAddress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buyer = User::create([
            'first_name' => "Dummy",
            'last_name' => "Buyer",
            'email' => 'buyer@gmail.com',
            'phone_num' => '012-234 3232',
            'password' => bcrypt('buyer12345'),
            'approve_status' => 'approved',
            'types' => 'buyer',
        ]);

        $seller = User::create([
            'first_name' => "Dummy",
            'last_name' => "Seller",
            'email' => 'seller@gmail.com',
            'phone_num' => '012-234 3233',
            'password' => bcrypt('seller12345'),
            'approve_status' => 'approved',
            'types' => 'seller',
        ]);

        $product_1 = Product::create([
            'name' => "Product Dummy 1",
            'description' => "Product Dummy Description 1",
            'quantity_available' => 100,
            'price' => 50.0,
            'rating' => 3.5,
            'condition' => 'new',
            'images' => null,
            'category_id' => 1,
            'approve_status' => 'approved',
            'user_id' => $seller->id,
        ]);

        $product_2 = Product::create([
            'name' => "Product Dummy 2",
            'description' => "Product Dummy Description 2",
            'quantity_available' => 50,
            'price' => 50.0,
            'rating' => 0,
            'condition' => 'used',
            'images' => null,
            'category_id' => 2,
            'approve_status' => 'approved',
            'user_id' => $seller->id,
        ]);

        $product_3 = Product::create([
            'name' => "Product Dummy 3",
            'description' => "The Product Dummy does not have quantity",
            'quantity_available' => 0,
            'price' => 1.0,
            'rating' => 5,
            'condition' => 'new',
            'images' => null,
            'category_id' => 2,
            'approve_status' => 'approved',
            'user_id' => $seller->id,
        ]);

        $product_4 = Product::create([
            'name' => "Product Dummy 4",
            'description' => "The Product have only 1 quantity for testing",
            'quantity_available' => 1,
            'price' => 100.0,
            'rating' => 3,
            'condition' => 'new',
            'images' => null,
            'category_id' => 5,
            'approve_status' => 'approved',
            'user_id' => $seller->id,
        ]);

        $product_5 = Product::create([
            'name' => "Product Dummy 5",
            'description' => "Product Dummy Description 5",
            'quantity_available' => 100,
            'price' => 50.0,
            'rating' => 2,
            'condition' => 'used',
            'images' => null,
            'category_id' => 3,
            'approve_status' => 'approved',
            'user_id' => $seller->id,
        ]);

        $address = ShippingAddress::create([
            'address_line_1' => "NO JALAN FAKE",
            'address_line_2' => "TAMAN FAKE",
            'city' => 'FAKE CITY',
            'state' => 'FAKE STATE',
            'zip_code' => '12345',
            'default' => true,
            'user_id' => $buyer->id,
        ]);

        $address2 = ShippingAddress::create([
            'address_line_1' => "NO JALAN FAKE 2",
            'address_line_2' => "TAMAN FAKE 2",
            'city' => 'FAKE CITY 2',
            'state' => 'FAKE STATE 2',
            'zip_code' => '12345',
            'user_id' => $buyer->id,
        ]);


        Comment::create([
            'description' => "FAKE DESCRIPTION",
            'rating' => 3,
            'product_id' => $product_1->id,
            'user_id' => $buyer->id,
        ]);

        Comment::create([
            'description' => "FAKE DESCRIPTION",
            'rating' => 1,
            'product_id' => $product_2->id,
            'user_id' => $buyer->id,
        ]);

        $cart = Cart::create([
            'user_id' => $buyer->id,
        ]);


        //Get Buyer Cart
        //Create If Does Not Exists
        $buyer->cart()->create();

        $cart = $buyer->cart;
        //Attach Product to Buyer Cart
        $cart->products()->attach($product_4->id,["quantity" => 5]);
        $cart->products()->attach($product_2->id,["quantity" => 3]);

        //Example Make Order 
        $buyer_order = $buyer->orders()->create();

        $buyer->orders[0]->products()->attach($product_3->id,["quantity" => 5]);
        $buyer->orders[0]->products()->attach($product_5->id,["quantity" => 2]);


        Shipment::create([
            'status' => 'pending',
            'address_id' => $address->id,
            'user_id' => $buyer->id,
            'order_id' => $buyer_order->id,
        ]);

        Payment::create([
            'total_payment' => 100.20,
            'order_id' => $buyer_order->id,
            'user_id' => $buyer->id,
        ]);

    }
}
