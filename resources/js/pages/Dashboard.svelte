<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { dashboard } from '@/routes';
    import type { CreatorCatalogRow, CreatorMessageRow, CreatorPriority } from '@/types/marketplace';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: t('common.dashboard'),
            href: dashboard(),
        },
    ];

    let {
        stats,
        priorities = [],
        recentConversations = [],
        catalogSnapshot = [],
    }: {
        stats: {
            activeProducts: number;
            unreadMessages: number;
            profileCompletion: number;
            responseTime: string;
        };
        priorities: CreatorPriority[];
        recentConversations: CreatorMessageRow[];
        catalogSnapshot: CreatorCatalogRow[];
    } = $props();
</script>

<AppHead title={t('common.dashboard')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
            <div class="theme-panel rounded-2xl p-6">
                <div class="theme-pill-soft">
                    {t('creator.dashboard_badge')}
                </div>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground md:text-4xl">
                    {t('creator.dashboard_title')}
                </h1>
                <p class="mt-4 max-w-3xl text-sm leading-7 text-muted-foreground">
                    {t('creator.dashboard_text')}
                </p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="theme-panel-soft rounded-xl p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.active_products')}</div>
                        <div class="mt-2 text-3xl font-bold text-foreground">{stats.activeProducts}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{t('creator.active_products_note')}</div>
                    </div>
                    <div class="theme-panel-soft rounded-xl p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.unread_messages')}</div>
                        <div class="mt-2 text-3xl font-bold text-foreground">{stats.unreadMessages}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{t('creator.unread_messages_note')}</div>
                    </div>
                    <div class="theme-panel-soft rounded-xl p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.profile_completion')}</div>
                        <div class="mt-2 text-3xl font-bold text-foreground">{stats.profileCompletion}%</div>
                        <div class="mt-1 text-sm text-muted-foreground">{t('creator.profile_completion_note')}</div>
                    </div>
                    <div class="theme-panel-soft rounded-xl p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.response_time')}</div>
                        <div class="mt-2 text-3xl font-bold text-foreground">{stats.responseTime}</div>
                        <div class="mt-1 text-sm text-muted-foreground">{t('creator.response_time_note')}</div>
                    </div>
                </div>
            </div>

            <div class="theme-panel rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-foreground">{t('creator.priorities')}</h2>
                <div class="mt-5 space-y-4">
                    {#each priorities as priority}
                        <div class="rounded-xl border border-border p-4">
                            <div class="text-sm font-semibold text-foreground">{priority.title}</div>
                            <div class="mt-1 text-sm text-muted-foreground">{priority.text}</div>
                        </div>
                    {/each}
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <div class="theme-panel rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-foreground">{t('creator.recent_conversations')}</h2>
                <div class="mt-5 space-y-4">
                    {#each recentConversations as conversation}
                        <div class="rounded-xl border border-border p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-sm font-semibold text-foreground">{conversation.subject}</div>
                                <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{conversation.state}</div>
                            </div>
                            <div class="mt-1 text-xs text-muted-foreground">{conversation.buyer}</div>
                            <div class="mt-2 text-sm text-muted-foreground">{conversation.excerpt}</div>
                        </div>
                    {/each}
                </div>
            </div>

            <div class="theme-panel rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-foreground">{t('creator.catalog_snapshot')}</h2>
                <div class="mt-5 overflow-hidden rounded-xl border border-border">
                    <table class="min-w-full divide-y divide-border text-sm">
                        <thead class="bg-secondary text-left text-xs font-semibold uppercase tracking-[0.14em] text-primary">
                            <tr>
                                <th class="px-4 py-3">{t('creator.table_product')}</th>
                                <th class="px-4 py-3">{t('creator.table_status')}</th>
                                <th class="px-4 py-3">{t('creator.table_price')}</th>
                                <th class="px-4 py-3">{t('creator.table_interest')}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-foreground">
                            {#each catalogSnapshot as item}
                                <tr>
                                    <td class="px-4 py-3 font-medium">{item.title}</td>
                                    <td class="px-4 py-3 text-muted-foreground">{item.status}</td>
                                    <td class="px-4 py-3 text-muted-foreground">{item.price}</td>
                                    <td class="px-4 py-3 text-muted-foreground">{item.interest}</td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</AppLayout>
