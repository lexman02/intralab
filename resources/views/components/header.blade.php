@props(['title' => request()->route()->getName()])

<div class="flex justify-between items-center px-4 sm:px-0">
    <h3 class="text-3xl font-extralight text-white/50">{{ Str::title($title) }}</h3>
    {{-- Grid/List Buttons --}}
    @if(request()->routeIs('home'))
        <div class="inline-flex items-center space-x-2">
            {{--        <a class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover" href="#">--}}
            {{--            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
            {{--                 stroke="currentColor">--}}
            {{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
            {{--                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>--}}
            {{--            </svg>--}}
            {{--        </a>--}}
            {{--        <a class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover" href="#">--}}
            {{--            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
            {{--                 stroke="currentColor">--}}
            {{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
            {{--                      d="M4 6h16M4 10h16M4 14h16M4 18h16"/>--}}
            {{--            </svg>--}}
            {{--        </a>--}}
            <a class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover" href="#"
               wire:click="$emit('openModal', 'add-app')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                </svg>
            </a>
        </div>
    @endif
</div>
