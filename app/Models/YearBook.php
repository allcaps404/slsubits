<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearBook extends Model
{
    protected $fillable = [
        'user_id',
        'grad_pic',
        'motto',
        'grad_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
