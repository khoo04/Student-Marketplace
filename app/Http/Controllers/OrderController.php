<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request){
        $user = Auth::user();
        $product_id = $request->product_id;
        
        if ($user->types != 'buyer'){
            return back()->with('message', 'Only buyer can perform this action.');
        }

        $stocks = Product::find($product_id)->quantity_available;

        if ($stocks <= 0){
            return back()->with('message','The product is out of stock!');
        }

        $order = $user->orders()->create();

        $order->products()->attach($product_id,["quantity" => 1]);

        return view('');
    }
}
