@extends('layout.main')

@section('content')
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto min-h-screen">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="bg-teal-100 border border-teal-200 text-sm text-teal-800 rounded-lg p-4 mb-6" role="alert">
                <span class="font-bold">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 mb-6" role="alert">
                <span class="font-bold">Error!</span> {{ session('error') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-10 text-center">
            <h2 class="text-2xl font-bold md:text-3xl text-gray-800 dark:text-white">Jadwal Latihan</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Pilih sesi latihan yang sesuai dengan waktu Anda.</p>
        </div>

        {{-- Bagian 1: Jadwal Tersedia --}}
        <div class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Jadwal Tersedia
                </h3>
            </div>

            @if($availableSchedules->isEmpty())
                <div
                    class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center text-gray-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                    Belum ada jadwal latihan baru yang tersedia saat ini.
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availableSchedules as $schedule)
                        <div
                            class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                            <div
                                class="h-40 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl overflow-hidden relative">
                                {{-- Pattern Overlay --}}
                                <div
                                    class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
                                </div>

                                <h3 class="text-2xl font-bold text-white relative z-10">{{ $schedule->activity->name }}</h3>
                                <p class="text-blue-100 relative z-10 text-sm mt-1">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</p>
                            </div>
                            <div class="p-4 md:p-6">
                                <span class="block mb-1 text-xs font-semibold uppercase text-blue-600 dark:text-blue-500">
                                    {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }}
                                </span>
                                <div class="mt-3 flex items-center gap-2 text-gray-500 text-sm dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $schedule->location }}
                                </div>
                                <div class="mt-1 flex items-center gap-2 text-gray-500 text-sm dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Coach {{ $schedule->coach->name }}
                                </div>
                            </div>
                            <div
                                class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                                <form action="{{ route('atlit.schedules.join', $schedule->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-b-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800 text-blue-600 font-bold hover:text-blue-800">
                                        Gabung Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Bagian 2: Jadwal Saya --}}
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    Agenda Saya
                </h3>
            </div>

            @if($mySchedules->isEmpty())
                <div
                    class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center text-gray-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                    Anda belum terdaftar di jadwal latihan apapun.
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($mySchedules as $participation)
                        @php $schedule = $participation->schedule; @endphp
                        <div
                            class="group flex flex-col h-full bg-white border border-green-200 shadow-sm rounded-xl dark:bg-slate-900 dark:border-green-800 dark:shadow-slate-700/[.7] overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                            {{ $schedule->activity->name }}
                                        </h3>
                                        @if($participation->status == 'attended')
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mt-2">Hadir</span>
                                        @elseif($participation->status == 'absent')
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 mt-2">Tidak Hadir</span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 mt-2">Terdaftar</span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-3xl font-bold text-gray-800 dark:text-white">
                                            {{ \Carbon\Carbon::parse($schedule->date)->format('d') }}</p>
                                        <p class="text-sm font-medium text-gray-500 uppercase">
                                            {{ \Carbon\Carbon::parse($schedule->date)->format('M') }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB
                                    </div>
                                    <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $schedule->location }}
                                    </div>
                                    <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Coach {{ $schedule->coach->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 p-4">
                                <form action="{{ route('atlit.schedules.leave', $schedule->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan pendaftaran?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 w-full text-center">
                                        Batalkan Pendaftaran
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Bagian 3: Riwayat Kelas --}}
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat Latihan
                </h3>
            </div>

            @if($historySchedules->isEmpty())
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center text-gray-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                    Belum ada riwayat latihan.
                </div>
            @else
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="border rounded-lg overflow-hidden dark:border-gray-700">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Tanggal</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Kegiatan</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Pelatih</th>
                                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($historySchedules as $participation)
                                            @php $histSchedule = $participation->schedule; @endphp
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    {{ \Carbon\Carbon::parse($histSchedule->date)->translatedFormat('d M Y') }} <span class="text-gray-500">({{ \Carbon\Carbon::parse($histSchedule->start_time)->format('H:i') }})</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    {{ $histSchedule->activity->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    {{ $histSchedule->coach->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                    @if($participation->status === 'attended')
                                                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                                            Hadir
                                                        </span>
                                                    @elseif($participation->status === 'absent')
                                                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">
                                                            Tidak Hadir
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400">
                                                            Terdaftar
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
@endsection