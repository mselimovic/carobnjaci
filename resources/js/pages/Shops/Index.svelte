<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import PageHeader from '@/components/PageHeader.svelte';
    import ShopCard from '@/components/ShopCard.svelte';
    import { t } from '@/lib/i18n';
    import { featuredShops } from '@/lib/showcase';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
</script>

<AppHead title={t('common.shops')} />

<PublicLayout>
    <section class="space-y-8">
        <PageHeader
            eyebrow={t('listings.shops_eyebrow')}
            title={t('listings.shops_title')}
            description={t('listings.shops_text')}
        />

        <div class="grid gap-6 xl:grid-cols-3">
            {#each featuredShops as shop}
                <ShopCard {shop} />
            {/each}
        </div>
    </section>
</PublicLayout>
