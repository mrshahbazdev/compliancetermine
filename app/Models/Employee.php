<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder; // Scope ke liye lazmi hai

class Employee extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'dob',
        'tenant_id', // Isolation column
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * Global Scope: Automatic Filtering & Automatic tenant_id Assignment
     */
    protected static function booted()
    {
        // Query filter: SELECT * FROM employees WHERE tenant_id = '...'
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (session()->has('tenant_id')) {
                $builder->where('tenant_id', session('tenant_id'));
            }
        });

        // Auto-save tenant_id when creating a new employee
        static::creating(function ($model) {
            if (session()->has('tenant_id')) {
                $model->tenant_id = session('tenant_id');
            }
        });
    }

    /**
     * Get all trainings for the employee.
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    /**
     * The responsible persons (Users) for this employee.
     */
    public function responsibles(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'employee_responsible');
    }
}