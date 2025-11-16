<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public string $role;

    public function mount()
    {
        $this->role = Auth::user()?->getRoleNames()->first() ?? 'guest';
        // No auto-redirect - let users see the main dashboard and choose
    }

    /** @method static layout(string $name)*/
    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
