<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

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

        // Get all upcoming events visible to the student (NEW LOGIC)
        $upcomingEventsCount = Event::where('status', 'published')
            ->where('is_archived', false)
            ->where(function($query) use ($today, $currentTime) {
                // Event is upcoming if start date is in the future, 
                // or if it's today but start time is in the future
                $query->where('start_date', '>', $today)
                    ->orWhere(function($subQuery) use ($today, $currentTime) {
                        $subQuery->where('start_date', $today)
                            ->where('start_time', '>', $currentTime);
                    });
            })
            ->get()
            ->filter(function($event) use ($user) {
                // Filter events that are visible to this user
                return $event->isVisibleToUser($user);
            })
            ->count();

        $this->stats = [
            'my_events' => $registrations->where('status', 'registered')->count(),
            'upcoming_events' => $upcomingEventsCount, // Changed to count all visible upcoming events
            'my_tickets' => $ticketsCount,
            'pending_payments' => $pendingPaymentsCount,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}