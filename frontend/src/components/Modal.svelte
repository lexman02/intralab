<script>
    import {sineIn} from "svelte/easing";
    import {fade} from "svelte/transition";

    export let showModal = false;
</script>

{#if showModal}
    <div transition:fade={{ duration: 150, easing: sineIn }}
         class="fixed inset-0 z-10 overflow-y-auto"
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-10 text-center sm:block sm:p-0">
            <div on:click={() => showModal = false}
                 class="fixed inset-0 transition-all transform"
            >
                <div class="absolute inset-0 bg-gray-950/80"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block w-full sm:max-w-md md:max-w-xl lg:max-w-2xl align-bottom bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full"
                 aria-modal="true">
                <slot/>
            </div>
        </div>
    </div>
{/if}