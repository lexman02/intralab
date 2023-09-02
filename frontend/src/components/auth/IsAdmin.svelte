<script lang="ts">
    import {authState} from "../../stores/auth";

    export let isAdmin = false;

    function checkPermissions() {
        if ($authState.user.roles.includes($authState.admin_role)) {
            isAdmin = true;
            return true;
        }

        if ($authState.type === 'basic' && $authState.authenticated) {
            isAdmin = true;
            return true;
        }
    }
</script>

{#if $authState && checkPermissions()}
    <slot/>
{/if}