<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Training;
use App\Mail\TrainingExpiryWarning;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendExpiryReminders extends Command
{
    /**
     * Command ka naam (Terminal mein run karne ke liye)
     */
    protected $signature = 'app:send-expiry-reminders';

    /**
     * Command ki description
     */
    protected $description = 'Sende automatische E-Mail-Erinnerungen für bald ablaufende Schulungen';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Hum in intervals par alert bhejna chahte hain
        $intervals = [90, 60, 30, 7]; 

        foreach ($intervals as $days) {
            $targetDate = now()->addDays($days)->format('Y-m-d');
            
            // Sirf wo completed trainings dhoondein jo specific date par expire ho rahi hain
            $trainings = Training::whereDate('expiry_date', $targetDate)
                                 ->where('status', 'completed')
                                 ->get();

            foreach ($trainings as $training) {
                // Employee ke responsible managers (Verantwortliche) ko dhoondein
                $managers = $training->employee->responsibles;

                foreach ($managers as $manager) {
                    // FIX: Training object ke saath 'days' bhi pass kar rahe hain
                    Mail::to($manager->email)->send(new TrainingExpiryWarning($training, $days));
                    
                    $this->info("Erinnerung ({$days} Tage) gesendet an: {$manager->email} für {$training->employee->name}");
                }
            }
        }

        $this->info('Alle Ablauf-Erinnerungen wurden erfolgreich verarbeitet.');
    }
}