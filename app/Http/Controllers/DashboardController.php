<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Redirect to appropriate dashboard based on user's role and position
        if ($user->role === 'HRM' && $user->position === 'manager') {
            return $this->hrmManager($request);
        } elseif ($user->role === 'HRM' && $user->position === 'staff') {
            return $this->hrmEmployee($request);
        } elseif ($user->role === 'SCM' && $user->position === 'manager') {
            return $this->scmManager($request);
        } elseif ($user->role === 'SCM' && $user->position === 'staff') {
            return $this->scmEmployee($request);
        }

        // Default dashboard for other roles
        $stats = [
            'total_tasks' => 0,
            'pending_tasks' => 0,
            'completed_tasks' => 0,
        ];

        return Inertia::render('Dashboard/Index', [
            'stats' => $stats,
            'user' => $user,
        ]);
    }

    public function hrmManager(Request $request)
    {
        $stats = [
            'totalEmployees' => \App\Models\User::where('role', 'HRM')->count(),
            'activeRecruitments' => 12,
            'pendingLeaves' => 8,
            'attendanceRate' => 95,
        ];

        return Inertia::render('Dashboard/HRM/Manager/Index', [
            'stats' => $stats,
            'recentActivities' => [],
            'teamPerformance' => [],
        ]);
    }

    public function hrmEmployee(Request $request)
    {
        $stats = [
            'myTasks' => 15,
            'pendingApprovals' => 3,
            'upcomingInterviews' => 5,
            'completedThisWeek' => 12,
        ];

        $tasks = [
            ['id' => 1, 'title' => 'Process leave applications', 'due_date' => 'Today', 'priority' => 'high', 'completed' => false, 'category' => 'HR'],
            ['id' => 2, 'title' => 'Schedule interviews', 'due_date' => 'Tomorrow', 'priority' => 'medium', 'completed' => true, 'category' => 'Recruitment'],
            ['id' => 3, 'title' => 'Update employee records', 'due_date' => 'Dec 15', 'priority' => 'low', 'completed' => false, 'category' => 'Admin'],
        ];

        $recentActivities = [
            ['id' => 1, 'type' => 'completed', 'message' => 'Completed payroll processing', 'time' => '2 hours ago', 'category' => 'Payroll'],
            ['id' => 2, 'type' => 'new_user', 'message' => 'New employee onboarded', 'time' => 'Yesterday', 'category' => 'Onboarding'],
            ['id' => 3, 'type' => 'alert', 'message' => '2 pending leave requests', 'time' => '3 days ago', 'category' => 'Leave'],
        ];

        $upcomingEvents = [
            ['id' => 1, 'title' => 'Team Meeting', 'time' => '10:00 AM', 'type' => 'Meeting'],
            ['id' => 2, 'title' => 'Training Session', 'time' => '2:00 PM', 'type' => 'Training'],
        ];

        return Inertia::render('Dashboard/HRM/Employee/Index', [
            'stats' => $stats,
            'tasks' => $tasks,
            'recentActivities' => $recentActivities,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

    public function scmManager(Request $request)
    {
        $stats = [
            'totalInventory' => 1200,
            'pendingOrders' => 45,
            'activeShipments' => 32,
            'lowStockItems' => 15,
        ];

        $inventoryAlerts = [
            ['id' => 1, 'item' => 'Laptop Components', 'stock' => 12],
            ['id' => 2, 'item' => 'Shipping Materials', 'stock' => 8],
            ['id' => 3, 'item' => 'Packaging Boxes', 'stock' => 15],
        ];

        $recentShipments = [
            ['id' => 1, 'order' => 'ORD-001', 'destination' => 'New York', 'status' => 'In Transit', 'eta' => 'Dec 20'],
            ['id' => 2, 'order' => 'ORD-002', 'destination' => 'Los Angeles', 'status' => 'Delivered', 'eta' => 'Dec 18'],
        ];

        $financialMetrics = [
            'revenue' => 125000,
            'pendingPayments' => 25000,
            'inventoryValue' => 75000,
        ];

        return Inertia::render('Dashboard/SCM/Manager/Index', [
            'stats' => $stats,
            'inventoryAlerts' => $inventoryAlerts,
            'recentShipments' => $recentShipments,
            'financialMetrics' => $financialMetrics,
        ]);
    }

    public function scmEmployee(Request $request)
    {
        $stats = [
            'assignedTasks' => 8,
            'pendingOrders' => 23,
            'completedDeliveries' => 156,
            'stockAlerts' => 8,
        ];

        $tasks = [
            ['id' => 1, 'title' => 'Process incoming shipment', 'due_date' => 'Today', 'priority' => 'high', 'completed' => false, 'category' => 'Inventory'],
            ['id' => 2, 'title' => 'Update stock levels', 'due_date' => 'Today', 'priority' => 'medium', 'completed' => true, 'category' => 'Inventory'],
            ['id' => 3, 'title' => 'Prepare delivery schedule', 'due_date' => 'Tomorrow', 'priority' => 'low', 'completed' => false, 'category' => 'Logistics'],
        ];

        $inventoryItems = [
            ['id' => 1, 'name' => 'Laptop Components', 'location' => 'Warehouse A', 'quantity' => 120, 'status' => 'Normal'],
            ['id' => 2, 'name' => 'Shipping Materials', 'location' => 'Warehouse B', 'quantity' => 8, 'status' => 'Low'],
            ['id' => 3, 'name' => 'Packaging Boxes', 'location' => 'Warehouse A', 'quantity' => 450, 'status' => 'Normal'],
        ];

        $pendingOrders = [
            ['id' => 1, 'items' => 12, 'priority' => 'High'],
            ['id' => 2, 'items' => 5, 'priority' => 'Medium'],
            ['id' => 3, 'items' => 8, 'priority' => 'Low'],
        ];

        return Inertia::render('Dashboard/SCM/Employee/Index', [
            'stats' => $stats,
            'tasks' => $tasks,
            'inventoryItems' => $inventoryItems,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}
