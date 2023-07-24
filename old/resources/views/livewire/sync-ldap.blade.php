{{--    <button wire:click="syncUser" class="bg-gray-700 text-white p-4 rounded-md">Sync LDAP</button>--}}
<div class="flex justify-center items-center w-full h-">
    <div class="w-4/5 h-3/4 bg-gray-900/50 py-10 sm:py-20 px-4 flex flex-col items-center rounded-xl">
        <img class="w-20 h-20 object-cover object-center rounded-full" src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1171&q=80" alt="art" />
        <h1 class="my-2 text-white text-3xl font-bold capitalize text-center">Almost Done</h1>
        <p class="text-white/50 text-xl text-center">Your account still needs to be synced in order to use all available services.</p>
        {{--        <button wire:click="syncUser" class="mt-12 bg-gray-700/60 block w-1/3 py-3 text-white rounded-xl"><span class="text-lg font-semibold">Sync</span></button>--}}
        <button wire:click="syncUser" class="mt-12 block w-1/3 py-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2"><span class="text-lg font-semibold">Sync</span></button>
    </div>
</div>
