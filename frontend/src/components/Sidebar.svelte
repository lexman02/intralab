<script>
    import {Link} from "svelte-routing";
    import Logout from "./auth/Logout.svelte";

    function getProps(href) {
        const baseStyle = 'hover:bg-gray-800 hover:text-white smooth-hover p-4 inline-flex justify-center rounded-md'

        if (href.isCurrent) {
            return {class: 'bg-gray-800 text-white ' + baseStyle}
        }
        return {class: 'text-white/50 ' + baseStyle}
    }
</script>

<!-- Navigation -->
<nav class="bg-gray-900 px-2 lg:px-4 py-2 lg:py-10 rounded-b-xl md:rounded-xl flex lg:flex-col justify-between">
    <div class="flex items-center flex-row space-x-2 lg:space-x-0 lg:flex-col lg:space-y-2">
        <!-- Active: bg-gray-800 text-white, Not active: text-white/50 -->
        <Link to="/" {getProps}>
            <!--{{&#45;&#45;            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20" fill="currentColor">&#45;&#45;}}-->
            <!--{{&#45;&#45;                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />&#45;&#45;}}-->
            <!--{{&#45;&#45;            </svg>&#45;&#45;}}-->
            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20"
                 fill="currentColor"
                 class="w-5 h-5 sm:h-6 sm:w-6">
                <path fill-rule="evenodd"
                      d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z"
                      clip-rule="evenodd"/>
            </svg>

        </Link>
        <!--{{&#45;&#45;        <a class="{{ request()->is('') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white smooth-hover' }} p-4 inline-flex justify-center rounded-md" href="#">&#45;&#45;}}-->
        <!--{{&#45;&#45;            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20" fill="currentColor">&#45;&#45;}}-->
        <!--{{&#45;&#45;                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />&#45;&#45;}}-->
        <!--{{&#45;&#45;            </svg>&#45;&#45;}}-->
        <!--{{&#45;&#45;        </a>&#45;&#45;}}-->
        <!--        @if(config('ticketing.platform') != 'none' && config('ticketing.platform'))-->
        <!--{{&#45;&#45;            {{ dd(config('sync.ticketing_system')) }}&#45;&#45;}}-->
        <Link to="/ticketing" {getProps}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path d="M13.92 3.845a19.361 19.361 0 01-6.3 1.98C6.765 5.942 5.89 6 5 6a4 4 0 00-.504 7.969 15.974 15.974 0 001.271 3.341c.397.77 1.342 1 2.05.59l.867-.5c.726-.42.94-1.321.588-2.021-.166-.33-.315-.666-.448-1.004 1.8.358 3.511.964 5.096 1.78A17.964 17.964 0 0015 10c0-2.161-.381-4.234-1.08-6.155zM15.243 3.097A19.456 19.456 0 0116.5 10c0 2.431-.445 4.758-1.257 6.904l-.03.077a.75.75 0 001.401.537 20.902 20.902 0 001.312-5.745 1.999 1.999 0 000-3.545 20.902 20.902 0 00-1.312-5.745.75.75 0 00-1.4.537l.029.077z"/>
            </svg>
        </Link>
        <!--        @endif-->
        <!--{{&#45;&#45;        <a class="{{ request()->is('') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white smooth-hover' }} p-4 inline-flex justify-center rounded-md" href="#">&#45;&#45;}}-->
        <!--{{&#45;&#45;            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20" fill="currentColor">&#45;&#45;}}-->
        <!--{{&#45;&#45;                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />&#45;&#45;}}-->
        <!--{{&#45;&#45;            </svg>&#45;&#45;}}-->
        <!--{{&#45;&#45;        </a>&#45;&#45;}}-->
    </div>
    <div class="flex items-center flex-row space-x-2 lg:space-x-0 lg:flex-col lg:space-y-2">
        <Link to="/settings" {getProps}>
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 sm:h-6 sm:w-6"
                 viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                      clip-rule="evenodd"/>
            </svg>
        </Link>
        <Logout/>
    </div>
</nav>
