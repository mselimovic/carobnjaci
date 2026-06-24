<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import PageHeader from '@/components/PageHeader.svelte';
    import ShopCard from '@/components/ShopCard.svelte';
    import { t } from '@/lib/i18n';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
    import type { ShopCardData } from '@/types/marketplace';

    let {
        shops = [],
    }: {
        shops: ShopCardData[];
    } = $props();
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
            {#each shops as shop}
                <ShopCard {shop} />
            {/each}
        </div>
    </section>
</PublicLayout>
