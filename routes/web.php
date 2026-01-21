<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', \App\Livewire\Home::class)->name('home');
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/dashboard/admin', \App\Livewire\AdminDashboard::class)->name('dashboard.admin');
    Route::get('/dashboard/organizer', \App\Livewire\OrganizerDashboard::class)->name('dashboard.organizer');
    Route::get('/dashboard/student', \App\Livewire\StudentDashboard::class)->name('dashboard.student');

    //ticket test
    Route::get('/ticket/{ticket}/download', [TicketController::class, 'download'])
        ->name('ticket.download');
    Route::get('/ticket/{ticket}/view', [TicketController::class, 'view'])
        ->name('ticket.view');

    // Public verification route (NO auth middleware)
    Route::get('/ticket/verify/{ticketNumber}', [App\Http\Controllers\TicketVerificationController::class, 'verify'])
        ->name('ticket.verify.public');
        
    // Protected routes for ticket management
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/ticket/{ticketNumber}/use', [App\Http\Controllers\TicketVerificationController::class, 'markAsUsed'])
            ->name('ticket.mark-used');
        
        Route::post('/ticket/{ticketNumber}/reactivate', [App\Http\Controllers\TicketVerificationController::class, 'reactivate'])
            ->name('ticket.reactivate');
    });
});