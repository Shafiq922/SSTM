<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tickets')->upsert([
            // INCIDENT
            [
                'ticket_number' => 'INC-001',
                'summary' => 'Finance system unavailable',
                'type' => 'incident',
                'description' => 'Cannot open balance sheet',
                'priority' => 'High',
                'status' => 'Open',
                'userID' => 1,
                'slaID' => 1,
                'categoryID' => 1,
                'subCategoryID' => 1,
                // Incident Specific
                'impact_level' => 'High',
                'urgency' => 'Critical',
                // Service Request Specific (Set to null)
                'request_type' => null,
                'erp_module' => null,
            ],
            // SERVICE REQUEST
            [
                'ticket_number' => 'SR-001',
                'summary' => 'New ERP user request',
                'type' => 'service_request',
                'description' => 'Create account for new employee',
                'priority' => 'Normal',
                'status' => 'Open',
                'userID' => 2,
                'slaID' => 3,
                'categoryID' => 1,
                'subCategoryID' => 2,
                // Incident Specific (Set to null)
                'impact_level' => null,
                'urgency' => null,
                // Service Request Specific
                'request_type' => 'New Account',
                'erp_module' => 'HR Module',
            ],
        ], ['ticket_number'], ['summary', 'description', 'status', 'userID', 'slaID', 'categoryID', 'subCategoryID', 'impact_level', 'urgency', 'request_type', 'erp_module']);
    }
}
