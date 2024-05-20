<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product){
        $seller = $product->seller;
        return view('products.show',['product' => $product, 'seller' => $seller]);
    }
}
