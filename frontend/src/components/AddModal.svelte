<script>
    import {validateItem} from "../utils.ts";
    import Modal from "./Modal.svelte";
    import AllowedRoles from "./AllowedRoles.svelte";
    import ModalCloseButton from "./ModalCloseButton.svelte";

    export let showAddModal;
    export let itemCount;

    let item = {
        name: '',
        description: null,
        position: itemCount + 1,
        url: '',
        icon: null,
        allowed_roles: null
    }

    async function addItem() {
        if (!validateItem(item)) {
            console.log('validation failed')
            return;
        }

        await fetch('http://localhost:3000/api/items', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify([item])
        })
            .then(res => res.json())
            .then(data => {
                showAddModal = !showAddModal;
                // check if multiple entries want to be added
                window.location.reload();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
</script>

<Modal bind:showModal="{showAddModal}">
    <div class="p-10 text-center">
        <ModalCloseButton onClick="{() => showAddModal = !showAddModal}"/>
        <form on:submit|preventDefault={addItem}
              class="space-y-4">
            <div class="flex flex-col text-left text-white/60 font-medium">
                <label for="name">Name</label>
                <!--                    @error('name') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror-->
                <input type="text"
                       name="name"
                       id="name"
                       bind:value={item.name}
                       required
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
                   class="text-sm text-gray-600/70 hover:text-gray-400/50">A list of all icons can be found here</a>
            </div>
            <AllowedRoles bind:roles={item.allowed_roles}/>
            <button type="submit"
                    class="w-1/3 p-2.5 rounded-lg bg-blue-900/50 mt-4 text-white/60 hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2 disabled:bg-blue-900/30 disabled:text-white/50 disabled:cursor-not-allowed disabled:hidden">
                Add Item
            </button>
        </form>
    </div>
</Modal>
