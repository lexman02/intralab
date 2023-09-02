<script>
    export let items;
    export let activeTabValue = 1;
</script>

<div class="space-y-4">
    <div class="text-center">
        <div class="inline-flex p-1 pr-0 bg-gray-900 rounded-full overflow-hidden">
            {#each items as item}
                <button type="button"
                        on:click={() => activeTabValue = item.value}
                        class="px-4 py-1 text-sm font-semibold text-white/50 hover:bg-gray-800/50 hover:text-white mr-1 rounded-full cursor-pointer
                        {activeTabValue === item.value ? 'bg-gray-800 text-white': ''}">
                    {item.label}
                </button>
            {/each}
        </div>
    </div>
    <slot/>
</div>