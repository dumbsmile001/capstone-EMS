<?php

namespace App\Livewire;

use Livewire\Component;

class EventModal extends Component
{
    public $showModal = false;
    public $mode = 'create';
    public $eventId = null;

    public function openCreate()
    {
        $this->mode = 'create';
        $this->eventId = null;

        $this->dispatch('form-create'); // Tell EventForm to reset into create mode
        $this->showModal = true;
    }

    public function openEdit($id)
    {
        $this->mode = 'edit';
        $this->eventId = $id;

        $this->dispatch('form-edit', eventId: $id); 
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.event-modal');
    }
}
