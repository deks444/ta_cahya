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
        class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        {{-- Backdrop Overlay with Blur --}}
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"
            @click="show = false"></div>

        {{-- Layout Wrapper to center modal --}}
        <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-6">
            {{-- Modal Content Card --}}
            <div x-show="show" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full {{ $maxWidth }} bg-white dark:bg-gray-800 rounded-2xl text-left shadow-2xl transform transition-all border border-gray-100 dark:border-gray-700"
                @click.stop>

                {{-- Modal Header --}}
                <div
                    class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800 rounded-t-2xl">
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
                <div class="px-6 py-6">
                    {{ $slot }}
                </div>

                {{-- Modal Footer --}}
                @if(isset($footer))
                    <div
                        class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-x-2 rounded-b-2xl">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</template>