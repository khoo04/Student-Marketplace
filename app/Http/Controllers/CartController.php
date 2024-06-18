<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->cart == null) {
            $cart = $user->cart()->create();
        } else {
            $cart = $user->cart;
        }

        //Only show the approved product in cart
        //If user have add this item before but it turn to pending again due to update
        $cartItems = $cart->products()->where('approve_status','approved')->get(['id', 'name', 'price', 'quantity as order_quantity', 'quantity_available as stock', 'images']);

        $arrayItems = array();
        $arrayItems = [];

        foreach ($cartItems as $cartItem) {
            $itemDetails = [
                'id' => $cartItem->id,
                'name' => $cartItem->name,
                'price' => $cartItem->price,
                'stock' => (int) $cartItem->stock,
                'order_quantity' => $cartItem->order_quantity
            ];
        
            // Process images
            $imagePaths = [];
        
            if ($cartItem->images !== null && $cartItem->images !== '') {
                $imagePaths = explode(',', $cartItem->images);
            }
        
            if (empty($imagePaths)) {
                $imagePaths[0] = asset('images/No-Image-Placeholder.svg');
            } else {
                $imagePaths = array_map(function ($path) {
                    return asset('storage/' . $path);
                }, $imagePaths);
            }
        
            $itemDetails['images'] = $imagePaths;
        
            // Append item details to the 2D array
            $arrayItems[] = $itemDetails;
        }
        return view('cart', compact('arrayItems'));
    }

    public function update(Request $request)
    {
        $productID = $request->input('product_id');
        $quantity = $request->input('quantity');
        $user = auth()->user();
        //If user does not have cart create one
        if ($user->cart == null) {
            $cart = $user->cart()->create();
        } else {
            $cart = $user->cart;
        }

        $existingProduct = $cart->products()->where('product_id', $productID)->first();

        if ($existingProduct) {
            // If product exists, increment the quantity
            $currentQuantity = $existingProduct->pivot->quantity;
            $cart->products()->updateExistingPivot($productID, ['quantity' => $currentQuantity + $quantity]);
        } else {
            // If product does not exist, attach it with the initial quantity
            $cart->products()->attach($productID, ['quantity' => $quantity]);
        }
        return redirect()->back()->with([
            'message' => 'Product added to cart',
            'type' => 'success',
        ]);
    }

    public function updateQuantity(Request $request){
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        $user = auth()->user();
        $cart = $user->cart;

        $product = Product::find($productID);

        if ($product->quantity_available >= $quantity) {
            $cart->products()->updateExistingPivot($productID, ['quantity' => $quantity]);
            return response()->json(['status' => 'success', 'message' => 'Quantity updated successfully']);
        }else{
            return response()->json(['status' => 'failed', 'message'=> 'Not enough stock available']);
        }
    }

    public function destroy(Request $request)
    {
        $productID = $request->input('productID');
        $user = auth()->user();
        if ($user->cart == null) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $cart = $user->cart;
        $product = $cart->products()->where('product_id', $productID)->first();

        if ($product) {
            $cart->products()->detach($productID);
            return response()->json(['message' => 'Item removed from cart']);
        } else {
            return response()->json(['error' => 'Item not found in cart'], 404);
        }
    }
}
