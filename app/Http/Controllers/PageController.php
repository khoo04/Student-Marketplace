<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    const CATEGORY = [ 1 => "fa-person", 2 => "fa-person-dress", 3 => "fa-pencil", 4 => "fa-headphones", 5 => "fa-basketball", 6 => "fa-book", 7 => "fa-handshake"];
    public function index(){
        $categories = DB::table('category')->get();
        return view('index',['categories' => $categories, 'icons' => self::CATEGORY]);
    }

    public function paginateData(Request $request){
        $products = Product::latest()->filter($request->only('search'))->paginate(8);
        $ratings = $products->select('id','rating');
        $productCards = [];

        foreach ($products as $product){
            $productCards[] = view('components.product-card',['product' => $product])->render();
        }
        $pagination = $products->links()->toHtml();
        return response()->json(['products_cards' => $productCards, 'pagination' => $pagination, 'ratings' => $ratings]);
    }
}
