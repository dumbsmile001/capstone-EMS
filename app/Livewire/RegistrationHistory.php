<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class RegistrationHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';
    public $filterStatus = ''; // Added status filter
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterCategory', 'filterStatus', 'perPage']);
        $this->resetPage();
    }

    public function getAvailableCategoriesProperty()
    {
        return Auth::user()->registrations()
            ->with('event')
            ->get()
            ->pluck('event.category')
            ->unique()
            ->mapWithKeys(function ($category) {
                return [$category => ucfirst($category)];
            })
            ->toArray();
    }

    public function render()
    {
        $registrations = Auth::user()->registrations()
            ->with('event')
            ->when($this->search, function ($query) {
                $query->whereHas('event', function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterCategory, function ($query) {
                $query->whereHas('event', function ($q) {
                    $q->where('category', $this->filterCategory);
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('registered_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.registration-history', [
            'registrations' => $registrations,
            'availableCategories' => $this->availableCategories,
        ]);
    }
}