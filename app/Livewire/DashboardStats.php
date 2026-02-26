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

        // Get current date and time for comparison
        $now = now();
        $today = $now->toDateString();
        $currentTime = $now->format('H:i:s');

        $this->stats = [
            'my_events' => $registrations->where('status', 'registered')->count(),
            'upcoming_events' => $registrations->where('status', 'registered')
                ->filter(function($registration) use ($today, $currentTime) {
                    $event = $registration->event;
                    // Event is upcoming if start date is in the future, or if it's today but start time is in the future
                    return $event->start_date > $today || 
                           ($event->start_date == $today && $event->start_time > $currentTime);
                })->count(),
            'my_tickets' => $ticketsCount,
            'pending_payments' => $pendingPaymentsCount,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}