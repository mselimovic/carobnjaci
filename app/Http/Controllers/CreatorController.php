<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Support\MarketplacePresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CreatorController extends Controller
{
    public function dashboard(Request $request)
    {
        if ($request->user()->is_admin) {
            return Inertia::render('Admin/Dashboard', MarketplacePresenter::adminDashboardProps($request->user()));
        }

        return Inertia::render('Dashboard', MarketplacePresenter::creatorDashboardProps($request->user()));
    }

    public function shop(Request $request)
    {
        abort_if($request->user()->is_admin, 403);

        return Inertia::render('Creator/Shop', MarketplacePresenter::creatorShopProps($request->user()));
    }

    public function products(Request $request)
    {
        abort_if($request->user()->is_admin, 403);

        return Inertia::render('Creator/Products', MarketplacePresenter::creatorProductsProps($request->user()));
    }

    public function shopUpdate(Request $request): RedirectResponse
    {
        abort_if($request->user()->is_admin, 403);

        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'specialty' => ['nullable', 'string', 'max:120'],
            'city' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'instagram' => ['nullable', 'string', 'max:120'],
            'facebook' => ['nullable', 'string', 'max:120'],
            'tiktok' => ['nullable', 'string', 'max:120'],
            'website' => ['nullable', 'url', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:60'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'cover_image' => ['nullable', 'image', 'max:6144'],
        ]);

        $shop = $user->shop;

        if ($shop) {
            if ($request->hasFile('logo')) {
                $validated['logo'] = $this->storeImageUpload($request, 'logo', 'shops/logos', $shop->logo);
            } else {
                unset($validated['logo']);
            }

            if ($request->hasFile('cover_image')) {
                $validated['cover_image'] = $this->storeImageUpload($request, 'cover_image', 'shops/covers', $shop->cover_image);
            } else {
                unset($validated['cover_image']);
            }

            $validated['slug'] = $this->uniqueSlug(
                Shop::class,
                $validated['name'],
                $shop->id,
            );

            $shop->update($validated);
        } else {
            $validated['user_id'] = $user->id;
            $validated['slug'] = $this->uniqueSlug(Shop::class, $validated['name']);
            $validated['status'] = 'pending';
            $validated['logo'] = $request->hasFile('logo')
                ? $this->storeImageUpload($request, 'logo', 'shops/logos')
                : null;
            $validated['cover_image'] = $request->hasFile('cover_image')
                ? $this->storeImageUpload($request, 'cover_image', 'shops/covers')
                : null;

            Shop::query()->create($validated);
        }

        return to_route('creator.shop');
    }

    public function shopDestroy(Request $request): RedirectResponse
    {
        abort_if($request->user()->is_admin, 403);

        $shop = $request->user()->shop;
        abort_unless($shop, 404);

        $this->deleteStoredImage($shop->logo);
        $this->deleteStoredImage($shop->cover_image);

        foreach ($shop->products as $product) {
            $this->deleteStoredImage($product->featured_image);
        }

        $shop->delete();

        return to_route('creator.shop');
    }

    public function productStore(Request $request): RedirectResponse
    {
        abort_if($request->user()->is_admin, 403);

        $shop = $request->user()->shop;
        abort_unless($shop, 404);

        $validated = $this->validateProduct($request);
        $validated['featured_image'] = $request->hasFile('featured_image')
            ? $this->storeImageUpload($request, 'featured_image', 'products/featured')
            : null;

        $shop->products()->create([
            ...$validated,
            'slug' => $this->uniqueSlug(Product::class, $validated['title']),
            'materials' => $this->normalizeMaterials($request->string('materials')->toString()),
        ]);

        return to_route('creator.products');
    }

    public function productUpdate(Request $request, Product $product): RedirectResponse
    {
        abort_if($request->user()->is_admin, 403);

        $shop = $request->user()->shop;
        abort_unless($shop && $product->shop_id === $shop->id, 404);

        $validated = $this->validateProduct($request);
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->storeImageUpload(
                $request,
                'featured_image',
                'products/featured',
                $product->featured_image,
            );
        } else {
            unset($validated['featured_image']);
        }

        $product->update([
            ...$validated,
            'slug' => $this->uniqueSlug(Product::class, $validated['title'], $product->id),
            'materials' => $this->normalizeMaterials($request->string('materials')->toString()),
        ]);

        return to_route('creator.products');
    }

    public function productDestroy(Request $request, Product $product): RedirectResponse
    {
        abort_if($request->user()->is_admin, 403);

        $shop = $request->user()->shop;
        abort_unless($shop && $product->shop_id === $shop->id, 404);

        $this->deleteStoredImage($product->featured_image);
        $product->delete();

        return to_route('creator.products');
    }

    public function messages(Request $request)
    {
        return Inertia::render('Creator/Messages', MarketplacePresenter::creatorMessagesProps($request->user()));
    }

    protected function validateProduct(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'category_id' => ['nullable', 'integer', Rule::exists(Category::class, 'id')],
            'description' => ['nullable', 'string', 'max:4000'],
            'featured_image' => ['nullable', 'image', 'max:6144'],
            'materials' => ['nullable', 'string', 'max:500'],
            'lead_time' => ['nullable', 'string', 'max:120'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'contact_price' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', Rule::in(['draft', 'pending', 'published'])],
        ]);
    }

    protected function normalizeMaterials(string $materials): array
    {
        return collect(preg_split('/[\r\n,]+/', $materials) ?: [])
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    protected function uniqueSlug(string $modelClass, string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);
        $slug = $base !== '' ? $base : 'item';
        $original = $slug;
        $index = 2;

        while ($modelClass::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = "{$original}-{$index}";
            $index++;
        }

        return $slug;
    }

    protected function storeImageUpload(Request $request, string $field, string $directory, ?string $oldPath = null): string
    {
        $this->deleteStoredImage($oldPath);

        return $request->file($field)->store($directory, 'public');
    }

    protected function deleteStoredImage(?string $path): void
    {
        if (! $path || Str::startsWith($path, ['http://', 'https://', '/'])) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
