<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Registration;
use App\Models\Event;
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
        $this->registrations = Registration::with(['event', 'user', 'paymentVerifier'])
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

        $this->loadRegistrations();
        session()->flash('info', 'Payment rejected for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function resetPaymentStatus($registrationId)
    {
        $registration = Registration::with(['user'])->find($registrationId);
        
        $registration->update([
            'payment_status' => 'pending',
            'payment_verified_at' => null,
            'payment_verified_by' => null,
        ]);

        $this->loadRegistrations();
        session()->flash('info', 'Payment status reset to pending for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedRegistration = null;
        $this->verificationNotes = '';
    }

    public function getPaymentStatus($registration)
    {
        if (!$registration->event->require_payment) {
            return 'Free';
        }
        
        return ucfirst($registration->payment_status);
    }

    public function render()
    {
        return view('livewire.organizer-registrations');
    }
}