<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;



Auth::routes([
    'register' => false, // disable registration
]);

// Public routes
Route::get('/', [ProductController::class, 'dashboard'])->name('home');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/price-tracker', [ProductController::class, 'priceTracker'])->name('price-tracker');
Route::get('/products/load-more', [ProductController::class, 'loadMore'])->name('products.load-more');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/admin', function () {
    return redirect()->route('admin.products.index');
})->name('admin');
// Admin routes (protected with auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
    Route::post('/products/{product}/toggle-dod', [ProductController::class, 'toggleDealOfDay'])->name('products.toggle-dod');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
});
