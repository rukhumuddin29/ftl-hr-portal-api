<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\LeadController;
use App\Http\Controllers\Api\V1\LeadTypeController;

use App\Http\Controllers\Api\V1\ExpenseController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WorkdayController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\ForgotPasswordController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\SalaryStructureController;
use App\Http\Controllers\Api\V1\AttendanceSystemController;
use App\Http\Controllers\Api\V1\PayrollController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\ActivityLogController;
use App\Http\Controllers\Api\V1\LeaveController;
use App\Http\Controllers\Api\V1\BdeScorecardController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\WhatsappTemplateController;

Route::group(['prefix' => 'v1'], function () {

    // Public Routes
    Route::post('login', [AuthController::class , 'login']);
    Route::post('password/email', [ForgotPasswordController::class , 'sendResetLinkEmail']);
    Route::post('password/reset', [ForgotPasswordController::class , 'reset']);
    Route::get('company/public', [CompanyController::class , 'publicInfo']);

    // Protected Routes
    Route::group(['middleware' => 'auth:sanctum'], function () {

            // Dashboard
            Route::get('dashboard', [DashboardController::class , 'index']);
            Route::get('dashboard/lead-stats', [DashboardController::class , 'getLeadStats']);
            Route::get('dashboard/follow-ups', [DashboardController::class , 'getFollowUps']);
            Route::get('dashboard/interested-leads', [DashboardController::class , 'getInterestedLeads']);

            // Auth & Profile
            Route::get('/me', [AuthController::class , 'me']);
            Route::put('/profile', [ProfileController::class , 'update']);
            Route::post('/profile/avatar', [ProfileController::class , 'updateAvatar']);
            Route::post('/logout', [AuthController::class , 'logout']);

            // Workday Setup
            Route::group(['prefix' => 'workday-setup'], function () {
                    Route::get('/', [WorkdayController::class , 'index']);
                    Route::post('settings', [WorkdayController::class , 'updateSettings']);
                    Route::post('holidays', [WorkdayController::class , 'storeHoliday']);
                    Route::delete('holidays/{holiday}', [WorkdayController::class , 'destroyHoliday']);
                    Route::post('leave-policy', [WorkdayController::class , 'updateLeavePolicy'])->middleware('role:super_admin');
                }
                );

                // Leads
                Route::group(['prefix' => 'leads'], function () {
                    Route::get('/', [LeadController::class , 'index'])->middleware('permission:leads.view,leads.view_assigned');
                    Route::post('/', [LeadController::class , 'store'])->middleware('permission:leads.create');
                    Route::get('unassigned-counts', [LeadController::class , 'unassignedCounts'])->middleware('permission:leads.assign');
                    Route::get('pipeline', [LeadController::class , 'pipeline'])->middleware('permission:leads.view,leads.view_assigned');
                    Route::post('bulk-assign', [LeadController::class , 'bulkAssign'])->middleware('permission:leads.assign');
                    Route::post('bulk-import', [LeadController::class , 'bulkImport'])->middleware('permission:leads.create');
                    Route::apiResource('lead-types', LeadTypeController::class);
                    Route::apiResource('whatsapp-templates', WhatsappTemplateController::class);
                    Route::post('check-duplicates', [LeadController::class , 'checkDuplicates'])->middleware('permission:leads.create,leads.view');
                    Route::post('merge', [LeadController::class , 'mergeLeads'])->middleware('permission:leads.update_all');
                    Route::get('duplicates', [LeadController::class , 'duplicates'])->middleware('permission:leads.view');

                    Route::get('{lead}', [LeadController::class , 'show'])->middleware('permission:leads.view,leads.view_assigned');
                    Route::put('{lead}', [LeadController::class , 'update'])->middleware('permission:leads.update');
                    Route::post('{lead}/call-logs', [LeadController::class , 'addCallLog'])->middleware('permission:leads.update');
                    Route::post('{lead}/assign', [LeadController::class , 'assign'])->middleware('permission:leads.assign');
                    Route::patch('{lead}/snooze', [LeadController::class , 'snoozeFollowUp'])->middleware('permission:leads.update');
                    Route::patch('{lead}/complete', [LeadController::class , 'completeFollowUp'])->middleware('permission:leads.update');
                    Route::patch('{lead}/status', [LeadController::class , 'updateStatus'])->middleware('permission:leads.update');


                }
                );



                // Expenses
                Route::get('expense-categories', [ExpenseController::class , 'categories']);
                Route::apiResource('expenses', ExpenseController::class);
                Route::post('expenses/{expense}/approve', [ExpenseController::class , 'approve'])->middleware('permission:expenses.approve');



                // Salary Structures
                Route::group(['prefix' => 'salary-structures', 'middleware' => 'permission:payroll.manage'], function () {
                    Route::get('/', [SalaryStructureController::class , 'index']);
                    Route::get('{user}', [SalaryStructureController::class , 'show']);
                    Route::post('/', [SalaryStructureController::class , 'store']);
                }
                );

                // Attendance
                Route::group(['prefix' => 'attendance'], function () {
                    Route::get('my-today', [AttendanceSystemController::class , 'myToday']);
                    Route::get('my-history', [AttendanceSystemController::class , 'myHistory']);
                    Route::post('check-in', [AttendanceSystemController::class , 'checkIn']);
                    Route::post('check-out', [AttendanceSystemController::class , 'checkOut']);

                    Route::get('/', [AttendanceSystemController::class , 'index'])->middleware('permission:attendance.view');
                    Route::post('mark', [AttendanceSystemController::class , 'mark'])->middleware('permission:attendance.mark');
                    Route::post('bulk-mark', [AttendanceSystemController::class , 'bulkMark'])->middleware('permission:attendance.mark');
                    Route::post('mark-sundays', [AttendanceSystemController::class , 'markSundays'])->middleware('permission:attendance.mark');
                }
                );

                // Payroll
                Route::group(['prefix' => 'payroll'], function () {
                    Route::get('/', [PayrollController::class , 'index'])->middleware('permission:payroll.view');
                    Route::get('summary', [PayrollController::class , 'monthSummary'])->middleware('permission:payroll.view');
                    Route::post('generate', [PayrollController::class , 'generate'])->middleware('permission:payroll.generate');
                    Route::post('preview', [PayrollController::class , 'preview'])->middleware('permission:payroll.generate');
                    Route::get('{payroll}', [PayrollController::class , 'show'])->middleware('permission:payroll.view');
                    Route::post('{payroll}/approve', [PayrollController::class , 'approve'])->middleware('permission:payroll.approve');
                    Route::post('{payroll}/pay', [PayrollController::class , 'markPaid'])->middleware('permission:payroll.approve');
                    Route::post('bulk-approve', [PayrollController::class , 'bulkApprove'])->middleware('permission:payroll.approve');
                    Route::post('bulk-pay', [PayrollController::class , 'bulkPay'])->middleware('permission:payroll.approve');
                }
                );

                // BDE Performance Scorecard
                Route::group(['prefix' => 'bde-scorecard'], function () {
                    Route::get('leaderboard', [BdeScorecardController::class , 'leaderboard']);
                    Route::get('{userId}', [BdeScorecardController::class , 'show']);
                    Route::get('{userId}/trend', [BdeScorecardController::class , 'trend']);
                }
                )->middleware('permission:reports.view');

                // Notifications
                Route::group(['prefix' => 'notifications'], function () {
                    Route::get('/', [NotificationController::class , 'index']);
                    Route::get('unread-count', [NotificationController::class , 'unreadCount']);
                    Route::post('{id}/read', [NotificationController::class , 'markAsRead']);
                    Route::post('read-all', [NotificationController::class , 'markAllAsRead']);
                }
                );



                // Leave Management
                Route::group(['prefix' => 'leaves'], function () {
                    Route::get('my-leaves', [LeaveController::class , 'myLeaves']);
                    Route::get('my-balance', [LeaveController::class , 'myBalance']);
                    Route::post('apply', [LeaveController::class , 'apply']);
                    Route::post('{leaveRequest}/cancel', [LeaveController::class , 'cancel']);

                    Route::get('pending', [LeaveController::class , 'pending'])->middleware('permission:leaves.approve');
                    Route::get('all', [LeaveController::class , 'index'])->middleware('permission:leaves.view');
                    Route::post('{leaveRequest}/approve', [LeaveController::class , 'approve'])->middleware('permission:leaves.approve');
                    Route::post('{leaveRequest}/reject', [LeaveController::class , 'reject'])->middleware('permission:leaves.approve');
                }
                );

                Route::group(['prefix' => 'activity-logs'], function () {
                    Route::get('/', [ActivityLogController::class , 'index'])->middleware('permission:reports.view');
                    Route::get('model/{modelType}/{modelId}', [ActivityLogController::class , 'forModel'])
                        ->middleware('permission:reports.view,leads.view,leads.view_assigned');
                }
                );

                // Settings & Admin
                Route::get('company', [CompanyController::class , 'show']);
                Route::post('company', [CompanyController::class , 'update'])->middleware('role:super_admin');

                Route::get('users/bdes', [UserController::class , 'getBdes']);
                Route::apiResource('users', UserController::class)->middleware('permission:users.view');
                Route::apiResource('roles', RoleController::class)->middleware('permission:roles.view');
                Route::apiResource('permissions', PermissionController::class)->middleware('permission:roles.view');
                Route::apiResource('departments', DepartmentController::class)
                    ->except(['show'])
                    ->middleware(['index' => 'permission:departments.view', 'store' => 'permission:departments.manage', 'update' => 'permission:departments.manage', 'destroy' => 'permission:departments.manage']);
            }
            );
        });
