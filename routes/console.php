<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::command('app:send-expiry-reminders')->daily()->when(function () {
    return now()->day % 2 === 0; // Sirf un dino chalega jo 2 par divide hote hain
});