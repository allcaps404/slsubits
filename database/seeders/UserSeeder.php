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

        User::create([
            'firstname' => 'Scanner',
            'lastname' => 'User',
            'middlename' => 'n/a',
            'email' => 'scanner@example.com',
            'password' => Hash::make('password'),
            'dateofbirth' => Carbon::now(),
            'role_id' => 3,
        ]);

        User::create([
            'firstname' => 'Event Organizer',
            'lastname' => 'User',
            'middlename' => 'n/a',
            'email' => 'eventorganizer@example.com',
            'password' => Hash::make('password'),
            'dateofbirth' => Carbon::now(),
            'role_id' => 4,
        ]);

        User::create([
            'firstname' => 'Alumni',
            'lastname' => 'User',
            'middlename' => 'n/a',
            'email' => 'alumni@example.com',
            'password' => Hash::make('password'),
            'dateofbirth' => Carbon::now(),
            'role_id' => 5,
            'role_id' => 6, 
        ]);
    }
}
