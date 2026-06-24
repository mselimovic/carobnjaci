<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\MarketplaceController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'bs'], true), 404);

    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');

Route::get('/', [MarketplaceController::class, 'home'])->name('home');

Route::inertia('about', 'About')->name('about');
Route::get('products', [MarketplaceController::class, 'products'])->name('products.index');
Route::get('products/{slug}', [MarketplaceController::class, 'productShow'])->name('products.show');
Route::get('shops', [MarketplaceController::class, 'shops'])->name('shops.index');
Route::get('shops/{slug}', [MarketplaceController::class, 'shopShow'])->name('shops.show');
Route::get('categories', [MarketplaceController::class, 'categories'])->name('categories.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [CreatorController::class, 'dashboard'])->name('dashboard');
    Route::get('creator/shop', [CreatorController::class, 'shop'])->name('creator.shop');
    Route::post('creator/shop', [CreatorController::class, 'shopUpdate'])->name('creator.shop.update');
    Route::delete('creator/shop', [CreatorController::class, 'shopDestroy'])->name('creator.shop.destroy');
    Route::get('creator/products', [CreatorController::class, 'products'])->name('creator.products');
    Route::post('creator/products', [CreatorController::class, 'productStore'])->name('creator.products.store');
    Route::put('creator/products/{product}', [CreatorController::class, 'productUpdate'])->name('creator.products.update');
    Route::delete('creator/products/{product}', [CreatorController::class, 'productDestroy'])->name('creator.products.destroy');
    Route::get('creator/messages', [CreatorController::class, 'messages'])->name('creator.messages');
    Route::inertia('creator/settings', 'Creator/Settings')->name('creator.settings');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('shops/{shop}', [AdminController::class, 'updateShop'])->name('admin.shops.update');
    Route::post('products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
});

require __DIR__.'/settings.php';
