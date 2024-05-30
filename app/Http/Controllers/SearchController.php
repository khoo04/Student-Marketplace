<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $keyword = $request->input('keyword');
        $results = Product::where('name', 'like', '%' . $keyword . '%')
                ->where('approve_status','=','approved');
                
        if ($request->ajax()) {
            $category = $request->input('cat');
            $condition = $request->input('cond');
            $lowerPrice = $request->input('lower');
            $highestPrice = $request->input('highest');
    
            if ($category != null) {
                $results = $results->where('category_id', '=', $category);
            }
            if ($condition != null){
                $results = $results->where('condition','=',$condition);
            }
            if ($lowerPrice != null) {
                $results = $results->where('price', '>=', $lowerPrice);
            }
            if ($highestPrice != null) {
                $results = $results->where('price', '<=', $highestPrice);
            }
            
            $results = $results->paginate(5);
            foreach ($results as $result) {
                $searchCards[] = view('components.search-card', ['product' => $result])->render();
            }
            $pagination = $results->links()->toHtml();

            return response()->json(['searchCards' => $searchCards, 'pagination' => $pagination]);
        } 
        else {
            $results = $results->paginate(5);
            $categories = Category::all();
            return view('search', ['results' => $results, 'keyword' => $keyword, 'categories' => $categories]);
        }
    }
}
