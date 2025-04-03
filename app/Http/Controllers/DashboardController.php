<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $totalCustomers = Customer::count();

        $totalSuppliers = Supplier::count();

        // $allCustomers = DB::table('customers')->get();

        // $allSupplierss = DB::table('suppliers')->get();

        $categories = Category::all();


        return view('dashboard', compact(
            'totalCustomers',
            'totalSuppliers',
            // 'allCustomers',
            // 'allSupplierss'
            'categories',
        ));
    }


    public function customers()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function suppliers()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function products()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }


    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------


    // public function productsByCantegory($idCat)
    // {
    //     // $productsByCategory = Category::with('products')->find($idCat);
    //     $categories = Category::all();
    //     $productsByCategory = Product::where('category_id', $idCat)->get();
    //     return view('products.category', compact('productsByCategory', 'categories'));
    // }

    // public function productsByCategory(Request $request)
    // {
    //     $categories = Category::all();
    //     $selectedCategory = $request->input('category_id');
    //     $productsByCategory = Product::where('category_id', $selectedCategory)->get();

    //     return view('products.category', compact('categories', 'productsByCategory', 'selectedCategory'));
    // }


    public function productsByCategory()
    {
        $categories = Category::all();
        $products = collect();
        return view('products.category', compact('categories', 'products'));
    }

    public function getProductsByCategory(Category $category)
    {
        $categories = Category::all();
        $products = $category->productCat;
        return view('products.category', compact('categories', 'products'));
    }


    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------

    public function productsBySupplier()
    {
        $suppliers = Supplier::all();
        return view('products.supplier', compact('suppliers'));
    }



    public function getProductsBySupplier(Supplier $supplier)
    {
        $products = Product::with(['stock','category'])
        ->where('supplier_id', $supplier->id)
        ->get();

        // dd($products);

        return view('products._products_supplier', compact('products'));
    }


    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------

    public function productsByStore()
    {
        $stores = Store::all();
        return view('products.store', compact('stores'));
    }


    public function getProductsByStore(Store $store)
    {
        $products = Product::with(['category', 'stock'])
            ->whereHas('stock', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })
            ->get();

        return response()->json($products);
    }


    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------


    public function orders()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }


    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------

    // Search for customers by name, email, phone or address

    public function searchTerm(Request $request, $term)
    {
        $customers = Customer::where('first_name', 'like', "%{$term}%")
        ->orWhere('last_name', 'like', "%{$term}%")
        ->orWhere('email', 'like', "%{$term}%")
        ->orWhere('phone', 'like', "%{$term}%")
        ->orWhere('address', 'like', "%{$term}%")
        ->get();

        return response()->json($customers);
    }


    // Search for customers by name, email, phone or address

    public function search(Request $request)
    {
        $term = $request->input('term');
        $customers = Customer::where('first_name', 'like', "%{$term}%")
        ->orWhere('last_name', 'like', "%{$term}")
        ->orWhere('email', 'like', "%{$term}%")
        ->orWhere('phone', 'like', "%{$term}%")
        ->orWhere('address', 'like', "%{$term}%")
        ->paginate(10);

        return response()->json([
            'customers' => $customers->items(),
            'pagination' => [
                'total' => $customers->total(),
                'per_page' => $customers->perPage(),
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
                'from' => $customers->firstItem(),
                'to' => $customers->lastItem(),
                'links' => $customers->linkCollection()->toArray()
            ]
        ]);
    }

    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------

    public function getCustomerOrders(Customer $customer)
    {
        $orders = $customer->order()->get();
        return response()->json($orders);
    }


    public function getOrderDetails(Order $order)
    {
        $products = $order->productOrd()->get();
        // return response()->json($products);
        return view('orders.details', compact('products','order'));
    }

    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------

}