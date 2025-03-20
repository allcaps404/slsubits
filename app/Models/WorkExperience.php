<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experiences';

    protected $fillable = [
        'user_id',
        'position',
        'company_name',
        'contact_number',
        'start_date',
        'end_date',
        'currently_working',
        'description',
        'respondent_affiliation',
    ];
    

    /**
     * Define relationship with User model
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope query to get work experiences for the authenticated user
     */
    public function scopeForAuthUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
}
