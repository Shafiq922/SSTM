<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('departments')->upsert([
            ['name' => 'Finance'],
            ['name' => 'IT'],
            ['name' => 'HR'],
            ['name' => 'Procurement'],
            ['name' => 'Supply Chain'],
            ['name' => 'External Client']
        ], ['name'], ['name']);
    }
}
