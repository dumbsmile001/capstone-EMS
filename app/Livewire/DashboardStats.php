<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DashboardStats extends Component
{
    public $stats = [];

    public function mount()
    {
        $user = Auth::user();
        
        $registrations = $user->registrations()
            ->with('event')
            ->get();

        $this->stats = [
            'my_events' => $registrations->where('status', 'registered')->count(),
            'upcoming_events' => $registrations->where('status', 'registered')
                ->filter(function($registration) {
                    return $registration->event->date >= now()->format('Y-m-d');
                })->count(),
            'my_tickets' => 0, // Will update when we implement ticketing
            'pending_payments' => 0, // Will update when we implement payments
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}