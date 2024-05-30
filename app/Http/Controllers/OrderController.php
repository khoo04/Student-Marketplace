<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request){
        $user = Auth::user();
        $full_name = $user->first_name . ' ' . $user->last_name;
        $email = $user->email;
        $product_id = $request->product_id;

        if ($user->types != 'buyer'){
            return back()->with(['message' => 'Only buyer can perform this action.', 'type' => 'alert']);
        }

        $stocks = Product::find($product_id)->quantity_available;

        if ($stocks <= 0){
            return back()->with(['message' => 'The product is out of stock!', 'type' => 'alert']);
        }

        $order = $user->orders()->create();

        $order->products()->attach($product_id,["quantity" => 1]);

        $grand_total = 0;

        foreach($order->products as $product)
        {
            $grand_total += ($product->price) * ($product->pivot->quantity);
        }

        return view('order',compact('user','full_name','email','order','grand_total'));
    }

    public function destroy(Request $request){
        $user = Auth::user();

        $order = Order::find($request->Oid);

        if ($user->id != $order->buyer->id){
            return abort(403,"Unauthorized Action");
        }

        $order->products()->detach();
        $order->delete();
        return redirect()->route('main')->with(['message' =>'Order canceled successfully', 'type' => 'success']);
    }
}
