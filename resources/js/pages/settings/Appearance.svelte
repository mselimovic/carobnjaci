<script lang="ts">
    import AppearanceTabs from '@/components/AppearanceTabs.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import Heading from '@/components/Heading.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import SettingsLayout from '@/layouts/settings/Layout.svelte';
    import { edit as editAppearance } from '@/routes/appearance';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbItems: BreadcrumbItem[] = [
        {
            title: t('settings.appearance_page'),
            href: editAppearance(),
        },
    ];
</script>

<AppHead title={t('settings.appearance_page')} />

<AppLayout breadcrumbs={breadcrumbItems}>
    <h1 class="sr-only">{t('settings.appearance_page')}</h1>

    <SettingsLayout>
        <div class="space-y-6">
            <Heading
                variant="small"
                title={t('settings.appearance_page')}
                description={t('settings.appearance_text')}
            />
            <AppearanceTabs />
        </div>
    </SettingsLayout>
</AppLayout>
