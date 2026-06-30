<script lang="ts">
    import { Form, Link, page } from '@inertiajs/svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { t } from '@/lib/i18n';
    import { login, register } from '@/routes';
    import { toUrl } from '@/lib/utils';

    let {
        sellerName,
        contextLabel = 'product',
        shopId,
        productId = null,
        subject = '',
        sellerUserId = null,
    }: {
        sellerName: string;
        contextLabel?: string;
        shopId: number;
        productId?: number | null;
        subject?: string;
        sellerUserId?: number | null;
    } = $props();

    const auth = $derived($page.props.auth);
    const flash = $derived($page.props.flash as { success?: string } | undefined);
    const isOwner = $derived(Boolean(auth.user && sellerUserId && auth.user.id === sellerUserId));
</script>

<div class="theme-panel space-y-4 p-5">
    <div class="space-y-2">
        <h3 class="text-lg font-semibold text-foreground">{t('contact.title')}</h3>
        <p class="text-sm leading-6 text-muted-foreground">
            {#if auth.user}
                {t('contact.signed_in', { sellerName, contextLabel: t(`contact.${contextLabel}`) })}
            {:else}
                {t('contact.guest', { sellerName })}
            {/if}
        </p>
    </div>

    {#if auth.user && !isOwner}
        <Form action="/messages" method="post" class="space-y-4">
            {#snippet children({ errors, processing, recentlySuccessful })}
                <input type="hidden" name="shop_id" value={shopId} />
                {#if productId}
                    <input type="hidden" name="product_id" value={productId} />
                {/if}

                <div class="grid gap-2">
                    <Label for={`subject-${shopId}-${productId ?? 'shop'}`}>{t('contact.subject')}</Label>
                    <Input
                        id={`subject-${shopId}-${productId ?? 'shop'}`}
                        name="subject"
                        value={subject}
                        required
                    />
                    <InputError message={errors.subject} />
                </div>

                <div class="grid gap-2">
                    <Label for={`message-${shopId}-${productId ?? 'shop'}`}>{t('contact.message')}</Label>
                    <textarea
                        id={`message-${shopId}-${productId ?? 'shop'}`}
                        name="message"
                        rows="5"
                        required
                        placeholder={t('contact.message_placeholder', { sellerName })}
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
                        {t('contact.success')}
                    </div>
                {/if}

                <Button class="h-12 w-full rounded-lg px-6 text-sm font-semibold" type="submit" disabled={processing}>
                    {t('contact.button', { sellerName })}
                </Button>
            {/snippet}
        </Form>
    {:else if isOwner}
        <div class="rounded-xl border border-border bg-secondary/40 px-4 py-3 text-sm text-muted-foreground">
            {t('contact.owner_notice')}
        </div>
    {:else}
        <div class="flex flex-col gap-3 sm:flex-row">
            <Button
                asChild
                class="h-12 flex-1 rounded-lg px-6 text-sm font-semibold"
            >
                {#snippet children(props)}
                    <Link href={toUrl(login())} {...props}>{t('contact.login_cta')}</Link>
                {/snippet}
            </Button>
            <Button
                asChild
                variant="outline"
                class="h-12 flex-1 rounded-lg bg-secondary px-6 text-sm font-semibold text-foreground hover:bg-secondary/80"
            >
                {#snippet children(props)}
                    <Link href={toUrl(register())} {...props}>{t('contact.register_cta')}</Link>
                {/snippet}
            </Button>
        </div>
    {/if}
</div>
