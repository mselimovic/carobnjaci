<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('creator.nav_settings'), href: '/creator/settings' },
    ];
</script>

<AppHead title={t('creator.nav_settings')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
            <div class="inline-flex rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                {t('creator.settings_badge')}
            </div>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#24183d]">{t('creator.settings_title')}</h1>
            <p class="mt-3 max-w-3xl text-sm leading-7 text-[#5d5470]">
                {t('creator.settings_text')}
            </p>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
                <h2 class="text-lg font-semibold text-[#24183d]">{t('creator.shop_rules')}</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">{t('creator.rule_1_title')}</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{t('creator.rule_1_text')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">{t('creator.rule_2_title')}</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{t('creator.rule_2_text')}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
                <h2 class="text-lg font-semibold text-[#24183d]">{t('creator.public_visibility')}</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">{t('creator.visibility_1_title')}</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{t('creator.visibility_1_text')}</div>
                    </div>
                    <div class="rounded-xl border border-[#d5e8d8] p-4">
                        <div class="text-sm font-semibold text-[#24183d]">{t('creator.visibility_2_title')}</div>
                        <div class="mt-1 text-sm text-[#5d5470]">{t('creator.visibility_2_text')}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</AppLayout>
