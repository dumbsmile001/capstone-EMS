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

        // Count tickets that exist and are active
        $ticketsCount = $registrations->filter(function($registration) {
            return $registration->ticket && $registration->ticket->isActive();
        })->count();

        // Count pending payments
        $pendingPaymentsCount = $registrations->filter(function($registration) {
            return $registration->event->require_payment && 
                   $registration->payment_status === 'pending';
        })->count();

        $this->stats = [
            'my_events' => $registrations->where('status', 'registered')->count(),
            'upcoming_events' => $registrations->where('status', 'registered')
                ->filter(function($registration) {
                    return $registration->event->date >= now()->format('Y-m-d');
                })->count(),
            'my_tickets' => $ticketsCount, // Will update when we implement ticketing
            'pending_payments' => $pendingPaymentsCount, // Will update when we implement payments
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}