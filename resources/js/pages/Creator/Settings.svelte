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
        <section class="theme-panel rounded-2xl p-6">
            <div class="theme-pill-soft">
                {t('creator.settings_badge')}
            </div>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground">{t('creator.settings_title')}</h1>
            <p class="mt-3 max-w-3xl text-sm leading-7 text-muted-foreground">
                {t('creator.settings_text')}
            </p>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <div class="theme-panel rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-foreground">{t('creator.shop_rules')}</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-xl border border-border p-4">
                        <div class="text-sm font-semibold text-foreground">{t('creator.rule_1_title')}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{t('creator.rule_1_text')}</div>
                    </div>
                    <div class="rounded-xl border border-border p-4">
                        <div class="text-sm font-semibold text-foreground">{t('creator.rule_2_title')}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{t('creator.rule_2_text')}</div>
                    </div>
                </div>
            </div>

            <div class="theme-panel rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-foreground">{t('creator.public_visibility')}</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-xl border border-border p-4">
                        <div class="text-sm font-semibold text-foreground">{t('creator.visibility_1_title')}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{t('creator.visibility_1_text')}</div>
                    </div>
                    <div class="rounded-xl border border-border p-4">
                        <div class="text-sm font-semibold text-foreground">{t('creator.visibility_2_title')}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{t('creator.visibility_2_text')}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</AppLayout>
