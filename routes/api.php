<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\CustomerController;
use App\Http\Controllers\Api\Admin\InventoryController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\Admin\ContactMessageController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\FooterGalleryController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Support\Facades\Route;


// =============================================
// PUBLIC ROUTES — No Login Required
// =============================================

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/contact', [ContactController::class, 'store']);

// Forgot / Reset Password — Public
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password',  [AuthController::class, 'resetPassword']);

// Order Tracking — Public
Route::get('/track/{orderNumber}', [OrderController::class, 'track']);

// Categories
Route::get('/categories',       [CategoryController::class, 'index']);
Route::get('/categories/{slug}',[CategoryController::class, 'show']);
Route::post('/newsletter', [NewsletterController::class, 'subscribe']);
// Products
Route::get('/products',              [ProductController::class, 'index']);
Route::get('/products/featured',     [ProductController::class, 'featured']);
Route::get('/products/new-arrivals', [ProductController::class, 'newArrivals']);
Route::get('/products/popular',      [ProductController::class, 'popular']);   // ADD THIS
Route::get('/products/{slug}',       [ProductController::class, 'show']);      // must stay last

// Reviews — Public Read
Route::get('/products/{productId}/reviews', [ReviewController::class, 'index']);
Route::get('/footer-gallery', [FooterGalleryController::class, 'index']);
Route::get('/footer-gallery/{id}', [FooterGalleryController::class, 'show']);

// Coupon Apply
Route::post('/coupons/apply', [CouponController::class, 'apply']);

// =============================================
// CUSTOMER ROUTES — Login Required
// =============================================

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout',          [AuthController::class, 'logout']);
    Route::get('/profile',          [AuthController::class, 'profile']);
    Route::put('/profile',          [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/profile/avatar', [AuthController::class, 'uploadAvatar']);
    

    // Orders
    Route::get('/orders',           [OrderController::class, 'index']);
    Route::post('/orders',          [OrderController::class, 'store']);
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
    // NEW — screenshot upload for JazzCash/EasyPaisa/Bank proof
    Route::post('/orders/{orderNumber}/payment-proof', [OrderController::class, 'uploadPaymentProof']);

    // Reviews — Write
    Route::post('/products/{productId}/reviews', [ReviewController::class, 'store']);

    // Cart — moved OUT of admin group, this is a customer feature
    Route::get('/cart',                 [CartController::class, 'index']);
    Route::post('/cart/items',          [CartController::class, 'store']);
    Route::put('/cart/items/{item}',    [CartController::class, 'update']);
    Route::delete('/cart/items/{item}', [CartController::class, 'destroy']);
    Route::delete('/cart',              [CartController::class, 'clear']);
    Route::get('/wishlist',             [WishlistController::class, 'index']);
Route::post('/wishlist',            [WishlistController::class, 'store']);
Route::delete('/wishlist/{id}',     [WishlistController::class, 'destroy']);
    

    // =============================================
    // ADMIN ROUTES — Admin Only
    // =============================================

    Route::middleware('admin')->prefix('admin')->group(function () {

        Route::get('/messages',               [ContactMessageController::class, 'index']);
        Route::get('/messages/{id}',          [ContactMessageController::class, 'show']);
        Route::delete('/messages/{id}',       [ContactMessageController::class, 'destroy']);
        Route::get('/messages/unread-count',  [ContactMessageController::class, 'unreadCount']);
        Route::put('/messages/{id}/read',     [ContactMessageController::class, 'markAsRead']);
Route::get('/newsletter', [NewsletterController::class, 'index']);
Route::delete('/newsletter/{id}', [NewsletterController::class, 'destroy']);
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::apiResource('categories', AdminCategoryController::class);
        Route::post('/footer-gallery', [FooterGalleryController::class, 'store']);
Route::put('/footer-gallery/{id}', [FooterGalleryController::class, 'update']);
Route::delete('/footer-gallery/{id}', [FooterGalleryController::class, 'destroy']);
Route::put('admin/footer-gallery/{id}/status', [FooterGalleryController::class, 'toggleStatus']);


        // Products CRUD
        Route::get('/products',         [AdminProductController::class, 'index']);
        Route::post('/products',        [AdminProductController::class, 'store']);
        Route::get('/products/{id}',    [AdminProductController::class, 'show']);
        Route::put('/products/{id}',    [AdminProductController::class, 'update']);
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);

        // Orders Management
        Route::get('/orders',                     [AdminOrderController::class, 'index']);
        Route::get('/orders/{id}',                [AdminOrderController::class, 'show']);
        Route::put('/orders/{id}/status',         [AdminOrderController::class, 'updateStatus']);
        // NEW — required for the payment verification buttons in Orders.jsx
     Route::put('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus']);
        // Customers
        Route::get('/customers',         [CustomerController::class, 'index']);
        Route::get('/customers/{id}',    [CustomerController::class, 'show']);
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

        // Inventory
        Route::get('/inventory',           [InventoryController::class, 'index']);
        Route::put('/inventory/{id}',      [InventoryController::class, 'update']);
        Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock']);

        // Reports
        Route::get('/reports/sales',        [ReportController::class, 'sales']);
        Route::get('/reports/top-products', [ReportController::class, 'topProducts']);
        Route::get('/reports/summary',      [ReportController::class, 'summary']);

        // Coupons CRUD
        Route::get('/coupons',         [AdminCouponController::class, 'index']);
        Route::post('/coupons',        [AdminCouponController::class, 'store']);
        Route::put('/coupons/{id}',    [AdminCouponController::class, 'update']);
        Route::delete('/coupons/{id}', [AdminCouponController::class, 'destroy']);
    });
});