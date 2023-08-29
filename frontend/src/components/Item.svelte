<script>
    import Modal from "./Modal.svelte";
    import AllowedRoles from "./AllowedRoles.svelte";
    import {validateItem} from "../utils.ts";
    import ModalCloseButton from "./ModalCloseButton.svelte";

    export let item;
    export let editMode;
    export let showEditModal = false;
    let itemDeleted = false;

    function handleClick() {
        if (itemDeleted) {
            return;
        }

        if (editMode) {
            showEditModal = !showEditModal;
            return;
        }

        return window.open(item.url, '_blank');
    }

    async function editItem() {
        if (!validateItem(item)) {
            console.log('validation failed');
            return;
        }

        await fetch('/api/items', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: item.name,
                description: item.description,
                url: item.url,
                icon: item.icon,
                allowed_roles: item.allowed_roles
            })
        })
            .then(res => res.json())
            .then(data => {
                showEditModal = !showEditModal;
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    async function deleteItem() {
        await fetch('http://localhost:3000/api/items', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(item)
        })
            .then(res => res.json())
            .catch((error) => {
                console.error('Error:', error);
            });
        itemDeleted = true;
        showEditModal = !showEditModal;
        console.log('delete');
    }
</script>

<div>
    <a id="{item.name}"
       on:click={handleClick}
       class="{itemDeleted ? 'opacity-20 cursor-not-allowed' : 'cursor-pointer hover:bg-gray-700/40 hover:smooth-hover'} relative bg-gray-700/80 py-3 md:py-4 sm:py-20 w-full h-auto md:h-full flex flex-col items-center rounded-md">
        <!--{{&#45;&#45;    <span class="flex absolute top-0 right-0 -mt-1 -mr-1">&#45;&#45;}}-->
        <!--{{&#45;&#45;        Icon Only&#45;&#45;}}-->
        <!--{{&#45;&#45;        <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500"></span>&#45;&#45;}}-->
        <!--{{&#45;&#45;        With Text&#45;&#45;}}-->
        <!--{{&#45;&#45;                <span class="relative inline-flex rounded-full h-full w-full px-2 text-xs bg-green-500">Online</span>&#45;&#45;}}-->
        <!--{{&#45;&#45;    </span>&#45;&#45;}}-->
        <img class="w-1/6 sm:w-3/12 object-cover object-center rounded-xl mb-1.5"
             src="https://cdn.jsdelivr.net/gh/walkxcode/dashboard-icons/png/{item.icon ? item.icon : 'ubuntu'}.png"
             alt="{item.icon ? item.icon : 'ubuntu' + '_icon'}"/>
        <div class="flex flex-col h-full w-full items-center justify-center">
            <h4 class="text-white text-xl font-semibold text-center">{item.name}</h4>
            {#if item.description}
                <span class="text-white/50 text-sm text-center">{item.description}</span>
            {/if}
        </div>
    </a>

    <Modal bind:showModal="{showEditModal}">
        <div class="p-10 text-center">
            <ModalCloseButton onClick="{() => showEditModal = !showEditModal}"/>
            <form on:submit|preventDefault={() => editItem()}
                  class="space-y-4">
                <div class="flex flex-col text-left text-white/60 font-medium">
                    <label for="name">Name</label>
                    <!--                    @error('name') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror-->
                    <input type="text"
                           name="name"
                           id="name"
                           bind:value={item.name}
                           required
                           minlength="1"
                           placeholder="Example App"
                           class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                    <!--                           wire:model.lazy="name"-->
                </div>
                <div class="flex flex-col text-left text-white/60 font-medium">
                    <label for="description">Description</label>
                    <!--                    @error('description') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror-->
                    <input type="text"
                           name="description"
                           id="description"
                           bind:value={item.description}
                           placeholder="A brief description"
                           class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                    <!--                           wire:model.lazy="description"-->
                </div>
                <div class="flex flex-col text-left text-white/60 font-medium">
                    <label for="url">URL</label>
                    <!--                    @error('url') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror-->
                    <input type="url"
                           name="url"
                           id="url"
                           bind:value={item.url}
                           required
                           placeholder="https://example.com"
                           class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                    <!--                           wire:model.lazy="url"-->
                </div>
                <div class="flex flex-col text-left text-white/60 font-medium">
                    <label for="icon">Icon</label>
                    <!--                    @error('icon') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror-->
                    <input type="text"
                           name="icon"
                           id="icon"
                           bind:value={item.icon}
                           placeholder="ubuntu"
                           class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                    <!--                           wire:model.lazy="icon"-->
                    <a href="https://github.com/walkxcode/dashboard-icons/blob/main/ICONS.md"
                       class="text-sm text-gray-600/70 hover:text-gray-400/50">
                        A list of all icons can be found here
                    </a>
                </div>
                <AllowedRoles bind:roles={item.allowed_roles}/>
                <div class="space-x-4">
                    <button on:click|preventDefault={deleteItem}
                            type="button"
                            class="w-1/3 p-2.5 rounded-lg bg-red-900/50 mt-4 text-white/60 hover:smooth-hover hover:bg-red-900/70 focus:outline-none focus:ring-2 focus:ring-red-500/40 disabled:bg-red-900/30 disabled:text-white/50 disabled:cursor-not-allowed disabled:hidden">
                        Delete
                    </button>
                    <button type="submit"
                            class="w-1/3 p-2.5 rounded-lg bg-blue-900/50 mt-4 text-white/60 hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2 disabled:bg-blue-900/30 disabled:text-white/50 disabled:cursor-not-allowed disabled:hidden">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </Modal>
</div>
