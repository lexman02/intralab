<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['item', 'editMode']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['item', 'editMode']); ?>
<?php foreach (array_filter((['item', 'editMode']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php if($editMode): ?>
    <button wire:click="$emit('openEditModal', <?php echo e(json_encode($item)); ?>)"
<?php else: ?>
    <a href="<?php echo e($item->url); ?>"
       <?php endif; ?>
       class="relative bg-gray-700/80 py-3 md:py-4 sm:py-20 w-full h-36 flex flex-col items-center cursor-pointer rounded-md hover:bg-gray-700/40 hover:smooth-hover">
        
        
        
        
        
        
        <img class="w-1/6 sm:w-3/12 object-cover object-center rounded-xl mb-1.5"
             src="https://cdn.jsdelivr.net/gh/walkxcode/dashboard-icons/png/<?php echo e($item->icon ? $item->icon : 'ubuntu'); ?>.png"
             alt="<?php echo e($item->icon ? $item->icon : 'ubuntu' . '_icon'); ?>"/>
        <div class="flex flex-col h-full w-full items-center justify-center">
            <h4 class="text-white text-xl font-semibold text-center"><?php echo e($item->name); ?></h4>
            <span class="text-white/50 text-sm"><?php echo e($item->description); ?></span>
        </div>
    </a>
<?php /**PATH /Users/lex/Coding/Projects/Laravel/intralab/resources/views/components/card.blade.php ENDPATH**/ ?>