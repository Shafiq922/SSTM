<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->upsert([
            // -------------------------------------------------------
            // GENERAL INCIDENTS
            // -------------------------------------------------------
            [
                'name' => 'IT Infrastructure',
                'description' => 'Incidents related to hardware, network, servers, and end-user devices',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // -------------------------------------------------------
            // INCIDENT — ERP MODULES (SPECIFIC)
            // -------------------------------------------------------
            [
                'name' => 'Incident – ERP Human Resource (HR)',
                'description' => 'System errors, calculation bugs, or data discrepancies in the HR module',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Incident – ERP Finance',
                'description' => 'Posting failures, GL discrepancies, or reporting errors in Finance module',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Incident – ERP Supply Chain',
                'description' => 'Inventory sync errors, shipment tracking failures, or logistics module bugs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Incident – ERP Procurement',
                'description' => 'PO generation errors, vendor portal outages, or purchasing workflow failures',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // -------------------------------------------------------
            // SERVICE REQUEST — ERP MODULES
            // -------------------------------------------------------
            [
                'name' => 'ERP – Human Resource (HR)',
                'description' => 'Planned service requests related to HR module configuration and access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ERP – Finance',
                'description' => 'Planned service requests related to financial operations and reporting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ERP – Supply Chain',
                'description' => 'Service requests related to inventory, logistics, and supply chain processes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ERP – Procurement',
                'description' => 'Service requests related to purchasing, vendors, and procurement workflows',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['name'], ['description', 'updated_at']);
    }
}