@props(['name', 'description' => '', 'url', 'icon' => 'ubuntu'])
<a href="{{ $url }}" class="relative group bg-gray-700/80 md:py-4 sm:py-20 w-60 flex flex-col items-center cursor-pointer rounded-md hover:bg-gray-700/40 hover:smooth-hover">
{{--    <p class="absolute top-2 text-white/20 inline-flex items-center text-xs top-0 right-0 -mt-1 -mr-1">4 Online--}}
{{--        <span class="ml-2 w-4 h-4 block bg-green-500 rounded-full group-hover:animate-pulse"></span>--}}
{{--    </p>--}}
    <span class="flex absolute top-0 right-0 -mt-1 -mr-1">
        <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500"></span>
    </span>
    <img class="w-20 h-20 object-cover object-center rounded-full mb-1.5" src="https://cdn.jsdelivr.net/gh/walkxcode/dashboard-icons/png/{{ $icon }}.png" alt="{{ $icon . '_icon' }}" />
    @if(!empty($description))
        <h4 class="text-white text-xl font-semibold text-center">{{ $name }}</h4>
        <span class="text-white/50 text-sm">{{ $description }}</span>
    @else
        <div class="flex h-full w-full items-center justify-center">
            <h4 class="text-white text-xl font-semibold text-center">{{ $name }}</h4>
        </div>
    @endif
</a>
