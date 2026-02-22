<?php

namespace App\Livewire;

use App\Models\AuditLog;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AuditLogs extends Component
{
    use WithPagination;

    public $search = '';
    public $filterAction = '';
    public $filterUser = '';
    public $filterModel = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 15;

    protected $paginationTheme = 'bootstrap';

    // Modal properties
    public $showLogDetailsModal = false;
    public $selectedLog = null;

    public function mount()
    {
        // Check if user has permission to view audit logs
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function getLogsProperty()
    {
        return $this->getFilteredLogsQuery()->paginate($this->perPage);
    }

    public function getFilteredLogsQuery()
    {
        return AuditLog::with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                      ->orWhere('action', 'like', '%' . $this->search . '%')
                      ->orWhere('model_type', 'like', '%' . $this->search . '%')
                      ->orWhere('ip_address', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterAction, function ($query) {
                $query->where('action', $this->filterAction);
            })
            ->when($this->filterUser, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->filterUser . '%')
                      ->orWhere('last_name', 'like', '%' . $this->filterUser . '%')
                      ->orWhere('email', 'like', '%' . $this->filterUser . '%');
                });
            })
            ->when($this->filterModel, function ($query) {
                $query->where('model_type', 'like', '%' . $this->filterModel . '%');
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->orderBy('created_at', 'desc');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterAction', 'filterUser', 'filterModel', 'dateFrom', 'dateTo']);
        $this->gotoPage(1);
    }

    public function openLogDetailsModal($logId)
    {
        $this->selectedLog = AuditLog::with('user')->findOrFail($logId);
        $this->showLogDetailsModal = true;
    }

    public function closeLogDetailsModal()
    {
        $this->showLogDetailsModal = false;
        $this->selectedLog = null;
    }

    public function getAvailableActions()
    {
        return AuditLog::distinct('action')->pluck('action');
    }

    public function getModelTypes()
    {
        return AuditLog::whereNotNull('model_type')
            ->distinct('model_type')
            ->pluck('model_type')
            ->map(function ($type) {
                return class_basename($type);
            });
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'U', 0, 1));

        return view('livewire.audit-logs', [
            'userInitials' => $userInitials,
            'logs' => $this->logs,
            'availableActions' => $this->getAvailableActions(),
            'modelTypes' => $this->getModelTypes(),
        ])->layout('layouts.app');
    }
}