<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'middlename' => 'n/a',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'dateofbirth' => Carbon::now(),
            'role_id' => 1,
        ]);

        User::create([
            'firstname' => 'Student',
            'lastname' => 'User',
            'middlename' => 'n/a',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'dateofbirth' => Carbon::now(),
            'role_id' => 2,
        ]);
    }
}
