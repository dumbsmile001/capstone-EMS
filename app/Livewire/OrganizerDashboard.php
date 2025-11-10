<?php

namespace App\Livewire;

use Livewire\Component;

class OrganizerDashboard extends Component{
    /** @method static layout(string $name)*/
    public function render(){
        return view('livewire.organizer-dashboard')->layout('layouts.app');
    }
}


