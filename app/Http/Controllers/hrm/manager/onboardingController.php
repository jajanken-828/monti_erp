<?php

namespace App\Http\Controllers\hrm\manager;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class OnboardingController extends Controller
{
    public function onboarding()
    {
        // FIX: Added 'Dashboard/' to the path to match resources/js/Pages/Dashboard/HRM/Applicants/application.vue
        return Inertia::render('Dashboard/HRM/Manager/onboarding');
    }
}
