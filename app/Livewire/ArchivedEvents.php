<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ArchivedEvents extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';
    public $filterType = '';
    public $filterPayment = '';
    public $eventsPerPage = 10;
    public $exportFormat = 'xlsx'; // Add export format property
    public $showExportModal = false;

    // Confirmation modal properties
    public $showRestoreConfirmation = false;
    public $showDeleteConfirmation = false;
    public $selectedEventId = null;
    public $selectedEventTitle = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterPayment' => ['except' => ''],
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
            $this->showRestoreConfirmation = true;
        }
    }

    public function confirmDelete($eventId)
    {
        $event = Event::find($eventId);
        if ($event) {
            $this->selectedEventId = $eventId;
            $this->selectedEventTitle = $event->title;
            $this->showDeleteConfirmation = true;
        }
    }

    public function confirmAction()
    {
        if ($this->showRestoreConfirmation) {
            $this->unarchiveEvent($this->selectedEventId);
            $this->showRestoreConfirmation = false;
        } elseif ($this->showDeleteConfirmation) {
            $this->deleteArchivedEvent($this->selectedEventId);
            $this->showDeleteConfirmation = false;
        }
        
        $this->selectedEventId = null;
        $this->selectedEventTitle = '';
    }

    public function unarchiveEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if ($event->created_by !== Auth::id()) {
            session()->flash('error', 'You are not authorized to unarchive this event.');
            return;
        }

        $event->unarchive();
        session()->flash('success', 'Event unarchived successfully!');
    }

    public function deleteArchivedEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if ($event->created_by !== Auth::id()) {
            session()->flash('error', 'You are not authorized to delete this event.');
            return;
        }

        $event->delete();
        session()->flash('success', 'Event deleted permanently!');
    }

    // Add export method for archived events
    public function exportArchivedEvents()
    {
        $events = $this->getFilteredEventsQuery()->get();

        $this->showExportModal = false;
        
        // Prepare data for export
        $data = $events->map(function ($event) {
            return [
                'Event Name' => $event->title,
                'Description' => $event->description,
                'Date' => $event->date->format('Y-m-d'),
                'Time' => \Carbon\Carbon::parse($event->time)->format('g:i A'),
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
                        ->getStartColor()->setARGB('FFE0E0E0');
                    $column++;
                }
                
                // Add data
                $row = 2;
                foreach ($data as $item) {
                    $column = 'A';
                    foreach ($item as $value) {
                        $sheet->setCellValue($column . $row, $value);
                        $column++;
                    }
                    $row++;
                }
                
                // Auto-size columns
                $lastColumn = $sheet->getHighestColumn();
                for ($col = 'A'; $col <= $lastColumn; $col++) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
                
                // Add some styling
                $sheet->getStyle('A1:' . $lastColumn . '1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                
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

    // Add a method to get the query for export (without pagination)
    public function getFilteredEventsQuery()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
            ->where('is_archived', true)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
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
            ->orderBy('archived_at', 'desc');
    }

    public function getEventsProperty()
    {
        return $this->getFilteredEventsQuery()->paginate($this->eventsPerPage);
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        return view('livewire.archived-events', [
            'userInitials' => $userInitials,
            'events' => $this->events,
        ])->layout('layouts.app');
    }
}