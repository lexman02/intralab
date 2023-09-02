<div class="space-y-5 pb-5"
     x-data="{ edit: <?php if ((object) ('editMode') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('editMode'->value()); ?>')<?php echo e('editMode'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('editMode'); ?>')<?php endif; ?>, empty: false }">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header','data' => ['title' => 'Apps']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Apps']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <div x-cloak
         x-show="edit"
         x-transition:enter="transition ease-in duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="w-full bg-gray-700/40 rounded-lg p-4 text-center flex flex-col border-dashed border-4 border-gray-600">
        <span class="uppercase font-bold text-white/40 text-xl">Edit Mode</span>
        <span class="text-white/20">Select an app below to edit it's attributes</span>
    </div>
    <?php if(session()->has('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded-md">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="grid gap-5 sm:gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 px-4">
        
        
        
        
        
        
        
        
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['editMode' => $editMode,'item' => $item]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['editMode' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editMode),'item' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div
                x-init="empty = true"
                class="bg-gray-700/80 col-span-full text-white text-lg p-4 rounded-md">
                <span class="rounded-r-2xl rounded-l-md bg-gray-500/60 py-4 px-6 mr-4 -ml-4 -my-4 font-black text-2xl">!</span>
                No items found
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /Users/lex/Coding/Projects/Laravel/intralab/resources/views/livewire/dashboard.blade.php ENDPATH**/ ?>