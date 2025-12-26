<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->upsert([
            ['name' => 'Admin'],
            ['name' => 'IT Staff'],
            ['name' => 'Internal Customer'],
            ['name' => 'External Customer'],
        ], ['name'], ['name']);
    }
}
