<div class="space-y-5 pb-5" x-data="{ edit: @entangle('editMode') }">
    <x-header title="Apps"/>
    <div class="w-full bg-gray-700/40 rounded-lg p-4 text-center flex flex-col border-dashed border-4 border-gray-600"
         x-show="edit"
         x-transition:enter="transition ease-in duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <span class="uppercase font-bold text-white/40 text-xl">Edit Mode</span>
        <span class="text-white/20">Select an app below to edit it's attributes</span>
    </div>
    @if(session()->has('error'))
        <div class="bg-red-500 text-white p-4 rounded-md">
            {{ session('error') }}
        </div>
    @endif
    {{--    <div class="sm:mb-0 flex flex-wrap flex-col sm:flex-row sm:space-x-8 space-y-4 px-4 sm:space-y-0 sm:px-0">--}}
    <div class="grid gap-5 sm:gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 px-4">
        {{--        <div class="group bg-gray-900/30 py-20 px-4 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-900/40 hover:smooth-hover">--}}
        {{--            <a class="bg-gray-900/70 text-white/50 group-hover:text-white group-hover:smooth-hover flex w-20 h-20 rounded-full items-center justify-center" href="#">--}}
        {{--                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
        {{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />--}}
        {{--                </svg>--}}
        {{--            </a>--}}
        {{--            <a class="text-white/50 group-hover:text-white group-hover:smooth-hover text-center" href="#">Create group</a>--}}
        {{--        </div>--}}
        @forelse($items as $item)
            @if(isset($item->allowed_roles))
                @if(Auth::hasRole($item->allowed_roles, 'master-realm'))
                    <x-card :editMode="$editMode" :item="$item"/>
                @elseif($loop->remaining < 1)
                    <div class="bg-gray-700/80 col-span-full text-white text-lg p-4 rounded-xl">
                        <span class="rounded-l-xl bg-gray-500/60 px-6 mr-4 py-4 -ml-4 -my-4 font-black text-2xl">!</span>
                        No items found
                    </div>
                @endif
            @else
                <x-card :editMode="$editMode" :item="$item"/>
            @endif
        @empty
            <div class="bg-gray-700/80 col-span-full text-white text-lg p-4 rounded-md">
                <span class="rounded-r-2xl rounded-l-md bg-gray-500/60 py-4 px-6 mr-4 -ml-4 -my-4 font-black text-2xl">!</span>
                No items found
            </div>
        @endforelse
    </div>
</div>
