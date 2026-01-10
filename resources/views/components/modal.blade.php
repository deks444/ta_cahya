@props(['id', 'title', 'maxWidth' => '2xl'])

@php
    $maxWidth = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        '6xl' => 'max-w-6xl',
        '7xl' => 'max-w-7xl',
        'full' => 'max-w-full',
    ][$maxWidth];
@endphp

<template x-teleport="body">
    <div x-data="{ show: false }" x-show="show"
        x-on:open-modal.window="if ($event.detail.id === '{{ $id }}') show = true"
        x-on:close-modal.window="show = false" x-on:keydown.escape.window="show = false" style="display: none;"
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">

        {{-- Backdrop Overlay with Blur --}}
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"
            @click="show = false"></div>

        {{-- Modal Content Card --}}
        <div x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full {{ $maxWidth }} bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all border border-gray-100 dark:border-gray-700 mx-auto">

            {{-- Modal Header --}}
            <div
                class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800">
                @if(isset($title))
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 tracking-tight" id="modal-title">
                        {{ $title }}
                    </h3>
                @endif
                <button @click="show = false" type="button"
                    class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-blue-500 transition-colors dark:hover:text-gray-300">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="px-6 py-6 max-h-[90vh] overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</template>