<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AnnouncementController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Make dashboard the default home page
    Route::get('/dashboard', \App\Livewire\Home::class)->name('home'); // <-- Dashboard is now home
    Route::get('/announcements', \App\Livewire\Announcements::class)->name('announcements'); // <-- New announcements page
    
    // Role-specific dashboards
    Route::get('/dashboard/admin', \App\Livewire\AdminDashboard::class)->name('dashboard.admin');
    Route::get('/dashboard/organizer', \App\Livewire\OrganizerDashboard::class)->name('dashboard.organizer');
    Route::get('/dashboard/student', \App\Livewire\StudentDashboard::class)->name('dashboard.student');

    Route::get('/admin/events', \App\Livewire\AdminEvents::class)->name('admin.events');
    Route::get('/admin/events/archived', \App\Livewire\AdminArchivedEvents::class)->name('admin.events.archived');

    Route::get('/organizer/events', \App\Livewire\OrganizerEvents::class)
    ->name('organizer.events');
    Route::get('/organizer/events/archived', \App\Livewire\ArchivedEvents::class)->name('organizer.events.archived');
     Route::get('/organizer/attendance', \App\Livewire\EventAttendance::class)->name('organizer.attendance');

    Route::get('/dashboard/student/events', App\Livewire\StudentEvents::class)->name('student.events');

    // Ticket routes
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