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
            ? 'h-16 w-auto max-w-[200px] object-contain sm:h-18 sm:max-w-[240px]'
            : 'h-22 w-auto max-w-[290px] object-contain sm:h-26 sm:max-w-[360px] xl:h-30 xl:max-w-[420px]'}
    />
</div>
