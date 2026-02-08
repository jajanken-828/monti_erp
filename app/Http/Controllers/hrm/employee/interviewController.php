<?php

namespace App\Http\Controllers\hrm\employee;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class InterviewController extends Controller
{
    public function interview()
    {
        // FIX: Added 'Dashboard/' to the path to match resources/js/Pages/Dashboard/HRM/Applicants/application.vue
        return Inertia::render('Dashboard/HRM/Employee/interview');
    }
}
