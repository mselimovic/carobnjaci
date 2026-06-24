<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Message;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MarketplacePresenter
{
    public static function homeProps(): array
    {
        $featuredProducts = Product::query()
            ->with(['shop', 'category', 'images'])
            ->where('status', 'published')
            ->latest()
            ->take(4)
            ->get();

        $featuredShops = Shop::query()
            ->withCount([
                'products as published_products_count' => fn ($query) => $query->where('status', 'published'),
            ])
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();

        $featuredCategories = Category::query()
            ->withCount([
                'products as published_products_count' => fn ($query) => $query->where('status', 'published'),
            ])
            ->orderByDesc('published_products_count')
            ->take(4)
            ->get();

        return [
            'featuredProducts' => $featuredProducts->map(fn (Product $product) => self::productCard($product))->values(),
            'featuredShops' => $featuredShops->map(fn (Shop $shop) => self::shopCard($shop))->values(),
            'featuredCategories' => $featuredCategories->map(fn (Category $category) => self::categoryCard($category))->values(),
        ];
    }

    public static function productIndexProps(): array
    {
        $products = Product::query()
            ->with(['shop', 'category', 'images'])
            ->where('status', 'published')
            ->latest()
            ->get();

        return [
            'products' => $products->map(fn (Product $product) => self::productCard($product))->values(),
        ];
    }

    public static function shopIndexProps(): array
    {
        $shops = Shop::query()
            ->withCount([
                'products as published_products_count' => fn ($query) => $query->where('status', 'published'),
            ])
            ->where('status', 'approved')
            ->latest()
            ->get();

        return [
            'shops' => $shops->map(fn (Shop $shop) => self::shopCard($shop))->values(),
        ];
    }

    public static function categoryIndexProps(): array
    {
        $categories = Category::query()
            ->withCount([
                'products as published_products_count' => fn ($query) => $query->where('status', 'published'),
            ])
            ->orderBy('name')
            ->get();

        return [
            'categories' => $categories->map(fn (Category $category) => self::categoryCard($category))->values(),
        ];
    }

    public static function productShowProps(Product $product): array
    {
        $product->load(['shop', 'category', 'images']);

        $relatedProducts = Product::query()
            ->with(['shop', 'category', 'images'])
            ->where('status', 'published')
            ->whereKeyNot($product->id)
            ->when(
                $product->category_id,
                fn ($query) => $query->where('category_id', $product->category_id),
            )
            ->latest()
            ->take(4)
            ->get();

        return [
            'product' => self::productDetail($product),
            'shop' => self::shopSummary($product->shop),
            'relatedProducts' => $relatedProducts->map(fn (Product $item) => self::productCard($item))->values(),
        ];
    }

    public static function shopShowProps(Shop $shop): array
    {
        $shop->load([
            'products' => fn ($query) => $query
                ->with(['category', 'images'])
                ->where('status', 'published')
                ->latest(),
        ]);

        return [
            'shop' => self::shopDetail($shop),
            'products' => $shop->products->map(fn (Product $product) => self::productCard($product))->values(),
        ];
    }

    public static function creatorDashboardProps(User $user): array
    {
        $user->load([
            'shop.products.images',
            'shop.products.category',
            'receivedMessages.product',
            'receivedMessages.sender',
        ]);

        $shop = $user->shop;
        $products = $shop?->products ?? collect();
        $messages = $user->receivedMessages->sortByDesc('created_at')->values();
        $unreadMessages = $messages->whereNull('read_at');

        return [
            'stats' => [
                'activeProducts' => $products->where('status', 'published')->count(),
                'unreadMessages' => $unreadMessages->count(),
                'profileCompletion' => self::profileCompletion($user, $shop),
                'responseTime' => $shop?->response_time ?? self::fallbackResponseTime(),
            ],
            'priorities' => self::creatorPriorities($user, $shop, $products, $unreadMessages),
            'recentConversations' => $messages->take(3)->map(fn (Message $message) => self::messageCard($message))->values(),
            'catalogSnapshot' => $products->take(3)->map(fn (Product $product) => self::catalogRow($product))->values(),
        ];
    }

    public static function adminDashboardProps(User $user): array
    {
        $pendingShops = Shop::query()->where('status', 'pending')->count();
        $pendingProducts = Product::query()->where('status', 'pending')->count();
        $publishedShops = Shop::query()->where('status', 'approved')->count();
        $publishedProducts = Product::query()->where('status', 'published')->count();

        return [
            'stats' => [
                [
                    'label' => self::label('admin.dashboard_pending_shops'),
                    'value' => $pendingShops,
                    'note' => self::label('admin.dashboard_pending_shops_note'),
                ],
                [
                    'label' => self::label('admin.dashboard_pending_products'),
                    'value' => $pendingProducts,
                    'note' => self::label('admin.dashboard_pending_products_note'),
                ],
                [
                    'label' => self::label('admin.dashboard_live_shops'),
                    'value' => $publishedShops,
                    'note' => self::label('admin.dashboard_live_shops_note'),
                ],
                [
                    'label' => self::label('admin.dashboard_live_products'),
                    'value' => $publishedProducts,
                    'note' => self::label('admin.dashboard_live_products_note'),
                ],
            ],
            'queues' => [
                'shops' => Shop::query()
                    ->where('status', 'pending')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn (Shop $shop) => [
                        'title' => $shop->name,
                        'meta' => collect([$shop->city, $shop->created_at?->diffForHumans()])->filter()->implode(' • '),
                    ])->values(),
                'products' => Product::query()
                    ->with('shop')
                    ->where('status', 'pending')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn (Product $product) => [
                        'title' => $product->title,
                        'meta' => collect([$product->shop?->name, $product->created_at?->diffForHumans()])->filter()->implode(' • '),
                    ])->values(),
            ],
        ];
    }

    public static function creatorShopProps(User $user): array
    {
        $user->load('shop');

        $shop = $user->shop;

        return [
            'shop' => $shop ? self::creatorShop($shop) : null,
            'profileCompletion' => self::profileCompletion($user, $shop),
            'nextTasks' => self::shopTasks($shop),
        ];
    }

    public static function creatorProductsProps(User $user): array
    {
        $user->load([
            'shop.products.category',
            'shop.products.images',
        ]);

        $products = $user->shop?->products?->sortByDesc('updated_at')->values() ?? collect();
        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return [
            'hasShop' => $user->shop !== null,
            'categories' => $categories->map(fn (Category $category) => [
                'id' => $category->id,
                'name' => $category->name,
            ])->values(),
            'statuses' => collect(['draft', 'pending', 'published'])->map(fn (string $status) => [
                'value' => $status,
                'label' => self::statusLabel($status),
            ])->values(),
            'products' => $products->map(fn (Product $product) => self::creatorProductRow($product))->values(),
        ];
    }

    public static function creatorMessagesProps(User $user): array
    {
        $messages = Message::query()
            ->with(['sender', 'product'])
            ->where('receiver_id', $user->id)
            ->latest()
            ->get();

        return [
            'threads' => $messages->map(fn (Message $message) => self::messageCard($message))->values(),
        ];
    }

    public static function productCard(Product $product): array
    {
        $product->loadMissing(['shop', 'category', 'images']);

        return [
            'slug' => $product->slug,
            'title' => $product->title,
            'shop' => $product->shop?->name ?? '',
            'shopSlug' => $product->shop?->slug ?? '',
            'category' => $product->category?->name ?? 'Handmade',
            'priceLabel' => self::priceLabel($product),
            'image' => self::productImage($product),
            'accent' => self::accentClassForCategory($product->category?->slug),
            'interestLabel' => self::interestLabel($product->views),
        ];
    }

    public static function shopCard(Shop $shop): array
    {
        $shop->loadMissing('products');

        return [
            'slug' => $shop->slug,
            'name' => $shop->name,
            'city' => $shop->city ?? 'Bosnia and Herzegovina',
            'description' => $shop->description ?? $shop->bio ?? '',
            'specialty' => $shop->specialty ?? 'Handmade studio',
            'image' => self::mediaUrl($shop->cover_image ?: self::shopFallbackImage($shop)),
            'logo' => self::mediaUrl($shop->logo ?: '/brand/logo.png'),
            'publishedCount' => $shop->published_products_count ?? $shop->products->where('status', 'published')->count(),
        ];
    }

    public static function categoryCard(Category $category): array
    {
        return [
            'slug' => $category->slug,
            'name' => $category->name,
            'icon' => $category->icon ?: 'Sparkles',
            'description' => $category->description ?? '',
            'countLabel' => self::countLabel($category->published_products_count ?? 0),
        ];
    }

    public static function productDetail(Product $product): array
    {
        $gallery = $product->images
            ->sortBy('sort_order')
            ->pluck('image_path')
            ->map(fn (?string $path) => self::mediaUrl($path))
            ->filter()
            ->values();

        if ($gallery->isEmpty()) {
            $gallery = collect([self::productImage($product)]);
        }

        return [
            'slug' => $product->slug,
            'title' => $product->title,
            'category' => $product->category?->name ?? 'Handmade',
            'priceLabel' => self::priceLabel($product),
            'shortDescription' => Str::limit($product->description ?? '', 160),
            'description' => $product->description ?? '',
            'leadTime' => $product->lead_time ?? self::fallbackLeadTime(),
            'location' => $product->shop?->city ?? 'Bosnia and Herzegovina',
            'materials' => collect($product->materials ?? [])->values(),
            'gallery' => $gallery->values(),
        ];
    }

    public static function shopDetail(Shop $shop): array
    {
        $publishedCount = $shop->products->count();

        return [
            'slug' => $shop->slug,
            'name' => $shop->name,
            'city' => $shop->city ?? 'Bosnia and Herzegovina',
            'description' => $shop->description ?? '',
            'specialty' => $shop->specialty ?? 'Handmade studio',
            'bio' => $shop->bio ?: ($shop->description ?? ''),
            'logo' => self::mediaUrl($shop->logo ?: '/brand/logo.png'),
            'coverImage' => self::mediaUrl($shop->cover_image ?: self::shopFallbackImage($shop)),
            'responseTime' => $shop->response_time ?? self::fallbackResponseTime(),
            'productCount' => self::countLabel($publishedCount),
            'highlights' => array_values(array_filter([
                ['label' => self::shopFieldLabel('featured_category'), 'value' => $shop->specialty],
                ['label' => self::shopFieldLabel('based_in'), 'value' => $shop->city],
                ['label' => self::shopFieldLabel('instagram'), 'value' => $shop->instagram],
                ['label' => self::shopFieldLabel('phone'), 'value' => $shop->phone],
            ], fn ($item) => filled($item['value']))),
            'highlightBadges' => collect([
                $publishedCount > 0 ? self::countLabel($publishedCount) : null,
                $shop->response_time,
                $shop->city ? self::shopFieldLabel('local_workshop') : null,
            ])->filter()->values(),
            'since' => self::sinceLabel($shop),
        ];
    }

    public static function shopSummary(?Shop $shop): ?array
    {
        if (! $shop) {
            return null;
        }

        return [
            'slug' => $shop->slug,
            'name' => $shop->name,
            'city' => $shop->city ?? 'Bosnia and Herzegovina',
            'description' => $shop->description ?? '',
            'logo' => self::mediaUrl($shop->logo ?: '/brand/logo.png'),
        ];
    }

    public static function creatorShop(Shop $shop): array
    {
        $shop->loadMissing('products');

        return [
            'id' => $shop->id,
            'name' => $shop->name,
            'slug' => $shop->slug,
            'city' => $shop->city,
            'status' => $shop->status,
            'statusLabel' => self::shopStatusLabel($shop->status),
            'description' => $shop->description,
            'bio' => $shop->bio,
            'specialty' => $shop->specialty,
            'responseTime' => $shop->response_time ?? self::fallbackResponseTime(),
            'instagram' => $shop->instagram,
            'facebook' => $shop->facebook,
            'tiktok' => $shop->tiktok,
            'website' => $shop->website,
            'phone' => $shop->phone,
            'productCount' => $shop->products->count(),
            'visible' => $shop->status === 'approved',
            'coverImage' => self::mediaUrl($shop->cover_image),
            'logo' => self::mediaUrl($shop->logo),
        ];
    }

    public static function creatorProductRow(Product $product): array
    {
        return [
            'id' => $product->id,
            'title' => $product->title,
            'categoryId' => $product->category_id,
            'description' => $product->description ?? '',
            'featuredImage' => self::mediaUrl($product->featured_image),
            'materials' => implode(', ', $product->materials ?? []),
            'leadTime' => $product->lead_time ?? '',
            'priceValue' => $product->price !== null ? (string) $product->price : '',
            'contactPrice' => (bool) $product->contact_price,
            'isFeatured' => (bool) $product->is_featured,
            'statusValue' => $product->status,
            'status' => self::statusLabel($product->status),
            'price' => self::priceLabel($product),
            'updated' => $product->updated_at?->diffForHumans() ?? '',
        ];
    }

    public static function catalogRow(Product $product): array
    {
        return [
            'title' => $product->title,
            'status' => self::statusLabel($product->status),
            'price' => self::priceLabel($product),
            'interest' => self::interestLabel($product->views),
        ];
    }

    public static function messageCard(Message $message): array
    {
        return [
            'subject' => $message->subject ?: self::messageSubject($message),
            'buyer' => $message->sender?->name ?? '',
            'state' => $message->read_at ? self::label('creator.messages_replied') : self::label('creator.messages_new'),
            'excerpt' => Str::limit($message->message, 120),
            'createdAt' => $message->created_at?->diffForHumans(),
        ];
    }

    protected static function creatorPriorities(User $user, ?Shop $shop, Collection $products, Collection $unreadMessages): array
    {
        $priorities = [];

        if (! $shop || blank($shop->bio)) {
            $priorities[] = [
                'title' => self::label('creator.priority_1_title'),
                'text' => self::label('creator.priority_1_text'),
            ];
        }

        if ($unreadMessages->isNotEmpty()) {
            $priorities[] = [
                'title' => self::label('creator.priority_2_title'),
                'text' => self::label('creator.priority_2_text'),
            ];
        }

        if ($products->contains(fn (Product $product) => blank($product->featured_image))) {
            $priorities[] = [
                'title' => self::label('creator.priority_3_title'),
                'text' => self::label('creator.priority_3_text'),
            ];
        }

        return array_slice($priorities, 0, 3);
    }

    protected static function shopTasks(?Shop $shop): array
    {
        $tasks = [];

        if (! $shop || blank($shop->cover_image)) {
            $tasks[] = [
                'title' => self::label('creator.shop_task_1_title'),
                'text' => self::label('creator.shop_task_1_text'),
            ];
        }

        if (! $shop || blank($shop->bio)) {
            $tasks[] = [
                'title' => self::label('creator.shop_task_2_title'),
                'text' => self::label('creator.shop_task_2_text'),
            ];
        }

        if (! $shop || blank($shop->response_time)) {
            $tasks[] = [
                'title' => self::label('creator.shop_task_3_title'),
                'text' => self::label('creator.shop_task_3_text'),
            ];
        }

        return $tasks;
    }

    protected static function productImage(Product $product): string
    {
        return self::mediaUrl(
            $product->featured_image
            ?: $product->images->sortBy('sort_order')->pluck('image_path')->first()
            ?: '/placeholders/hero-handmade.jpg'
        );
    }

    protected static function shopFallbackImage(Shop $shop): string
    {
        return $shop->products()
            ->where('status', 'published')
            ->whereNotNull('featured_image')
            ->value('featured_image') ?: '/placeholders/about-studio.avif';
    }

    protected static function mediaUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return '/storage/'.ltrim($path, '/');
    }

    protected static function accentClassForCategory(?string $slug): string
    {
        return match ($slug) {
            'ceramics' => 'bg-accent',
            'art' => 'bg-chart-3',
            'jewelry' => 'bg-chart-4',
            'clothing' => 'bg-chart-5',
            default => 'bg-primary',
        };
    }

    protected static function countLabel(int $count): string
    {
        $suffix = app()->getLocale() === 'bs' ? 'proizvoda' : 'products';

        return "{$count} {$suffix}";
    }

    protected static function priceLabel(Product $product): string
    {
        if ($product->contact_price || $product->price === null) {
            return app()->getLocale() === 'bs' ? 'Cijena na upit' : 'Contact for price';
        }

        return number_format((float) $product->price, 0).' EUR';
    }

    protected static function interestLabel(int $views): string
    {
        $suffix = app()->getLocale() === 'bs' ? 'pregleda' : 'views';

        return "{$views} {$suffix}";
    }

    protected static function fallbackLeadTime(): string
    {
        return app()->getLocale() === 'bs' ? '3-5 dana' : '3-5 days';
    }

    protected static function fallbackResponseTime(): string
    {
        return app()->getLocale() === 'bs' ? 'Obicno odgovara u roku od 1 dana' : 'Usually replies within 1 day';
    }

    protected static function sinceLabel(Shop $shop): string
    {
        $year = $shop->created_at?->format('Y') ?? now()->format('Y');

        return app()->getLocale() === 'bs'
            ? "Kreira od {$year}"
            : "Creating since {$year}";
    }

    protected static function messageSubject(Message $message): string
    {
        if ($message->product) {
            return app()->getLocale() === 'bs'
                ? "Upit za {$message->product->title}"
                : "Inquiry about {$message->product->title}";
        }

        return app()->getLocale() === 'bs' ? 'Nova poruka kupca' : 'New buyer message';
    }

    protected static function profileCompletion(User $user, ?Shop $shop): int
    {
        $fields = [
            $user->name,
            $user->email,
            $user->avatar,
            $user->bio,
            $user->city,
            $shop?->name,
            $shop?->description,
            $shop?->bio,
            $shop?->cover_image,
            $shop?->logo,
            $shop?->response_time,
        ];

        $filled = collect($fields)->filter(fn ($value) => filled($value))->count();

        return (int) round(($filled / count($fields)) * 100);
    }

    protected static function statusLabel(string $status): string
    {
        return match ([$status, app()->getLocale()]) {
            ['draft', 'bs'] => 'Skica',
            ['pending', 'bs'] => 'Na cekanju',
            ['published', 'bs'] => 'Objavljeno',
            ['rejected', 'bs'] => 'Odbijeno',
            ['draft', 'en'] => 'Draft',
            ['pending', 'en'] => 'Pending',
            ['published', 'en'] => 'Published',
            ['rejected', 'en'] => 'Rejected',
            default => Str::headline($status),
        };
    }

    protected static function shopStatusLabel(string $status): string
    {
        return match ([$status, app()->getLocale()]) {
            ['pending', 'bs'] => 'Na cekanju',
            ['approved', 'bs'] => 'Odobreno',
            ['suspended', 'bs'] => 'Suspendovano',
            ['pending', 'en'] => 'Pending',
            ['approved', 'en'] => 'Approved',
            ['suspended', 'en'] => 'Suspended',
            default => Str::headline($status),
        };
    }

    protected static function label(string $key): string
    {
        return (string) __($key);
    }

    protected static function shopFieldLabel(string $key): string
    {
        return match ([$key, app()->getLocale()]) {
            ['featured_category', 'bs'] => 'Istaknuta kategorija',
            ['based_in', 'bs'] => 'Lokacija',
            ['instagram', 'bs'] => 'Instagram',
            ['phone', 'bs'] => 'Telefon',
            ['local_workshop', 'bs'] => 'Lokalna radionica',
            ['featured_category', 'en'] => 'Featured category',
            ['based_in', 'en'] => 'Based in',
            ['instagram', 'en'] => 'Instagram',
            ['phone', 'en'] => 'Phone',
            ['local_workshop', 'en'] => 'Local workshop',
            default => Str::headline($key),
        };
    }
}
