<script lang="ts">
    import Header from "../components/Header.svelte";
    import Item from "../components/Item.svelte";
    import { blur } from "svelte/transition";
    import AddModal from "../components/AddModal.svelte";
    import IsAdmin from "../components/auth/IsAdmin.svelte";

    let items;
    let itemCount = 0;
    let editMode = false;
    let empty = false;
    let showAddModal = false;

    // const test = {
    //     "name": "test",
    //     "position": 11,
    //     "description": "",
    //     "url": "https://vault.mcneillfam.co",
    //     "icon": "",
    //     "allowed_roles": []
    // }

    function toggleEditMode() {
        editMode = !editMode;

        if (!editMode) {
            loadItems();
        }
    }

    function toggleAddModal() {
        showAddModal = !showAddModal;

        if (!showAddModal) {
            loadItems();
        }
    }

    function loadItems() {
        fetch("http://localhost:3000/api/items")
            .then(res => res.json())
            .then(data => {
                items = data;
                itemCount = items.length;
                // for (let item of items) {
                //     item.allowed_roles = JSON.parse(item.allowed_roles);
                // }
                // items = [...items, test]
            });
    }

    loadItems();

    if (!items) {
        empty = true;
    }
</script>

<div class="space-y-5 pb-5">
    <Header title="Apps">
        <!--    Grid/List Buttons-->
        <IsAdmin>
            <div class="inline-flex items-center space-x-2">
                <!--{{--            <a class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover" href="#">--}}-->
                <!--{{--                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}-->
                <!--{{--                     stroke="currentColor">--}}-->
                <!--{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}-->
                <!--{{--                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>--}}-->
                <!--{{--                </svg>--}}-->
                <!--{{--            </a>--}}-->
                <button on:click={toggleAddModal}
                        class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover"
                        class:empty={'animate-bounce'}>
                    <!--           wire:click="$emit('openModal', 'add-app-modal')"-->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                    </svg>
                </button>

                {#if items}
                    <button on:click={toggleEditMode}
                            class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover"
                            class:editMode={'bg-gray-900/40 text-white/25'}>
                        <!--                @click="edit = !edit"-->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z"/>
                        </svg>
                    </button>
                {/if}
            </div>
        </IsAdmin>
    </Header>

    {#if editMode}
        <div transition:blur={{ amount: 20, duration: 350 }}
             class="w-full bg-gray-700/40 rounded-lg p-4 text-center flex flex-col border-dashed border-4 border-gray-600">
            <span class="uppercase font-bold text-white/40 text-xl">Edit Mode</span>
            <span class="text-white/20">Select an app below to edit it's attributes</span>
        </div>
    {/if}
    <!--    @if(session()->has('error'))-->
    <!--    <div class="bg-red-500 text-white p-4 rounded-md">-->
    <!--        {{ session('error') }}-->
    <!--    </div>-->
    <!--    @endif-->

    <!--{{&#45;&#45;    <div class="sm:mb-0 flex flex-wrap flex-col sm:flex-row sm:space-x-8 space-y-4 px-4 sm:space-y-0 sm:px-0">&#45;&#45;}}-->
    <div class="grid gap-5 sm:gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 px-4">
        <!--{{&#45;&#45;        <div class="group bg-gray-900/30 py-20 px-4 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-900/40 hover:smooth-hover">&#45;&#45;}}-->
        <!--{{&#45;&#45;            <a class="bg-gray-900/70 text-white/50 group-hover:text-white group-hover:smooth-hover flex w-20 h-20 rounded-full items-center justify-center" href="#">&#45;&#45;}}-->
        <!--{{&#45;&#45;                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">&#45;&#45;}}-->
        <!--{{&#45;&#45;                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />&#45;&#45;}}-->
        <!--{{&#45;&#45;                </svg>&#45;&#45;}}-->
        <!--{{&#45;&#45;            </a>&#45;&#45;}}-->
        <!--{{&#45;&#45;            <a class="text-white/50 group-hover:text-white group-hover:smooth-hover text-center" href="#">Create group</a>&#45;&#45;}}-->
        <!--{{&#45;&#45;        </div>&#45;&#45;}}-->
        {#if items}
            {#each items as item}
                <Item bind:item={item} {editMode}/>
            {/each}
        {:else}
            <div class="bg-gray-700/80 col-span-full text-white text-lg p-4 rounded-md">
                <span class="rounded-r-2xl rounded-l-md bg-gray-500/60 py-4 px-6 mr-4 -ml-4 -my-4 font-black text-2xl">!</span>
                No items found
            </div>
        {/if}
    </div>

    <AddModal bind:showAddModal bind:itemCount/>
</div>