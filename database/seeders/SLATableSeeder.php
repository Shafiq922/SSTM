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
                'response_time_minutes' => 60,     // 1 hour
                'resolution_time_minutes' => 240,  // 4 hours
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority' => 'High',
                'response_time_minutes' => 240,    // 4 hours
                'resolution_time_minutes' => 1440, // 1 day
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority' => 'Normal',
                'response_time_minutes' => 480,    // 8 hours
                'resolution_time_minutes' => 4320, // 3 days
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority' => 'Low',
                'response_time_minutes' => 1440,   // 1 day
                'resolution_time_minutes' => 10080,// 7 days
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['priority'], ['response_time_minutes', 'resolution_time_minutes', 'updated_at']);
    }
}
