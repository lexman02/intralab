<div class="p-10 text-center space-y-8 bg-gray-900">
    <form wire:submit.prevent="addApp" class="space-y-4">
        <div class="flex flex-col text-left text-white/60 font-medium">
            <label for="name">Name</label>
            @error('name') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror
            <input type="text"
                   wire:model.lazy="name"
                   name="name"
                   id="name"
                   required
                   placeholder="Example App"
                   class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
        </div>
        <div class="flex flex-col text-left text-white/60 font-medium">
            <label for="description">Description</label>
            @error('description') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror
            <input type="text"
                   wire:model.lazy="description"
                   name="description"
                   id="description"
                   placeholder="A brief description"
                   class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
        </div>
        <div class="flex flex-col text-left text-white/60 font-medium">
            <label for="url">URL</label>
            @error('url') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror
            <input type="url"
                   wire:model.lazy="url"
                   name="url"
                   id="url"
                   required
                   placeholder="https://example.com"
                   class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
        </div>
        <div class="flex flex-col text-left text-white/60 font-medium">
            <label for="icon">Icon</label>
            @error('icon') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror
            <input type="text"
                   wire:model.lazy="icon"
                   name="icon"
                   id="icon"
                   placeholder="ubuntu"
                   class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
            <a href="https://github.com/walkxcode/dashboard-icons#icons"
               class="text-sm text-gray-600/70 hover:text-gray-400/50">A list of all icons can be found here</a>
        </div>
        {{--        Insert Roles Options--}}
        <button type="submit"
                class="w-1/3 p-2.5 rounded-lg bg-blue-900/50 mt-4 text-white/60 hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2 disabled:bg-blue-900/30 disabled:text-white/50 disabled:cursor-not-allowed disabled:hidden">
            Add App
        </button>
    </form>
</div>
