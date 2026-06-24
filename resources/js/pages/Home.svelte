<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import {
        ArrowRight,
        CheckCircle2,
        CupSoda,
        Gem,
        Palette,
        ShieldCheck,
        Shirt,
        Sparkles,
        Trees,
        Truck,
    } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import ProductCard from '@/components/ProductCard.svelte';
    import ShopCard from '@/components/ShopCard.svelte';
    import { Button } from '@/components/ui/button';
    import { t } from '@/lib/i18n';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
    import { dashboard, login, register } from '@/routes';
    import type { CategoryCard, ProductCardData, ShopCardData } from '@/types/marketplace';
    import { toUrl } from '@/lib/utils';

    let {
        canRegister = true,
        featuredCategories = [],
        featuredProducts = [],
        featuredShops = [],
    }: {
        canRegister: boolean;
        featuredCategories: CategoryCard[];
        featuredProducts: ProductCardData[];
        featuredShops: ShopCardData[];
    } = $props();

    const auth = $derived($page.props.auth);

    const categoryIcons = {
        Gem,
        Trees,
        CupSoda,
        Palette,
        Sparkles,
        Shirt,
    } as const;

    const trustItems = [
        { label: t('home.trust_curated'), icon: ShieldCheck },
        { label: t('home.trust_contact'), icon: CheckCircle2 },
        { label: t('home.trust_handmade'), icon: Truck },
    ];
</script>

<AppHead title={t('home.title')}>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
</AppHead>

<PublicLayout>
    <section class="grid gap-6 xl:grid-cols-[minmax(0,1.02fr)_minmax(420px,0.98fr)]">
        <div class="theme-panel flex items-center p-8 lg:min-h-[30rem] lg:p-12 2xl:min-h-[34rem]">
            <div class="max-w-2xl space-y-6">
                <div class="theme-pill-soft items-center gap-2 tracking-[0.18em]">
                    {t('home.eyebrow')}
                </div>
                <div class="space-y-4">
                    <h1 class="text-5xl leading-[1.02] font-bold tracking-tight text-foreground lg:text-6xl 2xl:text-7xl">
                        {t('home.title')}
                    </h1>
                    <p class="max-w-2xl text-base leading-8 text-muted-foreground">
                        {t('home.description')}
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <Button asChild class="h-12 rounded-lg px-6 text-sm font-semibold">
                        {#snippet children(props)}
                            <Link href="/products" {...props}>
                                {t('home.browse_items')}
                                <ArrowRight class="size-4" />
                            </Link>
                        {/snippet}
                    </Button>
                    {#if auth.user}
                        <Button asChild variant="outline" class="h-12 rounded-lg px-6 text-sm font-semibold">
                            {#snippet children(props)}
                                <Link href={toUrl(dashboard())} {...props}>{t('home.open_dashboard')}</Link>
                            {/snippet}
                        </Button>
                    {:else if canRegister}
                        <Button asChild variant="outline" class="h-12 rounded-lg px-6 text-sm font-semibold">
                            {#snippet children(props)}
                                <Link href={toUrl(register())} {...props}>{t('common.become_creator')}</Link>
                            {/snippet}
                        </Button>
                    {:else}
                        <Button asChild variant="outline" class="h-12 rounded-lg px-6 text-sm font-semibold">
                            {#snippet children(props)}
                                <Link href={toUrl(login())} {...props}>{t('common.log_in')}</Link>
                            {/snippet}
                        </Button>
                    {/if}
                </div>
                <div class="flex flex-wrap gap-5 pt-2 text-sm text-muted-foreground">
                    {#each trustItems as item}
                        <div class="flex items-center gap-2">
                            <svelte:component this={item.icon} class="size-4 text-accent" />
                            {item.label}
                        </div>
                    {/each}
                </div>
            </div>
        </div>

        <div class="grid content-start gap-4 lg:min-h-[30rem] lg:grid-cols-2 2xl:min-h-[34rem]">
            <div class="theme-panel">
                <div class="border-b border-border px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-primary">
                    {t('home.best_seller')}
                </div>
                <div class="p-4">
                    <ProductCard product={featuredProducts[0]} />
                </div>
            </div>
            <div class="theme-panel">
                <div class="border-b border-border px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-primary">
                    {t('home.trending_now')}
                </div>
                <div class="p-4">
                    <ProductCard product={featuredProducts[1]} />
                </div>
            </div>
            <div class="theme-panel lg:col-span-2">
                <div class="grid gap-4 p-4 lg:grid-cols-[220px_1fr] lg:items-center">
                    <img
                        src="/placeholders/hero-handmade.jpg"
                        alt="Handmade workbench"
                        class="aspect-[4/3] h-full w-full rounded-lg object-cover"
                    />
                    <div class="space-y-3">
                        <div class="text-xs font-semibold uppercase tracking-[0.16em] text-primary">
                            {t('home.just_launched')}
                        </div>
                        <h2 class="text-2xl font-semibold tracking-tight text-foreground">
                            {t('home.launch_title')}
                        </h2>
                        <p class="max-w-2xl text-sm leading-7 text-muted-foreground">
                            {t('home.launch_text')}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12 space-y-6 pb-6">
        <div class="flex items-end justify-between gap-4">
            <div>
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-accent">{t('home.categories_eyebrow')}</div>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-foreground">{t('home.categories_title')}</h2>
            </div>
            <Link href="/categories" class="theme-link hidden items-center gap-2 text-sm sm:inline-flex">
                {t('home.see_all_categories')}
                <ArrowRight class="size-4" />
            </Link>
        </div>

        <div class="grid items-start gap-4 sm:grid-cols-2 xl:grid-cols-4">
            {#each featuredCategories.slice(0, 4) as category}
                <article class="theme-panel flex h-full flex-col p-4">
                    <img
                        src={featuredProducts[Math.min(featuredCategories.indexOf(category), featuredProducts.length - 1)].image}
                        alt={category.name}
                        class="aspect-[4/3] w-full object-cover"
                    />
                    <div class="mt-4 flex flex-1 flex-col space-y-2">
                        <div class="flex items-center gap-2 text-accent">
                            <svelte:component this={categoryIcons[category.icon as keyof typeof categoryIcons]} class="size-4" />
                            <span class="text-xs font-semibold uppercase tracking-[0.14em]">{category.countLabel}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-foreground">{category.name}</h3>
                        <p class="flex-1 text-sm leading-6 text-muted-foreground">{category.description}</p>
                        <Link href="/categories" class="theme-link inline-flex items-center gap-2 pt-1 text-sm">
                            {t('common.view_all')}
                            <ArrowRight class="size-4" />
                        </Link>
                    </div>
                </article>
            {/each}
        </div>
    </section>

    <section class="mt-8 space-y-8 pt-8">
        <div class="text-center">
            <div class="text-4xl font-bold tracking-tight text-foreground">{t('home.best_sellers_title')}</div>
            <div class="mx-auto mt-4 h-0.5 w-24 bg-primary"></div>
            <p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-muted-foreground">
                {t('home.best_sellers_text')}
            </p>
        </div>

        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
            {#each featuredProducts as product}
                <ProductCard {product} />
            {/each}
        </div>
    </section>

    <section class="mt-20 grid gap-8 2xl:grid-cols-[1.15fr_0.85fr]">
        <div class="theme-panel overflow-hidden">
            <img
                src="/placeholders/about-studio.avif"
                alt="Creative studio"
                class="aspect-[16/8] h-full w-full object-cover"
            />
        </div>
        <div class="theme-panel p-6 lg:p-8">
            <div class="theme-pill-soft">
                {t('home.season_eyebrow')}
            </div>
            <h2 class="mt-6 text-4xl font-bold tracking-tight text-foreground">
                {t('home.season_title')}
            </h2>
            <p class="mt-5 text-sm leading-7 text-muted-foreground">
                {t('home.season_text')}
            </p>
            <div class="mt-6 space-y-3 text-sm text-muted-foreground">
                {#each $page.props.translations.home.season_points as point}
                    <div class="flex items-center gap-2">
                        <CheckCircle2 class="size-4 text-accent" />
                        {point}
                    </div>
                {/each}
            </div>
            <Button asChild class="mt-8 h-12 rounded-lg px-6 text-sm font-semibold">
                {#snippet children(props)}
                    <Link href="/shops" {...props}>
                        {t('common.explore_creators')}
                        <ArrowRight class="size-4" />
                    </Link>
                {/snippet}
            </Button>
        </div>
    </section>

    <section class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        {#each featuredShops as shop}
            <ShopCard {shop} />
        {/each}
    </section>

    <section class="mt-20 grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="space-y-5">
            <div class="theme-pill-soft">
                {t('home.about_eyebrow')}
            </div>
            <h2 class="text-4xl font-bold tracking-tight text-foreground">
                {t('home.about_title')}
            </h2>
            <p class="text-sm leading-7 text-muted-foreground">
                {t('home.about_text_1')}
            </p>
            <p class="text-sm leading-7 text-muted-foreground">
                {t('home.about_text_2')}
            </p>
            <Button asChild variant="outline" class="h-12 rounded-lg px-6 text-sm font-semibold">
                {#snippet children(props)}
                    <Link href="/about" {...props}>
                        {t('common.read_more_about_us')}
                        <ArrowRight class="size-4" />
                    </Link>
                {/snippet}
            </Button>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="theme-panel p-4">
                <img src="/placeholders/card-paper.jpg" alt="Handmade paper card" class="aspect-[4/3] w-full object-cover" />
                <div class="mt-4 text-sm leading-6 text-muted-foreground">
                    {t('home.paper_caption')}
                </div>
            </div>
            <div class="theme-panel p-4">
                <img src="/placeholders/card-portrait.jpg" alt="Portrait art" class="aspect-[4/3] w-full object-cover" />
                <div class="mt-4 text-sm leading-6 text-muted-foreground">
                    {t('home.portrait_caption')}
                </div>
            </div>
        </div>
    </section>
</PublicLayout>
