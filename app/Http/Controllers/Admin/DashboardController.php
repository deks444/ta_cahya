<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Achievement;
use App\Models\ActivitySchedule;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';
        $isCoach = $user->role === 'pelatih';
        $isAthlete = $user->role === 'atlit';

        // Ambil 5 atlit paling aktif berdasarkan total point (activity scores)
        // Optimasi: hanya select field yang diperlukan
        $athletes = User::select('id', 'name', 'username', 'avatar')
            ->where('role', 'atlit')
            ->where('is_active', true)
            ->withSum('activityScores as total_point', 'score')
            ->orderByDesc('total_point')
            ->limit(5)
            ->get();

        // Ambil 5 pelatih yang aktif (hanya untuk admin)
        $coaches = null;
        if ($isAdmin) {
            $coaches = User::select('id', 'name', 'username', 'avatar')
                ->where('role', 'pelatih')
                ->where('is_active', true)
                ->withCount('activitySchedules as total_schedules')
                ->orderByDesc('total_schedules')
                ->limit(5)
                ->get();
        }

        // CHART STATISTIK KEGIATAN - Optimasi dengan raw query
        $filter = request('filter', 'daily');
        $chartLabels = [];
        $chartData = [];

        if ($filter == 'daily') {
            // 30 Hari Terakhir - Optimasi dengan groupBy di database
            $startDate = Carbon::now()->subDays(29)->format('Y-m-d');

            if ($isAthlete) {
                // Untuk atlit: hanya kegiatan yang diikuti
                $results = DB::table('activity_schedules')
                    ->join('activity_participants', 'activity_schedules.id', '=', 'activity_participants.activity_schedule_id')
                    ->where('activity_participants.user_id', $user->id)
                    ->where('activity_schedules.date', '>=', $startDate)
                    ->select('activity_schedules.date', DB::raw('COUNT(*) as count'))
                    ->groupBy('activity_schedules.date')
                    ->pluck('count', 'date');
            } elseif ($isCoach) {
                // Untuk pelatih: hanya kegiatan yang mereka buat
                $results = ActivitySchedule::where('coach_id', $user->id)
                    ->where('date', '>=', $startDate)
                    ->select('date', DB::raw('COUNT(*) as count'))
                    ->groupBy('date')
                    ->pluck('count', 'date');
            } else {
                // Untuk admin: semua kegiatan
                $results = ActivitySchedule::where('date', '>=', $startDate)
                    ->select('date', DB::raw('COUNT(*) as count'))
                    ->groupBy('date')
                    ->pluck('count', 'date');
            }

            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dateString = $date->format('Y-m-d');
                $chartLabels[] = $date->format('d M');
                $chartData[] = $results[$dateString] ?? 0;
            }

        } elseif ($filter == 'weekly') {
            // 8 Minggu Terakhir
            $startDate = Carbon::now()->subWeeks(7)->startOfWeek()->format('Y-m-d');

            if ($isAthlete) {
                $results = DB::table('activity_schedules')
                    ->join('activity_participants', 'activity_schedules.id', '=', 'activity_participants.activity_schedule_id')
                    ->where('activity_participants.user_id', $user->id)
                    ->where('activity_schedules.date', '>=', $startDate)
                    ->select(DB::raw("EXTRACT(WEEK FROM activity_schedules.date) as week"), DB::raw('COUNT(*) as count'))
                    ->groupBy('week')
                    ->pluck('count', 'week');
            } elseif ($isCoach) {
                $results = ActivitySchedule::where('coach_id', $user->id)
                    ->where('date', '>=', $startDate)
                    ->select(DB::raw("EXTRACT(WEEK FROM date) as week"), DB::raw('COUNT(*) as count'))
                    ->groupBy('week')
                    ->pluck('count', 'week');
            } else {
                $results = ActivitySchedule::where('date', '>=', $startDate)
                    ->select(DB::raw("EXTRACT(WEEK FROM date) as week"), DB::raw('COUNT(*) as count'))
                    ->groupBy('week')
                    ->pluck('count', 'week');
            }

            for ($i = 7; $i >= 0; $i--) {
                $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
                $chartLabels[] = $weekStart->format('d M');

                $weekNum = $weekStart->format('W');
                // Cast to int since array keys from pluck/DB can be strings or floats depending on DB driver
                $chartData[] = $results[(int) $weekNum] ?? $results[$weekNum] ?? 0;
            }

        } else {
            // Monthly (Default - Tahun Ini)
            $currentYear = date('Y');

            if ($isAthlete) {
                $results = DB::table('activity_schedules')
                    ->join('activity_participants', 'activity_schedules.id', '=', 'activity_participants.activity_schedule_id')
                    ->where('activity_participants.user_id', $user->id)
                    ->whereYear('activity_schedules.date', $currentYear)
                    ->select(DB::raw('EXTRACT(MONTH FROM activity_schedules.date) as month'), DB::raw('COUNT(*) as count'))
                    ->groupBy('month')
                    ->pluck('count', 'month');
            } elseif ($isCoach) {
                $results = ActivitySchedule::where('coach_id', $user->id)
                    ->whereYear('date', $currentYear)
                    ->select(DB::raw('EXTRACT(MONTH FROM date) as month'), DB::raw('COUNT(*) as count'))
                    ->groupBy('month')
                    ->pluck('count', 'month');
            } else {
                $results = ActivitySchedule::whereYear('date', $currentYear)
                    ->select(DB::raw('EXTRACT(MONTH FROM date) as month'), DB::raw('COUNT(*) as count'))
                    ->groupBy('month')
                    ->pluck('count', 'month');
            }

            foreach (range(1, 12) as $m) {
                $monthCarbon = Carbon::createFromDate(null, $m, 1);
                $chartLabels[] = $monthCarbon->format('M');
                $chartData[] = $results[$m] ?? 0;
            }
        }

        return view('admin.dashboard', [
            'athletes' => $athletes,
            'coaches' => $coaches,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'currentFilter' => $filter,
            'isAdmin' => $isAdmin,
            'isCoach' => $isCoach,
            'isAthlete' => $isAthlete
        ]);
    }
}

