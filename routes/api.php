<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\Customer\AddressController;
use App\Http\Controllers\Api\V1\Customer\CustomerController;
use App\Http\Controllers\Api\V1\Customer\OrderController;
use App\Http\Controllers\Api\V1\Customer\ReviewController;
use App\Http\Controllers\Api\V1\Customer\WishlistController;
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
use App\Http\Controllers\Api\V1\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Api\V1\Admin\ProductImageController;
use App\Http\Controllers\Api\V1\Admin\StockController as AdminStockController;
use App\Http\Controllers\Api\V1\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Api\V1\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Api\V1\Public\NewsletterController as PublicNewsletterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->json(['success' => true]);
});

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
        Route::middleware('auth:sanctum')->get('/verify', [AuthController::class, 'verify']);
    });

    Route::post('forgot-password', [ResetPasswordController::class, 'sendResetLink'])->middleware('guest');
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->middleware('guest');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('customer/profile', [CustomerController::class, 'profile']);
        Route::post('customer/profile', [CustomerController::class, 'update']);

        Route::post('wishlist/add/product/', [WishlistController::class, 'addToWishlist']);
        Route::delete('wishlist/remove/{product}', [WishlistController::class, 'removeFromWishlist']);
        Route::get('wishlist', [WishlistController::class, 'getWishlist']);

        Route::post('billing/addresses', [AddressController::class, 'createOrUpdatebillingAddress']);
        Route::post('billing/shipping', [AddressController::class, 'createOrUpdateShippingAddress']);

        Route::post('orders/place', [OrderController::class, 'placeOrder']);
        Route::get('orders/my', [OrderController::class, 'getUserOrders']);
        Route::get('orders/my/{id}', [OrderController::class, 'show']);
        Route::get('card', [OrderController::class, 'generateStripeToken']);

        Route::post('product/review', [ReviewController::class, 'review']);
    });

    Route::get('products', [PublicProductController::class, 'index']);
    Route::get('/products/min-max-prices', [PublicProductController::class, 'getMinMaxPrices']);
    Route::get('product/{slug}', [PublicProductController::class, 'show']);

    Route::get('colors', [PublicColorController::class, 'index']);
    Route::get('categories', [PublicCategoryController::class, 'index']);
    Route::get('category/{id}/products', [PublicCategoryController::class, 'getProducts']);

    Route::get('sizes', [PublicSizeController::class, 'index']);
    Route::get('brands', [PublicBrandController::class, 'index']);

    Route::middleware('cors')->group(function () {
        Route::get('cart', [PublicCartController::class, 'index']);
        Route::post('cart/add', [PublicCartController::class, 'add']);
        Route::delete('cart/remove/{productId}', [PublicCartController::class, 'remove']);
    });

    Route::get('delivery-options', [DeliveryOptionController::class, 'index']);

    Route::post('apply-coupon', [CouponController::class, 'applyCoupon']);

    Route::post('/newsletter/subscribe', [PublicNewsletterController::class, 'subscribe']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {

        Route::post('categories', [AdminCategoryController::class, 'store']);
        Route::put('categories/{id}', [AdminCategoryController::class, 'update']);
        Route::delete('categories/{id}', [AdminCategoryController::class, 'destroy']);

        Route::get('orders', [AdminOrderController::class, 'index']);
        Route::get('orders/{id}', [AdminOrderController::class, 'show']);
        Route::put('orders/{id}', [AdminOrderController::class, 'update']);
        Route::delete('orders/{id}', [AdminOrderController::class, 'destroy']);
        Route::get('orders-report', [AdminOrderController::class, 'getSalesReport']);

        Route::post('delivery-options', [AdminDeliveryOptionController::class, 'store']);
        Route::put('delivery-options/{id}', [AdminDeliveryOptionController::class, 'update']);
        Route::delete('delivery-options/{id}', [AdminDeliveryOptionController::class, 'destroy']);

        Route::post('products', [AdminProductController::class, 'store']);
        Route::post('products/{id}', [AdminProductController::class, 'update']);
        Route::delete('products/{id}', [AdminProductController::class, 'destroy']);

        Route::delete('image/{id}', [ProductImageController::class, 'destroy']);

        Route::get('customers', [AdminCustomerController::class, 'index']);
        Route::delete('customers/{id}', [AdminCustomerController::class, 'destroy']);
        Route::get('customers-report', [AdminCustomerController::class, 'getCustomersReport']);

        Route::get('coupons', [AdminCouponController::class, 'index']);
        Route::post('coupons', [AdminCouponController::class, 'store']);
        Route::delete('coupons/{id}', [AdminCouponController::class, 'destroy']);
        Route::put('coupons/{id}', [AdminCouponController::class, 'update']);

        Route::post('brands', [AdminBrandController::class, 'store']);
        Route::delete('brands/{id}', [AdminBrandController::class, 'destroy']);
        Route::put('brands/{id}', [AdminBrandController::class, 'update']);

        Route::get('stocks', [AdminStockController::class, 'index']);
    });
});
