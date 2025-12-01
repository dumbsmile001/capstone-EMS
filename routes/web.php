<?php

use Illuminate\Support\Facades\Route;

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
});

Route::get('/test-ticket', function() {
    $registration = \App\Models\Registration::latest()->first();
    
    if ($registration) {
        echo "Registration ID: " . $registration->id . "<br>";
        echo "Event: " . $registration->event->title . "<br>";
        echo "User: " . $registration->user->first_name . "<br>";
        echo "Has Ticket: " . ($registration->ticket ? 'YES' : 'NO') . "<br>";
        
        if ($registration->ticket) {
            echo "Ticket Number: " . $registration->ticket->ticket_number . "<br>";
            echo "Ticket Status: " . $registration->ticket->status . "<br>";
        }
    } else {
        echo "No registrations found";
    }
});