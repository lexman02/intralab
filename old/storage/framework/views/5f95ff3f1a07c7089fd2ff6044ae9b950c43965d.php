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
    
    <?php if(Auth::hasRole(config('sync.admin_role'), 'master-realm')): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header','data' => ['title' => 'Admin Settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Admin Settings']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="space-y-3 sm:space-y-6">
            <div class="bg-gray-900/50 rounded-xl px-6 py-4 space-y-3 sm:space-y-6"
                 x-data="{ confirmed: <?php if ((object) ('confirmed') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('confirmed'->value()); ?>')<?php echo e('confirmed'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('confirmed'); ?>')<?php endif; ?> }">
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
                <div x-cloak x-data="{ selectedTab: <?php if ((object) ('uploadMethod') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('uploadMethod'->value()); ?>')<?php echo e('uploadMethod'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('uploadMethod'); ?>')<?php endif; ?>.defer}" x-show="confirmed"
                     class="space-y-4">
                    <div class="text-center">
                        <div x-data="importTabs('tab', tabs)"
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
                            
                            <div
                                class="flex flex-col w-11/12 sm:w-4/6 max-w-full sm:p-5 p-2 bg-gray-700/30 rounded-xl space-y-3">
                                <?php $__errorArgs = ['config'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
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
                                    <span class="font-semibold mr-1 text-white/80 text-left flex-auto"><?php echo e($message); ?></span>
                                </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <input type="file" wire:model="config"
                                       class="text-white/70 focus:outline-0 file:bg-blue-900/60 file:mr-2.5 file:font-['Nunito'] file:font-semibold file:text-white file:py-2 file:px-4 file:rounded-xl file:border-0">
                            </div>
                            <button type="submit"
                                    <?php if($errors->isNotEmpty()): echo 'disabled'; endif; ?>
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
                            <?php $__errorArgs = ['config'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
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
                                <span class="font-semibold mr-1 text-white/80 text-left flex-auto"><?php echo e($message); ?></span>
                            </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                    <?php if($errors->isNotEmpty()): echo 'disabled'; endif; ?>
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

                function importTabs(name, radios) {
                    return {
                        name,
                        radios,
                    }
                }
            </script>

            <hr class="w-1/4 mx-auto border-white/30 border rounded-3xl">

            <div class="w-full bg-gray-900/50 rounded-xl px-6 py-4 space-y-3"
                 x-data="{ selectedPlatform: '<?php echo e(config('ticketing.platform')); ?>' }">
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 justify-between items-center">
                    <div>
                        <h5 class="text-xl text-white text-center sm:text-left">Ticketing</h5>
                        <span class="text-white/50">Manage settings for the ticketing integration</span>
                    </div>
                    <div class="text-center">
                        <div x-data="ticketingTabs('platform', platforms)"
                             class="inline-flex p-1 pr-0 bg-gray-900 rounded-full overflow-hidden">
                            <template x-for="radio in platforms">
                                <label :for="radio.id"
                                       class="block transition ease-in-out duration-200 px-4 py-1 rounded-full cursor-pointer text-white/50 hover:bg-gray-800/50 hover:text-white mr-1"
                                       :class="selectedPlatform === radio.value ? 'bg-gray-800 text-white': ''">
                                    <input type="radio"
                                           class="hidden"
                                           :id="radio.id"
                                           :value="radio.value"
                                           :name="name"
                                           x-model="selectedPlatform"
                                           @click="document.getElementById(radio.value).reset()"/>
                                    <div x-text="radio.label"></div>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>
                <div x-cloak
                     x-show="selectedPlatform !== 'none'"
                     class="space-y-3">
                    <hr class="border-white/10 border rounded-3xl">
                    <form action="#" id="ticketing" class="flex flex-col items-stretch space-y-2">
                        <div class="text-white/60 font-medium">
                            <label for="description">Description placeholder message</label>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-700 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <textarea form="ticket"
                                      wire:model.lazy="description"
                                      name="description"
                                      id="description"
                                      placeholder="<?php echo e(config('ticketing.subject_placeholder')); ?>"
                                      class="bg-gray-700/50 rounded-lg text-sm h-24 w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                        </textarea>
                        </div>
                        <div x-cloak
                             x-show="selectedPlatform === 'osticket'"
                             class="text-white/60 font-medium space-y-2">
                            <div>
                                <label for="osticket_base_url">Base URL</label>
                                <?php $__errorArgs = ['osticket_base_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-700 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <input form="ticket"
                                       wire:model.lazy="osticket_base_url"
                                       name="osticket_base_url"
                                       id="osticket_base_url"
                                       placeholder="<?php echo e(config('ticketing.osticket_base_url')); ?>"
                                       class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                            </div>
                            <div>
                                <label for="osticket_api_key">API Key</label>
                                <?php $__errorArgs = ['osticket_api_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-700 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <input form="ticket"
                                       wire:model.lazy="osticket_api_key"
                                       name="osticket_api_key"
                                       id="osticket_api_key"
                                       placeholder="<?php echo e(config('ticketing.osticket_api_key')); ?>"
                                       class="bg-gray-700/50 rounded-lg text-sm h-full w-full mt-1 text-white/75 caret-white p-2.5 resize-none border-0 ring-1 ring-slate-900/10 focus:outline-none placeholder:font-medium placeholder:text-white/20">
                            </div>
                        </div>
                        <button type="submit"
                                class="w-2/5 mx-auto p-2.5 rounded-lg bg-blue-900/50 mt-4 text-white/60 hover:smooth-hover hover:bg-blue-900/70 focus:outline-none focus:ring-2">
                            Save
                        </button>
                    </form>
                </div>
            </div>
            <script>
                const platforms = [
                    {
                        id: " option-tab-none",
                        value: "none",
                        label: "None"
                    },
                    {
                        id: "option-tab-osticket",
                        value: "osticket",
                        label: "osTicket"
                    }
                    // {
                    // id: "option-tab-zammad",
                    // value: "zammad",
                    // label: "Zammad"
                    // }
                ];

                function ticketingTabs(name, options) {
                    return {
                        name,
                        options,
                    }
                }
            </script>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /Users/lex/Coding/Projects/Laravel/intralab/resources/views/livewire/settings.blade.php ENDPATH**/ ?>