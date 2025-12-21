<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tenant_id',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * RELATIONSHIP: New Training Tool
     * Isse pata chalega ke ye user kin kin Employees ka "Responsible Person" hai.
     */
    public function responsibleForEmployees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_responsible');
    }

    /**
     * Global scope to filter users by tenant
     */
    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenant = request()->attributes->get('tenant');
            if ($tenant) {
                $builder->where('tenant_id', $tenant->id);
            }
        });
    }

    /**
     * Get user's initials for avatar
     */
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        if (count($names) >= 2) {
            return strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Role Checks
     */
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isDeveloper(): bool { return $this->role === 'developer'; }
    public function isWorkBee(): bool { return $this->role === 'work-bee'; }
    public function isStandard(): bool { return $this->role === 'standard'; }

    /**
     * Relationship: User belongs to Tenant
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Relationship: User belongs to many teams (Keep if still needed for structure)
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')->withTimestamps();
    }
}