@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6" x-data="{ 
            editMode: false, 
            currentAchievement: { id: '', name: '', rank: '', user_id: '' } 
        }">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Prestasi</h1>
                <p class="text-gray-500">Kelola semua data prestasi dan penghargaan atlit.</p>
            </div>
            <button
                @click="editMode = false; currentAchievement = { id: '', name: '', rank: '', user_id: '' }; $dispatch('open-modal', { id: 'achievementModal' })"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                + Tambah Prestasi
            </button>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Atlit</th>
                                <th class="px-4 py-3">Nama Prestasi</th>
                                <th class="px-4 py-3">Peringkat/Tingkat</th>
                                <th class="px-4 py-3 text-center">Berkas</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($achievements as $achievement)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-800">{{ $achievement->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $achievement->user->username }}</div>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        {{ $achievement->name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-bold">
                                            {{ $achievement->rank }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ asset($achievement->file_path) }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800 inline-flex items-center gap-1 font-semibold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                @click="editMode = true; currentAchievement = { id: '{{ $achievement->id }}', name: '{{ $achievement->name }}', rank: '{{ $achievement->rank }}', user_id: '{{ $achievement->user_id }}' }; $dispatch('open-modal', { id: 'achievementModal' })"
                                                class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            <form action="{{ route('admin.achievements.destroy', $achievement->id) }}"
                                                method="POST" onsubmit="return confirm('Hapus prestasi ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data prestasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $achievements->links() }}
                </div>
            </div>
        </div>

        {{-- Modal Achievement --}}
        <x-modal id="achievementModal" title="Form Prestasi">
            <form
                :action="editMode ? `{{ url('admin/achievements') }}/${currentAchievement.id}` : `{{ route('admin.achievements.store') }}`"
                method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Atlit</label>
                    <select name="user_id" x-model="currentAchievement.user_id" required
                        class="block w-full px-4 py-2 rounded-lg border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 transition-all">
                        <option value="">-- Pilih Atlit --</option>
                        @foreach($athletes as $athlete)
                            <option value="{{ $athlete->id }}">{{ $athlete->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Prestasi</label>
                    <input type="text" name="name" x-model="currentAchievement.name" required
                        placeholder="Contoh: Juara 1 Karate Open"
                        class="block w-full px-4 py-2 rounded-lg border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Peringkat / Tingkat</label>
                    <select name="rank" x-model="currentAchievement.rank" required
                        class="block w-full px-4 py-2 rounded-lg border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 transition-all">
                        <option value="">-- Pilih Peringkat --</option>
                        <option value="Juara 1">Juara 1</option>
                        <option value="Juara 2">Juara 2</option>
                        <option value="Juara 3">Juara 3</option>
                        <option value="Juara Harapan">Juara Harapan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Berkas Sertifikat</label>
                    <input type="file" name="file" :required="!editMode"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-400">PDF, JPG, PNG (Max. 2MB). <span x-show="editMode">Kosongkan jika
                            tidak ingin mengubah berkas.</span></p>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <button type="button" @click="$dispatch('close-modal')"
                        class="px-5 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        <span x-text="editMode ? 'Simpan Perubahan' : 'Tambah Prestasi'"></span>
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
@endsection