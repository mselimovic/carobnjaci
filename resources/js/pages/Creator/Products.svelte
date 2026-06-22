<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('creator.nav_products'), href: '/creator/products' },
    ];

    const items = [
        { title: 'Moonlit Keepsake Box', status: 'Featured', price: '78 EUR', updated: '2 days ago' },
        { title: 'Handbuilt Lavender Cup', status: 'Active', price: 'Contact for price', updated: 'Today' },
        { title: 'Star Thread Earrings', status: 'Draft refresh', price: '34 EUR', updated: '5 days ago' },
        { title: 'Botanical Wall Print', status: 'Active', price: '46 EUR', updated: 'Yesterday' },
    ];
</script>

<AppHead title={t('creator.nav_products')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <div class="inline-flex rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                        {t('creator.products_badge')}
                    </div>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#24183d]">{t('creator.products_title')}</h1>
                    <p class="mt-3 max-w-3xl text-sm leading-7 text-[#5d5470]">
                        {t('creator.products_text')}
                    </p>
                </div>
                <div class="rounded-xl bg-[#5603AD] px-5 py-3 text-sm font-semibold text-white">
                    {t('creator.add_product')}
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-[#d5e8d8] bg-white p-0 overflow-hidden">
            <table class="min-w-full divide-y divide-[#eef5ef] text-sm">
                <thead class="bg-[#f0fff1] text-left text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">
                    <tr>
                        <th class="px-5 py-4">{t('creator.table_product')}</th>
                        <th class="px-5 py-4">{t('creator.table_status')}</th>
                        <th class="px-5 py-4">{t('creator.table_price')}</th>
                        <th class="px-5 py-4">{t('creator.table_updated')}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef5ef] text-[#24183d]">
                    {#each items as item}
                        <tr>
                            <td class="px-5 py-4 font-medium">{item.title}</td>
                            <td class="px-5 py-4 text-[#5d5470]">{item.status}</td>
                            <td class="px-5 py-4 text-[#5d5470]">{item.price}</td>
                            <td class="px-5 py-4 text-[#5d5470]">{item.updated}</td>
                        </tr>
                    {/each}
                </tbody>
            </table>
        </section>
    </div>
</AppLayout>
