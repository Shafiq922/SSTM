<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sub_categories')->upsert([

            /* =======================
               INCIDENT – IT INFRASTRUCTURE (1)
               ======================= */
            [
                'categoryID' => 1,
                'name' => 'Network Connectivity Issue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 1,
                'name' => 'Printer or Peripheral Failure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 1,
                'name' => 'Email Service Not Accessible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 1,
                'name' => 'Workstation Hardware Malfunction',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =======================
               INCIDENT – ERP SYSTEM ISSUE (2)
               ======================= */
            [
                'categoryID' => 2,
                'name' => 'Unable to Login to ERP System',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 2,
                'name' => 'ERP System Performance Degradation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 2,
                'name' => 'Incorrect Data Displayed in ERP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 2,
                'name' => 'ERP Transaction Processing Failure',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =======================
               SERVICE REQUEST – ERP HR (3)
               ======================= */
            [
                'categoryID' => 3,
                'name' => 'New Employee Account Creation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 3,
                'name' => 'Employee Role or Access Modification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 3,
                'name' => 'Employee Transfer Between Departments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 3,
                'name' => 'Employee Termination or Account Deactivation',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =======================
               SERVICE REQUEST – ERP FINANCE (4)
               ======================= */
            [
                'categoryID' => 4,
                'name' => 'Year-End Projection (YEP) Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 4,
                'name' => 'New General Ledger (GL) Account Setup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 4,
                'name' => 'Financial Report Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 4,
                'name' => 'Cost Center Creation or Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =======================
               SERVICE REQUEST – ERP SUPPLY CHAIN (5)
               ======================= */
            [
                'categoryID' => 5,
                'name' => 'Inventory Item Master Creation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 5,
                'name' => 'Inventory Stock Adjustment Request',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 5,
                'name' => 'Warehouse Location Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 5,
                'name' => 'Supply Chain Report Request',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =======================
               SERVICE REQUEST – ERP PROCUREMENT (6)
               ======================= */
            [
                'categoryID' => 6,
                'name' => 'Vendor Registration Request',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 6,
                'name' => 'Vendor Information Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 6,
                'name' => 'Purchase Order Workflow Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 6,
                'name' => 'Procurement Approval Matrix Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['name'], ['categoryID', 'updated_at']);
    }
}
