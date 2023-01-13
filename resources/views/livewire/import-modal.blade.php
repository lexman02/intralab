<div class="p-10 text-center space-y-8 bg-gray-900">
    <span class="text-7xl">⚠️</span>
    <div>
        <h4 class="text-4xl text-white">Are you sure</h4>
        <p class="text-white/50">This will overwrite your current app settings and can't be undone!</p>
    </div>
    <div class="flex flex-row justify-center space-x-4">
        {{--        <button @click="confirmed = true"--}}
        <button wire:click="$emit('confirm')"
                class="w-1/2 p-3 rounded-xl bg-red-800/50 text-white hover:smooth-hover hover:bg-red-900/70 focus:outline-none focus:ring-2 focus:ring-red-500/50">
            Import
        </button>
        <button wire:click="$emit('closeModal')"
                class="w-1/2 p-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">
            Cancel
        </button>
    </div>
</div>
