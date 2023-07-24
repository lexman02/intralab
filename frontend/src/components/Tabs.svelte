<script>
    export let items;
    export let activeTabValue = 1;
</script>

<!--<ul>-->
<!--    {#each items as item}-->
<!--        <li class={activeTabValue === item.value ? 'active' : ''}>-->
<!--            <span on:click={handleClick(item.value)}>{item.label}</span>-->
<!--        </li>-->
<!--    {/each}-->
<!--</ul>-->
<!--{#each items as item}-->
<!--    {#if activeTabValue == item.value}-->
<!--        <div class="box">-->
<!--            <svelte:component this={item.component}/>-->
<!--        </div>-->
<!--    {/if}-->
<!--{/each}-->


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
<!--            <template x-for="radio in radios">-->
<!--                <label :for="radio.id"-->
<!--                       class="block transition ease-in-out duration-200 px-4 py-1 rounded-full cursor-pointer text-white/50 hover:bg-gray-800/50 hover:text-white mr-1"-->
<!--                       :class="selectedTab === radio.value ? 'bg-gray-800 text-white': ''">-->
<!--                    <input type="radio" class="hidden" :id="radio.id" :value="radio.value" :name="name"-->
<!--                           x-model="selectedTab" @click="document.getElementById(radio.value).reset()"/>-->
<!--                    <div x-text="radio.label"></div>-->
<!--                </label>-->
<!--            </template>-->
        </div>
    </div>
    <!--{#each items as item}-->
    <!--    {#if activeTabValue === item.value}-->
    <!--        <slot/>-->
    <!--    {/if}-->
    <!--{/each}-->
    <slot/>
</div>