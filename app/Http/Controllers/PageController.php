<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    const CATEGORY = [1 => "fa-person", 2 => "fa-person-dress", 3 => "fa-pencil", 4 => "fa-headphones", 5 => "fa-basketball", 6 => "fa-book", 7 => "fa-handshake"];
    public function index()
    {
        $categories = DB::table('categories')->get();
        return view('index', ['categories' => $categories, 'icons' => self::CATEGORY]);
    }

    public function paginateData()
    {
        $products = Product::latest()->where('approve_status', '=', 'approved')->paginate(10);

        $productCards = [];

        foreach ($products as $product) {
            $productCards[] = view('components.product-card', ['product' => $product])->render();
        }
        $pagination = $products->links()->toHtml();
        return response()->json(['products_cards' => $productCards, 'pagination' => $pagination]);
    }


    public function categoryPage(Request $request, string $categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            abort(404, 'Category not found');
        }


        $productsQuery = $category->products()->where('approve_status', '=', 'approved');

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
            return response()->json(['productCards' => $productCards, 'pagination' => $pagination]);
        } else {
            // Paginate the results for non-ajax requests
            $products = $productsQuery->paginate(5);
            return view('category', ['category' => $category, 'products' => $products]);
        }
    }

    public function showProfile()
    {
        $user = Auth::user();
        if ($user->types == 'seller') {
            return view('profiles.seller', compact('user'));
        } else {
            return view('profiles.buyer', compact('user'));
        }
    }
    public function showProfileControl()
    {
        $user = Auth::user();
        $profileControl = view('components.profiles.profile-control', ['user' => $user])->render();
        return response()->json(['control' => $profileControl]);
    }

    public function showAddressControl()
    {
        //TODO: Retrieve Data from DB
        $user = Auth::user();
        $addressControl = view('components.profiles.address-control')->render();
        return response()->json(['control' => $addressControl]);
    }

    public function showUserOrderControl()
    {
        //TODO: Retrieve Data from DB
        $user = Auth::user();
        $userOrderControl = view('components.profiles.user-order-control')->render();
        return response()->json(['control' => $userOrderControl]);
    }

    public function showProductControl()
    {
        $user = Auth::user();

        $products = $user->products;
        $productControl = view('components.profiles.product-control', compact('products'))->render();

        return response()->json(['control' => $productControl]);
    }

    public function showManageOrderControl()
    {
        //Retrieve all record related to the current seller
        $orders = Order::with(['address', 'product.seller', 'buyer', 'payment'])
            ->whereHas('product.seller', function ($query) {
                $query->where('user_id', auth()->user()->id); // user_id here refers to the seller_id
            })
            //Check whether the payment is success or not, only order with success payment will show on seller view
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', '=', 'success');
            })
            ->whereNotNull('order_status')
            ->orderByRaw('created_at DESC')
            ->get();

        $manageOrderControl = view('components.profiles.manage-order-control', ['orders' => $orders])->render();
        return response()->json(['control' => $manageOrderControl]);
    }


    public function manageOrderFilter(Request $request)
    {
        $fromDate = $request->input('order_from_date');
        $toDate = $request->input('order_to_date');
        $order_status = $request->input('status');
        $keyword = $request->input('keyword');

        $orderQuery = Order::with(['address', 'product.seller', 'buyer', 'payment'])
            ->whereHas('product.seller', function ($query) {
                $query->where('user_id', auth()->user()->id); // user_id here refers to the seller_id
            })
            //Check whether the payment is success or not, only order with success payment will show on seller view
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', '=', 'success');
            })
            ->whereNotNull('order_status')
            ->orderByRaw('created_at DESC');

        if ($fromDate != null){
            $orderQuery = $orderQuery->where('created_at','>=',$fromDate);
        }
        if ($toDate != null){
            $orderQuery = $orderQuery->where('created_at','<=',$toDate);
        }
        if ($order_status != null && $order_status != 'All'){
            $orderQuery = $orderQuery->where('order_status','=','status');
        }
        // if

        // $manageOrderControl = view('components.profiles.manage-order-control', ['orders' => $orders])->render();
        // return response()->json(['control' => $manageOrderControl]);
    }

    public function showSalesReportControl()
    {
        $user = Auth::user();
        $salesReportControl = view('components.profiles.sales-report-control')->render();
        return response()->json(['control' => $salesReportControl]);
    }
}
