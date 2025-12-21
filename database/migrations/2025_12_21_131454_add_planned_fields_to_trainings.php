<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Agar duration_days nahi hai to add karein
            if (!Schema::hasColumn('trainings', 'duration_days')) {
                $table->integer('duration_days')->default(365)->after('expiry_date');
            }
            
            // planned_date ko nullable banane ke liye (Agar pehle ban chuka hai)
            // Hum training_date ko fallback ke taur par use karenge
            if (!Schema::hasColumn('trainings', 'training_date')) {
                $table->date('training_date')->nullable()->after('last_event_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            //
        });
    }
};
