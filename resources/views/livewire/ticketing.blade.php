<div>
    @if(session()->has('success'))
        <div
            class="p-2 w-full bg-green-900 items-center mb-4 text-indigo-100 leading-none rounded-full flex lg:inline-flex"
            role="alert">
            <span
                class="flex rounded-full bg-green-600/60 uppercase px-1 sm:px-2 py-1 text-xs text-white/80 font-bold mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                          clip-rule="evenodd"/>
                </svg>
            </span>
            <span class="font-semibold mr-1 text-white/80 text-left flex-auto">{{ session('success') }}</span>
        </div>
    @elseif(session()->has('error'))
        <div
            class="p-2 w-full bg-red-900 items-center mb-4 text-indigo-100 leading-none rounded-full flex lg:inline-flex"
            role="alert">
            <span
                class="flex rounded-full bg-red-600/60 uppercase px-1 sm:px-2 py-1 text-xs text-white/80 font-bold mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                          clip-rule="evenodd"/>
                </svg>
            </span>
            <span class="font-semibold mr-1 text-white/80 text-left flex-auto">{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="init" class="space-y-4" id="ticket">
        <div class="text-left text-white/60 font-medium">
            <label for="subject">Name</label>
            @error('subject') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror
            <input type="text"
                   wire:model.lazy="subject"
                   name="subject"
                   id="subject"
                   required
                   placeholder="Example Title"
                   class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
        </div>
        <div class="text-left text-white/60 font-medium">
            <label for="message">Description</label>
            @error('message') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror
            <textarea form="ticket"
                      wire:model.lazy="message"
                      name="message"
                      id="message"
                      required
                      placeholder="{{ config('ticketing.subject_placeholder') }}"
                      class="bg-gray-700/50 rounded-lg text-sm h-48 w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
            </textarea>
        </div>
        <button type="submit"
                class="w-full p-2.5 rounded-lg bg-blue-900/50 mt-4 text-white/60 hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">
            Submit Support Ticket
        </button>
    </form>
</div>
