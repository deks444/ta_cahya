
@extends('admin.layouts.app')

@section('page-title', 'Daftar Member Sharefit')

@section('content')
    <div class="" x-data="{
        editMode: false,
        currentUser: { id: '', name: '', role: '', username: '', no_hp: '', is_active: 1 },
        resetForm() {
            this.editMode = false;
            this.currentUser = { id: '', name: '', role: '', username: '', no_hp: '', is_active: 1 };
        }
    }">
        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-bold shadow-sm">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-bold shadow-sm">
                {{ session('error') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-bold shadow-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-xl border border-gray-200 shadow-sm gap-4 mb-10">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data akun Pelatih dan Atlit Sharefit.</p>
            </div>
            <button @click="resetForm(); $dispatch('open-modal', { id: 'userModal' })"
                class="px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition flex items-center gap-2 shadow-lg shadow-blue-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah User Baru
            </button>
        </div>

        <!-- SECTION: DATA PELATIH -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-10">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Data Pelatih</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ $coaches->count() }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 text-[10px] font-bold uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-4 w-16 text-center">No</th>
                            <th class="px-6 py-4">Nama Pelatih</th>
                            <th class="px-6 py-4">Username</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($coaches as $index => $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800">{{ $user->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $user->username }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->no_hp }}</td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold">Active</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="editMode = true; currentUser = { id: '{{ $user->id }}', name: '{{ addslashes($user->name) }}', role: '{{ $user->role }}', username: '{{ $user->username }}', no_hp: '{{ $user->no_hp }}', is_active: {{ $user->is_active }} }; $dispatch('open-modal', { id: 'userModal' })"
                                            class="p-1.5 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition border border-amber-200 flex items-center justify-center leading-none"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pelatih ini?');" class="m-0 p-0 flex">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition border border-red-200 flex items-center justify-center leading-none" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400 italic bg-gray-50/30">Belum ada data pelatih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECTION: DATA ATLIT -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-10">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Data Atlit</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold">{{ $athletes->count() }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 text-[10px] font-bold uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-4 w-16 text-center">No</th>
                            <th class="px-6 py-4">Nama Atlit</th>
                            <th class="px-6 py-4">Username</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($athletes as $index => $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800">{{ $user->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $user->username }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->no_hp }}</td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold">Active</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="editMode = true; currentUser = { id: '{{ $user->id }}', name: '{{ addslashes($user->name) }}', role: '{{ $user->role }}', username: '{{ $user->username }}', no_hp: '{{ $user->no_hp }}', is_active: {{ $user->is_active }} }; $dispatch('open-modal', { id: 'userModal' })"
                                            class="p-1.5 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition border border-amber-200 flex items-center justify-center leading-none"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus atlit ini?');" class="m-0 p-0 flex">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition border border-red-200 flex items-center justify-center leading-none" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400 italic bg-gray-50/30">Belum ada data atlit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Create/Edit Modal -->
        <x-modal id="userModal" title="Form Member">
            <form :action="editMode ? `{{ url('admin/users') }}/${currentUser.id}` : `{{ route('admin.users.store') }}`" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="space-y-2">
                    <label for="name" class="text-sm font-bold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="currentUser.name" placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all" required>
                </div>

                <div class="space-y-2">
                    <label for="role" class="text-sm font-bold text-gray-700">Tipe Akun <span class="text-red-500">*</span></label>
                    <select name="role" x-model="currentUser.role" style="width: 100% !important; box-sizing: border-box !important;"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all" required>
                        <option value="">-- Pilih Tipe Akun --</option>
                        <option value="atlit">Atlit</option>
                        <option value="pelatih">Pelatih</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label for="username" class="text-sm font-bold text-gray-700">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" x-model="currentUser.username" placeholder="Contoh: panggilsaya"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all" required>
                    </div>
                    <div class="space-y-2">
                        <label for="no_hp" class="text-sm font-bold text-gray-700">Nomor Handphone <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp" x-model="currentUser.no_hp" placeholder="Contoh: 0812345xxx"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all" required>
                    </div>
                </div>

                <div class="space-y-2" x-data="{ photoPreview: null }">
                    <label class="text-sm font-bold text-gray-700">Foto Profil (Opsional)</label>
                    <input type="file" name="avatar" accept="image/*" class="hidden" x-ref="photo" 
                        @change="
                            const file = $refs.photo.files[0];
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL(file);
                        ">

                    <div class="relative group cursor-pointer" @click="$refs.photo.click()">
                        <!-- Preview Image -->
                        <div x-show="photoPreview" class="relative w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-blue-100 shadow-sm">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                <span class="text-white text-xs font-bold">Ganti</span>
                            </div>
                        </div>

                        <!-- Upload Placeholder -->
                        <div x-show="!photoPreview" class="w-full h-24 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center hover:bg-blue-50 hover:border-blue-300 transition-all">
                            <div class="p-2 bg-white rounded-full shadow-sm text-blue-600 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-600">Klik untuk upload foto</span>
                            <span class="text-[10px] text-gray-400 mt-0.5">JPG, PNG (Max 2MB)</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm font-bold text-gray-700">Password <span class="text-red-500" x-show="!editMode">*</span></label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all"
                        :required="!editMode">
                    <p x-show="editMode" class="text-xs text-gray-400 font-medium mt-1">Kosongkan jika tidak ingin mengganti password.</p>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" x-model="currentUser.is_active"
                        class="w-5 h-5 text-blue-600 bg-gray-50 border-gray-300 rounded focus:ring-blue-500">
                    <label class="text-sm font-semibold text-gray-700 select-none">Aktifkan akun member</label>
                </div>

                <div class="pt-6 flex gap-3 justify-end border-t border-gray-100">
                    <button type="button" @click="$dispatch('close-modal')"
                        class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                        <svg x-show="!editMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <svg x-show="editMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span x-text="editMode ? 'Simpan Perubahan' : 'Simpan Member'"></span>
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
@endsection