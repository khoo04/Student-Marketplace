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
    public function view(){
        return redirect()->route('profile')->with(['pageIndex' => 2]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $full_name = $user->first_name . ' ' . $user->last_name;
        $email = $user->email;
        $product_id = $request->product_id;
        $quantity = $request->quantity;


        if ($user->types != 'buyer') {
            return back()->with(['message' => 'Only buyer can perform this action.', 'type' => 'alert']);
        }

        $stocks = Product::find($product_id)->quantity_available;

        if ($stocks <= 0) {
            return back()->with(['message' => 'The product is out of stock!', 'type' => 'alert']);
        }
        
        //Check user have address or not before order
        if (count($user->addresses) == 0){
            return redirect()->route('profile')->with(['message' => 'Please add at least one address before buying', 'type' => 'alert', 'pageIndex' => 1]);
        }

        //Check the product status 
        $product_status = Product::find($product_id)->approve_status;
        if ($product_status == "pending"){
            return back()->with(['message' => 'This product is pending approval.', 'type' => 'alert']);
        }
        else if ($product_status == "rejected"){
            return back()->with(['message' => 'This product is rejected', 'type' => 'alert']);
        }
        $order = $user->orders()->create(['product_id' => $product_id, 'quantity' => $quantity]);

        $product_price = Product::find($product_id)->price;

        $price_total = ($product_price) * ($quantity);

        return view('order', compact('user', 'full_name', 'email', 'order', 'price_total'));
    }

    public function updateStatus(Request $request)
    {
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

    public function updateComment(Request $request)
    {
        $orderID = $request->input('orderID');
        $comment = $request->input('comment');

        if ($orderID == null ||  $comment == null){
            return redirect()->route('profile')->with(['message' => 'All field must be filled', 'type' => 'alert', 'pageIndex' => 2]);
        }

        $validatedRequest = $request->validate([
            'orderID' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'required|string',
        ]);

        $order = Order::find($validatedRequest['orderID']);
        if ($order) {
            $product = $order->product;
            $user = auth()->user();

            $product->comments()->create([
                'description' => $validatedRequest['comment'],
                'rating' => $validatedRequest['rating'],
                'user_id' => $user->id,
            ]);
            $order->comment_status = true;
            $order->save();

            $comments = $product->comments;
            $totalRating = $comments->sum('rating');
            $commentCount = $comments->count();
            $averageRating = $commentCount > 0 ? $totalRating / $commentCount : 0;

            // Update the product's average rating
            $product->rating = $averageRating;
            $product->save();
            
            return redirect()->route('profile')->with(['message' => 'Comment added successfully.', 'type' => 'success', 'pageIndex' => 2]);
        }
        return redirect()->route('profile')->with(['message' => 'Action failed.', 'type' => 'alert', 'pageIndex' => 2]);
    }

    public function receiveOrder(Request $request)
    {
        //For buyer page
        $request->validate([
            'order_id' => 'required',
        ]);

        $order = Order::find($request->order_id);

        if ($order && $order->user_id == auth()->user()->id) {
            $order->order_status = 'completed';
            $order->save();
            return redirect()->route('profile')->with(['message' => 'Order received.', 'type' => 'success', 'pageIndex' => 2]);
        }
        return redirect()->route('profile')->with(['message' => 'Failed action.', 'type' => 'alert', 'pageIndex' => 2]);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        $order = Order::find($request->Oid);

        if ($user->id != $order->buyer->id) {
            return abort(403, "Unauthorized Action");
        }

        $order->delete();
        return redirect()->route('main')->with(['message' => 'Order canceled successfully', 'type' => 'success']);
    }
}
