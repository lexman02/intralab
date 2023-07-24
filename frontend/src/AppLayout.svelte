<script>
    import { Route, Router } from "svelte-routing";
    import Sidebar from "./components/Sidebar.svelte";
    import Dashboard from "./pages/Dashboard.svelte";
    import Settings from "./pages/Settings.svelte";
    import Ticketing from "./pages/Ticketing.svelte";
</script>

<Router>
    <div class="bg-gray-900 min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 flex-1 flex flex-col space-y-5 lg:space-y-0 lg:flex-row md:p-2 h-screen">
    <!--        @if(Auth::hasRole('needs-sync') && !session()->has('success') && !session()->has('synced'))-->
    <!--        <livewire:sync-ldap/>-->
    <!--        @else-->
            <Sidebar/>
            <div class="flex-1 px-0 md:px-8 lg:p-8 space-y-5 sm:space-y-10 overflow-auto">
                <Route path="/" component="{Dashboard}"/>
                <Route path="/ticketing" component="{Ticketing}"/>
                <Route path="/settings" component="{Settings}"/>
            </div>
        </div>
    </div>
</Router>
