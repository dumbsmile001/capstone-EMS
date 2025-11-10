<?php

namespace App\Livewire;

use Livewire\Component;

class AdminDashboard extends Component{
    /** @method static layout(string $name)*/
    public function render(){
        return view('livewire.admin-dashboard')->layout('layouts.app');
    }
}


