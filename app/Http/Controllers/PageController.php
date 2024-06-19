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
        $products = Product::latest()->where('approve_status', '=', 'approved')->paginate(12);

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
        } else if ($user->types == 'admin') {
            //Redirect To Admin Page
            return redirect()->route('admin');
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
        $addresses = $user->addresses;
        $addressControl = view('components.profiles.address-control', ['addresses' => $addresses])->render();
        return response()->json(['control' => $addressControl]);
    }

    public function showUserOrderControl()
    {
        $user = auth()->user();
        //Retrieve All Order for Current User
        $userOrderData = Order::select(
            DB::raw('orders.id as order_id'),
            DB::raw('products.images as product_images'),
            DB::raw('products.id as product_id'),
            DB::raw('products.name as product_name'),
            DB::raw('orders.quantity as order_quantity'),
            DB::raw('products.price as product_unit_price'),
            DB::raw('(products.price * orders.quantity) as total_price'),
            DB::raw('orders.order_status as order_status'),
            DB::raw('orders.comment_status as comment_status'),
            DB::raw('orders.tracking_num as tracking_num'),
            DB::raw('CASE WHEN products.deleted_at IS NULL THEN 0 ELSE 1 END as is_deleted'),
            DB::raw('CONCAT(sellers.first_name, " ", sellers.last_name)  as seller_name'),
            DB::raw('sellers.email as seller_email'),
            DB::raw('sellers.phone_num as seller_phone')
        )
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('users as sellers', function ($join) {
                $join->on('products.user_id', '=', 'sellers.id');
            })
            ->where('payments.payment_status', 'success')
            ->where('users.id', $user->id)
            ->get();
        $userOrderControl = view('components.profiles.user-order-control', ['userOrderData' => $userOrderData])->render();
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
        $orders = Order::with([
            'address' => function ($query) {
                $query->withTrashed();
            },
            'product' => function ($query) {
                $query->withTrashed();  // Include soft-deleted products
            },
            'buyer',
            'payment'
        ])
            ->whereHas('product', function ($query) {
                $query->withTrashed()->where('user_id', auth()->user()->id); // user_id here refers to the seller_id
            })
            // Check whether the payment is successful, only orders with successful payment will show on seller view
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

        $orderQuery = Order::with([
            'address' => function ($query) {
                $query->withTrashed();
            }, 'product' => function ($query) {
                $query->withTrashed();
            }, 'buyer', 'payment'
        ])
            ->whereHas('product', function ($query) {
                $query->withTrashed()->where('user_id', auth()->user()->id); // user_id here refers to the seller_id
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

        $products = auth()->user()->products()->withTrashed()->get();

        $ordersQuery = Order::with(['product' => function ($query) {
            $query->withTrashed();
        }, 'payment'])
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

        $data = $dataQuery->groupBy('products.name', 'products.price')->first();
        $tableDataView = view('components.profiles.sub_components.sales-data', ["data" => $data])->render();

        return response()->json([
            'html' => $tableDataView
        ]);
    }

    public function getReportData(Request $request)
    {
        $currentUser = auth()->user();

        $productID = $request->input('productID');
        $year = $request->input('year');

        $product = Product::withTrashed()->find($productID);
        // Fetch orders for the given product and user, grouped by month and filtered by the selected year
        $ordersQuery = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(quantity) as total_quantity')
        )
            ->whereHas('product', function ($query) use ($currentUser) {
                $query->withTrashed();
                $query->where('user_id', $currentUser->id);
            })
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', 'success');
            })
            ->where('order_status', 'completed')
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

    public function getAllProductSalesData(Request $request)
    {
        $currentUser = auth()->user();
        $month = $request->input('month');
        $year = $request->input('year');

        $allProductOrderQuery =  Order::select(
            DB::raw('products.name as product_name'),
            DB::raw('SUM(orders.quantity) as sales_quantity'),
        )
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->groupBy('products.name')
            ->where('products.user_id', $currentUser->id)
            ->where('orders.order_status', 'completed')
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', 'success');
            })
            ->whereMonth('orders.created_at', $month)
            ->whereYear('orders.created_at', $year)
            ->get();

        return response()->json($allProductOrderQuery);
    }

    public function adminIndex()
    {
        if (auth()->user()->types == 'admin') {
            $usersPendingApprove = User::all()->where('approve_status', 'pending');
            return view('admin.index', ['usersPendingApprove' => $usersPendingApprove]);
        } else {
            return abort(403, 'Unauthorized Action');
        }
    }

    public function getAccApprovalPanel()
    {
        $usersPendingApprove = User::all()->where('approve_status', 'pending');
        $usersPendingApprovePanel = view('components.admin.account-approval-panel', ['usersPendingApprove' => $usersPendingApprove])->render();
        return response()->json(['panel' => $usersPendingApprovePanel]);
    }

    public function getProductApprovalPanel()
    {
        $productsPendingApprove = Product::all()->where('approve_status', 'pending');
        $productsPendingApprovePanel = view('components.admin.product-approval-panel', ['productsPendingApprove' => $productsPendingApprove])->render();
        return response()->json(['panel' => $productsPendingApprovePanel]);
    }

    public function getSalesPaybackPanel()
    {
        $paymentToPayData = Order::select(
            DB::raw('orders.id as order_id'),
            DB::raw('payments.transaction_no as transaction_no'),
            DB::raw('products.name as product_name'),
            DB::raw('products.price as product_unit_price'),
            DB::raw('orders.quantity as order_quantity'),
            DB::raw('(products.price * orders.quantity) as amount_to_pay'),
            DB::raw('users.bank_acc_name as bank_acc_name'),
            DB::raw('users.bank_name as bank_name'),
            DB::raw('users.bank_acc_num as bank_acc_num')
        )
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->where('payments.isPaid', false)
            ->where('payments.payment_status', 'success')
            ->where('orders.order_status', 'completed')
            ->get();
        $salesPaybackPanel = view('components.admin.sales-payback-panel', ['paymentToPayData' => $paymentToPayData])->render();
        return response()->json(['panel' => $salesPaybackPanel]);
    }
}
