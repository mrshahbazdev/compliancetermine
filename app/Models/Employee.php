<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'dob',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * Get all trainings for the employee.
     * Ek employee ki multiple trainings (ADR, Gabelstapler, etc.) ho sakti hain.
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    /**
     * The responsible persons (Users) for this employee.
     * Isse hum un 3 responsible logo ko link karenge jo is employee ke records dekh sakte hain.
     */
    public function responsibles(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'employee_responsible');
    }
}