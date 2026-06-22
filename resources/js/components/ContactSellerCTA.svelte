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

<div class="space-y-4 border border-[#d5e8d8] bg-white p-5">
    <div class="space-y-2">
        <h3 class="text-lg font-semibold text-[#24183d]">{t('contact.title')}</h3>
        <p class="text-sm leading-6 text-[#5d5470]">
            {#if auth.user}
                {t('contact.signed_in', { sellerName, contextLabel: t(`contact.${contextLabel}`) })}
            {:else}
                {t('contact.guest', { sellerName })}
            {/if}
        </p>
    </div>

    {#if auth.user}
        <Button class="h-12 w-full rounded-lg bg-[#5603AD] px-6 text-sm font-semibold text-white hover:bg-[#46038d]">
            {t('contact.button', { sellerName })}
        </Button>
    {:else}
        <div class="flex flex-col gap-3 sm:flex-row">
            <Button
                asChild
                class="h-12 flex-1 rounded-lg bg-[#5603AD] px-6 text-sm font-semibold text-white hover:bg-[#46038d]"
            >
                {#snippet children(props)}
                    <Link href={toUrl(login())} {...props}>{t('contact.login_cta')}</Link>
                {/snippet}
            </Button>
            <Button
                asChild
                variant="outline"
                class="h-12 flex-1 rounded-lg border-[#d5e8d8] bg-[#f0fff1] px-6 text-sm font-semibold text-[#24183d] hover:bg-[#e7faea]"
            >
                {#snippet children(props)}
                    <Link href={toUrl(register())} {...props}>{t('contact.register_cta')}</Link>
                {/snippet}
            </Button>
        </div>
    {/if}
</div>
