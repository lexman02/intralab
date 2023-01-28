<div class="space-y-5 pb-5">
    <x-header title="Apps"/>
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
        @if(session()->has('error'))
            <div class="bg-red-500 text-white p-4 rounded-md">
                {{ session('error') }}
            </div>
        @endif
        @forelse($items as $item)
            @if(isset($item->allowed_roles))
                @if(Auth::hasRole($item->allowed_roles, 'master-realm'))
                    <x-card :name="$item->name"
                            :description="$item->description"
                            :url="$item->url"
                            :icon="$item->icon"/>
                @elseif($loop->remaining < 1)
                    <div class="bg-gray-700/80 col-span-full text-white text-lg p-4 rounded-xl">
                        <span class="rounded-l-xl bg-gray-500/60 px-6 mr-4 py-4 -ml-4 -my-4 font-black text-2xl">!</span>
                        No items found
                    </div>
                @endif
            @else
                <x-card :name="$item->name"
                        :description="$item->description"
                        :url="$item->url"
                        :icon="$item->icon"/>
            @endif
        @empty
            <div class="bg-gray-700/80 col-span-full text-white text-lg p-4 rounded-md">
                <span class="rounded-r-2xl rounded-l-md bg-gray-500/60 py-4 px-6 mr-4 -ml-4 -my-4 font-black text-2xl">!</span>
                No items found
            </div>
        @endforelse

        {{--        <div class="relative group bg-gray-900 py-10 sm:py-20 px-4 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-900/80 hover:smooth-hover">--}}
        {{--            <img class="w-20 h-20 object-cover object-center rounded-full" src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1171&q=80" alt="art" />--}}
        {{--            <h4 class="text-white text-2xl font-bold capitalize text-center">Art</h4>--}}
        {{--            <p class="text-white/50">132 members</p>--}}
        {{--            <p class="absolute top-2 text-white/20 inline-flex items-center text-xs">4 Online <span class="ml-2 w-2 h-2 block bg-green-500 rounded-full group-hover:animate-pulse"></span></p>--}}
        {{--        </div>--}}
        {{--        <div class="relative group bg-gray-900 py-10 sm:py-20 px-4 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-900/80 hover:smooth-hover">--}}
        {{--            <img class="w-20 h-20 object-cover object-center rounded-full" src="https://images.unsplash.com/photo-1560419015-7c427e8ae5ba?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="gaming" />--}}
        {{--            <h4 class="text-white text-2xl font-bold capitalize text-center">Gaming</h4>--}}
        {{--            <p class="text-white/50">207 members</p>--}}
        {{--            <p class="absolute top-2 text-white/20 inline-flex items-center text-xs">0 Online <span class="ml-2 w-2 h-2 block bg-red-400 rounded-full group-hover:animate-pulse"></span></p>--}}
        {{--        </div>--}}
        {{--        <div class="relative group bg-gray-900 py-10 sm:py-20 px-4 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-900/80 hover:smooth-hover">--}}
        {{--            <img class="w-20 h-20 object-cover object-center rounded-full" src="https://images.unsplash.com/photo-1485846234645-a62644f84728?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1159&q=80" alt="cinema" />--}}
        {{--            <h4 class="text-white text-2xl font-bold capitalize text-center">cinema</h4>--}}
        {{--            <p class="text-white/50">105 members</p>--}}
        {{--            <p class="absolute top-2 text-white/20 inline-flex items-center text-xs">12 Online <span class="ml-2 w-2 h-2 block bg-green-500 rounded-full group-hover:animate-pulse"></span></p>--}}
        {{--        </div>--}}
        {{--        <div class="relative group bg-gray-900 py-10 sm:py-20 px-4 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-900/80 hover:smooth-hover">--}}
        {{--            <img class="w-20 h-20 object-cover object-center rounded-full" src="https://images.unsplash.com/photo-1484704849700-f032a568e944?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1170&q=80" alt="song" />--}}
        {{--            <h4 class="text-white text-2xl font-bold capitalize text-center">Song</h4>--}}
        {{--            <p class="text-white/50">67 members</p>--}}
        {{--            <p class="absolute top-2 text-white/20 inline-flex items-center text-xs">3 Online <span class="ml-2 w-2 h-2 block bg-green-500 rounded-full group-hover:animate-pulse"></span></p>--}}
        {{--        </div>--}}
        {{--        <div class="relative group bg-gray-900 py-10 sm:py-20 px-4 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-900/80 hover:smooth-hover">--}}
        {{--            <img class="w-20 h-20 object-cover object-center rounded-full" src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1170&q=80" alt="code" />--}}
        {{--            <h4 class="text-white text-2xl font-bold capitalize text-center">Code</h4>--}}
        {{--            <p class="text-white/50">83 members</p>--}}
        {{--            <p class="absolute top-2 text-white/20 inline-flex items-center text-xs">43 Online <span class="ml-2 w-2 h-2 block bg-green-500 rounded-full group-hover:animate-pulse"></span></p>--}}
        {{--        </div>--}}
        {{--        <div class="relative group bg-gray-900 py-10 sm:py-20 px-4 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-900/80 hover:smooth-hover">--}}
        {{--            <img class="w-20 h-20 object-cover object-center rounded-full" src="https://images.unsplash.com/photo-1533147670608-2a2f9775d3a4?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1170&q=80" alt="dancing" />--}}
        {{--            <h4 class="text-white text-2xl font-bold capitalize text-center">Dancing</h4>--}}
        {{--            <p class="text-white/50">108 members</p>--}}
        {{--            <p class="absolute top-2 text-white/20 inline-flex items-center text-xs">86 Online <span class="ml-2 w-2 h-2 block bg-green-500 rounded-full group-hover:animate-pulse"></span></p>--}}
        {{--        </div>--}}
    </div>
</div>
