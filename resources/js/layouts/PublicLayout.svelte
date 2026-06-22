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

    const auth = $derived($page.props.auth);

    const navItems = [
        { href: '/products', label: t('common.products'), icon: LayoutGrid },
        { href: '/shops', label: t('common.shops'), icon: Store },
        { href: '/categories', label: t('common.categories'), icon: Shapes },
    ];
</script>

<div class="min-h-screen bg-[#F0FFF1]">
    <div class="border-b border-[#d5e8d8] bg-[#eefcf0] text-sm text-[#5d5470]">
        <div class="flex items-center justify-between px-5 py-2.5 lg:px-10 2xl:px-16">
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-2">
                    <MapPin class="size-4 text-[#5603AD]" />
                    <span>{t('public.topbar_find_creator')}</span>
                </div>
                <div class="hidden items-center gap-2 sm:flex">
                    <Headset class="size-4 text-[#8367C7]" />
                    <span>{t('public.topbar_support')}</span>
                </div>
            </div>
            <div class="hidden sm:block">{t('public.topbar_notice')}</div>
        </div>
    </div>

    <div class="flex min-h-screen flex-col">
        <header class="border-b border-[#d5e8d8] bg-white">
            <div class="grid gap-5 px-5 py-5 lg:px-10 xl:grid-cols-[minmax(280px,360px)_minmax(0,1fr)_auto] xl:items-center 2xl:px-16">
                <div class="flex items-center justify-between gap-4">
                    <Link href="/" class="shrink-0">
                        <BrandMark />
                    </Link>
                    <button
                        type="button"
                        class="flex size-11 items-center justify-center rounded-lg border border-[#d5e8d8] text-[#24183d] xl:hidden"
                        aria-label="Navigation"
                    >
                        <Menu class="size-5" />
                    </button>
                </div>

                <div class="flex min-w-0 items-center gap-3">
                    <div class="relative flex-1">
                        <Search class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-[#7d7395]" />
                        <input
                            type="text"
                            placeholder={t('public.search_placeholder')}
                            class="h-12 w-full rounded-lg border border-[#d5e8d8] bg-[#F0FFF1] pr-4 pl-10 text-sm text-[#24183d] placeholder:text-[#8c84a1] focus:border-[#8367C7] focus:outline-none"
                        />
                    </div>
                    <Button class="h-12 rounded-lg bg-[#5603AD] px-6 text-sm font-semibold text-white hover:bg-[#46038d]">
                        {t('common.search')}
                    </Button>
                </div>

                <div class="hidden items-center justify-end gap-3 md:flex">
                    <LanguageSwitcher />
                    <div class="flex size-11 items-center justify-center rounded-full border border-[#d5e8d8] bg-[#F0FFF1] text-[#5d5470]">
                        <UserRound class="size-4" />
                    </div>
                        {#if auth.user}
                            <Link
                                href={toUrl(dashboard())}
                                class="text-sm font-semibold text-[#24183d] transition-colors hover:text-[#5603AD]"
                            >
                                {t('common.dashboard')}
                            </Link>
                        {:else}
                            <Link
                                href={toUrl(login())}
                                class="text-sm font-semibold text-[#24183d] transition-colors hover:text-[#5603AD]"
                            >
                                {t('common.log_in')}
                            </Link>
                            <Button
                                asChild
                                class="h-12 rounded-lg bg-[#5603AD] px-6 text-sm font-semibold text-white hover:bg-[#46038d]"
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
            <div class="flex items-center gap-1 overflow-x-auto border-t border-[#edf5ee] px-5 py-3 lg:px-10 2xl:px-16">
                <Link href="/" class="shrink-0 px-4 py-2 text-sm font-semibold text-[#5603AD]">{t('common.home')}</Link>
                <Link href="/about" class="shrink-0 px-4 py-2 text-sm font-medium text-[#5d5470] transition-colors hover:text-[#5603AD]">{t('common.about')}</Link>
                {#each navItems as item}
                    <Link
                        href={item.href}
                        class="inline-flex shrink-0 items-center gap-2 px-4 py-2 text-sm font-medium text-[#5d5470] transition-colors hover:text-[#5603AD]"
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

        <section class="mt-6 border-t border-[#d5e8d8] bg-[#eefcf0] px-5 py-14 text-center lg:px-10 2xl:px-16">
            <h2 class="text-3xl font-bold tracking-tight text-[#24183d]">{t('public.newsletter_title')}</h2>
            <p class="mt-3 text-sm text-[#5d5470]">
                {t('public.newsletter_text')}
            </p>
            <div class="mx-auto mt-6 flex max-w-xl flex-col gap-3 sm:flex-row">
                <input
                    type="email"
                    placeholder={t('public.newsletter_placeholder')}
                    class="h-12 flex-1 rounded-lg border border-[#d5e8d8] bg-white px-4 text-sm text-[#24183d] placeholder:text-[#8c84a1] focus:border-[#8367C7] focus:outline-none"
                />
                <Button class="h-12 rounded-lg bg-[#5603AD] px-6 text-sm font-semibold text-white hover:bg-[#46038d]">
                    {t('common.subscribe')}
                </Button>
            </div>
        </section>

        <footer class="border-t border-[#d5e8d8] bg-white px-5 py-12 text-sm text-[#5d5470] lg:px-10 2xl:px-16">
            <div class="grid gap-10 lg:grid-cols-[1.35fr_repeat(4,minmax(0,1fr))]">
                <div class="space-y-4">
                    <BrandMark compact />
                    <p class="max-w-xs leading-7">
                        {t('public.footer_text')}
                    </p>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-semibold text-[#24183d]">{t('public.footer_shop')}</h3>
                    <div class="space-y-3">
                        {#each $page.props.translations.public.footer_shop_items as item}
                            <div>{item}</div>
                        {/each}
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-semibold text-[#24183d]">{t('public.footer_support')}</h3>
                    <div class="space-y-3">
                        {#each $page.props.translations.public.footer_support_items as item}
                            <div>{item}</div>
                        {/each}
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-semibold text-[#24183d]">{t('public.footer_company')}</h3>
                    <div class="space-y-3">
                        {#each $page.props.translations.public.footer_company_items as item}
                            <div>{item}</div>
                        {/each}
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-semibold text-[#24183d]">{t('public.footer_mvp')}</h3>
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
