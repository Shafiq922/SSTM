<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch IDs dynamically
        $adminRole = DB::table('roles')->where('name', 'Admin')->value('roleID'); // Assuming Admin role is added back
        $itStaffRole = DB::table('roles')->where('name', 'IT Staff')->value('roleID');
        $internalRole = DB::table('roles')->where('name', 'Internal Customer')->value('roleID');
        $externalRole = DB::table('roles')->where('name', 'External Customer')->value('roleID');

        $financeDept = DB::table('departments')->where('name', 'Finance')->value('departmentID');
        $itDept = DB::table('departments')->where('name', 'IT')->value('departmentID');
        $hrDept = DB::table('departments')->where('name', 'HR')->value('departmentID');
        $procureDept = DB::table('departments')->where('name', 'Procurement')->value('departmentID');
        $supplyDept = DB::table('departments')->where('name', 'Supply Chain')->value('departmentID');
        $extDept = DB::table('departments')->where('name', 'External Client')->value('departmentID');

        DB::table('users')->upsert([

            /* =========================
               ADMIN USERS (IT Department)
               ========================= */
            [
                'name' => 'System Admin',
                'email' => 'admin1@salihin.com',
                'user_phone' => '0123456781',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $adminRole,
                'departmentID' => $itDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Senior IT Admin',
                'email' => 'admin2@salihin.com',
                'user_phone' => '0123456782',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $adminRole,
                'departmentID' => $itDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IT Operations Admin',
                'email' => 'admin3@salihin.com',
                'user_phone' => '0123456783',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $adminRole,
                'departmentID' => $itDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =========================
               IT STAFF
               ========================= */
            [
                'name' => 'IT Support Staff',
                'email' => 'itstaff1@salihin.com',
                'user_phone' => '0123456791',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $itStaffRole,
                'departmentID' => $itDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IT System Engineer',
                'email' => 'itstaff2@salihin.com',
                'user_phone' => '0123456792',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $itStaffRole,
                'departmentID' => $itDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =========================
               FINANCE USERS
               ========================= */
            [
                'name' => 'Finance Executive',
                'email' => 'finance1@salihin.com',
                'user_phone' => '0123456701',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $internalRole,
                'departmentID' => $financeDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Finance Manager',
                'email' => 'finance2@salihin.com',
                'user_phone' => '0123456702',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $internalRole,
                'departmentID' => $financeDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =========================
               HR USERS
               ========================= */
            [
                'name' => 'HR Officer',
                'email' => 'hr1@salihin.com',
                'user_phone' => '0123456711',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $internalRole,
                'departmentID' => $hrDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =========================
               PROCUREMENT USERS
               ========================= */
            [
                'name' => 'Procurement Officer',
                'email' => 'procurement1@salihin.com',
                'user_phone' => '0123456721',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $internalRole,
                'departmentID' => $procureDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =========================
               SUPPLY CHAIN USERS
               ========================= */
            [
                'name' => 'Supply Chain Executive',
                'email' => 'supplychain1@salihin.com',
                'user_phone' => '0123456731',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $internalRole,
                'departmentID' => $supplyDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /* =========================
               EXTERNAL CLIENT
               ========================= */
            [
                'name' => 'External Client User',
                'email' => 'client1@external.com',
                'user_phone' => '0123456741',
                'password' => Hash::make('Shafiq_123'),
                'roleID' => $externalRole,
                'departmentID' => $extDept,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['email'], ['name', 'user_phone', 'password', 'roleID', 'departmentID', 'updated_at']);
    }
}
