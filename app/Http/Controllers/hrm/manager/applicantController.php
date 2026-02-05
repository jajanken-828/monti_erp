<?php

namespace App\Http\Controllers\hrm\manager;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ApplicantController extends Controller
{
    public function index()
    {
        // This path must match: resources/js/Pages/HRM/Applicants/application.vue
        return Inertia::render('HRM/Applicants/application', [
            'applicants' => [
                ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'position' => 'Weaver', 'status' => 'Interview', 'date' => '2024-02-01'],
                ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'position' => 'Quality Control', 'status' => 'Pending', 'date' => '2024-02-03'],
            ],
        ]);
    }
}
