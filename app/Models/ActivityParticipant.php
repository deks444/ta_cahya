<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityParticipant extends Model
{
    protected $fillable = [
        'activity_schedule_id',
        'user_id',
        'status',
    ];

    // Jadwal
    public function schedule()
    {
        return $this->belongsTo(ActivitySchedule::class, 'activity_schedule_id');
    }

    // Atlit
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
