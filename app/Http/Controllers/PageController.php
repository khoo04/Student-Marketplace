<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    const CATEGORY = [ 1 => "fa-person", 2 => "fa-person-dress", 3 => "fa-pencil", 4 => "fa-headphones", 5 => "fa-basketball", 6 => "fa-book", 7 => "fa-handshake"];
    public function index(){
        $categories = DB::table('categories')->get();
        return view('index',['categories' => $categories, 'icons' => self::CATEGORY]);
    }

    public function paginateData(){
        $products = Product::latest()->paginate(10);
      
        $productCards = [];

        foreach ($products as $product){
            $productCards[] = view('components.product-card',['product' => $product])->render();
        }
        $pagination = $products->links()->toHtml();
        return response()->json(['products_cards' => $productCards, 'pagination' => $pagination]);
    }


    public function categoryPage(Request $request, string $categoryId){
        $category = Category::find($categoryId);
    
        if (!$category) {
            abort(404, 'Category not found');
        }
    
        
        $productsQuery = $category->products();

        if ($request->ajax()) {
            // Apply filters
            $lowerPrice = $request->input('lower');
            $highestPrice = $request->input('highest');
            $keyword = $request->input('keyword');
            $condition = $request->input('condition');
    
            if ($lowerPrice != null) {
                $productsQuery = $productsQuery->where('price', '>=', $lowerPrice);
            }
            if ($highestPrice != null) {
                $productsQuery = $productsQuery->where('price', '<=', $highestPrice);
            }
            if ($keyword != null) {
                $productsQuery = $productsQuery->where('name', 'like', '%' . $keyword . '%');
            }
            if ($condition != null) {
                $productsQuery = $productsQuery->where('condition', '=', $condition);
            }
    
            // Paginate the results
            $products = $productsQuery->paginate(5);
            $productCards = [];

            foreach ($products as $product) {
                $productCards[] = view('components.product-card', ['product' => $product])->render();
            }
            $pagination = $products->links()->toHtml();
            return response()->json(['productCards' => $productCards,'pagination' => $pagination]);
        } else {
            // Paginate the results for non-ajax requests
            $products = $productsQuery->paginate(5);
            return view('category', ['category' => $category, 'products' => $products]);
        }
    }

    public function showProfile(){
        $user = Auth::user();
        if ($user->types == 'seller'){
            return view('profiles.seller');
        }
        else{
            return view('profiles.buyer');
        }
        
    }
}
