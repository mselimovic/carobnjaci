<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $shops = Shop::query()
            ->with('user')
            ->withCount('products')
            ->latest()
            ->get();

        $products = Product::query()
            ->with(['shop.user', 'category'])
            ->latest()
            ->get();

        return Inertia::render('Admin/Moderation', [
            'shops' => $shops->map(fn (Shop $shop) => [
                'id' => $shop->id,
                'name' => $shop->name,
                'owner' => $shop->user?->name ?? '',
                'ownerEmail' => $shop->user?->email ?? '',
                'city' => $shop->city,
                'status' => $shop->status,
                'statusLabel' => Str::headline($shop->status),
                'productsCount' => $shop->products_count,
                'createdAt' => $shop->created_at?->diffForHumans(),
            ])->values(),
            'products' => $products->map(fn (Product $product) => [
                'id' => $product->id,
                'title' => $product->title,
                'shop' => $product->shop?->name ?? '',
                'owner' => $product->shop?->user?->name ?? '',
                'category' => $product->category?->name ?? '',
                'status' => $product->status,
                'statusLabel' => Str::headline($product->status),
                'createdAt' => $product->created_at?->diffForHumans(),
            ])->values(),
        ]);
    }

    public function updateShop(Shop $shop): RedirectResponse
    {
        $validated = request()->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'suspended'])],
        ]);

        $shop->update([
            'status' => $validated['status'],
        ]);

        return to_route('admin.index');
    }

    public function updateProduct(Product $product): RedirectResponse
    {
        $validated = request()->validate([
            'status' => ['required', Rule::in(['draft', 'pending', 'published', 'rejected'])],
        ]);

        $product->update([
            'status' => $validated['status'],
        ]);

        return to_route('admin.index');
    }
}
