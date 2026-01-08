@extends('admin.layouts.app')

@section('content')
<div x-data>
    <div class="col-span-12 space-y-6 xl:col-span-12">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-800 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Daftar Kegiatan</h3>
                <button @click="$dispatch('open-modal', { id: 'createActivityModal' })"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                    + Tambah Kegiatan
                </button>
            </div>

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400" role="alert">
                    <span class="font-medium">Sukses!</span> {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400" role="alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                Nama Kegiatan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                Deskripsi
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach ($activities as $activity)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $activity->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                                    {{ $activity->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        {{-- Edit Button --}}
                                        <button 
                                            @click="$dispatch('open-modal', { 
                                                id: 'editActivityModal', 
                                                activity: {{ $activity }}
                                            })"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            Edit
                                        </button>
                                        
                                        {{-- Delete Form --}}
                                        <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        
                        @if($activities->isEmpty())
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada data kegiatan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <x-modal id="createActivityModal" title="Tambah Kegiatan Baru">
        <form action="{{ route('admin.activities.store') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Nama Kegiatan</label>
                    <input type="text" name="name" id="name" required placeholder="Contoh: Strength Training"
                           class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                </div>
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="4" placeholder="Jelaskan detail kegiatan ini..."
                              class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all resize-none"></textarea>
                </div>
            </div>
            
            <div class="mt-8 flex items-center justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal')" 
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-all">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-all">
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Edit Modal --}}
    <x-modal id="editActivityModal" title="Edit Kegiatan">
        <div x-data="{ activity: { id: '', name: '', description: '' } }" 
             x-on:open-modal.window="if ($event.detail.id === 'editActivityModal') activity = $event.detail.activity">
            
            <form :action="`{{ url('admin/activities') }}/${activity.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label for="edit_name" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Nama Kegiatan</label>
                        <input type="text" name="name" id="edit_name" x-model="activity.name" required 
                               class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all">
                    </div>
                    <div>
                        <label for="edit_description" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Deskripsi</label>
                        <textarea name="description" id="edit_description" x-model="activity.description" rows="4" 
                                  class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-gray-800 transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <button type="button" @click="$dispatch('close-modal')" 
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
@endsection