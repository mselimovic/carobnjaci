<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('creator.nav_shop'), href: '/creator/shop' },
    ];
</script>

<AppHead title={t('creator.nav_shop')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
            <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                <div class="max-w-3xl">
                    <div class="inline-flex rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                        {t('creator.shop_badge')}
                    </div>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#24183d]">{t('creator.shop_title')}</h1>
                    <p class="mt-4 text-sm leading-7 text-[#5d5470]">
                        {t('creator.shop_text')}
                    </p>
                </div>
                <div class="grid w-full gap-4 sm:grid-cols-3 xl:max-w-xl">
                    <div class="rounded-xl border border-[#d5e8d8] bg-[#f0fff1] p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('creator.profile_strength')}</div>
                        <div class="mt-2 text-2xl font-bold text-[#24183d]">82%</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] bg-[#f0fff1] p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('creator.public_status')}</div>
                        <div class="mt-2 text-2xl font-bold text-[#24183d]">{t('creator.visible')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] bg-[#f0fff1] p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8367C7]">{t('creator.response_time')}</div>
                        <div class="mt-2 text-2xl font-bold text-[#24183d]">&lt; 1 day</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
            <div class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
                <h2 class="text-lg font-semibold text-[#24183d]">{t('creator.shop_details_title')}</h2>
                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">{t('creator.shop_detail_1_title')}</div>
                        <div class="mt-2 text-sm text-[#5d5470]">{t('creator.shop_detail_1_text')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">{t('creator.shop_detail_2_title')}</div>
                        <div class="mt-2 text-sm text-[#5d5470]">{t('creator.shop_detail_2_text')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">{t('creator.shop_detail_3_title')}</div>
                        <div class="mt-2 text-sm text-[#5d5470]">{t('creator.shop_detail_3_text')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">{t('creator.shop_detail_4_title')}</div>
                        <div class="mt-2 text-sm text-[#5d5470]">{t('creator.shop_detail_4_text')}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
                <h2 class="text-lg font-semibold text-[#24183d]">{t('creator.shop_tasks_title')}</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">Upload a studio cover image</div>
                        <div class="mt-1 text-sm text-[#5d5470]">A good cover immediately makes the shop page feel more premium.</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">Write a longer maker bio</div>
                        <div class="mt-1 text-sm text-[#5d5470]">Tell buyers how your products are made and who they are for.</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">Add fulfillment notes</div>
                        <div class="mt-1 text-sm text-[#5d5470]">Pickup, custom requests, timing, and gift packaging are all useful.</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</AppLayout>
