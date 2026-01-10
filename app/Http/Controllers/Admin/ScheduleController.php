<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivitySchedule;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ActivityParticipant;
use App\Models\ActivityScore;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua jadwal dengan jumlah peserta
        $schedules = ActivitySchedule::with(['activity', 'coach'])
            ->withCount('participants')
            ->get();

        // Format data untuk FullCalendar
        $events = $schedules->map(function ($schedule) {
            $color = 'primary'; // Default color
            if ($schedule->status == 'cancelled')
                $color = 'danger';
            if ($schedule->status == 'completed')
                $color = 'success';

            // Gabungkan tanggal dan jam mulai (Floating time, ignore timezone)
            $start = Carbon::parse($schedule->date . ' ' . $schedule->start_time)->format('Y-m-d\TH:i:s');

            return [
                'id' => $schedule->id,
                'title' => $schedule->activity->name,
                'start' => $start,
                'className' => 'event-' . $color, // Asumsi class CSS bawaan template
                // Data tambahan untuk modal detail nanti
                'extendedProps' => [
                    'coach' => $schedule->coach->name,
                    'status' => $schedule->status,
                    'description' => $schedule->activity->description,
                    'participants_count' => $schedule->participants_count,
                    'schedule_data' => $schedule // PASS FULL OBJECT
                ]
            ];
        });

        $activities = Activity::all();

        $user = Auth::user();
        if ($user->role === 'admin') {
            $coaches = User::where('role', 'pelatih')->get();
        } else {
            // Jika pelatih login, hanya tampilkan dirinya sendiri di list
            $coaches = User::where('id', $user->id)->get();
        }

        // Kita return ke view calendar, tapi kita inject variabel events
        return view('admin.schedules.calendar', compact('events', 'activities', 'coaches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'location' => 'required|string|max:255',
        ]);

        // Jika pelatih schedule ditentukan dari input (kalau admin), kalau pelatih login otomatis dia.
        // Untuk simpelnya sekarang kita ambil dari input atau auth user
        $coachId = Auth::user()->role === 'pelatih' ? Auth::id() : ($request->coach_id ?? Auth::id());

        ActivitySchedule::create([
            'activity_id' => $request->activity_id,
            'coach_id' => $coachId,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'location' => $request->location,
            'quota' => $request->quota,
            'status' => 'scheduled',
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dibuat.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = ActivitySchedule::findOrFail($id);

        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'location' => 'required|string|max:255',
            'status' => 'required|in:scheduled,cancelled,completed'
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = ActivitySchedule::findOrFail($id);

        // Hanya pemilik atau admin
        if (Auth::user()->role !== 'admin' && $schedule->coach_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $schedule->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus');
    }

    public function show($id)
    {
        $schedule = ActivitySchedule::with(['activity', 'coach', 'participants.user'])->findOrFail($id);
        return view('admin.schedules.show', compact('schedule'));
    }

    public function bulkAttendance(Request $request, ActivitySchedule $schedule)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:attended,absent,registered'
        ]);

        foreach ($request->attendance as $userId => $data) {
            $newStatus = $data['status'];

            $participant = ActivityParticipant::where('activity_schedule_id', $schedule->id)
                ->where('user_id', $userId)
                ->first();

            if (!$participant)
                continue;

            $oldStatus = $participant->status;

            // Jika status tidak berubah, lewati
            if ($oldStatus === $newStatus)
                continue;

            $participant->update(['status' => $newStatus]);

            // Logic Poin
            if ($newStatus === 'attended') {
                // Tambah Poin jika sebelumnya belum pernah "attended" untuk jadwal ini
                ActivityScore::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'activity_id' => $schedule->activity_id,
                        'date' => $schedule->date,
                        'time' => $schedule->start_time
                    ],
                    [
                        'score' => 1,
                        'points' => 1
                    ]
                );
            } elseif ($oldStatus === 'attended' && $newStatus !== 'attended') {
                // Hapus Poin jika batal hadir
                ActivityScore::where('user_id', $userId)
                    ->where('activity_id', $schedule->activity_id)
                    ->where('date', $schedule->date)
                    ->where('time', $schedule->start_time)
                    ->delete();
            }
        }

        return back()->with('success', 'Seluruh presensi berhasil disimpan.');
    }

    public function attendanceList()
    {
        $query = ActivitySchedule::with(['activity', 'coach'])
            ->withCount([
                'participants as total_participants',
                'participants as attended_participants' => function ($q) {
                    $q->where('status', 'attended');
                }
            ]);

        // Filter Pelatih: hanya lihat jadwalnya sendiri
        if (Auth::user()->role === 'pelatih') {
            $query->where('coach_id', Auth::id());
        }

        $schedules = $query->orderBy('date', 'desc')->orderBy('start_time', 'desc')->paginate(10);

        return view('admin.schedules.attendance-list', compact('schedules'));
    }

    /**
     * Hapus peserta dari jadwal tertentu
     */
    public function destroyParticipant($scheduleId, $participantId)
    {
        $schedule = ActivitySchedule::findOrFail($scheduleId);
        $participant = ActivityParticipant::findOrFail($participantId);

        // Validasi bahwa participant ini memang terdaftar di schedule ini
        if ($participant->activity_schedule_id != $scheduleId) {
            return back()->with('error', 'Data tidak valid.');
        }

        // Jika peserta sudah attended, hapus juga poinnya
        if ($participant->status === 'attended') {
            ActivityScore::where('user_id', $participant->user_id)
                ->where('activity_id', $schedule->activity_id)
                ->where('date', $schedule->date)
                ->where('time', $schedule->start_time)
                ->delete();
        }

        // Hapus peserta
        $participant->delete();

        return back()->with('success', 'Peserta berhasil dihapus dari jadwal.');
    }

    /**
     * Update quota jadwal via AJAX
     */
    public function updateQuota(Request $request, $scheduleId)
    {
        $schedule = ActivitySchedule::findOrFail($scheduleId);

        $request->validate([
            'quota' => 'nullable|integer|min:0'
        ]);

        $schedule->update([
            'quota' => $request->quota
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quota berhasil diperbarui',
            'quota' => $schedule->quota
        ]);
    }
}
