<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { CreatorMessageRow } from '@/types/marketplace';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('creator.nav_messages'), href: '/creator/messages' },
    ];

    let {
        threads = [],
    }: {
        threads: CreatorMessageRow[];
    } = $props();
</script>

<AppHead title={t('creator.nav_messages')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="theme-panel rounded-2xl p-6">
            <div class="theme-pill-soft">
                {t('creator.messages_badge')}
            </div>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground">{t('creator.messages_title')}</h1>
            <p class="mt-3 max-w-3xl text-sm leading-7 text-muted-foreground">
                {t('creator.messages_text')}
            </p>
        </section>

        <section class="grid gap-4">
            {#each threads as thread}
                <article class="theme-panel rounded-2xl p-5">
                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <div class="text-lg font-semibold text-foreground">{thread.subject}</div>
                            <div class="mt-1 text-sm text-primary">{t('creator.from_label')} {thread.buyer}</div>
                            <p class="mt-3 text-sm leading-7 text-muted-foreground">{thread.excerpt}</p>
                        </div>
                        <div class="theme-pill-soft tracking-[0.14em]">
                            {thread.state}
                        </div>
                    </div>
                </article>
            {/each}
        </section>
    </div>
</AppLayout>
