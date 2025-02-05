<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course',
        'year',
        'section',
        'semester',
        'academic_year',
        'birthdate',
        'birthplace',
        'address',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
