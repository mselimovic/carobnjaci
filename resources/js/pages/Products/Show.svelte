<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { ArrowRight, Clock3, MapPin, Store } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import ContactSellerCTA from '@/components/ContactSellerCTA.svelte';
    import ProductCard from '@/components/ProductCard.svelte';
    import { t } from '@/lib/i18n';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
    import { featuredProducts, getFeaturedProduct, getFeaturedShop } from '@/lib/showcase';

    let {
        slug,
    }: {
        slug: string;
    } = $props();

    const product = $derived(getFeaturedProduct(slug) ?? featuredProducts[0]);
    const shop = $derived(getFeaturedShop(product.shopSlug) ?? null);
    const relatedProducts = $derived(
        featuredProducts.filter((item) => product.relatedSlugs.includes(item.slug)),
    );
</script>

<AppHead title={product.title} />

<PublicLayout>
    <section class="space-y-10">
        <div class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]">
            <div class="space-y-4">
                <div class="overflow-hidden border border-[#d5e8d8] bg-white">
                    <img src={product.gallery[0]} alt={product.title} class="aspect-[4/3] w-full object-cover" />
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    {#each product.gallery.slice(1) as image}
                        <div class="overflow-hidden border border-[#d5e8d8] bg-white">
                            <img src={image} alt={product.title} class="aspect-[4/3] w-full object-cover" />
                        </div>
                    {/each}
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-3">
                    <div class="inline-flex rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                        {product.category}
                    </div>
                    <h1 class="text-4xl font-bold tracking-tight text-[#24183d] lg:text-5xl">
                        {product.title}
                    </h1>
                    <p class="text-lg text-[#5603AD]">{product.priceLabel}</p>
                    <p class="max-w-2xl text-base leading-8 text-[#5d5470]">
                        {product.shortDescription}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="border border-[#d5e8d8] bg-white p-4">
                        <div class="flex items-center gap-2 text-sm font-semibold text-[#24183d]">
                            <Store class="size-4 text-[#8367C7]" />
                            {t('product.shop')}
                        </div>
                        <div class="mt-2 text-sm text-[#5d5470]">{shop?.name ?? product.shop}</div>
                    </div>
                    <div class="border border-[#d5e8d8] bg-white p-4">
                        <div class="flex items-center gap-2 text-sm font-semibold text-[#24183d]">
                            <Clock3 class="size-4 text-[#8367C7]" />
                            {t('product.lead_time')}
                        </div>
                        <div class="mt-2 text-sm text-[#5d5470]">{product.leadTime}</div>
                    </div>
                    <div class="border border-[#d5e8d8] bg-white p-4">
                        <div class="flex items-center gap-2 text-sm font-semibold text-[#24183d]">
                            <MapPin class="size-4 text-[#8367C7]" />
                            {t('product.location')}
                        </div>
                        <div class="mt-2 text-sm text-[#5d5470]">{product.location}</div>
                    </div>
                </div>

                <div class="space-y-4 border border-[#d5e8d8] bg-white p-6">
                    <h2 class="text-xl font-semibold text-[#24183d]">{t('product.about_piece')}</h2>
                    <p class="text-sm leading-7 text-[#5d5470]">{product.description}</p>
                    <div>
                        <div class="text-sm font-semibold text-[#24183d]">{t('product.materials')}</div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            {#each product.materials as material}
                                <span class="rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold text-[#5603AD]">
                                    {material}
                                </span>
                            {/each}
                        </div>
                    </div>
                </div>

                <ContactSellerCTA sellerName={shop?.name ?? product.shop} />

                {#if shop}
                    <div class="border border-[#d5e8d8] bg-white p-5">
                        <div class="flex items-center gap-4">
                            <img src={shop.logo} alt={shop.name} class="h-16 w-16 rounded-xl border border-[#d5e8d8] bg-white object-cover" />
                            <div class="space-y-1">
                                <div class="text-lg font-semibold text-[#24183d]">{shop.name}</div>
                                <div class="text-sm text-[#5d5470]">{shop.city}</div>
                            </div>
                        </div>
                        <p class="mt-4 text-sm leading-7 text-[#5d5470]">{shop.description}</p>
                        <Link href={`/shops/${shop.slug}`} class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#5603AD]">
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
                    <div class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8367C7]">{t('product.related_eyebrow')}</div>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-[#24183d]">{t('product.related_title')}</h2>
                </div>
                <Link href="/products" class="hidden items-center gap-2 text-sm font-semibold text-[#5603AD] sm:inline-flex">
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
