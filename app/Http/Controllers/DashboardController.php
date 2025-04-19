<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Mail\MyTestMail;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function index()
    {
        // $totalCustomers = Customer::count();
        // $totalSuppliers = Supplier::count();

        // $allCustomers = DB::table('customers')->get();

        // $allSupplierss = DB::table('suppliers')->get();

        // $categories = Category::all();

        // return view('dashboard', compact(
        //     'totalCustomers',
        //     'totalSuppliers',
        //     // 'allCustomers',
        //     // 'allSupplierss'
        //     'categories',
        // ));

        // ----------------------------

        $user = User::find(1); //cherche l'utilisateur dont le id est 1
        return view('dashboard',[
            'pic'=>$user->avatar,
            'totalCustomers' => Customer::count(),
            'totalSuppliers' => Supplier::count(),
            'totalProducts' => Product::count(),
            'categories' => Category::all()
            ]);


    }


    public function customers()
    {
        // $customers = Customer::all();
        $customers = Customer::paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function suppliers()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function products()
    {
        // $products = Product::all();
        // return view('products.index', compact('products'));

        return view('products.index', [
            'products' => Product::with(['category', 'supplier', 'stock'])->get()
        ]);
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
        return view('products.by-category', compact('categories', 'products'));
    }

    public function getProductsByCategory(Category $category)
    {
        $categories = Category::all();
        $products = $category->productCat;
        return view('products.by-category', compact('categories', 'products'));
    }


    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------

    public function productsBySupplier()
    {
        $suppliers = Supplier::all();
        return view('products.by-supplier', compact('suppliers'));
    }



    public function getProductsBySupplier(Supplier $supplier)
    {
        $products = Product::with(['stock','category'])
        ->where('supplier_id', $supplier->id)
        ->get();

        // dd($products);

        return view('products._products_by_supplier', compact('products'));
    }


    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------

    public function productsByStore()
    {
        $stores = Store::all();
        return view('products.by-store', compact('stores'));
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

    public function create()
    {
        return view('customers.create');
    }



    public function store(CustomerRequest $request): RedirectResponse
    {
        Customer::create($request->validated());
        Mail::to($request->email)->send(new MyTestMail($request->first_name.' '.$request->last_name));
        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }


    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }


    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        // The request is automatically validated by the CustomerRequest class
        $customer->update($request->validated());

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }


    public function delete(Customer $customer)
    {
        return view('customers.delete', compact('customer'));
    }


    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }


    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------

    public function saveCookie()
    {
        $name = request()->input("txtCookie");
        //Cookie::put("UserName",$name,6000000);
        Cookie::queue("UserName",$name,6000000);
        return redirect()->back();
    }


   public function saveSession(Request $request)
    {
        $name = $request->input("txtSession");
        $request->session()->put('SessionName', $name);
        return redirect()->back();
    }



    public function saveAvatar()
    {
        request()->validate([
            'avatarFile'=>'required|image',
                ]);
        $ext = request()->avatarFile->getClientOriginalExtension();
        $name = Str::random(30).time().".".$ext;
        request()->avatarFile->move(public_path('storage/avatars'),$name);
        $user = User::find(1);
        $user->update(['avatar'=>$name]);
        return redirect()->back();
    }


}
