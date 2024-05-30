<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function show(Product $product){
        $seller = $product->seller;
        $comments = $product->comments;
        return view('products.show',['product' => $product, 'seller' => $seller, 'comments' => $comments]);
    }

    public function create(){
        $categories = Category::all();
        return view('products.create',['categories' => $categories]);
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'productQuantity' => 'required|integer|min:1',
            'productPrice' => 'required|numeric|min:0.01',
            'productCategory' => 'required',
            'condition' => 'required',
            'productImage1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', //5MB
            'productImage2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'productImage3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        //Declare an array to hold paths
        $imagePaths = [];

        foreach(['productImage1','productImage2','productImage3'] as $imageField){
            if ($request->hasFile($imageField)){
                //Add items to an existing array,
                $imagePaths[] = $formFields[$imageField]->store('images','public');
            }
        }
        //Create Product
        Product::create([
            'name' => $formFields['productName'],
            'description' => $formFields['productDescription'],
            'quantity_available' => $formFields['productQuantity'],
            'price' => $formFields['productPrice'],
            'condition' => $formFields['condition'],
            'images' => implode(',',$imagePaths),
            'category_id' => $formFields['productCategory'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('profile')->with(['message' => 'Product created successfully.','type' => 'success','pageIndex' => 1]);
    }

    public function edit(){

    }

    public function update(){
        
    }

    public function destory(Request $request){
        $currentUserID = auth()->user()->id;

        $id = $request->pID;

        $product = Product::find($id);

        if ($product->user_id == $currentUserID){
            $imagePaths = explode(',',$product->images);
            Storage::disk('public')->delete('images/pzO2HrcN7ve4LsE3QOdSU3789L4n1r7n9eocv2SJ.png');
            foreach($imagePaths as $imagePath){
                Storage::disk('public')->delete($imagePath);
            }
            $product->delete();
            return redirect()->route('profile')->with(['message' => 'Product deleted successfully.','type' => 'success','pageIndex' => 1]);
        }
        else{
            return abort(403,'Unauthorized Action');
        }
    }
}
