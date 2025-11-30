<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RegistrationHistory extends Component
{
    public $registrations;

    public function mount()
    {
        $this->loadRegistrations();
    }

    public function loadRegistrations()
    {
        $this->registrations = Auth::user()->registrations()
            ->with('event')
            ->orderBy('registered_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.registration-history');
    }
}