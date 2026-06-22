<script lang="ts">
    import {
        BadgeCheck,
        FolderOpen,
        Headphones,
        Users,
    } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { t } from '@/lib/i18n';
    import PublicLayout from '@/layouts/PublicLayout.svelte';

    const featureCards = [
        {
            title: t('about.feature_1_title'),
            body: t('about.feature_1_text'),
            icon: BadgeCheck,
        },
        {
            title: t('about.feature_2_title'),
            body: t('about.feature_2_text'),
            icon: Users,
        },
        {
            title: t('about.feature_3_title'),
            body: t('about.feature_3_text'),
            icon: FolderOpen,
        },
        {
            title: t('about.feature_4_title'),
            body: t('about.feature_4_text'),
            icon: Headphones,
        },
    ];

    const stats = [
        { value: '232', label: t('about.stats.creator_leads') },
        { value: '521', label: t('about.stats.products_planned') },
        { value: '1453', label: t('about.stats.supportive_visits') },
        { value: '32', label: t('about.stats.early_makers') },
    ];
</script>

<AppHead title={t('common.about')} />

<PublicLayout>
    <section class="grid gap-8 2xl:grid-cols-[0.92fr_1.08fr]">
        <div class="space-y-5">
            <div class="inline-flex rounded-full border border-[#c9e8cf] bg-white px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#5603AD]">
                {t('about.eyebrow')}
            </div>
            <h1 class="text-4xl font-bold tracking-tight text-[#24183d] lg:text-5xl 2xl:text-6xl">
                {t('about.title')}
            </h1>
            <p class="text-sm leading-7 text-[#5d5470]">
                {t('about.text_1')}
            </p>
            <p class="text-sm leading-7 text-[#5d5470]">
                {t('about.text_2')}
            </p>
        </div>

        <div class="overflow-hidden border border-[#d5e8d8] bg-white">
            <img
                src="/placeholders/about-studio.avif"
                alt="Creative studio workspace"
                class="aspect-[16/10] h-full w-full object-cover"
            />
        </div>
    </section>

    <section class="mt-10 grid gap-4 md:grid-cols-3 xl:grid-cols-4">
        {#each featureCards as card}
            <article class="border border-[#d5e8d8] bg-white p-5">
                <div class="mb-4 flex size-10 items-center justify-center rounded-lg bg-[#f0fff1] text-[#5603AD]">
                    <svelte:component this={card.icon} class="size-5" />
                </div>
                <h2 class="text-base font-semibold text-[#24183d]">{card.title}</h2>
                <p class="mt-3 text-sm leading-6 text-[#5d5470]">{card.body}</p>
            </article>
        {/each}
    </section>

    <section class="mt-10 grid gap-4 md:grid-cols-2">
        {#each stats as stat}
            <article class="border border-[#d5e8d8] bg-white p-6">
                <div class="text-3xl font-bold text-[#24183d]">{stat.value}</div>
                <div class="mt-2 text-sm text-[#5d5470]">{stat.label}</div>
            </article>
        {/each}
    </section>

    <section class="mt-10 grid gap-4 lg:grid-cols-3">
        <article class="border border-[#d5e8d8] bg-white p-4">
            <img src="/placeholders/card-paper.jpg" alt="Paper handmade craft" class="aspect-[4/3] w-full object-cover" />
            <div class="mt-4 text-sm leading-6 text-[#5d5470]">
                {t('about.gallery_1')}
            </div>
        </article>
        <article class="border border-[#d5e8d8] bg-white p-4">
            <img src="/placeholders/card-pompoms.jpg" alt="Colorful handmade craft" class="aspect-[4/3] w-full object-cover" />
            <div class="mt-4 text-sm leading-6 text-[#5d5470]">
                {t('about.gallery_2')}
            </div>
        </article>
        <article class="border border-[#d5e8d8] bg-white p-4">
            <img src="/placeholders/card-tree.jpg" alt="Artwork" class="aspect-[4/3] w-full object-cover" />
            <div class="mt-4 text-sm leading-6 text-[#5d5470]">
                {t('about.gallery_3')}
            </div>
        </article>
    </section>
</PublicLayout>
