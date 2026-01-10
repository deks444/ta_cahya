@extends('admin.layouts.app')

@section('page-title', 'Jadwal Latihan')

@section('content')
    <div x-data>
        <div class="col-span-12 space-y-6 xl:col-span-12">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-800 lg:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Jadwal Latihan</h3>
                    <button @click="$dispatch('open-modal', { id: 'createScheduleModal' })"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                        + Buat Jadwal Baru
                    </button>
                </div>

                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400"
                        role="alert">
                        <span class="font-medium">Sukses!</span> {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400"
                        role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Kegiatan
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Waktu
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Lokasi
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Pelatih
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($schedules as $schedule)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{-- Icon Placeholder --}}
                                            <div
                                                class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 font-bold text-lg">
                                                {{ substr($schedule->activity->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $schedule->activity->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $schedule->participants->count() }} Pendaftar
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white font-medium">
                                            {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Pukul {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $schedule->location }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $schedule->coach->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($schedule->status == 'scheduled')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                Terjadwal
                                            </span>
                                        @elseif($schedule->status == 'completed')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <button @click="$dispatch('open-modal', { 
                                                                id: 'editScheduleModal', 
                                                                schedule: {{ $schedule }}
                                                            })"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                Edit
                                            </button>

                                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if($schedules->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada jadwal latihan yang dibuat.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Create Modal --}}
        <x-modal id="createScheduleModal" title="Buat Jadwal Latihan">
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf

                {{-- Grid 2 Kolom --}}
                <div class="grid grid-cols-1 gap-5">
                    {{-- Pilih Kegiatan --}}
                    <div>
                        <label for="activity_id"
                            class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jenis Kegiatan</label>
                        <select name="activity_id" id="activity_id" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($activities as $activity)
                                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Tanggal --}}
                        <div>
                            <label for="date"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tanggal</label>
                            <input type="date" name="date" id="date" required
                                class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                        </div>
                        {{-- Jam --}}
                        <div>
                            <label for="start_time"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jam Mulai</label>
                            <input type="time" name="start_time" id="start_time" required
                                class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                        </div>
                    </div>

                    {{-- Lokasi & Kuota --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <label for="location"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Lokasi
                                Latihan</label>
                            <input type="text" name="location" id="location" value="Lapangan Utama" required
                                class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                        </div>
                        <div class="col-span-1">
                            <label for="quota"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Kuota
                                (Opsional)</label>
                            <input type="number" name="quota" id="quota" placeholder="∞"
                                class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                        </div>
                    </div>

                    {{-- Pilih Pelatih (Jika Admin) --}}
                    @if(Auth::user()->role === 'admin')
                        <div>
                            <label for="coach_id"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Pilih Pelatih</label>
                            <select name="coach_id" id="coach_id" required
                                class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                                <option value="{{ Auth::id() }}">Saya Sendiri ({{ Auth::user()->name }})</option>
                                @foreach($coaches as $coach)
                                    <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <button type="button" @click="$dispatch('close-modal')"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-all">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Edit Modal --}}
        <x-modal id="editScheduleModal" title="Edit Jadwal Latihan">
            <div x-data="{ schedule: { id: '', activity_id: '', date: '', start_time: '', location: '', quota: '', status: '' } }"
                x-on:open-modal.window="if ($event.detail.id === 'editScheduleModal') { 
                        schedule = $event.detail.schedule;
                        // Format time string HH:MM:SS to HH:MM for input time
                        if(schedule.start_time && schedule.start_time.length > 5) schedule.start_time = schedule.start_time.substring(0, 5); 
                     }">

                <form :action="`{{ url('admin/schedules') }}/${schedule.id}`" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5">
                        {{-- Pilih Kegiatan --}}
                        <div>
                            <label for="edit_activity_id"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jenis
                                Kegiatan</label>
                            <select name="activity_id" id="edit_activity_id" x-model="schedule.activity_id" required
                                class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Tanggal --}}
                            <div>
                                <label for="edit_date"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tanggal</label>
                                <input type="date" name="date" id="edit_date" x-model="schedule.date" required
                                    class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                            </div>
                            {{-- Jam --}}
                            <div>
                                <label for="edit_start_time"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jam
                                    Mulai</label>
                                <input type="time" name="start_time" id="edit_start_time" x-model="schedule.start_time"
                                    required
                                    class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                            </div>
                        </div>

                        {{-- Lokasi & Status --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_location"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Lokasi</label>
                                <input type="text" name="location" id="edit_location" x-model="schedule.location" required
                                    class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                            </div>
                            <div>
                                <label for="edit_status"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Status</label>
                                <select name="status" id="edit_status" x-model="schedule.status" required
                                    class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                                    <option value="scheduled">Terjadwal</option>
                                    <option value="cancelled">Dibatalkan</option>
                                    <option value="completed">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3">
                        <button type="button" @click="$dispatch('close-modal')"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-all">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-all">
                            Update Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>
    </div>
@endsection