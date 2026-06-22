<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { ArrowRight, MapPin, MessageCircleMore } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import ContactSellerCTA from '@/components/ContactSellerCTA.svelte';
    import ProductCard from '@/components/ProductCard.svelte';
    import { t } from '@/lib/i18n';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
    import { featuredShops, getFeaturedShop, getProductsForShop } from '@/lib/showcase';

    let {
        slug,
    }: {
        slug: string;
    } = $props();

    const shop = $derived(getFeaturedShop(slug) ?? featuredShops[0]);
    const products = $derived(getProductsForShop(shop.slug));
</script>

<AppHead title={shop.name} />

<PublicLayout>
    <section class="space-y-10">
        <div class="overflow-hidden border border-[#d5e8d8] bg-white">
            <img src={shop.coverImage} alt={shop.name} class="aspect-[16/5] w-full object-cover" />
            <div class="grid gap-6 px-6 py-6 lg:grid-cols-[auto_1fr_auto] lg:items-end lg:px-8">
                <div class="-mt-20">
                    <img src={shop.logo} alt={shop.name} class="h-28 w-28 rounded-2xl border-4 border-white bg-white object-cover shadow-sm" />
                </div>
                <div class="space-y-3">
                    <div class="inline-flex rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                        {shop.specialty}
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight text-[#24183d]">{shop.name}</h1>
                        <div class="mt-2 flex items-center gap-2 text-sm text-[#5d5470]">
                            <MapPin class="size-4 text-[#8367C7]" />
                            {shop.city}
                        </div>
                    </div>
                    <p class="max-w-3xl text-sm leading-7 text-[#5d5470]">{shop.bio}</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                    {#each shop.highlightBadges as badge}
                        <div class="border border-[#d5e8d8] bg-[#f0fff1] px-4 py-3 text-sm font-semibold text-[#24183d]">
                            {badge}
                        </div>
                    {/each}
                </div>
            </div>
        </div>

        <div class="grid gap-8 xl:grid-cols-[0.72fr_1.28fr]">
            <div class="space-y-5">
                <div class="border border-[#d5e8d8] bg-white p-5">
                    <h2 class="text-xl font-semibold text-[#24183d]">{t('shop.details')}</h2>
                    <div class="mt-5 space-y-4">
                        {#each shop.highlights as highlight}
                            <div class="border-b border-[#eef5ef] pb-4 last:border-b-0 last:pb-0">
                                <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{highlight.label}</div>
                                <div class="mt-1 text-sm text-[#24183d]">{highlight.value}</div>
                            </div>
                        {/each}
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-1">
                    <div class="border border-[#d5e8d8] bg-white p-5">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('shop.response_time')}</div>
                        <div class="mt-2 text-sm text-[#24183d]">{shop.responseTime}</div>
                    </div>
                    <div class="border border-[#d5e8d8] bg-white p-5">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('shop.studio_info')}</div>
                        <div class="mt-2 text-sm text-[#24183d]">{shop.since}</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{shop.productCount}</div>
                    </div>
                </div>

                <ContactSellerCTA sellerName={shop.name} contextLabel="shop" />
            </div>

            <div class="space-y-6">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8367C7]">{t('shop.products_eyebrow')}</div>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-[#24183d]">{t('shop.products_title')}</h2>
                    </div>
                    <Link href="/products" class="hidden items-center gap-2 text-sm font-semibold text-[#5603AD] sm:inline-flex">
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
                    <div class="border border-[#d5e8d8] bg-white p-8 text-center">
                        <MessageCircleMore class="mx-auto size-10 text-[#8367C7]" />
                        <h3 class="mt-4 text-xl font-semibold text-[#24183d]">{t('shop.coming_title')}</h3>
                        <p class="mt-2 text-sm text-[#5d5470]">
                            {t('shop.coming_text')}
                        </p>
                    </div>
                {/if}
            </div>
        </div>
    </section>
</PublicLayout>
