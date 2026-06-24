<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { Heart } from 'lucide-svelte';
    import { t } from '@/lib/i18n';
    import type { ProductCardData } from '@/types/marketplace';

    let {
        product,
    }: {
        product: ProductCardData;
    } = $props();
</script>

<article
    class="theme-panel group overflow-hidden rounded-lg transition-colors duration-200 hover:border-primary/30"
>
    <div class="relative aspect-[4/4.25] overflow-hidden bg-background">
        <Link href={`/products/${product.slug}`} class="block h-full">
            <img
                src={product.image}
                alt={product.title}
                class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-[1.02]"
            />
        </Link>
        <div class="absolute inset-x-4 top-4 flex items-center justify-between">
            <span class="rounded-full border border-border bg-card px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.16em] text-primary">
                {product.category}
            </span>
            <button
                type="button"
                class="theme-icon-chip flex size-9 rounded-full"
                aria-label={t('common.products')}
            >
                <Heart class="size-4" />
            </button>
        </div>
    </div>
    <div class="space-y-3 px-4 py-4">
        <div class="space-y-1">
            <div class="text-[0.7rem] font-medium uppercase tracking-[0.12em] text-muted-foreground">
                {t('cards.featured_item')}
            </div>
            <h3 class="text-[1.05rem] font-semibold tracking-tight text-foreground">
                <Link href={`/products/${product.slug}`} class="transition-colors hover:text-primary">
                    {product.title}
                </Link>
            </h3>
            <div class="text-sm text-muted-foreground">
                {t('cards.by')} <Link href={`/shops/${product.shopSlug}`} class="transition-colors hover:text-primary">{product.shop}</Link>
            </div>
        </div>
        <div class="flex items-center justify-between border-t border-border pt-3">
            <div class="font-semibold text-primary">{product.priceLabel}</div>
            <div class={`h-2.5 w-2.5 rounded-full ${product.accent}`}></div>
        </div>
    </div>
</article>
