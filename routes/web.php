<?php

use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsVerifyEmail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


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



// reset password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');



Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify');


Route::middleware(["auth",IsVerifyEmail::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/customers', [DashboardController::class, 'customers'])->name('customers.index');
    Route::get('/suppliers', [DashboardController::class, 'suppliers'])->name('suppliers.index');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/api/products/{product}', [ProductController::class, 'show'])->name('api.products.show');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


    Route::get('/products-by-category', [DashboardController::class, 'productsByCategory'])->name('products.by.category');
    Route::get('/products-by-category/{category}', [DashboardController::class, 'getProductsByCategory'])->name('products.filter.by.category');


    Route::get('/products-by-supplier', [DashboardController::class, 'productsBySupplier'])->name('products.by.supplier');
    Route::get('/api/products-by-supplier/{supplier}', [DashboardController::class, 'getProductsBySupplier'])->name('api.products.by.supplier');


    Route::get('/products-by-store', [DashboardController::class, 'productsByStore'])->name('products.by.store');
    Route::get('/api/products-by-store/{store}', [DashboardController::class, 'getProductsByStore'])->name('api.products.by.store');


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

    // Import
    Route::post('products-import', [ProductController::class, 'import'])->name('products.import');


});
