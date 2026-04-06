<?php

use App\Console\Commands\ArchiveExpiredEvents;
use Illuminate\Support\Facades\Schedule;

// Define the scheduled task directly in routes/console.php
Schedule::command('events:archive-expired --days=1')
    ->dailyAt('01:00')
    ->onFailure(function () {
        \Log::error('Auto-archive task failed');
    })
    ->onSuccess(function () {
        \Log::info('Auto-archive task completed successfully');
    });