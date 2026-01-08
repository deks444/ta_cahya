@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $schedule->activity->name }}</h1>
                <p class="text-gray-500 dark:text-gray-400">
                    {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }} •
                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB •
                    {{ $schedule->location }}
                </p>
            </div>
            <a href="{{ request('source') === 'calendar' ? route('admin.schedules.index') : route('admin.attendance.index') }}"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                &larr; Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400"
                role="alert">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        {{-- Detail Card --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">Daftar Peserta (Presensi)</h3>
                </div>

                <form action="{{ route('admin.schedules.attendance.save', $schedule->id) }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase font-semibold text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3 rounded-l-lg">Atlit</th>
                                    <th class="px-4 py-3 text-center">Aksi / Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($schedule->participants as $participant)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                                    {{ substr($participant->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    {{ $participant->user->name }}
                                                    <div class="text-xs text-gray-400">{{ $participant->user->username }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            {{-- Local Alpine State for Row --}}
                                            <div class="flex items-center justify-center" x-data="{ status: '{{ $participant->status }}' }">
                                                <input type="hidden" :name="`attendance[{{ $participant->user_id }}][status]`" x-model="status">
                                                
                                                <div class="inline-flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                                                    {{-- Tombol Hadir --}}
                                                    <button type="button" @click="status = 'attended'"
                                                        :class="status === 'attended' ? 'bg-white shadow text-green-600 dark:bg-gray-600 dark:text-green-400' : 'text-gray-500 hover:text-gray-700'"
                                                        class="px-4 py-1.5 rounded-md text-xs font-bold transition">
                                                        Hadir
                                                    </button>

                                                    {{-- Tombol Absen --}}
                                                    <button type="button" @click="status = 'absent'"
                                                        :class="status === 'absent' ? 'bg-white shadow text-red-600 dark:bg-gray-600 dark:text-red-400' : 'text-gray-500 hover:text-gray-700'"
                                                        class="px-4 py-1.5 rounded-md text-xs font-bold transition">
                                                        Absen
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-8 text-center text-gray-500">
                                            Belum ada peserta yang mendaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($schedule->participants->isNotEmpty())
                        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                            <button type="submit" 
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition shadow-lg shadow-blue-200 dark:shadow-none">
                                Simpan Seluruh Presensi
                            </button>
                        </div>
                    @endif
                </form>
            </div>

            {{-- Side info --}}
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="font-bold text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Ringkasan
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <div class="text-3xl font-bold text-gray-800 dark:text-white">
                                {{ $schedule->participants->count() }}</div>
                            <div class="text-sm text-gray-500">Total Pendaftar</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                                {{ $schedule->participants->where('status', 'attended')->count() }}</div>
                            <div class="text-sm text-gray-500">Hadir</div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="font-bold text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Pelatih
                    </h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                            {{-- Avatar placeholder --}}
                            <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-gray-800 dark:text-white">{{ $schedule->coach->name }}</div>
                            <div class="text-xs text-gray-500">Coach</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection