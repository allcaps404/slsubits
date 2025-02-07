<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'birthplace',
        'address',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
