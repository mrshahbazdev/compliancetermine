<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Training extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
        protected $fillable = [
        'employee_id', 
        'category_id', 
        'training_date', 
        'last_event_date', // Ye lazmi add karein
        'expiry_date', 
        'duration_days', 
        'certificate_path', 
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'training_date' => 'date',
        'last_event_date' => 'date', // Purane data ke liye
        'expiry_date' => 'date',
    ];

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
     * Yeh hum frontend par 'Red' color dikhane ke liye use karenge.
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->expiry_date) return false;
        
        $daysRemaining = now()->diffInDays($this->expiry_date, false);
        return $daysRemaining <= 90 && $daysRemaining > 0;
    }
}