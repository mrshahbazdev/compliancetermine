<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder; // Scope ke liye lazmi hai

class Training extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'employee_id', 
        'category_id', 
        'tenant_id', // Isolation column
        'last_event_date', 
        'training_date', 
        'expiry_date', 
        'duration_days', 
        'certificate_path', 
        'status'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'training_date' => 'date',
        'last_event_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Global Scope: Automatic Filtering & Tenant ID Assignment
     */
    protected static function booted()
    {
        // Global Scope: Har query mein automatic tenant filter lagayega
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (session()->has('tenant_id')) {
                $builder->where('tenant_id', session('tenant_id'));
            }
        });

        // Auto-save tenant_id: Naya record save karte waqt khud session se ID uthayega
        static::creating(function ($model) {
            if (session()->has('tenant_id')) {
                $model->tenant_id = session('tenant_id');
            }
        });
    }

    /**
     * Get the employee that owns the training.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the category (e.g., ADR, Gabelstapler) of the training.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Helper logic: Check if training is expiring within 90 days.
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->expiry_date) return false;
        
        $daysRemaining = now()->diffInDays($this->expiry_date, false);
        return $daysRemaining <= 90 && $daysRemaining > 0;
    }
}