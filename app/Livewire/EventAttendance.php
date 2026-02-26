<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EventAttendance extends Component
{
    use WithPagination;

    public $search = '';
    public $filterEvent = '';
    public $filterPayment = '';
    public $filterDate = '';
    public $perPage = 10;
    public $exportFormat = 'xlsx';
    public $showExportModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterEvent' => ['except' => ''],
        'filterPayment' => ['except' => ''],
        'filterDate' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        if (!auth()->user()->hasRole('organizer')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function openExportModal()
    {
        $this->exportFormat = 'xlsx';
        $this->showExportModal = true;
    }

    public function closeExportModal()
    {
        $this->showExportModal = false;
    }

    public function exportAttendance()
    {
        $attendance = $this->getFilteredAttendanceQuery()->get();

        $this->showExportModal = false;
        
        // Prepare data for export - UPDATED with new date fields
        $data = $attendance->map(function ($ticket) {
            return [
                'Ticket Number' => $ticket->ticket_number,
                'Student Name' => $ticket->registration->user->first_name . ' ' . $ticket->registration->user->last_name,
                'Student ID' => $ticket->registration->user->student_id ?? 'N/A',
                'Email' => $ticket->registration->user->email,
                'Grade Level' => $ticket->registration->user->grade_level ?? 'N/A',
                'Year Level' => $ticket->registration->user->year_level ?? 'N/A',
                'Program/Strand' => $ticket->registration->user->college_program ?? $ticket->registration->user->shs_strand ?? 'N/A',
                'Event Name' => $ticket->registration->event->title,
                'Event Start Date' => $ticket->registration->event->start_date->format('Y-m-d'),
                'Event End Date' => $ticket->registration->event->end_date->format('Y-m-d'),
                'Event Start Time' => \Carbon\Carbon::parse($ticket->registration->event->start_time)->format('g:i A'),
                'Event End Time' => \Carbon\Carbon::parse($ticket->registration->event->end_time)->format('g:i A'),
                'Event Category' => ucfirst($ticket->registration->event->category),
                'Event Type' => ucfirst(str_replace('-', ' ', $ticket->registration->event->type)),
                'Payment Type' => $ticket->registration->event->require_payment ? 'Paid' : 'Free',
                'Amount Paid' => $ticket->registration->event->require_payment ? '₱' . number_format($ticket->registration->event->payment_amount, 2) : 'Free',
                'Payment Status' => ucfirst($ticket->registration->payment_status),
                'Registered At' => $ticket->registration->registered_at ? $ticket->registration->registered_at->format('Y-m-d H:i:s') : 'N/A',
                'Ticket Generated At' => $ticket->generated_at->format('Y-m-d H:i:s'),
                'Attendance Time' => $ticket->used_at->format('Y-m-d H:i:s'),
                'Attendance Status' => 'Present',
            ];
        })->toArray();
        
        // Generate filename with timestamp
        $filename = 'event_attendance_' . date('Y-m-d_H-i-s');
        
        // Add filter info to filename if filters are applied
        if ($this->search || $this->filterEvent || $this->filterDate) {
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
                    ->setCreator("Event Attendance System")
                    ->setTitle("Event Attendance Report")
                    ->setSubject("Event Attendance Data Export")
                    ->setDescription("Exported event attendance data from organizer dashboard");
                
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

    public function getFilteredAttendanceQuery()
    {
        $userId = Auth::id();
        
        return Ticket::where('status', 'used')
            ->whereHas('registration.event', function ($query) use ($userId) {
                $query->where('created_by', $userId);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('ticket_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('registration.user', function ($userQuery) {
                          $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                                   ->orWhere('last_name', 'like', '%' . $this->search . '%')
                                   ->orWhere('email', 'like', '%' . $this->search . '%')
                                   ->orWhere('student_id', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->filterEvent, function ($query) {
                $query->whereHas('registration.event', function ($eventQuery) {
                    $eventQuery->where('id', $this->filterEvent);
                });
            })
            ->when($this->filterPayment !== '', function ($query) {
                $query->whereHas('registration.event', function ($eventQuery) {
                    if ($this->filterPayment === 'paid') {
                        $eventQuery->where('require_payment', true);
                    } elseif ($this->filterPayment === 'free') {
                        $eventQuery->where('require_payment', false);
                    }
                });
            })
            ->when($this->filterDate, function ($query) {
                $query->whereDate('used_at', $this->filterDate);
            })
            ->with([
                'registration.event',
                'registration.user',
                'registration' => function ($query) {
                    $query->with('paymentVerifier');
                }
            ])
            ->orderBy('used_at', 'desc');
    }

    public function getAttendanceProperty()
    {
        return $this->getFilteredAttendanceQuery()->paginate($this->perPage);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterEvent', 'filterPayment', 'filterDate', 'perPage']);
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        // Get events for filter dropdown (only events with attendance)
        $events = \App\Models\Event::where('created_by', Auth::id())
            ->whereHas('registrations.ticket', function ($query) {
                $query->where('status', 'used');
            })
            ->orderBy('title')
            ->get();

        return view('livewire.event-attendance', [
            'userInitials' => $userInitials,
            'attendance' => $this->attendance,
            'events' => $events,
            'totalAttendance' => $this->getFilteredAttendanceQuery()->count(),
        ])->layout('layouts.app');
    }
}