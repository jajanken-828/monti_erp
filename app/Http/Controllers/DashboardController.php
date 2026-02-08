<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = strtoupper($user->role);
        $position = strtolower($user->position);

        return match ($role) {
            'HRM' => $this->handleHrmDashboard($position),
            'SCM' => $this->handleScmDashboard($position),
            default => $this->renderDefaultDashboard($user),
        };
    }

    private function handleHrmDashboard(string $position)
    {
        if ($position === 'manager') {
            return Inertia::render('Dashboard/HRM/Manager/Index', [
                'stats' => [
                    'totalEmployees' => User::where('role', 'HRM')->count(),
                    'activeRecruitments' => 12,
                    'pendingLeaves' => 8,
                    'attendanceRate' => 95,
                ],
            ]);
        }

        // HRM Staff Dashboard
        return Inertia::render('Dashboard/HRM/Employee/Index', [
            'stats' => [
                'assignedTasks' => 4,
                'leaveBalance' => 15,
                'trainingModules' => 2,
            ],
            'user' => Auth::user(),
        ]);
    }

    private function handleScmDashboard(string $position)
    {
        if ($position === 'manager') {
            return Inertia::render('Dashboard/SCM/Manager/Index', [
                'stats' => [
                    'totalInventory' => 1250,
                    'pendingOrders' => 8,
                    'completedDeliveries' => 24,
                    'stockAlerts' => 3,
                ],
                'inventoryItems' => [],
                'pendingOrders' => [],
            ]);
        }

        // SCM Staff Dashboard
        return Inertia::render('Dashboard/SCM/Employee/Index', [
            'stats' => [
                'pendingPickups' => 5,
                'incomingShipments' => 3,
                'inventoryChecks' => 2,
            ],
            'user' => Auth::user(),
        ]);
    }

    private function renderDefaultDashboard($user)
    {
        return Inertia::render('Dashboard/Index', [
            'stats' => ['total_tasks' => 0],
            'user' => $user,
        ]);
    }
}
