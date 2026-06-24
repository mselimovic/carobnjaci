<script lang="ts">
    import type { Snippet } from 'svelte';
    import { Link, page } from '@inertiajs/svelte';
    import { Headset, LayoutGrid, MapPin, Menu, Search, Shapes, Store, UserRound } from 'lucide-svelte';
    import BrandMark from '@/components/BrandMark.svelte';
    import LanguageSwitcher from '@/components/LanguageSwitcher.svelte';
    import { Button } from '@/components/ui/button';
    import { t } from '@/lib/i18n';
    import { dashboard, login, register } from '@/routes';
    import { toUrl } from '@/lib/utils';

    let {
        children,
    }: {
        children?: Snippet;
    } = $props();

    let isMobileMenuOpen = $state(false);

    const auth = $derived($page.props.auth);

    const navItems = [
        { href: '/products', label: t('common.products'), icon: LayoutGrid },
        { href: '/shops', label: t('common.shops'), icon: Store },
        { href: '/categories', label: t('common.categories'), icon: Shapes },
    ];
</script>

<div class="min-h-screen bg-background">
    <div class="border-b border-border bg-muted text-sm text-muted-foreground">
        <div class="flex items-center justify-between px-5 py-2.5 lg:px-10 2xl:px-16">
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-2">
                    <MapPin class="size-4 text-primary" />
                    <span>{t('public.topbar_find_creator')}</span>
                </div>
                <div class="hidden items-center gap-2 sm:flex">
                    <Headset class="size-4 text-accent" />
                    <span>{t('public.topbar_support')}</span>
                </div>
            </div>
            <div class="hidden sm:block">{t('public.topbar_notice')}</div>
        </div>
    </div>

    <div class="flex min-h-screen flex-col">
        <header class="border-b border-border bg-card">
            <div class="grid gap-6 px-5 py-5 lg:px-10 xl:grid-cols-[minmax(320px,420px)_minmax(0,1fr)_auto] xl:items-center 2xl:px-16">
                <div class="flex items-center justify-between gap-4">
                    <Link href="/" class="shrink-0">
                        <BrandMark />
                    </Link>
                    <button
                        type="button"
                        class="flex size-11 items-center justify-center rounded-lg border border-border text-foreground xl:hidden"
                        aria-label="Navigation"
                        aria-expanded={isMobileMenuOpen}
                        onclick={() => (isMobileMenuOpen = !isMobileMenuOpen)}
                    >
                        <Menu class="size-5" />
                    </button>
                </div>

                <div class="flex min-w-0 items-center gap-3">
                    <div class="relative flex-1">
                        <Search class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground" />
                        <input
                            type="text"
                            placeholder={t('public.search_placeholder')}
                            class="theme-input h-12 w-full rounded-lg pr-4 pl-10 text-sm"
                        />
                    </div>
                    <Button class="h-12 rounded-lg px-6 text-sm font-semibold">
                        {t('common.search')}
                    </Button>
                </div>

                <div class="hidden items-center justify-end gap-3 md:flex">
                    <LanguageSwitcher />
                    <div class="theme-icon-chip flex size-11 rounded-full">
                        <UserRound class="size-4" />
                    </div>
                        {#if auth.user}
                            <Link
                                href={toUrl(dashboard())}
                                class="text-sm font-semibold text-foreground transition-colors hover:text-primary"
                            >
                                {t('common.dashboard')}
                            </Link>
                        {:else}
                            <Link
                                href={toUrl(login())}
                                class="text-sm font-semibold text-foreground transition-colors hover:text-primary"
                            >
                                {t('common.log_in')}
                            </Link>
                            <Button
                                asChild
                                class="h-12 rounded-lg px-6 text-sm font-semibold"
                            >
                                {#snippet children(props)}
                                    <Link href={toUrl(register())} {...props}>
                                        {t('common.become_creator')}
                                    </Link>
                                {/snippet}
                            </Button>
                        {/if}
                </div>
            </div>
            {#if isMobileMenuOpen}
                <div class="border-t border-border px-5 py-4 md:hidden lg:px-10 2xl:px-16">
                    <div class="flex flex-col gap-4">
                        <LanguageSwitcher />
                        <div class="flex flex-col gap-3">
                            {#if auth.user}
                                <Link
                                    href={toUrl(dashboard())}
                                    class="rounded-lg border border-border bg-card px-4 py-3 text-sm font-semibold text-foreground transition-colors hover:bg-secondary"
                                    onclick={() => (isMobileMenuOpen = false)}
                                >
                                    {t('common.dashboard')}
                                </Link>
                            {:else}
                                <Link
                                    href={toUrl(login())}
                                    class="rounded-lg border border-border bg-card px-4 py-3 text-sm font-semibold text-foreground transition-colors hover:bg-secondary"
                                    onclick={() => (isMobileMenuOpen = false)}
                                >
                                    {t('common.log_in')}
                                </Link>
                                <Button
                                    asChild
                                    class="h-12 rounded-lg px-6 text-sm font-semibold"
                                >
                                    {#snippet children(props)}
                                        <Link href={toUrl(register())} {...props} onclick={() => (isMobileMenuOpen = false)}>
                                            {t('common.become_creator')}
                                        </Link>
                                    {/snippet}
                                </Button>
                            {/if}
                        </div>
                    </div>
                </div>
            {/if}
            <div class="flex items-center gap-1 overflow-x-auto border-t border-border px-5 py-3 lg:px-10 2xl:px-16">
                <Link href="/" class="shrink-0 px-4 py-2 text-sm font-semibold text-primary">{t('common.home')}</Link>
                <Link href="/about" class="shrink-0 px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-primary">{t('common.about')}</Link>
                {#each navItems as item}
                    <Link
                        href={item.href}
                        class="inline-flex shrink-0 items-center gap-2 px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-primary"
                    >
                        <svelte:component this={item.icon} class="size-4" />
                        {item.label}
                    </Link>
                {/each}
            </div>
        </header>

        <main class="flex-1 px-5 py-8 lg:px-10 sm:py-10 2xl:px-16">
            {@render children?.()}
        </main>

        <section class="mt-6 border-t border-border bg-muted px-5 py-14 text-center lg:px-10 2xl:px-16">
            <h2 class="text-3xl font-bold tracking-tight text-foreground">{t('public.newsletter_title')}</h2>
            <p class="mt-3 text-sm text-muted-foreground">
                {t('public.newsletter_text')}
            </p>
            <div class="mx-auto mt-6 flex max-w-xl flex-col gap-3 sm:flex-row">
                <input
                    type="email"
                    placeholder={t('public.newsletter_placeholder')}
                    class="theme-input h-12 flex-1 rounded-lg px-4 text-sm"
                />
                <Button class="h-12 rounded-lg px-6 text-sm font-semibold">
                    {t('common.subscribe')}
                </Button>
            </div>
        </section>

        <footer class="border-t border-border bg-card px-5 py-12 text-sm text-muted-foreground lg:px-10 2xl:px-16">
            <div class="grid gap-10 lg:grid-cols-[1.35fr_repeat(4,minmax(0,1fr))]">
                <div class="space-y-4">
                    <BrandMark compact />
                    <p class="max-w-xs leading-7">
                        {t('public.footer_text')}
                    </p>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-semibold text-foreground">{t('public.footer_shop')}</h3>
                    <div class="space-y-3">
                        {#each $page.props.translations.public.footer_shop_items as item}
                            <div>{item}</div>
                        {/each}
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-semibold text-foreground">{t('public.footer_support')}</h3>
                    <div class="space-y-3">
                        {#each $page.props.translations.public.footer_support_items as item}
                            <div>{item}</div>
                        {/each}
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-semibold text-foreground">{t('public.footer_company')}</h3>
                    <div class="space-y-3">
                        {#each $page.props.translations.public.footer_company_items as item}
                            <div>{item}</div>
                        {/each}
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-semibold text-foreground">{t('public.footer_mvp')}</h3>
                    <div class="space-y-3">
                        {#each $page.props.translations.public.footer_mvp_items as item}
                            <div>{item}</div>
                        {/each}
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
