<script lang="ts">
    import { authState, isAdmin } from "../../stores/auth";

    function checkPermissions() {
        if ($authState.auth_type === 'oidc') {
            if ($authState.user.roles.includes($authState.admin_role)) {
                isAdmin.set(true);
                return true;
            }
        }

        if ($authState.auth_type === 'basic' && $authState.authenticated) {
            isAdmin.set(true);
            return true;
        }

        return false;
    }
</script>

{#if $authState && checkPermissions()}
    <slot/>
{/if}