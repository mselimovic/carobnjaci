<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { ArrowRight, MapPin, MessageCircleMore } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import ContactSellerCTA from '@/components/ContactSellerCTA.svelte';
    import ProductCard from '@/components/ProductCard.svelte';
    import { t } from '@/lib/i18n';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
    import type { ProductCardData, ShopDetail } from '@/types/marketplace';

    let {
        shop,
        products = [],
    }: {
        shop: ShopDetail;
        products: ProductCardData[];
    } = $props();
</script>

<AppHead title={shop.name} />

<PublicLayout>
    <section class="space-y-10">
        <div class="theme-panel overflow-hidden">
            <img src={shop.coverImage} alt={shop.name} class="aspect-[16/5] w-full object-cover" />
            <div class="grid gap-6 px-6 py-6 lg:grid-cols-[auto_1fr_auto] lg:items-end lg:px-8">
                <div class="-mt-20">
                    <img src={shop.logo} alt={shop.name} class="h-28 w-28 rounded-2xl border-4 border-card bg-card object-cover shadow-sm" />
                </div>
                <div class="space-y-3">
                    <div class="theme-pill-soft">
                        {shop.specialty}
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight text-foreground">{shop.name}</h1>
                        <div class="mt-2 flex items-center gap-2 text-sm text-muted-foreground">
                            <MapPin class="size-4 text-primary" />
                            {shop.city}
                        </div>
                    </div>
                    <p class="max-w-3xl text-sm leading-7 text-muted-foreground">{shop.bio}</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                    {#each shop.highlightBadges as badge}
                        <div class="theme-panel-soft px-4 py-3 text-sm font-semibold text-foreground">
                            {badge}
                        </div>
                    {/each}
                </div>
            </div>
        </div>

        <div class="grid gap-8 xl:grid-cols-[0.72fr_1.28fr]">
            <div class="space-y-5">
                <div class="theme-panel p-5">
                    <h2 class="text-xl font-semibold text-foreground">{t('shop.details')}</h2>
                    <div class="mt-5 space-y-4">
                        {#each shop.highlights as highlight}
                            <div class="border-b border-border pb-4 last:border-b-0 last:pb-0">
                                <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{highlight.label}</div>
                                <div class="mt-1 text-sm text-foreground">{highlight.value}</div>
                            </div>
                        {/each}
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-1">
                    <div class="theme-panel p-5">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('shop.response_time')}</div>
                        <div class="mt-2 text-sm text-foreground">{shop.responseTime}</div>
                    </div>
                    <div class="theme-panel p-5">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('shop.studio_info')}</div>
                        <div class="mt-2 text-sm text-foreground">{shop.since}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{shop.productCount}</div>
                    </div>
                </div>

                <ContactSellerCTA sellerName={shop.name} contextLabel="shop" />
            </div>

            <div class="space-y-6">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.16em] text-primary">{t('shop.products_eyebrow')}</div>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-foreground">{t('shop.products_title')}</h2>
                    </div>
                    <Link href="/products" class="theme-link hidden items-center gap-2 text-sm sm:inline-flex">
                        {t('common.browse_all_products')}
                        <ArrowRight class="size-4" />
                    </Link>
                </div>

                {#if products.length > 0}
                    <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-3">
                        {#each products as product}
                            <ProductCard {product} />
                        {/each}
                    </div>
                {:else}
                    <div class="theme-panel p-8 text-center">
                        <MessageCircleMore class="mx-auto size-10 text-primary" />
                        <h3 class="mt-4 text-xl font-semibold text-foreground">{t('shop.coming_title')}</h3>
                        <p class="mt-2 text-sm text-muted-foreground">
                            {t('shop.coming_text')}
                        </p>
                    </div>
                {/if}
            </div>
        </div>
    </section>
</PublicLayout>
