<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = \App\Models\Achievement::with('user')->orderBy('created_at', 'desc')->paginate(10);
        $athletes = \App\Models\User::where('role', 'atlit')->get();
        return view('admin.achievements.index', compact('achievements', 'athletes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/achievements'), $filename);
            $path = 'uploads/achievements/' . $filename;
        }

        // Jika admin, gunakan user_id dari request, jika bukan gunakan Auth::id()
        $userId = (\Illuminate\Support\Facades\Auth::user()->role === 'admin' && $request->user_id)
            ? $request->user_id
            : \Illuminate\Support\Facades\Auth::id();

        \App\Models\Achievement::create([
            'user_id' => $userId,
            'name' => $request->name,
            'rank' => $request->rank,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function update(Request $request, \App\Models\Achievement $achievement)
    {
        // Penjagaan: hanya admin atau pemilik yang bisa update
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin' && $achievement->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'rank' => $request->rank,
        ];

        // Admin juga bisa mengubah kepemilikan prestasi jika diperlukan
        if (\Illuminate\Support\Facades\Auth::user()->role === 'admin' && $request->user_id) {
            $data['user_id'] = $request->user_id;
        }

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($achievement->file_path && file_exists(public_path($achievement->file_path))) {
                @unlink(public_path($achievement->file_path));
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/achievements'), $filename);
            $data['file_path'] = 'uploads/achievements/' . $filename;
        }

        $achievement->update($data);

        return back()->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(\App\Models\Achievement $achievement)
    {
        // Penjagaan: hanya admin atau pemilik yang bisa hapus
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin' && $achievement->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        if ($achievement->file_path && file_exists(public_path($achievement->file_path))) {
            @unlink(public_path($achievement->file_path));
        }

        $achievement->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }
}
