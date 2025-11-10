<?php

namespace App\Livewire;

use Livewire\Component;

class StudentDashboard extends Component{
    /** @method static layout(string $name)*/
    public function render(){
        return view('livewire.student-dashboard')->layout('layouts.app');
    }
}


