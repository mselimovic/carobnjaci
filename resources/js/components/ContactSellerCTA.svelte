<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import { Button } from '@/components/ui/button';
    import { t } from '@/lib/i18n';
    import { login, register } from '@/routes';
    import { toUrl } from '@/lib/utils';

    let {
        sellerName,
        contextLabel = 'product',
    }: {
        sellerName: string;
        contextLabel?: string;
    } = $props();

    const auth = $derived($page.props.auth);
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

    {#if auth.user}
        <Button class="h-12 w-full rounded-lg px-6 text-sm font-semibold">
            {t('contact.button', { sellerName })}
        </Button>
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
