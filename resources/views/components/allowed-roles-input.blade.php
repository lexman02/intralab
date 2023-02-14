@props(['allowed_roles'])

<div class="flex flex-col space-y-3">
    @foreach($allowed_roles as $index => $allowed_role)
        <div class="flex align-middle items-center">
            <label for="allowed_roles.{{ $index }}"
                   class="flex-none text-white/60 font-medium px-3">{{ $index + 1 }}.</label>
            <input wire:model="allowed_roles.{{ $index }}"
                   type="text"
                   id="allowed_roles.{{ $index }}"
                   placeholder="example-role"
                   class="bg-gray-700/50 rounded-lg text-sm h-full w-full text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
            <button wire:click.prevent="removeRole({{ $index }})" class="text-xs text-gray-500 px-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                </svg>
            </button>
        </div>
    @endforeach

    <button wire:click.prevent="addRole"
            class="flex items-center justify-center bg-gray-800/60 text-white/50 p-2 rounded-lg hover:text-white smooth-hover">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path d="M10.75 6.75a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"/>
        </svg>
        @if(count($allowed_roles) === 0)
            Add role
        @else
            Add another role
        @endif
    </button>
</div>
