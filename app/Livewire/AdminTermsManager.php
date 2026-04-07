<?php
// app/Livewire/AdminTermsManager.php

namespace App\Livewire;

use App\Models\TermsVersion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminTermsManager extends Component
{
    use WithPagination;

    public $version;
    public $content;
    public $summary;
    public $effective_date;
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'version' => 'required|string|unique:terms_versions,version',
        'content' => 'required|string',
        'summary' => 'nullable|string|max:500',
        'effective_date' => 'required|date',
    ];

    public function save()
    {
        $this->validate();

        TermsVersion::create([
            'version' => $this->version,
            'content' => $this->content,
            'summary' => $this->summary,
            'effective_date' => $this->effective_date,
            'created_by' => Auth::id(),
            'is_active' => true,
        ]);

        // Deactivate older versions
        TermsVersion::where('id', '!=', TermsVersion::latest()->first()->id)
            ->update(['is_active' => false]);

        $this->reset(['version', 'content', 'summary', 'effective_date', 'showForm']);
        session()->flash('message', 'Terms version created successfully!');
    }

    public function activate($id)
    {
        TermsVersion::where('is_active', true)->update(['is_active' => false]);
        TermsVersion::find($id)->update(['is_active' => true]);
        session()->flash('message', 'Terms version activated!');
    }

    public function render()
    {
        return view('livewire.admin-terms-manager', [
            'termsVersions' => TermsVersion::with('creator')->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}