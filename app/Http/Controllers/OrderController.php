<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function store(Request $request){
        $user = Auth::user();
        $full_name = $user->first_name . ' ' . $user->last_name;
        $email = $user->email;
        $product_id = $request->product_id;
        $quantity = $request->quantity;


        if ($user->types != 'buyer'){
            return back()->with(['message' => 'Only buyer can perform this action.', 'type' => 'alert']);
        }

        $stocks = Product::find($product_id)->quantity_available;

        if ($stocks <= 0){
            return back()->with(['message' => 'The product is out of stock!', 'type' => 'alert']);
        }

        $order = $user->orders()->create(['product_id' => $product_id, 'quantity' => $quantity]);
        
        $product_price = Product::find($product_id)->price;

        $price_total = ($product_price) * ($quantity);

        return view('order',compact('user','full_name','email','order','price_total'));
    }

    public function updateStatus(Request $request){
        $request->validate([
            'oID' => 'required',
            'tracking_num' => 'nullable|string|max:255',
        ]);

 
        $order = Order::find($request->oID);
        $currentDate = Carbon::now();
        $tracking_num = $request->tracking_num ?? null;

        $order->update([
            'order_status' => 'shipping',
            'tracking_num' => $tracking_num,
            'ship_out_date' => $currentDate,
        ]);

        return redirect()->route('profile')->with(['message' => 'Shipping status updated successfully.', 'type' => 'success', 'pageIndex' => 2]);
    }

    public function destroy(Request $request){
        $user = Auth::user();

        $order = Order::find($request->Oid);

        if ($user->id != $order->buyer->id){
            return abort(403,"Unauthorized Action");
        }

        $order->delete();
        return redirect()->route('main')->with(['message' =>'Order canceled successfully', 'type' => 'success']);
    }
}
