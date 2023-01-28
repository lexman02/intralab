@props(['name', 'description' => '', 'url', 'icon' => 'ubuntu'])
<a href="{{ $url }}"
   class="relative bg-gray-700/80 py-3 md:py-4 sm:py-20 w-full h-36 flex flex-col items-center cursor-pointer rounded-md hover:bg-gray-700/40 hover:smooth-hover">
    {{--    <span class="flex absolute top-0 right-0 -mt-1 -mr-1">--}}
    {{--        Icon Only--}}
    {{--        <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500"></span>--}}
    {{--        With Text--}}
    {{--                <span class="relative inline-flex rounded-full h-full w-full px-2 text-xs bg-green-500">Online</span>--}}
    {{--    </span>--}}
    <img class="w-1/6 sm:w-3/12 object-cover object-center rounded-xl mb-1.5"
         src="https://cdn.jsdelivr.net/gh/walkxcode/dashboard-icons/png/{{ $icon }}.png"
         alt="{{ $icon . '_icon' }}"/>
    <div class="flex flex-col h-full w-full items-center justify-center">
        <h4 class="text-white text-xl font-semibold text-center">{{ $name }}</h4>
        <span class="text-white/50 text-sm">{{ $description }}</span>
    </div>
</a>
