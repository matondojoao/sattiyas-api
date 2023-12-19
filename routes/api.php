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
use \App\Http\Controllers\Api\V1\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\V1\Admin\DeliveryOptionController as AdminDeliveryOptionController;
use App\Http\Controllers\Api\V1\Admin\PaymentMethodController as AdminPaymentMethodController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\ProductImageController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist']);
    Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'removeFromWishlist']);
    Route::get('/wishlist', [WishlistController::class, 'getWishlist']);
});


Route::middleware(['auth:sanctum'])->post('billing/addresses', [AddressController::class, 'createOrUpdatebillingAddress']);
Route::middleware(['auth:sanctum'])->post('billing/shipping', [AddressController::class, 'createOrUpdateShippingAddress']);

Route::middleware(['auth:sanctum'])->post('/orders/place', [OrderController::class, 'placeOrder']);
Route::middleware(['auth:sanctum'])->get('/orders/my', [OrderController::class, 'getUserOrders']);
Route::middleware(['auth:sanctum'])->get('orders/my/{id}', [OrderController::class, 'show']);
Route::middleware(['auth:sanctum'])->get('/card', [OrderController::class, 'generateStripeToken']);


Route::get('/delivery-options', [DeliveryOptionController::class, 'index']);
Route::get('/payment-methods', [PaymentMethodController::class, 'index']);

Route::post('/apply-coupon', [CouponController::class, 'applyCoupon']);


Route::group(['middleware' => ['auth:sanctum','admin']], function () {

    Route::post('categories', [AdminCategoryController::class, 'store']);
    Route::put('categories/{id}', [AdminCategoryController::class, 'update']);
    Route::delete('categories/{id}', [AdminCategoryController::class, 'destroy']);

    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::put('orders/{id}', [AdminOrderController::class, 'update']);
    Route::delete('orders/{id}', [AdminOrderController::class, 'destroy']);

    Route::post('delivery-options', [AdminDeliveryOptionController::class, 'store']);
    Route::put('delivery-options/{id}', [AdminDeliveryOptionController::class, 'update']);
    Route::delete('delivery-options/{id}', [AdminDeliveryOptionController::class, 'destroy']);

    Route::post('payment-methods', [AdminPaymentMethodController::class, 'store']);
    Route::put('payment-methods/{id}', [AdminPaymentMethodController::class, 'update']);
    Route::delete('payment-methods/{id}', [AdminPaymentMethodController::class, 'destroy']);

    Route::post('products', [AdminProductController::class, 'store']);
    Route::post('products/{id}', [AdminProductController::class, 'update']);
    Route::delete('products/{id}', [AdminProductController::class, 'destroy']);

    Route::delete('image/{id}', [ProductImageController::class, 'destroy']);

});
