<script lang="ts">
    let {
        compact = false,
    }: {
        compact?: boolean;
    } = $props();
</script>

<div class="flex shrink-0 items-center overflow-hidden">
    <img
        src="/brand/logo.png"
        alt="Carobnjaci"
        class={compact
            ? 'h-14 w-auto max-w-[180px] object-contain sm:h-16 sm:max-w-[220px]'
            : 'h-20 w-auto max-w-[260px] object-contain sm:h-24 sm:max-w-[320px] xl:h-28 xl:max-w-[380px]'}
    />
</div>
