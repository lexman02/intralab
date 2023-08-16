<script>
    export let onClick
</script>

<button on:click|preventDefault={onClick}
        type="button"
        class="absolute top-0 right-0 mr-3 mt-3 bg-gray-950/40 rounded-full p-2 inline-flex items-center justify-center text-gray-400/60 hover:text-gray-400/80 hover:bg-gray-950/20 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-950/50">
    <span class="sr-only">Close menu</span>
    <!-- Heroicon name: outline/x -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
    </svg>
</button>