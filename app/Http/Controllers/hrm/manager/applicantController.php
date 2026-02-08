<?php

namespace App\Http\Controllers\hrm\manager;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ApplicantController extends Controller
{
    /**
     * Display a listing of applicants without scheduled interviews.
     */
    public function index()
    {
        return Inertia::render('Dashboard/HRM/Applicants/application', [
            'applicants' => Applicant::doesntHave('interview')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($a) => [
                    'id' => $a->id,
                    'name' => $a->name, // Uses the accessor in Applicant Model
                    'email' => $a->email,
                    'phone_number' => $a->phone_number,
                    'position' => $a->position_applied,
                    'status' => $a->status,
                    'date' => $a->created_at->format('Y-m-d'),
                    'notice_period' => $a->notice_period,
                    'street_address' => $a->street_address,
                    'city' => $a->city,
                    'state_province' => $a->state_province,
                    'postal_zip_code' => $a->postal_zip_code,
                    // Generate public URLs for images to display in the View Details modal
                    'sss_file_url' => $a->sss_file ? Storage::url($a->sss_file) : null,
                    'philhealth_file_url' => $a->philhealth_file ? Storage::url($a->philhealth_file) : null,
                    'pagibig_file_url' => $a->pagibig_file ? Storage::url($a->pagibig_file) : null,
                ]),
        ]);
    }

    /**
     * Store a newly created applicant in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:applicants,email',
            'phone_number' => 'required|string',
            'position_applied' => 'required|string',
            'expected_salary' => 'nullable|numeric',
            'notice_period' => 'required|string|in:immediate,15_days,30_days',
            'street_address' => 'required|string',
            'street_address_line2' => 'nullable|string',
            'city' => 'required|string',
            'state_province' => 'required|string',
            'postal_zip_code' => 'required|string',
            'textile_experience' => 'required|string|in:yes,no',
            // File validations
            'sss_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'philhealth_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pagibig_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Extract all data except files first
        $data = $request->except(['sss_file', 'philhealth_file', 'pagibig_file']);

        // Handle File Uploads and store paths in the database
        if ($request->hasFile('sss_file')) {
            $data['sss_file'] = $request->file('sss_file')->store('applicants/ids', 'public');
        }
        if ($request->hasFile('philhealth_file')) {
            $data['philhealth_file'] = $request->file('philhealth_file')->store('applicants/ids', 'public');
        }
        if ($request->hasFile('pagibig_file')) {
            $data['pagibig_file'] = $request->file('pagibig_file')->store('applicants/ids', 'public');
        }

        Applicant::create($data);

        // redirect back() triggers Inertia to re-fetch the 'applicants' prop in real-time
        return back()->with('success', 'Applicant added successfully.');
    }

    /**
     * Schedule an interview for an applicant.
     */
    public function scheduleInterview(Request $request, Applicant $applicant)
    {
        $request->validate([
            'scheduled_at' => 'required|date',
            'interview_type' => 'required|string|in:phone,technical,behavioral,onsite,video',
            'duration' => 'required|integer|in:15,30,45,60',
            'interviewer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Update applicant status to "Interview"
        $applicant->update(['status' => 'Interview']);

        // Create the interview with all fields
        Interview::create([
            'applicant_id' => $applicant->id,
            'scheduled_at' => $request->scheduled_at,
            'interview_type' => $request->interview_type,
            'duration' => $request->duration,
            'interviewer' => $request->interviewer,
            'location' => $request->location,
            'notes' => $request->notes,
        ]);

        // Once scheduled, the applicant will be filtered out of the index query automatically
        return back()->with('success', 'Interview scheduled successfully.');
    }
}
