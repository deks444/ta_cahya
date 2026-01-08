<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Achievement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil 5 atlit paling aktif berdasarkan total point (activity scores)
        $athletes = User::where('role', 'atlit')
            ->where('is_active', true)
            ->withSum('activityScores as total_point', 'score')
            ->orderByDesc('total_point')
            ->take(5)
            ->get();

        // Ambil 5 pelatih yang aktif
        $coaches = User::where('role', 'pelatih')
            ->where('is_active', true)
            ->withCount('activitySchedules as total_schedules')
            ->orderByDesc('total_schedules')
            ->take(5)
            ->get();

        // CHART STATISTIK KEGIATAN
        $filter = request('filter', 'monthly');
        $chartLabels = [];
        $chartData = [];

        if ($filter == 'daily') {
            // 30 Hari Terakhir
            $schedules = \App\Models\ActivitySchedule::whereDate('date', '>=', Carbon::now()->subDays(29))->get();

            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dateString = $date->format('Y-m-d');
                $chartLabels[] = $date->format('d M');
                // Count exact date match
                $chartData[] = $schedules->where('date', $dateString)->count();
            }

        } elseif ($filter == 'weekly') {
            // 8 Minggu Terakhir
            $schedules = \App\Models\ActivitySchedule::whereDate('date', '>=', Carbon::now()->subWeeks(7)->startOfWeek())->get();

            for ($i = 7; $i >= 0; $i--) {
                $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
                $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
                $chartLabels[] = $weekStart->format('d M'); // Label awal minggu

                $count = $schedules->filter(function ($item) use ($weekStart, $weekEnd) {
                    $d = Carbon::parse($item->date);
                    return $d->between($weekStart, $weekEnd);
                })->count();
                $chartData[] = $count;
            }

        } else {
            // Monthly (Default - Tahun Ini)
            $schedules = \App\Models\ActivitySchedule::whereYear('date', date('Y'))->get();

            foreach (range(1, 12) as $m) {
                $monthCarbon = Carbon::createFromDate(null, $m, 1);
                $chartLabels[] = $monthCarbon->format('M'); // Jan, Feb...

                $count = $schedules->filter(function ($item) use ($m) {
                    return Carbon::parse($item->date)->month == $m;
                })->count();
                $chartData[] = $count;
            }
        }

        return view('admin.dashboard', [
            'athletes' => $athletes,
            'coaches' => $coaches,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'currentFilter' => $filter
        ]);
    }
}
