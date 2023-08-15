<script>
    export let title;
</script>

<div class="flex justify-between items-center px-4 md:px-0">
    <h3 class="text-3xl font-extralight text-white/50">{title}</h3>
    <slot></slot>
</div>