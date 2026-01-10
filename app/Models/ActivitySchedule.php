<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitySchedule extends Model
{
    protected $fillable = [
        'activity_id',
        'coach_id',
        'date',
        'start_time',
        'location',
        'quota',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Jenis Kegiatan (Master Data)
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // Pelatih
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    // Peserta
    public function participants()
    {
        return $this->hasMany(ActivityParticipant::class);
    }
}
