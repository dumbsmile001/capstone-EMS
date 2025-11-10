<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard/admin', \App\Livewire\AdminDashboard::class)->name('dashboard.admin');
    Route::get('/dashboard/organizer', \App\Livewire\OrganizerDashboard::class)->name('dashboard.organizer');
    Route::get('/dashboard/student', \App\Livewire\StudentDashboard::class)->name('dashboard.student');
});
