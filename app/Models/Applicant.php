<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Applicant extends Model
{
    /**
     * The attributes that are mass assignable.
     * Added street_address_line2 to match the application.vue form.
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
        'street_address',
        'street_address_line2',
        'city',
        'state_province',
        'postal_zip_code',
        'position_applied',
        'expected_salary',
        'notice_period',
        'textile_experience',
        'status',
        'sss_file',
        'philhealth_file',
        'pagibig_file',
    ];

    protected $casts = [
        'expected_salary' => 'decimal:2',
    ];

    /**
     * Helper to get the full name of the applicant.
     * This is used in the controller to map the 'name' key for the frontend table.
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Relationship: An applicant has one interview schedule.
     * This allows the controller to filter out applicants who already have a schedule.
     */
    public function interview(): HasOne
    {
        return $this->hasOne(Interview::class);
    }
}
