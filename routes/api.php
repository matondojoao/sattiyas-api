<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\ReviewController as PublicReviewController;
use App\Http\Controllers\Public\WishlistController as PublicWishlistController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

// Route::get('colors', [ColorController::class, 'index']);

// Route::get('categories', [CategoryController::class, 'index']);
// Route::get('categories/{id}/products', [CategoryController::class, 'show']);

// Route::get('sizes', [SizeController::class, 'index']);

// Route::get('stocks/{id}', [StockController::class, 'show']);
// // Route::get('stocks', [StockController::class, 'index']);


// Rotas para usuários autenticados
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/profile', [UserController::class, 'profile']);
    // Adicione aqui outras rotas para usuários autenticados, se necessário
});

// Rotas para administração (requer autenticação e papel de admin)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('admin/products', [ProductAdminController::class, 'store']);
    Route::put('admin/products/{id}', [ProductAdminController::class, 'update']);
    Route::delete('admin/products/{id}', [ProductAdminController::class, 'destroy']);

    Route::post('admin/orders', [OrderAdminController::class, 'store']);
    // Adicione aqui outras rotas administrativas, se necessário
});

// Rotas de autenticação
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);
// Adicione aqui outras rotas de autenticação, se necessário