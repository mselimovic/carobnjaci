<script lang="ts">
    import { Badge } from '@/components/ui/badge';

    let {
        eyebrow,
        title,
        description,
    }: {
        eyebrow: string;
        title: string;
        description: string;
    } = $props();
</script>

<div class="max-w-2xl space-y-4">
    <Badge class="bg-white px-4 py-1 text-[0.7rem] font-semibold uppercase tracking-[0.28em] text-[#5603AD] shadow-sm">
        {eyebrow}
    </Badge>
    <div class="space-y-3">
        <h1 class="text-4xl font-bold tracking-tight text-[#24183d] sm:text-5xl">
            {title}
        </h1>
        <p class="text-base leading-7 text-[#5d5470] sm:text-lg">
            {description}
        </p>
    </div>
</div>
