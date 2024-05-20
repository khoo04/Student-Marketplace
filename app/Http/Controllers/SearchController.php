<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $query = $request->input('keyword');
        $result = Product::where('name','like','%' . $query . '%')->get();
        return view('search',['results' => $result]);
    }
}
