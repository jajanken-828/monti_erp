<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'position',
        'employee_id',
        'department',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Scope for HRM department users
     */
    public function scopeHrm($query)
    {
        return $query->where('role', 'HRM');
    }

    /**
     * Scope for SCM department users
     */
    public function scopeScm($query)
    {
        return $query->where('role', 'SCM');
    }

    /**
     * Scope for managerial positions
     */
    public function scopeManagers($query)
    {
        return $query->where('position', 'manager');
    }

    /**
     * Scope for staff positions
     */
    public function scopeStaff($query)
    {
        return $query->where('position', 'staff');
    }

    /**
     * Check if user belongs to HRM department
     */
    public function isHrm(): bool
    {
        return $this->role === 'HRM';
    }

    /**
     * Check if user belongs to SCM department
     */
    public function isScm(): bool
    {
        return $this->role === 'SCM';
    }

    /**
     * Check if user is a department manager
     */
    public function isManager(): bool
    {
        return $this->position === 'manager';
    }

    /**
     * Check if user is department staff
     */
    public function isStaff(): bool
    {
        return $this->position === 'staff';
    }

    /**
     * Get user's full department name
     */
    public function getRoleNameAttribute(): string
    {
        return match ($this->role) {
            'HRM' => 'Human Resource Management',
            'SCM' => 'Supply Chain Management',
            default => 'Unknown Department',
        };
    }

    /**
     * Get user's position title
     */
    public function getPositionNameAttribute(): string
    {
        return match ($this->position) {
            'manager' => 'Department Manager',
            'staff' => 'Department Staff',
            default => 'Unknown Position',
        };
    }

    /**
     * Get user's display name with department
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name.' - '.$this->role_name;
    }

    /**
     * Check if user has permission for specific department and position
     */
    public function hasPermission(string $requiredRole, ?string $requiredPosition = null): bool
    {
        if ($this->role !== $requiredRole) {
            return false;
        }

        if ($requiredPosition && $this->position !== $requiredPosition) {
            return false;
        }

        return true;
    }

    /**
     * Get appropriate dashboard path based on department and position
     */
    public function getDashboardPathAttribute(): string
    {
        return match ([$this->role, $this->position]) {
            ['HRM', 'manager'] => route('hrm.manager.dashboard'),
            ['HRM', 'staff'] => route('hrm.employee.dashboard'),
            ['SCM', 'manager'] => route('scm.manager.dashboard'),
            ['SCM', 'staff'] => route('scm.employee.dashboard'),
            default => route('dashboard'),
        };
    }

    /**
     * Get employee status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->email_verified_at
            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
    }

    /**
     * Get employee status text
     */
    public function getStatusTextAttribute(): string
    {
        return $this->email_verified_at ? 'Active' : 'Pending Verification';
    }
}
