<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\OtherDetail;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN = 1;
    const STUDENT = 2;
    const SCANNER = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'dateofbirth',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function OtherDetail()
    {
        return $this->belongsTo(OtherDetail::class, 'id', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function yearBook()
    {
        return $this->hasOne(YearBook::class);
    }
    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class, 'student_id');
    }
}
