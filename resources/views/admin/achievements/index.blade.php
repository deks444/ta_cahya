@extends('admin.layouts.app')

@section('page-title', 'Manajemen Prestasi')

@section('content')
    <div class="space-y-6" x-data="{ 
                                editMode: false, 
                                currentAchievement: { id: '', name: '', rank: '', user_id: '' },
                                previewFile: null,
                                isImage(url) {
                                    if(!url) return false;
                                    const ext = url.split('.').pop().toLowerCase();
                                    return ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext);
                                }
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
                                        <button type="button"
                                            @click="previewFile = '{{ asset($achievement->file_path) }}'; $dispatch('open-modal', { id: 'previewModal' })"
                                            class="text-blue-600 hover:text-blue-800 inline-flex items-center gap-1 font-semibold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat
                                        </button>
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
        {{-- Modal Achievement --}}
        <x-modal id="achievementModal" title="Form Prestasi" maxWidth="4xl">
            <form
                :action="editMode ? `{{ url('admin/achievements') }}/${currentAchievement.id}` : `{{ route('admin.achievements.store') }}`"
                method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Pilih Atlit <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="user_id" x-model="currentAchievement.user_id"
                            style="width: 100% !important; box-sizing: border-box !important;" required
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all box-border appearance-none">
                            <option value="">-- Pilih Atlit --</option>
                            @foreach($athletes as $athlete)
                                <option value="{{ $athlete->id }}">{{ $athlete->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Nama Prestasi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="currentAchievement.name" required
                        placeholder="Contoh: Juara 1 Karate Open"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Peringkat / Tingkat <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="rank" x-model="currentAchievement.rank"
                            style="width: 100% !important; box-sizing: border-box !important;" required
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all box-border appearance-none">
                            <option value="">-- Pilih Peringkat --</option>
                            <option value="Juara 1">Juara 1</option>
                            <option value="Juara 2">Juara 2</option>
                            <option value="Juara 3">Juara 3</option>
                            <option value="Juara Harapan">Juara Harapan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2" x-data="{ filePreview: null }">
                    <label class="text-sm font-bold text-gray-700">Berkas Sertifikat <span class="text-red-500"
                            x-show="!editMode">*</span></label>
                    <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" class="hidden" x-ref="certFile"
                        :required="!editMode" @change="
                                                    const file = $refs.certFile.files[0];
                                                    if(file) filePreview = file.name;
                                                ">

                    <div class="relative group cursor-pointer" @click="$refs.certFile.click()">
                        <div
                            class="w-full h-24 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center hover:bg-blue-50 hover:border-blue-300 transition-all">
                            <div class="p-2 bg-white rounded-full shadow-sm text-blue-600 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-gray-600"
                                x-text="filePreview ? filePreview : 'Klik untuk upload sertifikat'"></span>
                            <span class="text-[10px] text-gray-400 mt-0.5" x-show="!filePreview">PDF, JPG, PNG (Max
                                2MB)</span>
                        </div>
                    </div>
                    <p x-show="editMode" class="text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah berkas.</p>
                </div>

                <div class="pt-6 flex gap-3 justify-end border-t border-gray-100">
                    <button type="button" @click="$dispatch('close-modal')"
                        class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                        <svg x-show="!editMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <svg x-show="editMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span x-text="editMode ? 'Simpan Perubahan' : 'Simpan Data'"></span>
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Preview File --}}
        <x-modal id="previewModal" title="Preview Berkas" maxWidth="5xl">
            <div class="space-y-4">
                <template x-if="previewFile && isImage(previewFile)">
                    <img :src="previewFile" class="w-full h-auto rounded-lg shadow-sm border border-gray-100" alt="Preview">
                </template>

                <template x-if="previewFile && !isImage(previewFile)">
                    <div class="relative w-full border border-gray-200 rounded-lg overflow-hidden bg-gray-50 mb-4"
                        style="height: 80vh; min-height: 600px;">
                        <iframe :src="previewFile" class="absolute inset-0 w-full h-full" allowfullscreen></iframe>
                    </div>
                </template>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="button" @click="$dispatch('close-modal')"
                        class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                        Tutup
                    </button>
                    <a :href="previewFile" download
                        class="px-5 py-2.5 ml-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Download
                    </a>
                </div>
            </div>
        </x-modal>
    </div>
@endsection