<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;
use Carbon\Carbon;

class ArchivedEvents extends Component
{
    use WithPagination, LogsActivity;

    public $search = '';
    public $filterCategory = '';
    public $filterType = '';
    public $filterPayment = '';
    public $eventsPerPage = 10;
    public $exportFormat = 'xlsx';
    public $showExportModal = false;
    
    // New properties for sorting
    public $sortField = 'archived_at';
    public $sortDirection = 'desc';
    
    // Confirmation modal properties
    public $showRestoreConfirmation = false;
    public $showDeleteConfirmation = false;
    public $selectedEventId = null;
    public $selectedEventTitle = '';
    public $currentAction = null;
    public $currentEventId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterPayment' => ['except' => ''],
        'sortField' => ['except' => 'archived_at'],
        'sortDirection' => ['except' => 'desc'],
        'eventsPerPage' => ['except' => 10],
    ];

    public function mount()
    {
        if (!auth()->user()->hasRole('organizer')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function confirmRestore($eventId)
    {
        $event = Event::find($eventId);
        if ($event) {
            $this->selectedEventId = $eventId;
            $this->selectedEventTitle = $event->title;
            $this->currentAction = 'restore';
            $this->currentEventId = $eventId;
            $this->showRestoreConfirmation = true;
        }
    }

    public function confirmDelete($eventId)
    {
        $event = Event::find($eventId);
        if ($event) {
            $this->selectedEventId = $eventId;
            $this->selectedEventTitle = $event->title;
            $this->currentAction = 'delete_permanent';
            $this->currentEventId = $eventId;
            $this->showDeleteConfirmation = true;
        }
    }

    public function confirmAction()
    {
        if ($this->currentAction === 'restore' && $this->selectedEventId) {
            $this->unarchiveEvent($this->selectedEventId);
            
            // Log the restore action
            $event = Event::find($this->selectedEventId);
            if ($event) {
                $this->logActivity('RESTORE', $event,
                    auth()->user()->first_name . ' ' . auth()->user()->last_name . ' restored event: ' . $event->title);
            }
        } elseif ($this->currentAction === 'delete_permanent' && $this->selectedEventId) {
            $event = Event::find($this->selectedEventId);
            if ($event) {
                $eventTitle = $event->title;
                
                // Log permanent deletion
                $this->logActivity('DELETE_PERMANENT', $event,
                    auth()->user()->first_name . ' ' . auth()->user()->last_name . ' permanently deleted archived event: ' . $eventTitle);
                
                $event->delete();
                session()->flash('success', 'Event "' . $eventTitle . '" deleted permanently!');
            }
        }
        
        // Reset the action trackers
        $this->currentAction = null;
        $this->currentEventId = null;
        $this->selectedEventId = null;
        $this->selectedEventTitle = '';
        $this->showRestoreConfirmation = false;
        $this->showDeleteConfirmation = false;
    }

    public function unarchiveEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if ($event->created_by !== Auth::id()) {
            session()->flash('error', 'You are not authorized to unarchive this event.');
            return;
        }

        if ($event->unarchive()) {
            // Log the restore activity
            $this->logActivity('RESTORE', $event);
            session()->flash('success', 'Event "' . $event->title . '" restored successfully!');
        } else {
            session()->flash('error', 'Failed to restore event.');
        }
    }

    public function deleteArchivedEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if ($event->created_by !== Auth::id()) {
            session()->flash('error', 'You are not authorized to delete this event.');
            return;
        }
        
        $eventTitle = $event->title;
        $event->delete();
        
        // Log permanent deletion
        $this->logActivity('DELETE_PERMANENT', $eventTitle);

        session()->flash('success', 'Event "' . $eventTitle . '" deleted permanently!');
    }

    public function exportArchivedEvents()
    {
        $events = $this->getFilteredEventsQuery()->get();

        // Log the export action
        $this->logActivity('EXPORT_ARCHIVED', null,
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' exported archived events (' . $events->count() . ' records)');

        $this->showExportModal = false;
        
        // Prepare data for export
        $data = $events->map(function ($event) {
            return [
                'Event Name' => $event->title,
                'Description' => $event->description,
                'Start Date' => $event->start_date->format('Y-m-d'),
                'Start Time' => \Carbon\Carbon::parse($event->start_time)->format('g:i A'),
                'End Date' => $event->end_date->format('Y-m-d'),
                'End Time' => \Carbon\Carbon::parse($event->end_time)->format('g:i A'),
                'Category' => ucfirst($event->category),
                'Type' => ucfirst(str_replace('-', ' ', $event->type)),
                'Payment Type' => $event->require_payment ? 'Paid' : 'Free',
                'Amount' => $event->require_payment ? '₱' . number_format($event->payment_amount, 2) : 'Free',
                'Registrations' => $event->registrations_count,
                'Archived Date' => $event->archived_at->format('Y-m-d'),
                'Archived Time' => $event->archived_at->format('g:i A'),
                'Status' => 'Archived',
            ];
        })->toArray();
        
        // Generate filename with timestamp
        $filename = 'archived_events_' . date('Y-m-d_H-i-s');
        
        // Add filter info to filename if filters are applied
        if ($this->search || $this->filterCategory || $this->filterType || $this->filterPayment) {
            $filename .= '_filtered';
        }
        
        if ($this->exportFormat === 'csv') {
            // Export as CSV
            $filename .= '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            return response()->streamDownload(function () use ($data) {
                $output = fopen('php://output', 'w');
                
                // Add UTF-8 BOM for Excel compatibility
                fwrite($output, "\xEF\xBB\xBF");
                
                // Add CSV headers if we have data
                if (!empty($data)) {
                    fputcsv($output, array_keys($data[0]));
                }
                
                // Add data rows
                foreach ($data as $row) {
                    fputcsv($output, $row);
                }
                
                fclose($output);
            }, $filename, $headers);
        } else {
            // Export as Excel using PhpSpreadsheet
            $filename .= '.xlsx';
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            return response()->streamDownload(function () use ($data) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                
                // Set document properties
                $spreadsheet->getProperties()
                    ->setCreator("Archived Events System")
                    ->setTitle("Archived Events Report")
                    ->setSubject("Archived Events Data Export")
                    ->setDescription("Exported archived events data from organizer dashboard");
                
                // Add headers with styling
                $headers = !empty($data) ? array_keys($data[0]) : [];
                $column = 'A';
                foreach ($headers as $header) {
                    $sheet->setCellValue($column . '1', $header);
                    // Style the header
                    $sheet->getStyle($column . '1')->getFont()->setBold(true);
                    $sheet->getStyle($column . '1')->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF1E40AF'); // Blue color
                    $sheet->getStyle($column . '1')->getFont()->getColor()->setARGB('FFFFFFFF'); // White text
                    $column++;
                }
                
                // Add data
                $row = 2;
                foreach ($data as $index => $item) {
                    $column = 'A';
                    foreach ($item as $value) {
                        $sheet->setCellValue($column . $row, $value);
                        $column++;
                    }
                    
                    // Alternate row colors
                    if ($index % 2 === 0) {
                        $sheet->getStyle('A' . $row . ':' . $column . $row)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFF0F9FF'); // Light blue
                    }
                    $row++;
                }
                
                // Auto-size columns
                $lastColumn = $sheet->getHighestColumn();
                for ($col = 'A'; $col <= $lastColumn; $col++) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
                
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save('php://output');
            }, $filename, $headers);
        }
    }

    public function openExportModal()
    {
        $this->exportFormat = 'xlsx'; // Reset to default
        $this->showExportModal = true;
    }

    public function closeExportModal()
    {
        $this->showExportModal = false;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterCategory', 'filterType', 'filterPayment', 'sortField', 'sortDirection']);
        $this->sortField = 'archived_at';
        $this->sortDirection = 'desc';
    }

    public function getFilteredEventsQuery()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
            ->where('is_archived', true)
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category', $this->filterCategory);
            })
            ->when($this->filterPayment !== '', function ($query) {
                if ($this->filterPayment === 'paid') {
                    $query->where('require_payment', true);
                } elseif ($this->filterPayment === 'free') {
                    $query->where('require_payment', false);
                }
            })
            ->withCount('registrations')
            ->with('creator')
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function getEventsProperty()
    {
        return $this->getFilteredEventsQuery()->paginate($this->eventsPerPage);
    }

    // New computed properties for stats
    public function getThisMonthCountProperty()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
            ->where('is_archived', true)
            ->whereMonth('archived_at', Carbon::now()->month)
            ->whereYear('archived_at', Carbon::now()->year)
            ->count();
    }

    public function getTotalRegistrationsProperty()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
            ->where('is_archived', true)
            ->withCount('registrations')
            ->get()
            ->sum('registrations_count');
    }

    public function getPaidEventsCountProperty()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
            ->where('is_archived', true)
            ->where('require_payment', true)
            ->count();
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.archived-events', [
            'userInitials' => $userInitials,
            'events' => $this->events,
            'thisMonthCount' => $this->thisMonthCount,
            'totalRegistrations' => $this->totalRegistrations,
            'paidEventsCount' => $this->paidEventsCount,
        ])->layout('layouts.app');
    }
}