<div class="px-4 sm:px-0 space-y-5">
    <div
        class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row justify-between items-center bg-gray-900/50 rounded-xl px-6 py-4">
        <div>
            <h5 class="text-xl text-white text-center sm:text-left">Account</h5>
            <span class="text-white/50">Manage your account settings and change your password.</span>
        </div>
        <a href="#"
           class="w-full sm:w-fit text-center py-3 px-6 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">Go
            to Keycloak</a>
    </div>
    {{--        <hr class="border-2 rounded-2xl border-gray-600/30">--}}
    @if(Auth::hasRole(config('sync.admin_role'), 'master-realm'))
        <x-header title="Admin Settings"/>

        <div class="bg-gray-900/50 rounded-xl px-6 py-4 space-y-3 sm:space-y-6"
             x-data="{ confirmed: @entangle('confirmed') }">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 justify-between items-center">
                <div>
                    <h5 class="text-xl text-white text-center sm:text-left">Backup & Restore</h5>
                    <span class="text-white/50">Backup your layout and settings to a JSON file to be imported.</span>
                </div>
                <div class="flex flex-col space-y-2.5 w-full sm:w-1/4 text-center">
                    <button wire:click="export()"
                            class="p-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">
                        Export
                    </button>
                    <button wire:click="$emit('openModal', 'import-modal')"
                            class="p-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">
                        Import
                    </button>
                </div>
            </div>
            <div x-cloak x-data="{ selectedTab: @entangle('uploadMethod').defer}" x-show="confirmed"
                 class="space-y-4">
                <div class="text-center">
                    <div x-data="radioTabs('tab', tabs)"
                         class="inline-flex p-1 pr-0 bg-gray-900 rounded-full overflow-hidden">
                        <template x-for="radio in radios">
                            <label :for="radio.id"
                                   class="block transition ease-in-out duration-200 px-4 py-1 rounded-full cursor-pointer text-white/50 hover:bg-gray-800/50 hover:text-white mr-1"
                                   :class="selectedTab === radio.value ? 'bg-gray-800 text-white': ''">
                                <input type="radio" class="hidden" :id="radio.id" :value="radio.value" :name="name"
                                       x-model="selectedTab" @click="document.getElementById(radio.value).reset()"/>
                                <div x-text="radio.label"></div>
                            </label>
                        </template>
                    </div>
                </div>
                <div x-show="selectedTab === 'file'" class="flex justify-center">
                    <form wire:submit.prevent="import"
                          class="flex flex-col justify-center space-y-2 sm:space-y-4 items-center sm:w-1/2 py-5 bg-gray-800/70 rounded-xl"
                          id="file">
                        {{--                    <label for="" class="text-white/70 font-semibold text-xl">Upload a valid JSON config</label>--}}
                        <div
                            class="flex flex-col w-11/12 sm:w-4/6 max-w-full sm:p-5 p-2 bg-gray-700/30 rounded-xl space-y-3">
                            @error('config')
                            <div
                                class="self-center p-2 max-w-fit bg-red-900 items-center text-indigo-100 leading-none rounded-full flex lg:inline-flex"
                                role="alert">
                            <span
                                class="flex rounded-full bg-red-600/60 uppercase px-1 sm:px-2 py-1 text-xs text-white/80 font-bold mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                     class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </span>
                                <span class="font-semibold mr-1 text-white/80 text-left flex-auto">{{ $message }}</span>
                            </div>
                            @enderror
                            <input type="file" wire:model="config"
                                   class="text-white/70 focus:outline-0 file:bg-blue-900/60 file:mr-2.5 file:font-['Nunito'] file:font-semibold file:text-white file:py-2 file:px-4 file:rounded-xl file:border-0">
                        </div>
                        <button type="submit"
                                @disabled($errors->isNotEmpty())
                                class="w-1/3 p-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2 disabled:bg-blue-900/30 disabled:text-white/50 disabled:cursor-not-allowed">
                            Save
                        </button>
                    </form>
                </div>
                <div x-show="selectedTab === 'input'" class="flex justify-center h-60">
                    <form wire:submit.prevent="import"
                          class="flex flex-col justify-center items-center sm:w-3/4 sm:h-full p-5 bg-gray-800/70 rounded-xl"
                          id="input">
                        <label for="input-textbox"
                               class="text-white/70 self-start sr-only">Paste your config here</label>
                        @error('config')
                        <div
                            class="self-center p-2 max-w-fit bg-red-900 items-center mb-4 text-indigo-100 leading-none rounded-full flex lg:inline-flex"
                            role="alert">
                            <span
                                class="flex rounded-full bg-red-600/60 uppercase px-1 sm:px-2 py-1 text-xs text-white/80 font-bold mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                     class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="font-semibold mr-1 text-white/80 text-left flex-auto">{{ $message }}</span>
                        </div>
                        @enderror
                        <textarea data-gramm="false"
                                  autocomplete="off"
                                  autocorrect="off"
                                  autocapitalize="off"
                                  spellcheck="false"
                                  id="input-textbox"
                                  wire:model="config"
                                  placeholder="Paste config here"
                                  class="bg-gray-700/50 rounded-xl text-sm h-full w-full text-white/75 caret-white p-4 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-5xl placeholder:text-center"></textarea>
                        <button type="submit"
                                @disabled($errors->isNotEmpty())
                                class="w-1/3 p-3 rounded-xl bg-blue-900/50 mt-4 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2 disabled:bg-blue-900/30 disabled:text-white/50 disabled:cursor-not-allowed disabled:hidden">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            const tabs = [{id: "radio-tab-file", value: "file", label: "Upload"}, {
                id: "radio-tab-input",
                value: "input",
                label: "Input"
            }];

            function radioTabs(name, radios) {
                return {
                    name,
                    radios,
                }
            }
        </script>
    @endif
</div>
