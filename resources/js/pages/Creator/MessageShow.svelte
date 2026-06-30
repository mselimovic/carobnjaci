<script lang="ts">
    import { Form, Link, page } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { t } from '@/lib/i18n';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import type { CreatorMessageDetail } from '@/types/marketplace';
    import type { BreadcrumbItem } from '@/types';

    let {
        message,
    }: {
        message: CreatorMessageDetail;
    } = $props();

    const breadcrumbs = $derived.by<BreadcrumbItem[]>(() => [
        { title: t('common.dashboard'), href: '/dashboard' },
        { title: t('creator.nav_messages'), href: '/creator/messages' },
        { title: message.subject, href: `/creator/messages/${message.id}` },
    ]);
    const flash = $derived($page.props.flash as { success?: string } | undefined);
</script>

<AppHead title={message.subject} />

<AppLayout {breadcrumbs}>
    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <section class="theme-panel rounded-2xl p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <div class="theme-pill-soft">{message.state}</div>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-foreground">{message.subject}</h1>
                    <div class="mt-3 text-sm text-primary">{t('creator.from_label')} {message.buyer}</div>
                    <div class="mt-1 text-sm text-muted-foreground">{message.buyerEmail}</div>
                    {#if message.createdAt}
                        <div class="mt-1 text-xs uppercase tracking-[0.14em] text-muted-foreground">{message.createdAt}</div>
                    {/if}
                </div>
                <div class="flex items-center gap-3">
                    <Form action={`/creator/messages/${message.id}/close`} method="post">
                        {#snippet children({ processing })}
                            <Button type="submit" variant="outline" disabled={processing}>{t('creator.close_conversation')}</Button>
                        {/snippet}
                    </Form>
                    <Link href="/creator/messages" class="theme-link text-sm">
                        {t('creator.back_to_messages')}
                    </Link>
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[0.78fr_1.22fr]">
            <div class="space-y-6">
                <div class="theme-panel rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-foreground">{t('creator.message_context')}</h2>
                    <div class="mt-5 space-y-4 text-sm text-muted-foreground">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.message_sender')}</div>
                            <div class="mt-1 text-foreground">{message.buyer}</div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.message_email')}</div>
                            <div class="mt-1 text-foreground">{message.buyerEmail}</div>
                        </div>
                        {#if message.productTitle}
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{t('creator.messages_about_label')}</div>
                            <div class="mt-1 text-foreground">{message.productTitle}</div>
                        </div>
                    {/if}
                        {#if message.productSlug}
                            <div>
                                <Link href={`/products/${message.productSlug}`} class="theme-link">
                                    {t('creator.view_product')}
                                </Link>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="theme-panel rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-foreground">{t('creator.conversation_title')}</h2>
                    <div class="mt-5 space-y-4">
                        {#each message.messages as item}
                            <div class={`max-w-3xl rounded-2xl border px-5 py-4 text-sm leading-7 ${item.fromCurrentUser ? 'ml-auto border-primary/30 bg-primary/8 text-foreground' : 'border-border bg-secondary/40 text-foreground'}`}>
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <div class="text-xs font-semibold uppercase tracking-[0.14em] text-primary">{item.senderName}</div>
                                    <div class="text-xs text-muted-foreground">{item.createdAt}</div>
                                </div>
                                <div class="whitespace-pre-wrap">{item.body}</div>
                            </div>
                        {/each}
                    </div>
                </div>

                <div class="theme-panel rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-foreground">{t('creator.reply_title')}</h2>
                    <p class="mt-2 text-sm text-muted-foreground">{t('creator.reply_text')}</p>

                    <Form action={`/creator/messages/${message.id}/reply`} method="post" class="mt-5 space-y-4">
                        {#snippet children({ errors, processing, recentlySuccessful })}
                            <div class="grid gap-2">
                                <textarea
                                    name="message"
                                    rows="5"
                                    required
                                    placeholder={t('creator.reply_placeholder')}
                                    class="min-h-32 rounded-xl border border-input bg-background px-4 py-3 text-sm text-foreground outline-none placeholder:text-muted-foreground focus:border-ring"
                                ></textarea>
                                <InputError message={errors.message} />
                            </div>

                            {#if flash?.success}
                                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                                    {flash.success}
                                </div>
                            {/if}

                            {#if recentlySuccessful}
                                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                                    {t('creator.reply_success')}
                                </div>
                            {/if}

                            <Button type="submit" disabled={processing}>{t('creator.send_reply')}</Button>
                        {/snippet}
                    </Form>
                </div>
            </div>
        </section>
    </div>
</AppLayout>
