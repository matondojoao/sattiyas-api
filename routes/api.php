<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\Customer\AddressController;
use App\Http\Controllers\Api\V1\Customer\CustomerController;
use App\Http\Controllers\Api\V1\Customer\OrderController;
use App\Http\Controllers\Api\V1\Customer\ReviewController;
use App\Http\Controllers\Api\V1\Customer\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Public\ProductController as PublicProductController;
use App\Http\Controllers\Api\V1\Public\CategoryController as PublicCategoryController;
use App\Http\Controllers\Api\V1\Public\ColorController as PublicColorController;
use App\Http\Controllers\Api\V1\Public\BrandController as PublicBrandController;
use App\Http\Controllers\Api\V1\Public\SizeController as PublicSizeController;
use App\Http\Controllers\Api\V1\Public\CartController as PublicCartController;
use App\Http\Controllers\Api\V1\Public\CouponController;
use App\Http\Controllers\Api\V1\Public\DeliveryOptionController;
use App\Http\Controllers\Api\V1\Public\PaymentMethodController;

use App\Http\Controllers\Api\V1\Admin\CategoryController as AdminCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Rotas para controllers públicos (não requerem autenticação)

// Route::get('products', [ProductController::class, 'index']);
// Route::get('products/{slug}', [ProductController::class, 'show']);

// Route::get('colors', [ColorController::class, 'index']);

// Route::get('categories', [CategoryController::class, 'index']);
// Route::get('categories/{id}/products', [CategoryController::class, 'show']);

// Route::get('sizes', [SizeController::class, 'index']);

// Route::get('stocks/{id}', [StockController::class, 'show']);
// Route::get('stocks', [StockController::class, 'index']);

// Route::get('reviews/{id}', [ReviewController::class, 'show']);
// Route::get('reviews', [ReviewController::class, 'index']);

// Route::get('promotions/{id}', [PromotionController::class, 'show']);
// Route::get('promotions', [PromotionController::class, 'index']);

// Route::get('wishlists/{id}', [WishlistController::class, 'show']);
// Route::get('wishlists', [WishlistController::class, 'index']);

// // Rotas para controllers administrativos
// Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

//     Route::get('orders/{id}', [OrderController::class, 'show']);
//     Route::get('orders', [OrderController::class, 'index']);

//     Route::post('products', [ProductController::class, 'store']);
//     Route::put('products/{id}', [ProductController::class, 'update']);
//     Route::delete('products/{id}', [ProductController::class, 'destroy']);

//     Route::post('colors', [ColorController::class, 'store']);
//     Route::put('colors/{id}', [ColorController::class, 'update']);
//     Route::delete('colors/{id}', [ColorController::class, 'destroy']);

//     Route::post('categories', [CategoryController::class, 'store']);
//     Route::put('categories/{id}', [CategoryController::class, 'update']);
//     Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

//     Route::post('sizes', [SizeController::class, 'store']);
//     Route::put('sizes/{id}', [SizeController::class, 'update']);
//     Route::delete('sizes/{id}', [SizeController::class, 'destroy']);

//     Route::post('stocks', [StockController::class, 'store']);
//     Route::put('stocks/{id}', [StockController::class, 'update']);
//     Route::delete('stocks/{id}', [StockController::class, 'destroy']);

//     Route::post('images', [ImageController::class, 'store']);
//     Route::put('images/{id}', [ImageController::class, 'update']);
//     Route::delete('images/{id}', [ImageController::class, 'destroy']);

//     Route::post('orders', [OrderController::class, 'store']);
//     Route::put('orders/{id}', [OrderController::class, 'update']);
//     Route::delete('orders/{id}', [OrderController::class, 'destroy']);

//     Route::post('reviews', [ReviewController::class, 'store']);
//     Route::put('reviews/{id}', [ReviewController::class, 'update']);
//     Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);

//     Route::post('promotions', [PromotionController::class, 'store']);
//     Route::put('promotions/{id}', [PromotionController::class, 'update']);
//     Route::delete('promotions/{id}', [PromotionController::class, 'destroy']);

//     Route::post('wishlists', [WishlistController::class, 'store']);
//     Route::delete('wishlists/{id}', [WishlistController::class, 'destroy']);
// });

// // Rotas para controllers de usuários autenticados
// Route::middleware('auth:sanctum')->group(function () {
//     // Adicione aqui rotas adicionais para controllers de usuários autenticados
// });

// // Rotas para controllers de autenticação e autorização
// Route::group(function () {
//     // Adicione aqui rotas adicionais para controllers de autenticação e autorização
// });

// Rotas públicas
Route::get('products', [PublicProductController::class, 'index']);
Route::get('product/{slug}', [PublicProductController::class, 'show']);
Route::get('colors', [PublicColorController::class, 'index']);
Route::get('categories', [PublicCategoryController::class, 'index']);
Route::get('sizes', [PublicSizeController::class, 'index']);
Route::get('brands', [PublicBrandController::class, 'index']);
Route::get('/cart', [PublicCartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [PublicCartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{productId}', [PublicCartController::class, 'remove'])->name('cart.remove');

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->middleware('guest');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
   Route::get('customer/profile', [CustomerController::class, 'profile']);
});

Route::post('/products/reviews', [ReviewController::class, 'review'])->middleware(['auth:sanctum']);


Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name

Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist']);
    Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'removeFromWishlist']);
    Route::get('/wishlist', [WishlistController::class, 'getWishlist']);
});


Route::middleware(['auth:sanctum'])->post('billing/addresses', [AddressController::class, 'createOrUpdatebillingAddress']);
Route::middleware(['auth:sanctum'])->post('billing/shipping', [AddressController::class, 'createOrUpdateShippingAddress']);

Route::middleware(['auth:sanctum'])->post('/orders/place', [OrderController::class, 'placeOrder']);
Route::middleware(['auth:sanctum'])->get('/orders/my', [OrderController::class, 'getUserOrders']);
Route::middleware(['auth:sanctum'])->get('/card', [OrderController::class, 'generateStripeToken']);


Route::get('/delivery-options', [DeliveryOptionController::class, 'index']);
Route::get('/payment-methods', [PaymentMethodController::class, 'index']);

Route::post('/apply-coupon', [CouponController::class, 'applyCoupon']);


Route::group(['middleware' => ['auth:sanctum','admin']], function () {
    Route::post('categories', [AdminCategoryController::class, 'store']);
    Route::put('categories/{id}', [AdminCategoryController::class, 'update']);
    Route::delete('categories/{id}', [AdminCategoryController::class, 'destroy']);
});

Route::get('/', function(){
    return view('testecheckout');
});
// // Rotas para administração (requer autenticação e papel de admin)
// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::post('admin/products', [ProductAdminController::class, 'store']);
//     Route::put('admin/products/{id}', [ProductAdminController::class, 'update']);
//     Route::delete('admin/products/{id}', [ProductAdminController::class, 'destroy']);

//     Route::post('admin/orders', [OrderAdminController::class, 'store']);
//     // Adicione aqui outras rotas administrativas, se necessário
// });

// // Rotas de autenticação
// Route::post('login', [AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);
// Route::post('logout', [AuthController::class, 'logout']);
// // Adicione aqui outras rotas de autenticação, se necessário
