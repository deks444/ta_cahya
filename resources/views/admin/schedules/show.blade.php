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
            <div
                class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">Daftar Peserta (Presensi)</h3>
                </div>

                <form action="{{ route('admin.schedules.attendance.save', $schedule->id) }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                            <thead
                                class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase font-semibold text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3 rounded-l-lg">Atlit</th>
                                    <th class="px-4 py-3 text-center">Aksi / Status</th>
                                    <th class="px-4 py-3 text-center rounded-r-lg">Hapus</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($schedule->participants as $participant)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
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
                                            <div class="flex items-center justify-center"
                                                x-data="{ status: '{{ $participant->status }}' }">
                                                <input type="hidden" :name="`attendance[{{ $participant->user_id }}][status]`"
                                                    x-model="status">

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
                                        <td class="px-4 py-3">
                                            {{-- Tombol Hapus Peserta --}}
                                            <div class="flex items-center justify-center">
                                                <button type="button"
                                                    class="delete-participant p-2 text-red-600 hover:text-red-800 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-red-900/20 rounded-lg transition"
                                                    data-url="{{ route('admin.schedules.participant.destroy', [$schedule->id, $participant->id]) }}"
                                                    data-name="{{ $participant->user->name }}" title="Hapus peserta">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">
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
                        {{-- Quota Card dengan Edit --}}
                        <div x-data="{ 
                                        editing: false, 
                                        quota: {{ $schedule->quota ?? 'null' }}, 
                                        originalQuota: {{ $schedule->quota ?? 'null' }},
                                        saving: false,
                                        async saveQuota() {
                                            if (this.quota === this.originalQuota) {
                                                this.editing = false;
                                                return;
                                            }
                                            this.saving = true;
                                            try {
                                                const response = await fetch('{{ route('admin.schedules.updateQuota', $schedule->id) }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify({ quota: this.quota })
                                                });
                                                if (response.ok) {
                                                    this.originalQuota = this.quota;
                                                    this.editing = false;
                                                } else {
                                                    alert('Gagal menyimpan quota');
                                                    this.quota = this.originalQuota;
                                                }
                                            } catch (error) {
                                                alert('Terjadi kesalahan');
                                                this.quota = this.originalQuota;
                                            } finally {
                                                this.saving = false;
                                            }
                                        },
                                        cancelEdit() {
                                            this.quota = this.originalQuota;
                                            this.editing = false;
                                        }
                                    }" class="border-b border-gray-100 dark:border-gray-700 pb-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm text-gray-500">Kuota Peserta</div>
                                <button @click="editing = !editing" x-show="!editing"
                                    class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                    title="Edit quota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <div x-show="!editing">
                                <div class="text-3xl font-bold"
                                    :class="quota !== null && {{ $schedule->participants->count() }} >= quota ? 'text-red-600 dark:text-red-400' : 'text-blue-600 dark:text-blue-400'">
                                    {{ $schedule->participants->count() }}<span class="text-lg text-gray-400"
                                        x-show="quota !== null"> / <span x-text="quota"></span></span><span
                                        class="text-lg text-gray-400" x-show="quota === null"> / ∞</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span x-show="quota === null">Tanpa batas</span>
                                    <span x-show="quota !== null">
                                        <span x-show="{{ $schedule->participants->count() }} < quota"
                                            class="text-green-600">Tersedia</span>
                                        <span x-show="{{ $schedule->participants->count() }} >= quota"
                                            class="text-red-600">Penuh</span>
                                    </span>
                                </div>
                            </div>

                            <div x-show="editing" x-cloak class="space-y-2">
                                <input type="number" x-model.number="quota" min="0" placeholder="Tanpa batas"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                    @keydown.enter="saveQuota()" @keydown.escape="cancelEdit()">
                                <div class="flex gap-2">
                                    <button @click="saveQuota()" :disabled="saving"
                                        class="flex-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition disabled:opacity-50">
                                        <span x-show="!saving">Simpan</span>
                                        <span x-show="saving">Menyimpan...</span>
                                    </button>
                                    <button @click="cancelEdit()" :disabled="saving"
                                        class="flex-1 px-3 py-1.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-medium transition disabled:opacity-50">
                                        Batal
                                    </button>
                                </div>
                                <div class="text-xs text-gray-500">
                                    Kosongkan untuk tanpa batas
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="text-3xl font-bold text-gray-800 dark:text-white">
                                {{ $schedule->participants->count() }}
                            </div>
                            <div class="text-sm text-gray-500">Total Pendaftar</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                                {{ $schedule->participants->where('status', 'attended')->count() }}
                            </div>
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

@push('scripts')
    <script>
        // Handle delete participant button
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-participant').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    const url = this.dataset.url;
                    const name = this.dataset.name;

                    if (confirm(`Yakin ingin menghapus ${name} dari daftar peserta? Tindakan ini tidak dapat dibatalkan.`)) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;

                        // Add CSRF token
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';
                        form.appendChild(csrfInput);

                        // Add method spoofing for DELETE
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush