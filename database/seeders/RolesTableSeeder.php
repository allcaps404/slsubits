<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['role_name' => 'Admin', 'url' => '/admin'],
            ['role_name' => 'Student', 'url' =>'/student'],
            ['role_name' => 'Scanner', 'url' =>'/scanner'],
            ['role_name' => 'Event Organizer', 'url' =>'/eventorganizer'],
            ['role_name' => 'Alumni', 'url' =>'/alumni'],
        ]);
    }
}
