<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\On;

class EventForm extends Component
{
    public $title;
    public $date;
    public $time;
    public $type;
    public $category;
    public $description;
    public $require_payment = false;

    public function createEvent()
    {
        $data = $this->validate([
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'type' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);
        Event::create($data);
        $this->reset(['title', 'date', 'time', 'type', 'category', 'description', 'require_payment']);

        session()->flash('success', 'Event created successfully');
    }
    public function render()
    {
        return view('livewire.event-form');
    }
}
