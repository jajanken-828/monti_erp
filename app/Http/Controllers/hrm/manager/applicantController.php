<?php

namespace App\Http\Controllers\hrm\manager;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ApplicantController extends Controller
{
    public function index()
    {
        // FIX: Added 'Dashboard/' to the path to match resources/js/Pages/Dashboard/HRM/Applicants/application.vue
        return Inertia::render('Dashboard/HRM/Applicants/application', [
            'applicants' => [
                ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'position' => 'Weaver', 'status' => 'Interview', 'date' => '2024-02-01'],
                ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'position' => 'Quality Control', 'status' => 'Pending', 'date' => '2024-02-03'],
                ['id' => 3, 'name' => 'Mike Ross', 'email' => 'mike@example.com', 'position' => 'Floor Manager', 'status' => 'Rejected', 'date' => '2024-01-28'],
            ],
        ]);
    }
}
