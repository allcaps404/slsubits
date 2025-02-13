<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'short_description',
        'event_date',
        'login_datetime',
        'logout_datetime',
        'academic_year',
        'semester',
    ];
    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
