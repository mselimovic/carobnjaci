<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'bs'], true), 404);

    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');

Route::inertia('/', 'Home', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::inertia('about', 'About')->name('about');
Route::inertia('products', 'Products/Index')->name('products.index');
Route::get('products/{slug}', function (string $slug) {
    return Inertia::render('Products/Show', [
        'slug' => $slug,
    ]);
})->name('products.show');
Route::inertia('shops', 'Shops/Index')->name('shops.index');
Route::get('shops/{slug}', function (string $slug) {
    return Inertia::render('Shops/Show', [
        'slug' => $slug,
    ]);
})->name('shops.show');
Route::inertia('categories', 'Categories/Index')->name('categories.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('creator/shop', 'Creator/Shop')->name('creator.shop');
    Route::inertia('creator/products', 'Creator/Products')->name('creator.products');
    Route::inertia('creator/messages', 'Creator/Messages')->name('creator.messages');
    Route::inertia('creator/settings', 'Creator/Settings')->name('creator.settings');
});

require __DIR__.'/settings.php';
