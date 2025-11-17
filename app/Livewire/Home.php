<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'U', 0, 1) . substr($user->last_name ?? 'S', 0, 1));
        $userRole = $user->getRoleNames()->first() ?? 'User';
        
        return view('livewire.home', [
            'userInitials' => $userInitials,
            'userRole' => ucfirst($userRole),
        ])->layout('layouts.app');
    }
}

