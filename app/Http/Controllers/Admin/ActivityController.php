<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::latest()->get();
        return view('admin.activities.index', compact('activities'), ['title' => 'Daftar Kegiatan']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:activities',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        Activity::create($validated);

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $activity = Activity::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:activities,name,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $activity->update($validated);

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);

        // Optional: Check if activity has scores before deleting
        if ($activity->scores()->exists()) {
            return back()->with('error', 'Gagal hapus! Kegiatan ini sudah memiliki nilai atlit.');
        }

        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
