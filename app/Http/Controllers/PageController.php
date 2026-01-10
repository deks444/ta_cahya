<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\ActivitySchedule;

class PageController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return view('index', compact('activities'));
    }

    public function events()
    {
        $query = ActivitySchedule::where('date', '<', now());

        $totalEvents = $query->count();
        $totalParticipants = \App\Models\ActivityParticipant::whereHas('schedule', function ($q) {
            $q->where('date', '<', now());
        })->where('status', 'attended')->count();

        $schedules = ActivitySchedule::with(['activity', 'coach'])
            ->withCount('participants')
            ->where('date', '<', now())
            ->orderBy('date', 'desc')
            ->paginate(9);

        return view('events', compact('schedules', 'totalEvents', 'totalParticipants'));
    }
    public function about()
    {
        return view('about');
    }

    public function login()
    {
        return view('login');
    }
}
