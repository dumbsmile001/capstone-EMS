<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public function mount()
    {
        // Redirect to appropriate dashboard based on role
        $user = Auth::user();
        $role = $user->getRoleNames()->first() ?? 'student';
        
        switch($role) {
            case 'admin':
                return redirect()->route('dashboard.admin');
            case 'organizer':
                return redirect()->route('dashboard.organizer');
            case 'student':
            default:
                return redirect()->route('dashboard.student');
        }
    }
    
    public function render()
    {
        // This will rarely be seen as we redirect immediately
        return view('livewire.home')->layout('layouts.app');
    }
}