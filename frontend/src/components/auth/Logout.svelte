<script lang="ts">
    import {authState} from "../../stores/auth.js";

    function handleLogout() {
        authState.set(null);
        window.location.href = '/auth/logout';
    }
</script>

<button on:click|preventDefault={handleLogout}
        class="text-white/50 hover:bg-gray-800 hover:text-white smooth-hover p-4 inline-flex justify-center rounded-md">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-5 w-5 sm:h-6 sm:w-6"
         viewBox="0 0 20 20"
         fill="currentColor">
        <path fill-rule="evenodd"
              d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
              clip-rule="evenodd"/>
    </svg>
</button>
