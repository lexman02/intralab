<script lang="ts">
    import { authState } from "../../stores/auth";

    export let isAdmin = false;

    function checkPermissions() {
        if ($authState.auth_type === 'oidc') {
            if ($authState.user.roles.includes($authState.admin_role)) {
                isAdmin = true;
                return true;
            }
        }

        if ($authState.auth_type === 'basic' && $authState.authenticated) {
            isAdmin = true;
            return true;
        }

        return false;
    }
</script>

{#if $authState && checkPermissions()}
    <slot/>
{/if}