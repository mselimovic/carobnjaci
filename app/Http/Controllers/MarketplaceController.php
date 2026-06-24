<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Support\MarketplacePresenter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class MarketplaceController extends Controller
{
    public function home(Request $request)
    {
        return Inertia::render('Home', array_merge(
            [
                'canRegister' => Features::enabled(Features::registration()),
            ],
            MarketplacePresenter::homeProps(),
        ));
    }

    public function products()
    {
        return Inertia::render('Products/Index', MarketplacePresenter::productIndexProps());
    }

    public function productShow(string $slug)
    {
        $product = Product::query()
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('Products/Show', MarketplacePresenter::productShowProps($product));
    }

    public function shops()
    {
        return Inertia::render('Shops/Index', MarketplacePresenter::shopIndexProps());
    }

    public function shopShow(string $slug)
    {
        $shop = Shop::query()
            ->where('status', 'approved')
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('Shops/Show', MarketplacePresenter::shopShowProps($shop));
    }

    public function categories()
    {
        return Inertia::render('Categories/Index', MarketplacePresenter::categoryIndexProps());
    }
}
