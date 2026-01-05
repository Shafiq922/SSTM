<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SummaryTemplateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('summary_templates')->upsert([

            // IT
            [
                'system_code' => 'IT',
                'operation_type' => 'Network Operations',
                'user_type' => 'Internal User',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_code' => 'IT',
                'operation_type' => 'Network Operations',
                'user_type' => 'External Customer',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // FIN
            [
                'system_code' => 'FIN',
                'operation_type' => 'Financial Operations',
                'user_type' => 'Internal User',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_code' => 'FIN',
                'operation_type' => 'Financial Operations',
                'user_type' => 'External Customer',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // HR
            [
                'system_code' => 'HR',
                'operation_type' => 'Employee Management',
                'user_type' => 'Internal User',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_code' => 'HR',
                'operation_type' => 'Employee Management',
                'user_type' => 'External Customer',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Procurement
            [
                'system_code' => 'PROC',
                'operation_type' => 'Procurement Management',
                'user_type' => 'Internal User',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_code' => 'PROC',
                'operation_type' => 'Procurement Management',
                'user_type' => 'External Customer',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Supply Chain
            [
                'system_code' => 'SUPP',
                'operation_type' => 'Supply Chain Operations',
                'user_type' => 'Internal User',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'system_code' => 'SUPP',
                'operation_type' => 'Supply Chain Operations',
                'user_type' => 'External Customer',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['system_code', 'operation_type', 'user_type'], ['is_active', 'updated_at']);
    }
}
