<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder; // Scope ke liye

class Category extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'tenant_id', // Isolation ke liye lazmi hai
    ];

    /**
     * Global Scope: Sirf current tenant ki categories dikhaye.
     */
    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (session()->has('tenant_id')) {
                $builder->where('tenant_id', session('tenant_id'));
            }
        });

        // Nayi category create karte waqt automatic tenant_id dakhil karna
        static::creating(function ($model) {
            if (session()->has('tenant_id')) {
                $model->tenant_id = session('tenant_id');
            }
        });
    }

    /**
     * Get all the trainings associated with this category.
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }
}