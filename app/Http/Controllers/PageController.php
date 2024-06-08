<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
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
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $order_status = $request->input('status');
        $keyword = $request->input('keyword');

        $orderQuery = Order::with(['address', 'product', 'product.seller', 'buyer', 'payment'])
            ->whereHas('product.seller', function ($query) {
                $query->where('user_id', auth()->user()->id); // user_id here refers to the seller_id
            })
            //Check whether the payment is success or not, only order with success payment will show on seller view
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', '=', 'success');
            })
            ->whereNotNull('order_status')
            ->orderByRaw('created_at DESC');

        if ($fromDate != null) {
            $orderQuery = $orderQuery->where('created_at', '>=', $fromDate);
        }
        if ($toDate != null) {
            $toDate = Carbon::parse($toDate)->endOfDay();
            $orderQuery = $orderQuery->where('created_at', '<=', $toDate);
        }
        if ($order_status != null && $order_status != 'all') {
            $orderQuery = $orderQuery->where('order_status', '=', $order_status);
        }
        if ($keyword != null) {
            $orderQuery = $orderQuery->whereHas('product', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
        }

        $orders = $orderQuery->get();

        $order_list = view('components.profiles.sub_components.order-list', ['orders' => $orders])->render();
        return response()->json(['orderList' => $order_list, 'order' => $orders, 'keyword' => $keyword]);
    }

    public function showSalesReportControl()
    {
        $currentUser = Auth::user();

        $products = auth()->user()->products;

        $ordersQuery = Order::with(['product', 'payment'])
            ->whereHas('product', function ($query) use ($currentUser) {
                $query->where('user_id', $currentUser->id);
            })
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', 'success');
            });

        // Get the first and last order dates
        $firstOrderDate = $ordersQuery->orderBy('created_at', 'asc')->first()->created_at ?? Carbon::now();
        $lastOrderDate = $ordersQuery->orderBy('created_at', 'desc')->first()->created_at ?? Carbon::now();

        //Generate the year range
        $startYear = $firstOrderDate->year;
        $endYear = $lastOrderDate->year;
        $years = range($startYear, $endYear);

        $salesReportControl = view('components.profiles.sales-report-control', ['products' => $products, 'years' => $years])->render();
        return response()->json(['control' => $salesReportControl]);
    }

    public function getSalesTableData(Request $request)
    {
        $currentUser = auth()->user();

        $productID = $request->input('productID');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $dataQuery = Order::select(
            DB::raw('products.name as product_name'),
            DB::raw('products.price as unit_price'),
            DB::raw('SUM(orders.quantity) as sales_quantity'),
            DB::raw('SUM(orders.quantity * products.price) as total_sales')
        )
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('products.user_id', $currentUser->id)
            ->where('products.id', $productID)
            ->where('orders.order_status', 'completed')
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', 'success');
            });

        if ($fromDate != null) {
            $dataQuery = $dataQuery->where('orders.created_at', '>=', $fromDate);
        }
        if ($toDate != null) {
            $toDate = Carbon::parse($toDate)->endOfDay();
            $dataQuery = $dataQuery->where('orders.created_at', '<=', $toDate);
        }
        $data = $dataQuery->groupBy('products.name','products.price')->first();
        $tableDataView = view('components.profiles.sub_components.sales-data',["data" => $data])->render();
        return response()->json([
            'html' => $tableDataView
        ]);
    }

    public function getReportData(Request $request)
    {
        $currentUser = auth()->user();

        $productID = $request->input('productID');
        $year = $request->input('year');

        $product = Product::find($productID);
        // Fetch orders for the given product and user, grouped by month and filtered by the selected year
        $ordersQuery = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(quantity) as total_quantity')
        )
            ->whereHas('product', function ($query) use ($currentUser) {
                $query->where('user_id', $currentUser->id);
            })
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', 'success');
            })
            ->where('order_status', 'completed')
            //Add Where the order_status is completed?
            ->where('product_id', $productID)
            ->whereYear('created_at', $year)  // Filter by the selected year
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare the data for each month
        $data = array_fill(0, 12, 0);
        foreach ($ordersQuery as $order) {
            $data[$order->month - 1] = $order->total_quantity;
        }

        // Create the final JSON structure
        $response = [
            'data' => $data,
            'product' => $product->name
        ];
        // Convert the results to JSON

        return response()->json($response);
    }
}
