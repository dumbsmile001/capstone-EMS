<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Registration;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class OrganizerRegistrations extends Component
{
    public $registrations;
    public $events;
    
    // For payment verification modal
    public $showPaymentModal = false;
    public $selectedRegistration;
    public $verificationNotes = '';

    public function mount()
    {
        $this->loadRegistrations();
        $this->loadEvents();
    }

    public function loadRegistrations()
    {
        $this->registrations = Registration::with(['event', 'user', 'ticket'])
            ->whereHas('event', function($query) {
                $query->where('created_by', auth()->id());
            })
            ->orderBy('registered_at', 'desc')
            ->get();
    }

    public function loadEvents()
    {
        $this->events = Event::where('created_by', auth()->id())->get();
    }

    public function verifyPayment($registrationId)
    {
        $this->selectedRegistration = Registration::with(['user', 'event'])->find($registrationId);
        $this->verificationNotes = '';
        $this->showPaymentModal = true;
    }

    public function confirmPaymentVerification()
    {
        $this->validate([
            'verificationNotes' => 'nullable|string|max:500',
        ]);

        $this->selectedRegistration->update([
            'payment_status' => 'verified',
            'payment_verified_at' => now(),
            'payment_verified_by' => Auth::id(),
        ]);

        $this->showPaymentModal = false;
        $this->loadRegistrations();
        
        session()->flash('success', 'Payment verified successfully for ' . $this->selectedRegistration->user->first_name . ' ' . $this->selectedRegistration->user->last_name);
    }

    public function rejectPayment($registrationId)
    {
        $registration = Registration::with(['user'])->find($registrationId);
        
        $registration->update([
            'payment_status' => 'rejected',
            'payment_verified_at' => now(),
            'payment_verified_by' => Auth::id(),
        ]);

        // For rejected payments, if ticket exists, keep it but mark appropriately
        if ($registration->ticket && $registration->ticket->isPendingPayment()) {
            $registration->ticket->update([
                'status' => 'pending_payment', // Keep as pending_payment for rejected payments
            ]);
        }

        $this->loadRegistrations();
        session()->flash('info', 'Payment rejected for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function resetPaymentStatus($registrationId)
    {
        $registration = Registration::with(['user', 'ticket'])->find($registrationId);
        
        $registration->update([
            'payment_status' => 'pending',
            'payment_verified_at' => null,
            'payment_verified_by' => null,
        ]);

        // If ticket exists for paid event, reset to pending_payment
        if ($registration->ticket && $registration->event->require_payment) {
            $registration->ticket->update([
                'status' => 'pending_payment',
            ]);
        }

        $this->loadRegistrations();
        session()->flash('info', 'Payment status reset to pending for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedRegistration = null;
        $this->verificationNotes = '';
    }

    public function generateTicket($registrationId)
    {
        $registration = Registration::with(['user', 'event', 'ticket'])->find($registrationId);
        
        // Check if registration is eligible for ticket generation
        if (!$this->isEligibleForTicket($registration)) {
            session()->flash('error', 'Cannot generate ticket. Payment not verified or registration incomplete.');
            return;
        }

        // Check if ticket already exists and is active
        if ($registration->ticket && $registration->ticket->isActive()) {
            session()->flash('info', 'Ticket already exists and is active');
            return;
        }

        try {
            // If ticket exists but not active, regenerate it
            if ($registration->ticket) {
                $registration->regenerateTicket();
                $registration->ticket->update(['status' => 'active']);
                session()->flash('success', 'Ticket regenerated for ' . $registration->user->first_name);
            } else {
                // Create new ticket
                Ticket::create([
                    'registration_id' => $registration->id,
                    'ticket_number' => Registration::generateTicketNumber(),
                    'status' => 'active',
                    'generated_at' => now(),
                ]);
                session()->flash('success', 'Ticket generated for ' . $registration->user->first_name);
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate ticket: ' . $e->getMessage());
        }
        
        $this->loadRegistrations();
    }

    public function regenerateTicket($registrationId)
    {
        $registration = Registration::with(['user', 'event', 'ticket'])->find($registrationId);
        
        // Check if registration is eligible for ticket regeneration
        if (!$this->isEligibleForTicket($registration)) {
            session()->flash('error', 'Cannot regenerate ticket. Payment not verified or registration incomplete.');
            return;
        }

        if ($registration->ticket) {
            try {
                $registration->regenerateTicket();
                session()->flash('success', 'Ticket regenerated for ' . $registration->user->first_name);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to regenerate ticket: ' . $e->getMessage());
            }
        } else {
            session()->flash('error', 'No ticket found to regenerate');
        }
        
        $this->loadRegistrations();
    }

    public function viewTicket($registrationId)
    {
        $registration = Registration::with(['ticket'])->find($registrationId);
        
        if ($registration->ticket) {
            // You can implement modal or redirect to ticket view page here
            // For now, just show a message
            session()->flash('info', 'Ticket view for: ' . $registration->ticket->ticket_number);
        } else {
            session()->flash('error', 'No ticket found for this registration');
        }
    }

    // Helper method to check if registration is eligible for ticket
    private function isEligibleForTicket($registration)
    {
        // For free events, always eligible
        if (!$registration->event->require_payment) {
            return true;
        }
        
        // For paid events, only eligible if payment is verified
        return $registration->isPaymentVerified();
    }

    // Helper method to determine what buttons to show
    public function getActionButtons($registration)
    {
        $buttons = [];
        
        if ($registration->event->require_payment) {
            // Paid event logic
            if ($registration->isPaymentPending()) {
                $buttons = [
                    'verify' => true,
                    'reject' => true,
                    'generate' => false,
                    'view' => false,
                    'regenerate' => false,
                    'reset' => false,
                ];
            } elseif ($registration->isPaymentVerified()) {
                $buttons = [
                    'verify' => false,
                    'reject' => false,
                    'generate' => !$registration->ticket || !$registration->ticket->isActive(),
                    'view' => $registration->ticket && $registration->ticket->isActive(),
                    'regenerate' => $registration->ticket && $registration->ticket->isActive(),
                    'reset' => true,
                ];
            } elseif ($registration->isPaymentRejected()) {
                $buttons = [
                    'verify' => false,
                    'reject' => false,
                    'generate' => false,
                    'view' => false,
                    'regenerate' => false,
                    'reset' => true,
                ];
            }
        } else {
            // Free event logic
            $buttons = [
                'verify' => false,
                'reject' => false,
                'generate' => !$registration->ticket || !$registration->ticket->isActive(),
                'view' => $registration->ticket && $registration->ticket->isActive(),
                'regenerate' => $registration->ticket && $registration->ticket->isActive(),
                'reset' => false,
            ];
        }
        
        return $buttons;
    }

    public function render()
    {
        return view('livewire.organizer-registrations');
    }
}