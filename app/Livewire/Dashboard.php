<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public string $role;

    public function mount()
    {
        $this->role = Auth::user()?->getRoleNames()->first() ?? 'student';
        
        // Redirect to role-specific dashboard
        $redirectRoutes = [
            'admin' => route('dashboard.admin'),
            'organizer' => route('dashboard.organizer'),
            'student' => route('dashboard.student'),
        ];
        
        if (isset($redirectRoutes[$this->role])) {
            return $this->redirect($redirectRoutes[$this->role], navigate: false);
        }
        
        // Default to student dashboard if no role
        return $this->redirect(route('dashboard.student'), navigate: false);
    }

    /** @method static layout(string $name)*/
    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
