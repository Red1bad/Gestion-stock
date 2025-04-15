<?php

use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// // Route::get('/', function () {
// //     return view('welcome');
// // });

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/customers', [DashboardController::class, 'customers'])->name('customers.index');
// Route::get('/suppliers', [DashboardController::class, 'suppliers'])->name('suppliers.index');
// // Route::get('/products', [DashboardController::class, 'products'])->name('products.index');


// // Route::get('/productsByCategory', [DashboardController::class, 'productsByCategory'])->name('products.category');
// // Route::get('/productsByCategory/{idCat?}', [DashboardController::class, 'productsByCategory'])->name('products.category');


// // Product routes
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route::post('/products', [ProductController::class, 'store'])->name('products.store');
// Route::get('/api/products/{product}', [ProductController::class, 'show'])->name('api.products.show');
// Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// Route::get('/products-category', [DashboardController::class, 'productsByCategory'])->name('products.category');
// Route::get('/products-category/{category}', [DashboardController::class, 'getProductsByCategory'])->name('products.filter.category');



// // Products by Supplier routes
// Route::get('/products-supplier', [DashboardController::class, 'productsBySupplier'])->name('products.supplier');
// Route::get('/api/products-supplier/{supplier}', [DashboardController::class, 'getProductsBySupplier'])->name('api.products.supplier');



// // Products by Store routes
// Route::get('/products-store', [DashboardController::class, 'productsByStore'])->name('products.store');
// Route::get('/api/products-store/{store}', [DashboardController::class, 'getProductsByStore'])->name('api.products.store');




// // // Order routes
// Route::get('/orders', [DashboardController::class, 'orders'])->name('orders.index');


// // Customer search API route
// Route::get('/api/customers/search', [DashboardController::class, 'search'])->name('customers.search');

// // Customer search API route
// Route::get('/api/customers/search/{term}', [DashboardController::class, 'searchTerm'])->name('customers.search.term');


// // Customer orders API route
// Route::get('/api/customers/{customer}/orders', [DashboardController::class, 'getCustomerOrders'])->name('customers.orders');

// // Order details route
// Route::get('/api/orders/{order}/details', [DashboardController::class, 'getOrderDetails'])->name('orders.details');




// // Customer routes
// Route::get('/customers/create', [DashboardController::class, 'create'])->name('customers.create');
// Route::post('/customers', [DashboardController::class, 'store'])->name('customers.store');
// Route::get('/customer/{customer}/edit', [DashboardController::class, 'edit'])->name('customers.edit');
// Route::put('/customers/{customer}', [DashboardController::class, 'update'])->name('customers.update');
// Route::get('/customers/{customer}/delete', [DashboardController::class, 'delete'])->name('customers.delete');
// Route::delete('/customers/{customer}', [DashboardController::class, 'destroy'])->name('customers.destroy');




// // Mail
// Route::get('/test-mail', function(){
//     $name = 'Hombre';
//     // $eamils = ['elkaidzaid@gmail.com','redouanbader@gmail.com','imadfd03@gmail.com', 'zouhairkan2005@gmail.com'];
//     $eamils = ['zouhairkan2005@gmail.com'];
//     Mail::to($eamils)->send(new MyTestMail($name));
//     return 'Mail sent';
// });



// // ------------------
// Route::post("/saveCookie", [DashboardController::class, 'saveCookie'])->name("saveCookie");
// Route::post("/saveSession", [DashboardController::class, 'saveSession'])->name("saveSession");
// Route::post("/saveAvatar", [DashboardController::class, 'saveAvatar'])->name("saveAvatar");












// login

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/customers', [DashboardController::class, 'customers'])->name('customers.index');
    Route::get('/suppliers', [DashboardController::class, 'suppliers'])->name('suppliers.index');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/api/products/{product}', [ProductController::class, 'show'])->name('api.products.show');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/products-category', [DashboardController::class, 'productsByCategory'])->name('products.category');
    Route::get('/products-category/{category}', [DashboardController::class, 'getProductsByCategory'])->name('products.filter.category');

    Route::get('/products-supplier', [DashboardController::class, 'productsBySupplier'])->name('products.supplier');
    Route::get('/api/products-supplier/{supplier}', [DashboardController::class, 'getProductsBySupplier'])->name('api.products.supplier');

    Route::get('/products-store', [DashboardController::class, 'productsByStore'])->name('products.store');
    Route::get('/api/products-store/{store}', [DashboardController::class, 'getProductsByStore'])->name('api.products.store');

    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders.index');
    Route::get('/api/customers/search', [DashboardController::class, 'search'])->name('customers.search');
    Route::get('/api/customers/search/{term}', [DashboardController::class, 'searchTerm'])->name('customers.search.term');
    Route::get('/api/customers/{customer}/orders', [DashboardController::class, 'getCustomerOrders'])->name('customers.orders');
    Route::get('/api/orders/{order}/details', [DashboardController::class, 'getOrderDetails'])->name('orders.details');

    Route::get('/customers/create', [DashboardController::class, 'create'])->name('customers.create');
    Route::post('/customers', [DashboardController::class, 'store'])->name('customers.store');
    Route::get('/customer/{customer}/edit', [DashboardController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [DashboardController::class, 'update'])->name('customers.update');
    Route::get('/customers/{customer}/delete', [DashboardController::class, 'delete'])->name('customers.delete');
    Route::delete('/customers/{customer}', [DashboardController::class, 'destroy'])->name('customers.destroy');

    Route::post("/saveCookie", [DashboardController::class, 'saveCookie'])->name("saveCookie");
    Route::post("/saveSession", [DashboardController::class, 'saveSession'])->name("saveSession");
    Route::post("/saveAvatar", [DashboardController::class, 'saveAvatar'])->name("saveAvatar");



    // Traduction

    Route::get('/changeLocale/{locale}', function (string $locale) {
        if (in_array($locale, ['en', 'es', 'fr', 'ar'])) {
            session()->put('locale', $locale);
         }
        return redirect()->back();
    });


    // Export
    Route::get('products-export', [ProductController::class, 'export'])->name('products.export');

});