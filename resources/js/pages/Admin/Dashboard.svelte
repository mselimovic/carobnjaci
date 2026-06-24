<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
    ];

    let {
        stats = [],
        queues = { shops: [], products: [] },
    }: {
        stats: Array<{ label: string; value: number; note: string }>;
        queues: {
            shops: Array<{ title: string; meta: string }>;
            products: Array<{ title: string; meta: string }>;
        };
    } = $props();
</script>

<AppHead title={t('common.dashboard')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="theme-panel rounded-2xl p-6">
            <div class="theme-pill-soft">{t('admin.badge')}</div>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground md:text-4xl">{t('admin.dashboard_title')}</h1>
            <p class="mt-4 max-w-3xl text-sm leading-7 text-muted-foreground">{t('admin.dashboard_text')}</p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                {#each stats as stat}
                    <div class="theme-panel-soft rounded-xl p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{stat.label}</div>
                        <div class="mt-2 text-3xl font-bold text-foreground">{stat.value}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{stat.note}</div>
                    </div>
                {/each}
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <div class="theme-panel rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-foreground">{t('admin.queue_shops')}</h2>
                <div class="mt-5 space-y-4">
                    {#each queues.shops as item}
                        <div class="rounded-xl border border-border p-4">
                            <div class="text-sm font-semibold text-foreground">{item.title}</div>
                            <div class="mt-1 text-sm text-muted-foreground">{item.meta}</div>
                        </div>
                    {/each}
                </div>
            </div>

            <div class="theme-panel rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-foreground">{t('admin.queue_products')}</h2>
                <div class="mt-5 space-y-4">
                    {#each queues.products as item}
                        <div class="rounded-xl border border-border p-4">
                            <div class="text-sm font-semibold text-foreground">{item.title}</div>
                            <div class="mt-1 text-sm text-muted-foreground">{item.meta}</div>
                        </div>
                    {/each}
                </div>
            </div>
        </section>
    </div>
</AppLayout>
