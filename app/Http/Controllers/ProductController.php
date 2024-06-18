<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        //Return 404 if product is not approved
        if ($product->approve_status != "approved"){
            return abort(404);
        }
        $seller = $product->seller;
        $comments = $product->comments;
        return view('products.show', ['product' => $product, 'seller' => $seller, 'comments' => $comments]);
    }

    public function create()
    {
        //Check the seller have bank account or not before they add product
        $user = auth()->user();
        if ($user->bank_name == null || $user->bank_acc_name == null || $user->bank_acc_num == null) {
            return redirect()->route('profile.createBankDetails')->with(['message' => 'Please add your bank details before adding product.', 'type' => 'alert']);
        }
        $categories = Category::all();
        return view('products.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'productQuantity' => 'required|integer|min:1|max:5000',
            'productPrice' => 'required|numeric|min:1',
            'productCategory' => 'required',
            'condition' => 'required',
            'productImage1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', //5MB
            'productImage2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'productImage3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        //Declare an array to hold paths
        $imagePaths = [];

        foreach (['productImage1', 'productImage2', 'productImage3'] as $imageField) {
            if ($request->hasFile($imageField)) {
                //Add items to an existing array,
                $imagePaths[] = $formFields[$imageField]->store('images', 'public');
            }
        }
        //Create Product
        Product::create([
            'name' => $formFields['productName'],
            'description' => $formFields['productDescription'],
            'quantity_available' => $formFields['productQuantity'],
            'price' => $formFields['productPrice'],
            'condition' => $formFields['condition'],
            'images' => implode(',', $imagePaths),
            'category_id' => $formFields['productCategory'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('profile')->with(['message' => 'Product created successfully.', 'type' => 'success', 'pageIndex' => 1]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        if ($product->user_id != auth()->id()) {
            return abort(403, 'Unauthorized Action');
        }
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id != auth()->id()) {
            return abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'productQuantity' => 'required|integer|min:1|max:5000',
            'productPrice' => 'required|numeric|min:0.01',
            'productCategory' => 'required',
            'condition' => 'required',
            'productImage1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120', //5MB
            'productImage2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'productImage3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        //Retrieve Previous Image Path
        $imagePaths = explode(',', $product->images);

        // Ensure imagePaths array has at least 3 elements
        for ($i = 0; $i < 3; $i++) {
            if (!isset($imagePaths[$i])) {
                $imagePaths[$i] = null;
            }
        }

        if ($request->hasFile('productImage1')) {
            if ($imagePaths[0] != null) {
                Storage::disk('public')->delete($imagePaths[0]);
            }
            $imagePaths[0] = $formFields['productImage1']->store('images', 'public');
        }

        if ($request->hasFile('productImage2')) {
            if ($imagePaths[1] != null) {
                Storage::disk('public')->delete($imagePaths[1]);
            }
            $imagePaths[1] = $formFields['productImage2']->store('images', 'public');
        }

        if ($request->hasFile('productImage3')) {
            if ($imagePaths[2] != null) {
                Storage::disk('public')->delete($imagePaths[2]);
            }
            $imagePaths[2] = $formFields['productImage3']->store('images', 'public');
        }


        if ($imagePaths != []) {
            //Update Product with Image
            $imagePaths = array_filter($imagePaths);
            $product->update([
                'name' => $formFields['productName'],
                'description' => $formFields['productDescription'],
                'quantity_available' => $formFields['productQuantity'],
                'price' => $formFields['productPrice'],
                'condition' => $formFields['condition'],
                'images' => implode(',', $imagePaths),
                //Change approve status to pending again
                'approve_status' => 'pending',
                'category_id' => $formFields['productCategory'],
                'user_id' => auth()->user()->id,
            ]);
        } else {
            $product->update([
                'name' => $formFields['productName'],
                'description' => $formFields['productDescription'],
                'quantity_available' => $formFields['productQuantity'],
                'price' => $formFields['productPrice'],
                'condition' => $formFields['condition'],
                //Change approve status to pending again
                'approve_status' => 'pending',
                'category_id' => $formFields['productCategory'],
                'user_id' => auth()->user()->id,
            ]);
        }


        return redirect()->route('profile')->with(['message' => 'Product updated successfully.', 'type' => 'success', 'pageIndex' => 1]);
    }

    public function updateImage(Product $product, int $index)
    {
        if ($product->user_id != auth()->id()) {
            return abort(403, 'Unauthorized Action');
        }
        //Retrieve Previous Image Path
        $imagePaths = explode(',', $product->images);

        // Ensure imagePaths array has at least 3 elements
        for ($i = 0; $i < 3; $i++) {
            if (!isset($imagePaths[$i])) {
                $imagePaths[$i] = null;
            }
        }

        if ($imagePaths[$index] != null) {
            Storage::disk('public')->delete($imagePaths[$index]);
            $imagePaths[$index] = null;
        }

        $product->update([
            'images' => implode(',', $imagePaths),
        ]);

        return redirect()->back();
    }

    public function destory(Request $request)
    {
        $currentUserID = auth()->user()->id;

        $id = $request->pID;

        $product = Product::find($id);

        if ($product->user_id == $currentUserID) {
            $imagePaths = explode(',', $product->images);
            foreach ($imagePaths as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $product->delete();
            return redirect()->route('profile')->with(['message' => 'Product deleted successfully.', 'type' => 'success', 'pageIndex' => 1]);
        } else {
            return abort(403, 'Unauthorized Action');
        }
    }

    public function redirectManageProduct()
    {
        return redirect()->route('profile')->with(['pageIndex' => 1]);
    }

    public function updateProductStatus(Request $request)
    {
        $productID = $request->input('productID');
        $status = $request->input('status');

        $product = Product::find($productID);

        $product->update(['approve_status' => $status]);

        return response()->json(['success' => true]);
    }

    public function getDetails(Request $request)
    {
        $orderID = $request->orderID;

        $product = Order::find($orderID)->product;

        if ($product) {
            return response()->json(
                [
                    'status' => 'success',
                    'productName' => $product->name,
                    'orderID' => $orderID,
                ]
            );
        }
        return response()->json(['status' => 'failed']);
    }
}
