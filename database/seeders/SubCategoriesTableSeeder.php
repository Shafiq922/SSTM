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
                'name' => 'Email Service Unavailable',
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
                'name' => 'User Workstation Hardware Failure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 1,
                'name' => 'VPN or Remote Access Issue',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =====================================================
                         INCIDENT – ERP SYSTEM ISSUE
               ===================================================== */

            /* ---------- ERP HR MODULE (Category ID = 2) ---------- */
            [
                'categoryID' => 2,
                'name' => 'Employee Record Not Displayed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 2,
                'name' => 'Payroll Calculation Error',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 2,
                'name' => 'User Access Denied (HR)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 2,
                'name' => 'Leave Balance Incorrect',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 2,
                'name' => 'Attendance Data Not Captured',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 2,
                'name' => 'Employee Status Update Failed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* ---------- ERP FINANCE MODULE (Category ID = 3) ---------- */
            [
                'categoryID' => 3,
                'name' => 'Unable to Access General Ledger',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 3,
                'name' => 'Incorrect Balance Sheet Data',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 3,
                'name' => 'Financial Report Generation Failure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 3,
                'name' => 'Journal Entry Posting Failure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 3,
                'name' => 'Fiscal Period Not Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 3,
                'name' => 'Tax Calculation Inconsistency',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* ---------- ERP SUPPLY CHAIN MODULE (Category ID = 4) ---------- */
            [
                'categoryID' => 4,
                'name' => 'Inventory Quantity Mismatch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 4,
                'name' => 'Stock Movement Not Updated',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 4,
                'name' => 'Goods Receipt Not Posted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 4,
                'name' => 'Inventory Valuation Error',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 4,
                'name' => 'Batch or Serial Number Missing',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* ---------- ERP PROCUREMENT MODULE (Category ID = 5) ---------- */
            [
                'categoryID' => 5,
                'name' => 'Purchase Order Approval Stuck',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 5,
                'name' => 'Vendor Data Not Loading',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 5,
                'name' => 'Purchase Requisition Not Submitted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 5,
                'name' => 'Vendor Pricing Not Applied',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 5,
                'name' => 'Contract Expiry Not Triggered',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =====================================================
                                SERVICE REQUESTS
               ===================================================== */

            /* =======================
               SERVICE REQUEST – ERP HR (6)
               ======================= */
            [
                'categoryID' => 6,
                'name' => 'New Employee Account Creation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 6,
                'name' => 'Employee Role or Access Modification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 6,
                'name' => 'Employee Transfer Between Departments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 6,
                'name' => 'Employee Termination or Account Deactivation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Added
            [
                'categoryID' => 6,
                'name' => 'Bulk Payroll Data Upload',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 6,
                'name' => 'Organizational Structure Restructuring',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 6,
                'name' => 'Benefit Plan Configuration Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =======================
               SERVICE REQUEST – ERP FINANCE (7)
               ======================= */
            [
                'categoryID' => 7,
                'name' => 'Year-End Projection (YEP) Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 7,
                'name' => 'New General Ledger (GL) Account Setup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 7,
                'name' => 'Financial Report Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 7,
                'name' => 'Cost Center Creation or Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Added
            [
                'categoryID' => 7,
                'name' => 'Fixed Asset Category Setup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 7,
                'name' => 'Tax Code or Rate Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 7,
                'name' => 'Bank Interface (H2H) Setup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 7,
                'name' => 'Foreign Exchange Rate Table Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =======================
               SERVICE REQUEST – ERP SUPPLY CHAIN (8)
               ======================= */
            [
                'categoryID' => 8,
                'name' => 'Inventory Item Master Creation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 8,
                'name' => 'Inventory Stock Adjustment Request',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 8,
                'name' => 'Warehouse Location Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 8,
                'name' => 'Supply Chain Report Request',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Added
            [
                'categoryID' => 8,
                'name' => 'Bill of Materials (BOM) Modification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 8,
                'name' => 'Unit of Measure (UOM) Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 8,
                'name' => 'Cycle Counting Schedule Setup',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =======================
               SERVICE REQUEST – ERP PROCUREMENT (9)
               ======================= */
            [
                'categoryID' => 9,
                'name' => 'Vendor Registration Request',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 9,
                'name' => 'Vendor Information Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 9,
                'name' => 'Purchase Order Workflow Configuration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 9,
                'name' => 'Procurement Approval Matrix Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Added
            [
                'categoryID' => 9,
                'name' => 'E-Procurement Catalog Update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 9,
                'name' => 'Purchasing Contract Template Modification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoryID' => 9,
                'name' => 'RFP/RFQ Event Setup Support',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ], ['name'], ['categoryID', 'updated_at']);
    }
}