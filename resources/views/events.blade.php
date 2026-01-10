@extends('layout.layout')

@section('page-title', 'Riwayat Kegiatan - Sharefit')

@section('content')
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title -->
        <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">Riwayat Kegiatan</h2>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Arsip kegiatan dan latihan yang telah dilaksanakan bersama
                Sharefit.</p>
        </div>
        <!-- End Title -->

        <!-- Stats -->
        <div class="max-w-2xl mx-auto grid grid-cols-2 gap-4 mb-10">
            <div class="text-center">
                <h3 class="text-3xl font-bold text-blue-600 dark:text-blue-500">{{ $totalEvents }}</h3>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Kegiatan Terlaksana</p>
            </div>
            <div class="text-center">
                <h3 class="text-3xl font-bold text-blue-600 dark:text-blue-500">{{ $totalParticipants }}+</h3>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Total Partisipan</p>
            </div>
        </div>
        <!-- End Stats -->

        @if($schedules->count() > 0)
            <!-- Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schedules as $schedule)
                    <div
                        class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl p-5 dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7] hover:shadow-md transition-all">
                        <div class="mb-4">
                            <span
                                class="inline-block py-1 px-2 rounded-lg bg-blue-50 text-xs font-semibold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ $schedule->date->format('d F Y') }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                {{ $schedule->activity->name ?? 'Kegiatan Umum' }}
                            </h3>
                            <div class="mt-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                            </div>
                            <div class="mt-1 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $schedule->location }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- End Grid -->

            <!-- Pagination -->
            <div class="mt-10">
                {{ $schedules->links() }}
            </div>
        @else
            <div
                class="flex flex-col items-center justify-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Belum ada riwayat kegiatan.</h3>
                <p class="text-gray-500 mt-2">Kegiatan yang telah dilaksanakan akan muncul di sini.</p>
            </div>
        @endif
    </div>
@endsection