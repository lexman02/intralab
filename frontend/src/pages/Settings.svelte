<script>
    import Header from "../components/Header.svelte";
    import Tabs from "../components/Tabs.svelte";
    import {parseJSON} from "../utils.ts";
    import config from "../../../config.json";
    import Modal from "../components/Modal.svelte";
    import IsAdmin from "../components/auth/IsAdmin.svelte";

    const importTabs = [
        {
            value: 1,
            label: "Upload"
        },
        {
            value: 2,
            label: "Input"
        }
    ];
    const ticketingTabs = [
        {
            value: 1,
            label: "None"
        },
        {
            value: 2,
            label: "osTicket"
        }
        // {
        // value: 3,
        // label: "Zammad"
        // }
    ];

    let activeImportTab;
    let activeTicketingTab = setActiveTicketingTab();
    let showConfirmation = false;
    let disabled;
    let input;
    let confirmed = false;

    function setActiveTicketingTab() {
        switch (config.ticketing.Platform) {
            case "osTicket":
                return 2;
            case "Zammad":
                return 3;
            default:
                return 1;
        }
    }

    async function submitImport() {
        await fetch("/api/config", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: input
        })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data.status === "success") {
                    console.log("success");
                }
            })
    }

    function exportConfig() {
        this.setAttribute("href", "/api/config");
    }

    function toggleConfirmation() {
        showConfirmation = !showConfirmation;
    }

    function confirm(value) {
        confirmed = value;
        toggleConfirmation();
    }

    const validateFields = (event) => {
        let json;

        if (activeImportTab === 1) {
            const reader = new FileReader();
            reader.onload = () => {
                input = reader.result;
                json = parseJSON(input);
            };
            reader.readAsText(event.target.files[0]);
        } else {
            json = parseJSON(input);
        }

        if (input === "") {
            disabled = true;
        } else disabled = json === false;
    }
</script>

<div class="px-4 sm:px-0 space-y-5">
    <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row justify-between items-center bg-gray-900/50 rounded-xl px-6 py-4">
        <div>
            <h5 class="text-xl text-white text-center sm:text-left">Account</h5>
            <span class="text-white/50">Manage your account settings and change your password.</span>
        </div>
        <a href="#"
           class="w-full sm:w-fit text-center py-3 px-6 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">Go
            to Keycloak</a>
    </div>
    <!--{{&#45;&#45;        <hr class="border-2 rounded-2xl border-gray-600/30">&#45;&#45;}}-->
    <!--    @if(Auth::hasRole(config('sync.admin_role'), 'master-realm'))-->
    <IsAdmin>
        <Header title="Admin Settings"/>

        <div class="space-y-3 sm:space-y-6">
            <div class="flex flex-col bg-gray-900/50 rounded-xl px-6 py-4 space-y-3 sm:space-y-4">
                <!--             x-data="{ confirmed: @entangle('confirmed') }">-->
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 justify-between items-center">
                    <div>
                        <h5 class="text-xl text-white text-center sm:text-left">Backup & Restore</h5>
                        <span class="text-white/50">Backup your layout and settings to a JSON file to be imported.</span>
                    </div>
                    <div class="flex flex-col space-y-2.5 w-full sm:w-1/4 text-center">
                        <a on:click={exportConfig}
                           class="p-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2"
                           href="#">
                            Export
                        </a>
                        <button on:click={toggleConfirmation}
                                disabled={confirmed}
                                class="p-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2 disabled:bg-blue-900/30 disabled:text-white/50 disabled:cursor-not-allowed">
                            Import
                        </button>
                    </div>
                </div>
                {#if confirmed}
                    <div class="self-center p-2 max-w-fit bg-red-900 items-center mb-4 text-indigo-100 leading-none rounded-full flex lg:inline-flex"
                         role="alert">
                <span class="flex rounded-full bg-red-600/60 uppercase px-1 sm:px-2 py-1 text-xs text-white/80 font-bold mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                         class="w-5 h-5">
                        <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                              clip-rule="evenodd"/>
                    </svg>
                </span>
                        <span class="font-semibold mr-2 text-white/80 text-left flex-auto">Are you sure? This will overwrite your current app settings and can't be undone!</span>
                    </div>
                    <Tabs items={importTabs} bind:activeTabValue={activeImportTab}>
                        {#if activeImportTab === 1}
                            <div class="flex justify-center">
                                <form on:submit|preventDefault={submitImport}
                                      class="flex flex-col justify-center space-y-2 sm:space-y-4 items-center sm:w-1/2 py-5 bg-gray-800/70 rounded-xl"
                                      id="file">
                                    <!--                        <label for="" class="text-white/70 font-semibold text-xl">Upload a valid JSON config</label>-->
                                    <div
                                            class="flex flex-col w-11/12 sm:w-4/6 max-w-full sm:p-5 p-2 bg-gray-700/30 rounded-xl space-y-3">
                                        <!--                            @error('config')-->
                                        <!--                            <div-->
                                        <!--                                    class="self-center p-2 max-w-fit bg-red-900 items-center text-indigo-100 leading-none rounded-full flex lg:inline-flex"-->
                                        <!--                                    role="alert">-->
                                        <!--                                        <span-->
                                        <!--                                                class="flex rounded-full bg-red-600/60 uppercase px-1 sm:px-2 py-1 text-xs text-white/80 font-bold mr-3">-->
                                        <!--                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"-->
                                        <!--                                                 class="w-5 h-5">-->
                                        <!--                                                <path fill-rule="evenodd"-->
                                        <!--                                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"-->
                                        <!--                                                      clip-rule="evenodd"/>-->
                                        <!--                                            </svg>-->
                                        <!--                                        </span>-->
                                        <!--                                <span class="font-semibold mr-1 text-white/80 text-left flex-auto">{{ $message }}</span>-->
                                        <!--                            </div>-->
                                        <!--                            @enderror-->
                                        <input type="file"
                                               accept=".json"
                                               on:invalid={() => disabled = true}
                                               on:input={validateFields}
                                               bind:value={input}
                                               class="text-white/70 focus:outline-0 file:bg-blue-900/60 file:mr-2.5 file:font-['Nunito'] file:font-semibold file:text-white file:py-2 file:px-4 file:rounded-xl file:border-0">
                                    </div>
                                    <button type="submit"
                                            {disabled}
                                            class="w-1/3 p-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2 disabled:bg-blue-900/30 disabled:text-white/50 disabled:cursor-not-allowed">
                                        Save
                                    </button>
                                </form>
                            </div>
                        {:else if activeImportTab === 2}
                            <div class="flex justify-center h-60">
                                <form on:submit|preventDefault={submitImport}
                                      class="flex flex-col justify-center items-center sm:w-3/4 sm:h-full p-5 bg-gray-800/70 rounded-xl"
                                      id="input">
                                    <label for="input-textbox"
                                           class="text-white/70 self-start sr-only">Paste your config here</label>
                                    <textarea data-gramm="false"
                                              autocomplete="off"
                                              autocorrect="off"
                                              autocapitalize="off"
                                              spellcheck="false"
                                              id="input-textbox"
                                              bind:value={input}
                                              on:input={validateFields}
                                              placeholder="Paste config here"
                                              class="bg-gray-700/50 rounded-xl text-sm h-full w-full text-white/75 caret-white p-4 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-5xl placeholder:text-center"></textarea>
                                    <button type="submit"
                                            {disabled}
                                            class="w-1/3 p-3 rounded-xl bg-blue-900/50 mt-4 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2 disabled:bg-blue-900/30 disabled:text-white/50 disabled:cursor-not-allowed">
                                        Save
                                    </button>
                                </form>
                            </div>
                        {/if}
                    </Tabs>
                {/if}
            </div>

            <hr class="w-1/4 mx-auto border-white/30 border rounded-3xl">

            <div class="w-full bg-gray-900/50 rounded-xl px-6 py-4 space-y-3">
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 justify-between items-center">
                    <div>
                        <h5 class="text-xl text-white text-center sm:text-left">Ticketing</h5>
                        <span class="text-white/50">Manage settings for the ticketing integration</span>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex p-1 pr-0 bg-gray-900 rounded-full overflow-hidden">
                            <Tabs items={ticketingTabs} bind:activeTabValue={activeTicketingTab}/>
                        </div>
                    </div>
                </div>
                {#if activeTicketingTab !== 1}
                    <div class="space-y-3">
                        <hr class="border-white/10 border rounded-3xl">
                        <form id="ticketing" class="flex flex-col items-stretch space-y-2">
                            <div class="text-white/60 font-medium">
                                <label for="description">Description placeholder message</label>
                                <!--                        @error('description') <span class="text-red-700 text-sm">{{ $message }}</span> @enderror-->
                                <textarea bind:value={config.ticketing.SubjectPlaceholder}
                                          id="description"
                                          class="bg-gray-700/50 rounded-lg text-sm h-24 w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20"></textarea>
                            </div>
                            {#if activeTicketingTab === 2}
                                <div class="text-white/60 font-medium space-y-2">
                                    <div>
                                        <label for="osticket_base_url">Base URL</label>
                                        <!--                                @error('osticket_base_url')-->
                                        <!--                                <span class="text-red-700 text-sm">{{ $message }}</span> @enderror-->
                                        <input form="ticketing"
                                               name="osticket_base_url"
                                               id="osticket_base_url"
                                               class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                                        <!--                                       placeholder="{{ config('ticketing.osticket_base_url') }}"-->
                                        <!--                                       wire:model.lazy="osticket_base_url"-->
                                    </div>
                                    <div>
                                        <label for="osticket_api_key">API Key</label>
                                        <!--                                @error('osticket_api_key')-->
                                        <!--                                <span class="text-red-700 text-sm">{{ $message }}</span> @enderror-->
                                        <input form="ticketing"
                                               name="osticket_api_key"
                                               id="osticket_api_key"
                                               class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                                        <!--                                       placeholder="{{ config('ticketing.osticket_api_key') }}"-->
                                        <!--                                       wire:model.lazy="osticket_api_key"-->
                                    </div>
                                </div>
                                <button type="submit"
                                        class="w-2/5 mx-auto p-2.5 rounded-lg bg-blue-900/50 mt-4 text-white/60 hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">
                                    Save
                                </button>
                            {/if}
                        </form>
                    </div>
                {/if}
            </div>
        </div>

        <Modal bind:showModal={showConfirmation}>
            <div class="p-10 text-center space-y-6">
                <!--                                    <span class="text-7xl">&#x26A0;</span>-->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     class="w-1/4 h-1/4 md:w-1/5 md:h-1/5 mx-auto text-amber-600">
                    <path fill-rule="evenodd"
                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                          clip-rule="evenodd"/>
                </svg>
                <div>
                    <h4 class="text-4xl text-white">Are you sure</h4>
                    <p class="text-white/50">This will overwrite your current app settings and can't be undone!</p>
                </div>
                <div class="flex flex-row justify-center space-x-4">
                    <button on:click={() => confirm(true)}
                            class="w-1/2 p-3 rounded-xl bg-red-800/50 text-white hover:smooth-hover hover:bg-red-900/70 focus:outline-none focus:ring-2 focus:ring-red-500/50">
                        Import
                    </button>
                    <button on:click={() => confirm(false)}
                            class="w-1/2 p-3 rounded-xl bg-blue-900/50 text-white hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">
                        Cancel
                    </button>
                </div>
            </div>
        </Modal>
    </IsAdmin>
</div>
