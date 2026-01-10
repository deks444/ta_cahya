<?php

namespace App\Http\Controllers\Atlit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivitySchedule;
use App\Models\ActivityParticipant;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // 1. Ambil ID jadwal yang sudah diikuti user
        $joinedScheduleIds = ActivityParticipant::where('user_id', $user->id)
            ->pluck('activity_schedule_id')
            ->toArray();

        // 2. Jadwal Tersedia (Future, belum diikuti, status scheduled)
        $availableSchedules = ActivitySchedule::with(['activity', 'coach', 'participants'])
            ->where('date', '>=', $now->toDateString()) // Hari ini atau masa depan
            ->where('status', 'scheduled')
            ->whereNotIn('id', $joinedScheduleIds)
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        // 3. Ambil Partisipasi User (Untuk Jadwal Saya & Riwayat)
        $allParticipations = ActivityParticipant::with(['schedule.activity', 'schedule.coach'])
            ->where('user_id', $user->id)
            ->get();

        // Filter: Jadwal Saya (Hanya yang BELUM Presensi & Tanggal >= Hari Ini)
        $mySchedules = $allParticipations->filter(function ($p) use ($now) {
            if (!$p->schedule)
                return false;
            $isFutureOrToday = $p->schedule->date >= $now->toDateString();
            $isRegistered = $p->status === 'registered';

            // Hanya tampilkan jika hari ini/masa depan DAN status masih registered
            return $isFutureOrToday && $isRegistered;
        })->sortBy(function ($p) {
            return $p->schedule->date . ' ' . $p->schedule->start_time;
        });

        // Filter: Riwayat (Masa Lalu atau Status Sudah Diabsen)
        $historySchedules = $allParticipations->filter(function ($p) use ($now) {
            if (!$p->schedule)
                return false;
            $isPast = $p->schedule->date < $now->toDateString();
            $isProcessed = in_array($p->status, ['attended', 'absent']);

            // Masuk riwayat jika jadwal sudah lewat ATAU statusnya sudah bukan registered
            return $isPast || $isProcessed;
        })->sortByDesc(function ($p) {
            return $p->schedule->date . ' ' . $p->schedule->start_time;
        });

        return view('atlit.schedules.index', compact('availableSchedules', 'mySchedules', 'historySchedules'));
    }

    public function join(Request $request, $scheduleId)
    {
        $user = Auth::user();

        // Cek apakah jadwal valid
        $schedule = ActivitySchedule::findOrFail($scheduleId);

        // Cek apakah sudah terdaftar (validasi ganda)
        $exists = ActivityParticipant::where('user_id', $user->id)
            ->where('activity_schedule_id', $scheduleId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah terdaftar di jadwal ini.');
        }

        // Cek Kuota (jika ada)
        if ($schedule->quota !== null) {
            $participantsCount = $schedule->participants()->count();
            if ($participantsCount >= $schedule->quota) {
                return back()->with('error', 'Kuota kelas penuh.');
            }
        }

        // Join logic
        ActivityParticipant::create([
            'user_id' => $user->id,
            'activity_schedule_id' => $scheduleId,
            'status' => 'registered'
        ]);

        return back()->with('success', 'Berhasil mendaftar kegiatan!');
    }
}
