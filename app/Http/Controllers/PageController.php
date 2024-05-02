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
        $products = Product::latest()->filter(request(['search']))->paginate(10);
        $ratings = $products->select('id','rating');
        return view('index',['categories' => $categories, 'products' => $products, 'icons' => self::CATEGORY, 'ratings' => $ratings]);
    }
}
