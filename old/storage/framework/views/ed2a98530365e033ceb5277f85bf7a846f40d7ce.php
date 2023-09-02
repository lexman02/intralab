<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['title' => request()->route()->getName()]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['title' => request()->route()->getName()]); ?>
<?php foreach (array_filter((['title' => request()->route()->getName()]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="flex justify-between items-center px-4 sm:px-0">
    <h3 class="text-3xl font-extralight text-white/50"><?php echo e(Str::title($title)); ?></h3>
    
    <?php if(Auth::hasRole(config('sync.admin_role'), 'master-realm') && $title === 'Apps'): ?>
        <div class="inline-flex items-center space-x-2">
            
            
            
            
            
            
            
            <a class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover"
               :class="empty === true ? 'animate-pulse':''"
               href="#"
               wire:click="$emit('openModal', 'add-app-modal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                </svg>
            </a>
            <a
                x-cloak
                x-show="!empty"
                class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover"
                :class="edit === true ? 'bg-gray-900/40 text-white/25 transition':''"
                @click="edit = !edit"
                href="#">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z"/>
                </svg>
            </a>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /Users/lex/Coding/Projects/Laravel/intralab/resources/views/components/header.blade.php ENDPATH**/ ?>