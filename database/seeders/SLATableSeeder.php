<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SLATableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sla')->upsert([
            [
                'priority' => 'Critical',
                'response_time_minutes' => 30,     // 1 hour
                'resolution_time_minutes' => 240,  // 4 hours
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority' => 'High',
                'response_time_minutes' => 60,    // 4 hours
                'resolution_time_minutes' => 480, // 1 day
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority' => 'Moderate',
                'response_time_minutes' => 240,    // 4 hours
                'resolution_time_minutes' => 2880, // 3 days
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority' => 'Low',
                'response_time_minutes' => 480,   // 1 day
                'resolution_time_minutes' => 4320,// 7 days
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority' => 'Planning',
                'response_time_minutes' => 1440,   // 1 day
                'resolution_time_minutes' => 7200,// 7 days
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['priority'], ['response_time_minutes', 'resolution_time_minutes', 'updated_at']);
    }
}
