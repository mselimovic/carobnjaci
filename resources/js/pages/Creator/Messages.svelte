<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { BreadcrumbItem } from '@/types';

    const breadcrumbs: BreadcrumbItem[] = [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('creator.nav_messages'), href: '/creator/messages' },
    ];

    const threads = [
        { subject: 'Custom engraving request', buyer: 'Lejla H.', state: 'New', excerpt: 'Can you add initials to the keepsake box before gifting?' },
        { subject: 'Pickup on Saturday', buyer: 'Adnan R.', state: 'Replied', excerpt: 'I am local to Sarajevo and wanted to ask about pickup.' },
        { subject: 'Gift note included?', buyer: 'Mina K.', state: 'Waiting', excerpt: 'Could you include a short handwritten card with the order?' },
    ];
</script>

<AppHead title={t('creator.nav_messages')} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="rounded-2xl border border-[#d5e8d8] bg-white p-6">
            <div class="inline-flex rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                {t('creator.messages_badge')}
            </div>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#24183d]">{t('creator.messages_title')}</h1>
            <p class="mt-3 max-w-3xl text-sm leading-7 text-[#5d5470]">
                {t('creator.messages_text')}
            </p>
        </section>

        <section class="grid gap-4">
            {#each threads as thread}
                <article class="rounded-2xl border border-[#d5e8d8] bg-white p-5">
                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <div class="text-lg font-semibold text-[#24183d]">{thread.subject}</div>
                            <div class="mt-1 text-sm text-[#8367C7]">From {thread.buyer}</div>
                            <p class="mt-3 text-sm leading-7 text-[#5d5470]">{thread.excerpt}</p>
                        </div>
                        <div class="inline-flex rounded-full border border-[#c9e8cf] bg-[#f0fff1] px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-[#5603AD]">
                            {thread.state}
                        </div>
                    </div>
                </article>
            {/each}
        </section>
    </div>
</AppLayout>
