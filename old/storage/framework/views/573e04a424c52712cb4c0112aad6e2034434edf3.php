<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e($title ?? config()->get('app.name')); ?></title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo \Livewire\Livewire::styles(); ?>


    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Focus plugin -->
    <script defer src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        [x-cloak] {
            display: none;
        }
    </style>
</head>
<body>
<div class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 flex-1 flex flex-col space-y-5 lg:space-y-0 lg:flex-row md:p-2 h-screen">
        <?php if(Auth::hasRole('needs-sync') && !session()->has('success') && !session()->has('synced')): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('sync-ldap', [])->html();
} elseif ($_instance->childHasBeenRendered('YiZzth7')) {
    $componentId = $_instance->getRenderedChildComponentId('YiZzth7');
    $componentTag = $_instance->getRenderedChildComponentTagName('YiZzth7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YiZzth7');
} else {
    $response = \Livewire\Livewire::mount('sync-ldap', []);
    $html = $response->html();
    $_instance->logRenderedChild('YiZzth7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <div class="flex-1 px-0 md:px-8 lg:p-8 space-y-5 sm:space-y-10 overflow-auto">
                <?php echo e($slot); ?>

            </div>
        <?php endif; ?>
    </div>
</div>


<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('livewire-ui-modal')->html();
} elseif ($_instance->childHasBeenRendered('BkaGZRO')) {
    $componentId = $_instance->getRenderedChildComponentId('BkaGZRO');
    $componentTag = $_instance->getRenderedChildComponentTagName('BkaGZRO');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('BkaGZRO');
} else {
    $response = \Livewire\Livewire::mount('livewire-ui-modal');
    $html = $response->html();
    $_instance->logRenderedChild('BkaGZRO', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php echo \Livewire\Livewire::scripts(); ?>

</body>
</html>
<?php /**PATH /Users/lex/Coding/Projects/Laravel/intralab/resources/views/layouts/app.blade.php ENDPATH**/ ?>