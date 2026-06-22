<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import { t } from '@/lib/i18n';

    const locales = $derived(
        (($page.props.locales as { code: string; label: string }[] | undefined) ?? []),
    );
    const currentLocale = $derived(($page.props.locale as string | undefined) ?? 'en');
</script>

<div class="flex items-center gap-1 text-xs font-semibold uppercase tracking-[0.14em] text-[#5d5470]">
    <span class="mr-1 hidden sm:inline">{t('languages.switch')}</span>
    {#each locales as item}
        <Link
            href={`/language/${item.code}`}
            class={`rounded-full px-2.5 py-1 transition-colors ${
                item.code === currentLocale
                    ? 'bg-[#5603AD] text-white'
                    : 'bg-[#f0fff1] text-[#24183d] hover:bg-[#dff5e3]'
            }`}
        >
            {item.code.toUpperCase()}
        </Link>
    {/each}
</div>
