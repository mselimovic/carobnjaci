<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { Heart } from 'lucide-svelte';
    import { t } from '@/lib/i18n';
    import type { FeaturedProduct } from '@/lib/showcase';

    let {
        product,
    }: {
        product: FeaturedProduct;
    } = $props();
</script>

<article
    class="group overflow-hidden rounded-lg border border-[#d5e8d8] bg-white transition-colors duration-200 hover:border-[#b3e9c7]"
>
    <div class="relative aspect-[4/4.25] overflow-hidden bg-[#f0fff1]">
        <Link href={`/products/${product.slug}`} class="block h-full">
            <img
                src={product.image}
                alt={product.title}
                class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-[1.02]"
            />
        </Link>
        <div class="absolute inset-x-4 top-4 flex items-center justify-between">
            <span class="rounded-full border border-[#c9e8cf] bg-white px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                {product.category}
            </span>
            <button
                type="button"
                class="flex size-9 items-center justify-center rounded-full border border-[#d5e8d8] bg-white text-[#5d5470]"
                aria-label={t('common.products')}
            >
                <Heart class="size-4" />
            </button>
        </div>
    </div>
    <div class="space-y-3 px-4 py-4">
        <div class="space-y-1">
            <div class="text-[0.7rem] font-medium uppercase tracking-[0.12em] text-[#8c84a1]">
                {t('cards.featured_item')}
            </div>
            <h3 class="text-[1.05rem] font-semibold tracking-tight text-[#24183d]">
                <Link href={`/products/${product.slug}`} class="transition-colors hover:text-[#5603AD]">
                    {product.title}
                </Link>
            </h3>
            <div class="text-sm text-[#5d5470]">
                {t('cards.by')} <Link href={`/shops/${product.shopSlug}`} class="transition-colors hover:text-[#5603AD]">{product.shop}</Link>
            </div>
        </div>
        <div class="flex items-center justify-between border-t border-[#eef5ef] pt-3">
            <div class="font-semibold text-[#5603AD]">{product.priceLabel}</div>
            <div class={`h-2.5 w-2.5 rounded-full ${product.accent}`}></div>
        </div>
    </div>
</article>
