@extends('admin.layouts.app')

@section('content')
    <div class="col-span-12 space-y-6">
        {{-- Header & Button --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4" x-data>
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Jadwal Latihan</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Klik tanggal untuk menambah jadwal, atau klik event
                    untuk mengedit.</p>
            </div>
            <button @click="$dispatch('open-modal', { id: 'createScheduleModal' })"
                class="w-full sm:w-auto px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 whitespace-nowrap">
                + Buat Jadwal Baru
            </button>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400"
                role="alert">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        {{-- Calendar Container --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-800 lg:p-6">
            <div id="scheduleCalendar" class="min-h-[600px]"></div>
        </div>

    </div>

    {{-- Modals Container (Moved Outside Main Grid) --}}
    <div x-data>
        {{-- Create Modal --}}
        <x-modal id="createScheduleModal" title="Buat Jadwal Latihan" maxWidth="2xl">
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="activity_id"
                            class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jenis Kegiatan</label>
                        <select name="activity_id" id="activity_id" required
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($activities as $activity)
                                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="date"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tanggal</label>
                            <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" required
                                class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                        </div>
                        <div>
                            <label for="start_time"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jam Mulai</label>
                            <input type="time" name="start_time" id="start_time" list="time-options" required
                                class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                            <datalist id="time-options">
                                <option value="06:00">
                                <option value="07:00">
                                <option value="08:00">
                                <option value="09:00">
                                <option value="10:00">
                                <option value="15:00">
                                <option value="16:00">
                                <option value="17:00">
                                <option value="18:30">
                                <option value="19:00">
                                <option value="20:00">
                            </datalist>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <label for="location"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Lokasi
                                Latihan</label>
                            <input type="text" name="location" id="location" value="Lapangan Utama" required
                                class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                        </div>
                        <div class="col-span-1">
                            <label for="quota"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Kuota</label>
                            <input type="number" name="quota" id="quota" placeholder="∞"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="coach_id"
                            class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Pilih Pelatih</label>
                        <select name="coach_id" id="coach_id" required
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                            @foreach($coaches as $coach)
                                <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <button type="button" @click="$dispatch('close-modal')"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition shadow-lg shadow-blue-200 dark:shadow-none">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Edit Modal --}}
        <x-modal id="editScheduleModal" title="Edit Jadwal Latihan" maxWidth="2xl">
            <div x-data="{ schedule: { id: '', activity_id: '', date: '', start_time: '', location: '', quota: '', status: '', coach_id: '' } }"
                x-on:open-modal.window="if ($event.detail.id === 'editScheduleModal') {
                                                            schedule = $event.detail.schedule;
                                                            if(schedule.start_time && schedule.start_time.length > 5) schedule.start_time = schedule.start_time.substring(0, 5);
                                                         }">
                <form :action="`{{ url('admin/schedules') }}/${schedule.id}`" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jenis
                                Kegiatan</label>
                            <select name="activity_id" x-model="schedule.activity_id" required
                                class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Tanggal</label>
                                <input type="date" name="date" x-model="schedule.date" required
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Jam</label>
                                <input type="time" name="start_time" x-model="schedule.start_time" list="time-options"
                                    required
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Lokasi</label>
                                <input type="text" name="location" x-model="schedule.location" required
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Status</label>
                                <select name="status" x-model="schedule.status" required
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                                    <option value="scheduled">Terjadwal</option>
                                    <option value="cancelled">Dibatalkan</option>
                                    <option value="completed">Selesai</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Pelatih</label>
                            <select name="coach_id" x-model="schedule.coach_id" required
                                class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                                @foreach($coaches as $coach)
                                    <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Delete --}}
                    {{-- Action Buttons --}}
                    <div class="mt-8 space-y-4">
                        {{-- Presensi CTA --}}
                        <a :href="`{{ url('admin/attendance') }}/${schedule.id}?source=calendar`"
                            class="flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl transition dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            Kelola Presensi & Peserta
                        </a>

                        <div class="flex items-center {{ Auth::user()->role === 'admin' ? 'justify-between' : 'justify-end' }} pt-4 border-t border-gray-100 dark:border-gray-700">
                            {{-- Delete (Admin Only) --}}
                            @if(Auth::user()->role === 'admin')
                                <button type="button"
                                    @click="if(confirm('Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.')) { document.getElementById('delete-form-' + schedule.id).submit(); }"
                                    class="flex items-center gap-2 text-red-500 hover:text-red-700 text-sm font-medium transition py-2 px-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Hapus
                                </button>
                            @endif

                            <div class="flex gap-3">
                                <button type="button" @click="$dispatch('close-modal')"
                                    class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition shadow-lg shadow-blue-200 dark:shadow-none">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Form Delete Hidden --}}
                <form :id="'delete-form-' + schedule.id" :action="`{{ url('admin/schedules') }}/${schedule.id}`"
                    method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            </div>
        </x-modal>
    </div>

    <!-- Load FullCalendar via ES Module to avoid global conflicts -->
    <script type="module">
        import { Calendar } from 'https://cdn.skypack.dev/@fullcalendar/core@6.1.10';
        import dayGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.10';
        import timeGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/timegrid@6.1.10';
        import listPlugin from 'https://cdn.skypack.dev/@fullcalendar/list@6.1.10';
        import interactionPlugin from 'https://cdn.skypack.dev/@fullcalendar/interaction@6.1.10'; // Needed for selectable/clickable

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('scheduleCalendar');

            if (calendarEl) {
                console.log('Calendar Element Found:', calendarEl);
            } else {
                console.error('Calendar Element NOT Found!');
                return;
            }

            var calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                height: 'auto',
                contentHeight: 600,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 640 ? 'dayGridMonth' : 'dayGridMonth,timeGridWeek,listWeek'
                },
                buttonText: {
                    today: window.innerWidth < 640 ? 'Hari Ini' : 'Hari Ini',
                    month: window.innerWidth < 640 ? 'Bulan' : 'Bulan',
                    week: window.innerWidth < 640 ? 'Minggu' : 'Minggu',
                    list: window.innerWidth < 640 ? 'List' : 'List'
                },
                events: @json($events),
                editable: false,
                selectable: true,
                dayMaxEvents: true,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },

                // Klik pada tanggal kosong -> Buka Modal Create
                select: function (info) {
                    document.getElementById('date').value = info.startStr;
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: 'createScheduleModal' } }));
                },

                // Klik pada Event -> Buka Modal Edit
                eventClick: function (info) {
                    var eventData = info.event;
                    var schedule = {
                        id: eventData.id,
                        activity_id: '',
                        date: eventData.start.toISOString().split('T')[0],
                        start_time: eventData.start.toTimeString().split(' ')[0],
                        location: eventData.extendedProps.schedule_data ? eventData.extendedProps.schedule_data.location : 'Lapangan',
                        status: eventData.extendedProps.status
                    };

                    if (eventData.extendedProps.schedule_data) {
                        schedule = eventData.extendedProps.schedule_data;
                    }

                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: {
                            id: 'editScheduleModal',
                            schedule: schedule
                        }
                    }));
                },

                eventContent: function (arg) {
                    let italicEl = document.createElement('div');
                    let time = arg.timeText || '';
                    let title = arg.event.title;
                    let coach = arg.event.extendedProps.coach || '-';
                    italicEl.innerHTML = `<div class="p-1 overflow-hidden leading-tight">
                                        <span class="block text-xs font-bold truncate">${title}</span>
                                        <span class="block text-[10px] truncate">(${coach})</span>
                                        <span class="block text-[10px] font-medium opacity-90">${time}</span>
                                    </div>`;
                    return { domNodes: [italicEl] };
                }
            });

            console.log('Initializing Calendar (Module)...');
            calendar.render();
            console.log('Calendar Rendered.');
        });
    </script>
    <style>
        /* Custom Style untuk FullCalendar agar match dengan theme */
        :root {
            --fc-border-color: #e5e7eb;
            --fc-button-bg-color: #3b82f6;
            --fc-button-border-color: #3b82f6;
            --fc-button-hover-bg-color: #2563eb;
            --fc-button-hover-border-color: #2563eb;
            --fc-button-active-bg-color: #1d4ed8;
            --fc-today-bg-color: rgba(59, 130, 246, 0.1);
        }

        .dark {
            --fc-border-color: #374151;
            --fc-page-bg-color: #1f2937;
            --fc-neutral-bg-color: #111827;
            --fc-list-event-hover-bg-color: #374151;
            --fc-theme-standard-border-color: #374151;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: var(--fc-border-color);
        }

        /* Memastikan calendar selalu visible */
        #scheduleCalendar {
            display: block !important;
            visibility: visible !important;
        }

        /* Responsive Styles untuk Mobile */
        @media (max-width: 640px) {

            /* Tombol toolbar lebih kecil di mobile */
            .fc .fc-button {
                padding: 0.25rem 0.5rem !important;
                font-size: 0.75rem !important;
                line-height: 1.25rem !important;
            }

            /* Title lebih kecil di mobile */
            .fc .fc-toolbar-title {
                font-size: 1rem !important;
                line-height: 1.5rem !important;
            }

            /* Spacing toolbar lebih kecil */
            .fc .fc-toolbar {
                gap: 0.25rem !important;
            }

            .fc .fc-toolbar-chunk {
                display: flex;
                gap: 0.25rem !important;
            }

            /* Event content lebih kecil */
            .fc-event {
                font-size: 0.65rem !important;
                padding: 1px !important;
            }

            /* Day cell header lebih kecil */
            .fc .fc-col-header-cell {
                font-size: 0.7rem !important;
                padding: 0.25rem 0.125rem !important;
            }

            /* Day number lebih kecil */
            .fc .fc-daygrid-day-number {
                font-size: 0.75rem !important;
                padding: 0.125rem !important;
            }

            /* Reduce calendar padding */
            .fc .fc-view-harness {
                padding: 0 !important;
            }
        }

        /* Tablet adjustments */
        @media (min-width: 641px) and (max-width: 1024px) {
            .fc .fc-button {
                padding: 0.375rem 0.75rem !important;
                font-size: 0.875rem !important;
            }

            .fc .fc-toolbar-title {
                font-size: 1.25rem !important;
            }
        }
    </style>
@endsection