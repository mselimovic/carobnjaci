<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import {
        ArrowRight,
        CupSoda,
        Gem,
        MessageCircleMore,
        Palette,
        Shirt,
        Sparkles,
        Store,
        Trees,
        UserRoundPlus,
    } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import PageHeader from '@/components/PageHeader.svelte';
    import ProductCard from '@/components/ProductCard.svelte';
    import ShopCard from '@/components/ShopCard.svelte';
    import { Button } from '@/components/ui/button';
    import { featuredCategories, featuredProducts, featuredShops } from '@/lib/showcase';
    import PublicLayout from '@/layouts/PublicLayout.svelte';
    import { dashboard, login, register } from '@/routes';
    import { toUrl } from '@/lib/utils';

    let {
        canRegister = true,
    }: {
        canRegister: boolean;
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

    const steps = [
        {
            title: 'Discover',
            body: 'Browse warm collections of handmade work instead of scrolling a generic marketplace.',
            icon: Sparkles,
        },
        {
            title: 'Register',
            body: 'Create an account when you want to save favorites or reach out to a creator.',
            icon: UserRoundPlus,
        },
        {
            title: 'Contact creator',
            body: 'Start a direct conversation about custom work, pricing, and availability.',
            icon: MessageCircleMore,
        },
    ];
</script>

<AppHead title="Discover handmade magic">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
</AppHead>

<PublicLayout>
    <section class="grid gap-8 lg:grid-cols-[minmax(0,1.15fr)_minmax(360px,0.85fr)] lg:items-center">
        <div class="space-y-8">
            <div class="inline-flex items-center gap-2 rounded-full border border-white/70 bg-white/75 px-4 py-2 text-sm font-semibold text-[#6C3BFF] shadow-sm backdrop-blur-sm">
                <Sparkles class="size-4" />
                Handmade pieces with a little magic
            </div>

            <div class="max-w-3xl space-y-6">
                <h1 class="text-5xl leading-none font-black tracking-tight text-[#171321] sm:text-6xl lg:text-7xl">
                    Discover handmade magic from local creators.
                </h1>
                <p class="max-w-2xl text-lg leading-8 text-[#6F687A] sm:text-xl">
                    Carobnjaci is a curated digital gallery for makers, artists, and small studios.
                    Explore one-of-a-kind work, meet the people behind it, and contact creators directly.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <Button
                    asChild
                    class="h-[3.25rem] rounded-full bg-[#6C3BFF] px-6 text-base font-semibold text-white shadow-[0_24px_50px_-24px_rgba(108,59,255,0.9)] hover:bg-[#5d33df]"
                >
                    {#snippet children(props)}
                        <Link href="/products" {...props}>
                            Explore products
                            <ArrowRight class="size-4" />
                        </Link>
                    {/snippet}
                </Button>

                {#if auth.user}
                    <Button
                        asChild
                        variant="outline"
                        class="h-[3.25rem] rounded-full border-[#d8cdfb] bg-white/70 px-6 text-base font-semibold text-[#25113F] hover:bg-[#f4efff]"
                    >
                        {#snippet children(props)}
                            <Link href={toUrl(dashboard())} {...props}>Go to dashboard</Link>
                        {/snippet}
                    </Button>
                {:else if canRegister}
                    <Button
                        asChild
                        variant="secondary"
                        class="h-[3.25rem] rounded-full bg-[#f4efff] px-6 text-base font-semibold text-[#6C3BFF] shadow-sm hover:bg-[#ede3ff]"
                    >
                        {#snippet children(props)}
                            <Link href={toUrl(register())} {...props}>Become a creator</Link>
                        {/snippet}
                    </Button>
                {:else}
                    <Button
                        asChild
                        variant="outline"
                        class="h-[3.25rem] rounded-full border-[#d8cdfb] bg-white/70 px-6 text-base font-semibold text-[#25113F] hover:bg-[#f4efff]"
                    >
                        {#snippet children(props)}
                            <Link href={toUrl(login())} {...props}>Log in to join</Link>
                        {/snippet}
                    </Button>
                {/if}
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur-sm">
                    <div class="text-3xl font-black text-[#25113F]">120+</div>
                    <div class="mt-2 text-sm leading-6 text-[#6F687A]">Curated handmade pieces across early collections.</div>
                </div>
                <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur-sm">
                    <div class="text-3xl font-black text-[#25113F]">35</div>
                    <div class="mt-2 text-sm leading-6 text-[#6F687A]">Independent creators from local studios and workshops.</div>
                </div>
                <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-5 shadow-sm backdrop-blur-sm">
                    <div class="text-3xl font-black text-[#25113F]">0</div>
                    <div class="mt-2 text-sm leading-6 text-[#6F687A]">Checkout clutter. Conversation is the main conversion in the MVP.</div>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -top-8 -left-5 h-24 w-24 rounded-full bg-[#eab8ff]/70 blur-2xl"></div>
            <div class="absolute right-2 bottom-12 h-28 w-28 rounded-full bg-[#ffe7b1]/70 blur-2xl"></div>

            <div class="relative grid gap-4 lg:grid-cols-[0.92fr_1.08fr]">
                <div class="space-y-4 lg:pt-10">
                    <div class="rounded-[2rem] border border-white/75 bg-white/80 p-5 shadow-[0_35px_80px_-45px_rgba(37,17,63,0.55)] backdrop-blur-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.3em] text-[#6f687a]">Featured creator</div>
                                <div class="mt-1 text-xl font-bold text-[#171321]">Atelier Luma</div>
                            </div>
                            <div class="flex size-12 items-center justify-center rounded-full bg-[#25113F] text-white">
                                <Store class="size-5" />
                            </div>
                        </div>
                        <div class="rounded-[1.5rem] bg-gradient-to-br from-[#6C3BFF] to-[#25113F] p-5 text-white">
                            <div class="text-sm text-white/75">Sarajevo workshop</div>
                            <div class="mt-2 text-lg font-semibold leading-7">
                                Carved keepsake boxes, candle holders, and small home rituals.
                            </div>
                        </div>
                    </div>
                    <div class="rounded-[2rem] border border-white/75 bg-[#fff9f0]/90 p-5 shadow-[0_35px_80px_-45px_rgba(37,17,63,0.55)] backdrop-blur-sm">
                        <div class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#6f687a]">Why it feels different</div>
                        <div class="text-lg font-bold text-[#171321]">Large imagery, calm spacing, and warm discovery over crowded commerce.</div>
                    </div>
                </div>
                <div class="rounded-[2.2rem] border border-white/80 bg-white/85 p-4 shadow-[0_40px_100px_-50px_rgba(37,17,63,0.6)] backdrop-blur-sm">
                    <ProductCard product={featuredProducts[0]} />
                </div>
            </div>
        </div>
    </section>

    <section class="mt-24 space-y-8">
        <PageHeader
            eyebrow="Featured categories"
            title="Browse by craft, material, and mood."
            description="The first experience should feel like wandering through a thoughtful gallery, not a crowded catalog."
        />

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            {#each featuredCategories as category}
                <article class="rounded-[1.75rem] border border-white/70 bg-white/80 p-6 shadow-[0_24px_60px_-40px_rgba(37,17,63,0.4)] backdrop-blur-sm transition-transform duration-300 hover:-translate-y-1.5">
                    <div class="mb-5 flex size-14 items-center justify-center rounded-[1.2rem] bg-[#f4efff] text-[#6C3BFF]">
                        <svelte:component this={categoryIcons[category.icon as keyof typeof categoryIcons]} class="size-6" />
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-xl font-bold tracking-tight text-[#171321]">
                                {category.name}
                            </h3>
                            <span class="rounded-full bg-[#fff9f0] px-3 py-1 text-xs font-semibold text-[#6C3BFF]">
                                {category.countLabel}
                            </span>
                        </div>
                        <p class="text-sm leading-6 text-[#6F687A]">
                            {category.description}
                        </p>
                    </div>
                </article>
            {/each}
        </div>
    </section>

    <section class="mt-24 space-y-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <PageHeader
                eyebrow="Featured products"
                title="Image-first pieces that invite conversation."
                description="The MVP centers around discovery and connection, so every card is built to spotlight craft and make contacting the creator feel natural."
            />
            <Link
                href="/products"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#6C3BFF] transition-colors hover:text-[#25113F]"
            >
                Browse all products
                <ArrowRight class="size-4" />
            </Link>
        </div>

        <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
            {#each featuredProducts as product}
                <ProductCard {product} />
            {/each}
        </div>
    </section>

    <section class="mt-24 space-y-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <PageHeader
                eyebrow="Featured creators"
                title="Small studios with personality, story, and local texture."
                description="Vendor pages should feel closer to artist profiles than generic storefronts."
            />
            <Link
                href="/shops"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#6C3BFF] transition-colors hover:text-[#25113F]"
            >
                Explore creators
                <ArrowRight class="size-4" />
            </Link>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            {#each featuredShops as shop}
                <ShopCard {shop} />
            {/each}
        </div>
    </section>

    <section class="mt-24 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="rounded-[2rem] border border-white/75 bg-[#25113F] p-8 text-white shadow-[0_35px_90px_-50px_rgba(37,17,63,0.85)]">
            <div class="mb-3 text-sm font-semibold uppercase tracking-[0.3em] text-white/65">
                How it works
            </div>
            <h2 class="max-w-md text-3xl font-black tracking-tight">
                Discover, register, and contact the creator directly.
            </h2>
            <p class="mt-4 max-w-lg text-base leading-7 text-white/75">
                No checkout maze in the MVP. The goal is to make finding the right maker feel easy and personal.
            </p>
        </div>
        <div class="grid gap-4 md:grid-cols-3">
            {#each steps as step, index}
                <article class="rounded-[1.75rem] border border-white/70 bg-white/85 p-6 shadow-[0_24px_60px_-40px_rgba(37,17,63,0.45)] backdrop-blur-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex size-12 items-center justify-center rounded-[1rem] bg-[#f4efff] text-[#6C3BFF]">
                            <svelte:component this={step.icon} class="size-5" />
                        </div>
                        <div class="text-sm font-semibold text-[#b3a7cc]">0{index + 1}</div>
                    </div>
                    <h3 class="text-xl font-bold tracking-tight text-[#171321]">{step.title}</h3>
                    <p class="mt-3 text-sm leading-6 text-[#6F687A]">{step.body}</p>
                </article>
            {/each}
        </div>
    </section>

    <section class="mt-24">
        <div class="relative overflow-hidden rounded-[2.4rem] border border-white/70 bg-[linear-gradient(135deg,#25113F_0%,#6C3BFF_55%,#9874FF_100%)] px-8 py-10 text-white shadow-[0_40px_100px_-55px_rgba(37,17,63,0.95)] sm:px-10 lg:px-12 lg:py-12">
            <div class="absolute top-0 right-0 h-40 w-40 rounded-full bg-white/15 blur-3xl"></div>
            <div class="absolute bottom-0 left-16 h-32 w-32 rounded-full bg-[#ffeec2]/20 blur-3xl"></div>
            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-3 text-sm font-semibold uppercase tracking-[0.3em] text-white/70">
                        For creators
                    </div>
                    <h2 class="text-3xl font-black tracking-tight sm:text-4xl">
                        Open your shop and let your work speak before commerce takes over.
                    </h2>
                    <p class="mt-4 text-base leading-7 text-white/78">
                        Build a profile, upload products, and start receiving messages from people who truly want what you make.
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    {#if canRegister && !auth.user}
                        <Button
                            asChild
                            class="h-[3.25rem] rounded-full bg-white px-6 text-base font-semibold text-[#25113F] hover:bg-[#f4efff]"
                        >
                            {#snippet children(props)}
                                <Link href={toUrl(register())} {...props}>Become a creator</Link>
                            {/snippet}
                        </Button>
                    {/if}
                    <Button
                        asChild
                        variant="outline"
                        class="h-[3.25rem] rounded-full border-white/35 bg-white/10 px-6 text-base font-semibold text-white hover:bg-white/15"
                    >
                        {#snippet children(props)}
                            <Link href="/shops" {...props}>See creator pages</Link>
                        {/snippet}
                    </Button>
                </div>
            </div>
        </div>
    </section>
</PublicLayout>
