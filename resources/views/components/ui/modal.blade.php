<template x-teleport="body">
    <div {{ $attributes->merge(['class' => 'fixed left-0 right-0 top-0 bottom-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-400/50 backdrop-blur-md dark:bg-gray-900/80 p-4 md:p-6']) }}
        x-show="open" style="display: none;" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform opacity-0" x-transition:enter-end="transform opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="transform opacity-100"
        x-transition:leave-end="transform opacity-0">
        <div @click.outside="open = false">
            {{ $slot }}
        </div>
    </div>
</template>