<script lang="ts">
    import { CupSoda, Gem, Palette, Shirt, Sparkles, Trees } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import PageHeader from '@/components/PageHeader.svelte';
    import { t } from '@/lib/i18n';
    import { featuredCategories } from '@/lib/showcase';
    import PublicLayout from '@/layouts/PublicLayout.svelte';

    const iconMap = {
        Gem,
        Trees,
        CupSoda,
        Palette,
        Sparkles,
        Shirt,
    } as const;
</script>

<AppHead title={t('common.categories')} />

<PublicLayout>
    <section class="space-y-8">
        <PageHeader
            eyebrow={t('listings.categories_eyebrow')}
            title={t('listings.categories_title')}
            description={t('listings.categories_text')}
        />

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            {#each featuredCategories as category}
                <article class="rounded-[1.75rem] border border-white/70 bg-white/80 p-6 shadow-[0_24px_60px_-40px_rgba(37,17,63,0.4)] backdrop-blur-sm">
                    <div class="mb-5 flex size-14 items-center justify-center rounded-[1.2rem] bg-[#f4efff] text-[#6C3BFF]">
                        <svelte:component this={iconMap[category.icon as keyof typeof iconMap]} class="size-6" />
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
</PublicLayout>
