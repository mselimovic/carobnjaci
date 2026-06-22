<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import PageHeader from '@/components/PageHeader.svelte';
    import ProductCard from '@/components/ProductCard.svelte';
    import { t } from '@/lib/i18n';
    import { featuredProducts } from '@/lib/showcase';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
</script>

<AppHead title={t('common.products')} />

<PublicLayout>
    <section class="space-y-8">
        <PageHeader
            eyebrow={t('listings.products_eyebrow')}
            title={t('listings.products_title')}
            description={t('listings.products_text')}
        />

        <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
            {#each featuredProducts as product}
                <ProductCard {product} />
            {/each}
        </div>
    </section>
</PublicLayout>
