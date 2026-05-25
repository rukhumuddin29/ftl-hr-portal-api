<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['module' => 'users', 'name' => 'users.view', 'display_name' => 'View Users'],
            ['module' => 'users', 'name' => 'users.create', 'display_name' => 'Create Users'],
            ['module' => 'users', 'name' => 'users.update', 'display_name' => 'Update Users'],
            ['module' => 'users', 'name' => 'users.delete', 'display_name' => 'Delete Users'],

            ['module' => 'roles', 'name' => 'roles.view', 'display_name' => 'View Roles'],
            ['module' => 'roles', 'name' => 'roles.create', 'display_name' => 'Create Roles'],
            ['module' => 'roles', 'name' => 'roles.update', 'display_name' => 'Update Roles'],
            ['module' => 'roles', 'name' => 'roles.delete', 'display_name' => 'Delete Roles'],

            ['module' => 'departments', 'name' => 'departments.view', 'display_name' => 'View Departments'],
            ['module' => 'departments', 'name' => 'departments.manage', 'display_name' => 'Manage Departments'],

            ['module' => 'leads', 'name' => 'leads.view', 'display_name' => 'View All Leads'],
            ['module' => 'leads', 'name' => 'leads.view_assigned', 'display_name' => 'View Assigned Leads'],
            ['module' => 'leads', 'name' => 'leads.create', 'display_name' => 'Create Leads'],
            ['module' => 'leads', 'name' => 'leads.update', 'display_name' => 'Update Leads'],
            ['module' => 'leads', 'name' => 'leads.assign', 'display_name' => 'Assign Leads'],
            ['module' => 'leads', 'name' => 'leads.update_all', 'display_name' => 'Update All Leads (Merge)'],

            ['module' => 'leaves', 'name' => 'leaves.view', 'display_name' => 'View All Leaves'],
            ['module' => 'leaves', 'name' => 'leaves.approve', 'display_name' => 'Approve Leaves'],
            ['module' => 'expenses', 'name' => 'expenses.view', 'display_name' => 'View Expenses'],
            ['module' => 'expenses', 'name' => 'expenses.create', 'display_name' => 'Create Expenses'],
            ['module' => 'expenses', 'name' => 'expenses.approve', 'display_name' => 'Approve Expenses'],

            ['module' => 'reports', 'name' => 'reports.view', 'display_name' => 'View Reports'],

            ['module' => 'payroll', 'name' => 'payroll.manage', 'display_name' => 'Manage Salary Structures'],
            ['module' => 'payroll', 'name' => 'payroll.view', 'display_name' => 'View Payroll'],
            ['module' => 'payroll', 'name' => 'payroll.generate', 'display_name' => 'Generate Payroll'],
            ['module' => 'payroll', 'name' => 'payroll.approve', 'display_name' => 'Approve & Pay Payroll'],

            ['module' => 'attendance', 'name' => 'attendance.view', 'display_name' => 'View Attendance'],
            ['module' => 'attendance', 'name' => 'attendance.mark', 'display_name' => 'Mark Attendance'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm['name']], $perm);
        }
    }
}
