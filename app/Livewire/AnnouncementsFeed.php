<?php

namespace App\Livewire;

use Livewire\Component;

class AnnouncementsFeed extends Component
{
    public $announcements;
    
    public function mount($announcements)
    {
        $this->announcements = $announcements;
    }
    
    public function render()
    {
        return view('components.announcements-feed');
    }
}