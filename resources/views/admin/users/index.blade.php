@extends('admin.layouts.app')

@section('page-title', 'Daftar Member Sharefit')

@section('content')
<div class="space-y-6">
    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-bold">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Total Member Terdaftar</h2>
                <p class="text-xs text-gray-400 font-medium">Lakukan manajemen data user Sharefit di sini.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah User
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-[10px] font-bold uppercase tracking-widest border-b border-gray-100">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">No. HP</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-xs font-bold text-blue-600">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->username }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->no_hp }}</td>
                        <td class="px-6 py-4">
                            @if($user->is_active)
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold font-sans">Aktif</span>
                            @else
                            <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold font-sans">Non-aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">Belum ada member yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection