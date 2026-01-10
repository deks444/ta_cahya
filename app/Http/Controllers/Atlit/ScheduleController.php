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
        $availableSchedules = ActivitySchedule::with(['activity', 'coach'])
            ->withCount('participants')
            ->where('date', '>=', $now->toDateString()) // Hari ini atau masa depan
            ->where('status', 'scheduled')
            ->whereNotIn('id', $joinedScheduleIds)
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        // 3. Filter: Jadwal Saya (Hanya yang BELUM Presensi & Tanggal >= Hari Ini)
        $mySchedules = ActivityParticipant::with(['schedule.activity', 'schedule.coach'])
            ->where('user_id', $user->id)
            ->where('status', 'registered')
            ->whereHas('schedule', function ($q) use ($now) {
                $q->where('date', '>=', $now->toDateString());
            })
            ->get()
            ->sortBy(function ($p) {
                return $p->schedule->date . ' ' . $p->schedule->start_time;
            });

        // 4. Filter: Riwayat (Masa Lalu atau Status Sudah Diabsen)
        $historySchedules = ActivityParticipant::with(['schedule.activity', 'schedule.coach'])
            ->where('user_id', $user->id)
            ->where(function ($q) use ($now) {
                $q->where('status', '!=', 'registered')
                    ->orWhereHas('schedule', function ($sq) use ($now) {
                        $sq->where('date', '<', $now->toDateString());
                    });
            })
            ->orderByDesc(
                ActivitySchedule::select('date')
                    ->whereColumn('id', 'activity_participants.activity_schedule_id')
                    ->limit(1)
            )
            ->orderByDesc(
                ActivitySchedule::select('start_time')
                    ->whereColumn('id', 'activity_participants.activity_schedule_id')
                    ->limit(1)
            )
            ->get();

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
