<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { ArrowRight, Clock3, MapPin, Store } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import ContactSellerCTA from '@/components/ContactSellerCTA.svelte';
    import ProductCard from '@/components/ProductCard.svelte';
    import { t } from '@/lib/i18n';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
    import type { ProductCardData, ProductDetail, ShopSummary } from '@/types/marketplace';

    let {
        product,
        shop = null,
        relatedProducts = [],
    }: {
        product: ProductDetail;
        shop?: ShopSummary | null;
        relatedProducts: ProductCardData[];
    } = $props();
</script>

<AppHead title={product.title} />

<PublicLayout>
    <section class="space-y-10">
        <div class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]">
            <div class="space-y-4">
                <div class="theme-panel overflow-hidden">
                    <img src={product.gallery[0]} alt={product.title} class="aspect-[4/3] w-full object-cover" />
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    {#each product.gallery.slice(1) as image}
                        <div class="theme-panel overflow-hidden">
                            <img src={image} alt={product.title} class="aspect-[4/3] w-full object-cover" />
                        </div>
                    {/each}
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-3">
                    <div class="theme-pill-soft">
                        {product.category}
                    </div>
                    <h1 class="text-4xl font-bold tracking-tight text-foreground lg:text-5xl">
                        {product.title}
                    </h1>
                    <p class="text-lg text-primary">{product.priceLabel}</p>
                    <p class="max-w-2xl text-base leading-8 text-muted-foreground">
                        {product.shortDescription}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="theme-panel p-4">
                        <div class="flex items-center gap-2 text-sm font-semibold text-foreground">
                            <Store class="size-4 text-primary" />
                            {t('product.shop')}
                        </div>
                        <div class="mt-2 text-sm text-muted-foreground">{shop?.name ?? ''}</div>
                    </div>
                    <div class="theme-panel p-4">
                        <div class="flex items-center gap-2 text-sm font-semibold text-foreground">
                            <Clock3 class="size-4 text-primary" />
                            {t('product.lead_time')}
                        </div>
                        <div class="mt-2 text-sm text-muted-foreground">{product.leadTime}</div>
                    </div>
                    <div class="theme-panel p-4">
                        <div class="flex items-center gap-2 text-sm font-semibold text-foreground">
                            <MapPin class="size-4 text-primary" />
                            {t('product.location')}
                        </div>
                        <div class="mt-2 text-sm text-muted-foreground">{product.location}</div>
                    </div>
                </div>

                <div class="theme-panel space-y-4 p-6">
                    <h2 class="text-xl font-semibold text-foreground">{t('product.about_piece')}</h2>
                    <p class="text-sm leading-7 text-muted-foreground">{product.description}</p>
                    <div>
                        <div class="text-sm font-semibold text-foreground">{t('product.materials')}</div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            {#each product.materials as material}
                                <span class="rounded-full border border-border bg-secondary px-3 py-1 text-xs font-semibold text-primary">
                                    {material}
                                </span>
                            {/each}
                        </div>
                    </div>
                </div>

                <ContactSellerCTA sellerName={shop?.name ?? ''} />

                {#if shop}
                    <div class="theme-panel p-5">
                        <div class="flex items-center gap-4">
                            <img src={shop.logo} alt={shop.name} class="h-16 w-16 rounded-xl border border-border bg-card object-cover" />
                            <div class="space-y-1">
                                <div class="text-lg font-semibold text-foreground">{shop.name}</div>
                                <div class="text-sm text-muted-foreground">{shop.city}</div>
                            </div>
                        </div>
                        <p class="mt-4 text-sm leading-7 text-muted-foreground">{shop.description}</p>
                        <Link href={`/shops/${shop.slug}`} class="theme-link mt-4 inline-flex items-center gap-2 text-sm">
                            {t('product.visit_shop')}
                            <ArrowRight class="size-4" />
                        </Link>
                    </div>
                {/if}
            </div>
        </div>

        <section class="space-y-6">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.16em] text-primary">{t('product.related_eyebrow')}</div>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-foreground">{t('product.related_title')}</h2>
                </div>
                <Link href="/products" class="theme-link hidden items-center gap-2 text-sm sm:inline-flex">
                    {t('common.browse_all_products')}
                    <ArrowRight class="size-4" />
                </Link>
            </div>

            <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
                {#each relatedProducts as relatedProduct}
                    <ProductCard product={relatedProduct} />
                {/each}
            </div>
        </section>
    </section>
</PublicLayout>
