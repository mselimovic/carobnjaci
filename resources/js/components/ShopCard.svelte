<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { ArrowUpRight, MapPin } from 'lucide-svelte';
    import type { FeaturedShop } from '@/lib/showcase';

    let {
        shop,
    }: {
        shop: FeaturedShop;
    } = $props();
</script>

<article class="overflow-hidden rounded-lg border border-[#d5e8d8] bg-white transition-colors duration-200 hover:border-[#b3e9c7]">
    <div class="h-36 overflow-hidden bg-[#f0fff1]">
        <Link href={`/shops/${shop.slug}`} class="block h-full">
            <img src={shop.image} alt={shop.name} class="h-full w-full object-cover transition-transform duration-200 hover:scale-[1.02]" />
        </Link>
    </div>
    <div class="relative px-5 pb-5">
        <div class="-mt-8 mb-4 flex items-end justify-between gap-4">
            <div class="flex items-center gap-4">
                <img
                    src={shop.logo}
                    alt={shop.name}
                    class="h-16 w-16 rounded-xl border-4 border-white bg-white object-cover shadow-sm"
                />
                <div>
                    <h3 class="text-xl font-semibold tracking-tight text-[#24183d]">
                        <Link href={`/shops/${shop.slug}`} class="transition-colors hover:text-[#5603AD]">{shop.name}</Link>
                    </h3>
                    <div class="mt-1 flex items-center gap-1 text-sm text-[#5d5470]">
                        <MapPin class="size-4" />
                        {shop.city}
                    </div>
                </div>
            </div>
            <div class="flex size-10 items-center justify-center rounded-full border border-[#d5e8d8] bg-white text-[#5603AD]">
                <ArrowUpRight class="size-5" />
            </div>
        </div>
        <div class="mb-3 inline-flex rounded-full border border-[#c9e8cf] px-3 py-1 text-xs font-semibold text-[#5603AD]">
            {shop.specialty}
        </div>
        <p class="text-sm leading-6 text-[#5d5470]">
            {shop.description}
        </p>
    </div>
</article>
