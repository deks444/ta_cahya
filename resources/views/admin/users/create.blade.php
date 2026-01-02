@extends('admin.layouts.app')

@section('page-title', 'Tambah Member Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Form Tambah Member</h2>
                <p class="text-xs text-gray-400 font-medium">Lengkapi data berikut untuk mendaftarkan member baru.</p>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="name" class="text-sm font-bold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all @error('name') border-red-500 @enderror"
                        required>
                    @error('name') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="username" class="text-sm font-bold text-gray-700">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                            placeholder="Contoh: panggilsaya"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all @error('username') border-red-500 @enderror"
                            required>
                        @error('username') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="no_hp" class="text-sm font-bold text-gray-700">Nomor Handphone</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                            placeholder="Contoh: 0812345xxx"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all @error('no_hp') border-red-500 @enderror"
                            required>
                        @error('no_hp') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm font-bold text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all @error('password') border-red-500 @enderror"
                        required>
                    @error('password') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="text-sm font-semibold text-gray-700">Aktifkan akun member</label>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="submit"
                        class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                        Simpan Member
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-8 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection