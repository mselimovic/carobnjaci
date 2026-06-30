<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
    import type { CreatorMessageRow } from '@/types/marketplace';

    let {
        threads = [],
    }: {
        threads: CreatorMessageRow[];
    } = $props();
</script>

<AppHead title={t('inbox.page_title')} />

<PublicLayout>
    <section class="space-y-8">
        <div class="theme-panel rounded-2xl p-6">
            <div class="theme-pill-soft">{t('inbox.badge')}</div>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground">{t('inbox.page_title')}</h1>
            <p class="mt-3 max-w-3xl text-sm leading-7 text-muted-foreground">{t('inbox.page_text')}</p>
        </div>

        <div class="grid gap-4">
            {#if threads.length > 0}
                {#each threads as thread}
                    <article class="theme-panel rounded-2xl p-5">
                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                            <div>
                                <div class="flex items-center gap-3">
                                    <div class="text-lg font-semibold text-foreground">{thread.subject}</div>
                                    {#if thread.unread}
                                        <span class="rounded-full bg-primary/10 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-primary">
                                            {t('creator.messages_new')}
                                        </span>
                                    {/if}
                                </div>
                                <div class="mt-1 text-sm text-primary">{t('inbox.with_label')} {thread.buyer}</div>
                                {#if thread.productTitle}
                                    <div class="mt-1 text-xs uppercase tracking-[0.14em] text-muted-foreground">
                                        {t('creator.messages_about')} {thread.productTitle}
                                    </div>
                                {/if}
                                <p class="mt-3 text-sm leading-7 text-muted-foreground">{thread.excerpt}</p>
                            </div>
                            <div class="flex flex-col items-start gap-3 md:items-end">
                                <div class="theme-pill-soft tracking-[0.14em]">{thread.state}</div>
                                <Link href={`/messages/${thread.id}`} class="theme-link text-sm">
                                    {t('inbox.open_thread')}
                                </Link>
                            </div>
                        </div>
                    </article>
                {/each}
            {:else}
                <div class="theme-panel rounded-2xl p-8 text-center text-sm text-muted-foreground">
                    {t('inbox.empty')}
                </div>
            {/if}
        </div>
    </section>
</PublicLayout>
