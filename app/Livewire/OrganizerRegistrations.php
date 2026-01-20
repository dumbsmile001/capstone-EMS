<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Registration;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class OrganizerRegistrations extends Component
{
    use WithPagination;
    public $events;

    // Search and filter properties
    public $search = '';
    public $filterEvent = '';
    public $filterPaymentStatus = '';
    public $filterTicketStatus = '';
    public $perPage = 10;
    
    // For payment verification modal
    public $showPaymentModal = false;
    public $selectedRegistration;
    public $verificationNotes = '';

     // Available filters
    public $availableEvents = [];
    public $availablePaymentStatuses = ['pending', 'verified', 'rejected'];
    public $availableTicketStatuses = ['active', 'pending_payment', 'used'];
    
    // For ticket view modal
    public $showTicketModal = false;
    public $selectedTicketRegistration = null;

    public $showExportModal = false;
    public $exportFormat = 'xlsx';

    public function mount()
    {
        // Load available events for the filter dropdown
        $this->availableEvents = Event::where('created_by', auth()->id())
            ->orderBy('title')
            ->get()
            ->mapWithKeys(function ($event) {
                return [$event->id => $event->title];
            })
            ->toArray();
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

    public function exportRegistrations()
    {
        $this->closeExportModal();
        
        $registrations = $this->getExportData();
        
        $data = $registrations->map(function ($registration) {
            return [
                'Student Name' => $registration->user->first_name . ' ' . $registration->user->last_name,
                'Student ID' => $registration->user->student_id ?? 'N/A',
                'Email' => $registration->user->email,
                'Event' => $registration->event->title,
                'Event Date' => $registration->event->date ? \Carbon\Carbon::parse($registration->event->date)->format('Y-m-d') : 'N/A',
                'Event Time' => $registration->event->time ? \Carbon\Carbon::parse($registration->event->time)->format('H:i') : 'N/A',
                'Registration Date' => $registration->registered_at ? \Carbon\Carbon::parse($registration->registered_at)->format('Y-m-d H:i:s') : 'N/A',
                'Registration Status' => ucfirst($registration->status ?? 'N/A'),
                'Ticket Status' => $registration->ticket ? $registration->ticket->status : 'No Ticket',
                'Ticket Number' => $registration->ticket->ticket_number ?? 'N/A',
                'Payment Status' => $registration->payment_status ? ucfirst($registration->payment_status) : ($registration->event->require_payment ? 'N/A' : 'Free'),
                'Payment Verified At' => $registration->payment_verified_at ? \Carbon\Carbon::parse($registration->payment_verified_at)->format('Y-m-d H:i:s') : 'N/A',
                'Payment Amount' => $registration->event->require_payment ? '₱' . number_format($registration->event->payment_amount, 2) : 'Free',
            ];
        })->toArray();
        
        return $this->generateExportFile($data, 'event_registrations');
    }

    private function getExportData()
    {
        return Registration::with(['user', 'event', 'ticket'])
            ->whereHas('event', function($query) {
                $query->where('created_by', auth()->id());
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($userQuery) {
                        $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%')
                                ->orWhere('student_id', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->filterEvent, function ($query) {
                $query->where('event_id', $this->filterEvent);
            })
            ->when($this->filterPaymentStatus, function ($query) {
                $query->where('payment_status', $this->filterPaymentStatus);
            })
            ->when($this->filterTicketStatus, function ($query) {
                $query->whereHas('ticket', function ($ticketQuery) {
                    $ticketQuery->where('status', $this->filterTicketStatus);
                });
            })
            ->orderBy('registered_at', 'desc')
            ->get();
    }

    private function generateExportFile($data, $reportType)
    {
        // Generate filename with timestamp
        $filename = $reportType . '_report_' . date('Y-m-d_H-i-s');
        
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
            
            return response()->streamDownload(function () use ($data, $reportType) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                
                // Set document properties
                $spreadsheet->getProperties()
                    ->setCreator("Organizer Dashboard")
                    ->setTitle(ucfirst($reportType) . " Report")
                    ->setSubject(ucfirst($reportType) . " Data Export")
                    ->setDescription("Exported " . $reportType . " data from organizer dashboard");
                
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

    // Computed property for registrations with search and filters
    public function getRegistrationsProperty()
    {
        return Registration::with(['event', 'user', 'ticket'])
            ->whereHas('event', function($query) {
                $query->where('created_by', auth()->id());
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($userQuery) {
                        $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                                  ->orWhere('email', 'like', '%' . $this->search . '%')
                                  ->orWhere('student_id', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->filterEvent, function ($query) {
                $query->where('event_id', $this->filterEvent);
            })
            ->when($this->filterPaymentStatus, function ($query) {
                $query->where('payment_status', $this->filterPaymentStatus);
            })
            ->when($this->filterTicketStatus, function ($query) {
                $query->whereHas('ticket', function ($ticketQuery) {
                    $ticketQuery->where('status', $this->filterTicketStatus);
                });
            })
            ->orderBy('registered_at', 'desc')
            ->paginate($this->perPage);
    }

    // Reset filters
    public function resetFilters()
    {
        $this->reset(['search', 'filterEvent', 'filterPaymentStatus', 'filterTicketStatus']);
        $this->gotoPage(1);
    }

    // Apply filters
    public function applyFilters()
    {
        $this->resetPage();
    }

    public function verifyPayment($registrationId)
    {
        $this->selectedRegistration = Registration::with(['user', 'event'])->find($registrationId);
        $this->verificationNotes = '';
        $this->showPaymentModal = true;
    }

    public function confirmPaymentVerification()
    {
        $this->validate([
            'verificationNotes' => 'nullable|string|max:500',
        ]);

        $this->selectedRegistration->update([
            'payment_status' => 'verified',
            'payment_verified_at' => now(),
            'payment_verified_by' => Auth::id(),
        ]);

        $this->showPaymentModal = false;
        session()->flash('success', 'Payment verified successfully for ' . $this->selectedRegistration->user->first_name . ' ' . $this->selectedRegistration->user->last_name);
    }

    public function rejectPayment($registrationId)
    {
        $registration = Registration::with(['user'])->find($registrationId);
        
        $registration->update([
            'payment_status' => 'rejected',
            'payment_verified_at' => now(),
            'payment_verified_by' => Auth::id(),
        ]);

        // For rejected payments, if ticket exists, keep it but mark appropriately
        if ($registration->ticket && $registration->ticket->isPendingPayment()) {
            $registration->ticket->update([
                'status' => 'pending_payment', // Keep as pending_payment for rejected payments
            ]);
        }

        session()->flash('info', 'Payment rejected for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function resetPaymentStatus($registrationId)
    {
        $registration = Registration::with(['user', 'ticket'])->find($registrationId);
        
        $registration->update([
            'payment_status' => 'pending',
            'payment_verified_at' => null,
            'payment_verified_by' => null,
        ]);

        // If ticket exists for paid event, reset to pending_payment
        if ($registration->ticket && $registration->event->require_payment) {
            $registration->ticket->update([
                'status' => 'pending_payment',
            ]);
        }

        // No need to manually load registrations
        session()->flash('info', 'Payment status reset to pending for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedRegistration = null;
        $this->verificationNotes = '';
    }

    public function generateTicket($registrationId)
    {
        $registration = Registration::with(['user', 'event', 'ticket'])->find($registrationId);
        
        // Check if registration is eligible for ticket generation
        if (!$this->isEligibleForTicket($registration)) {
            session()->flash('error', 'Cannot generate ticket. Payment not verified or registration incomplete.');
            return;
        }

        // Check if ticket already exists and is active
        if ($registration->ticket && $registration->ticket->isActive()) {
            session()->flash('info', 'Ticket already exists and is active');
            return;
        }

        try {
            // If ticket exists but not active, regenerate it
            if ($registration->ticket) {
                $registration->regenerateTicket();
                $registration->ticket->update(['status' => 'active']);
                session()->flash('success', 'Ticket regenerated for ' . $registration->user->first_name);
            } else {
                // Create new ticket
                Ticket::create([
                    'registration_id' => $registration->id,
                    'ticket_number' => Registration::generateTicketNumber(),
                    'status' => 'active',
                    'generated_at' => now(),
                ]);
                session()->flash('success', 'Ticket generated for ' . $registration->user->first_name);
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate ticket: ' . $e->getMessage());
        }
    }

    public function regenerateTicket($registrationId)
    {
        $registration = Registration::with(['user', 'event', 'ticket'])->find($registrationId);
        
        // Check if registration is eligible for ticket regeneration
        if (!$this->isEligibleForTicket($registration)) {
            session()->flash('error', 'Cannot regenerate ticket. Payment not verified or registration incomplete.');
            return;
        }

        if ($registration->ticket) {
            try {
                $registration->regenerateTicket();
                session()->flash('success', 'Ticket regenerated for ' . $registration->user->first_name);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to regenerate ticket: ' . $e->getMessage());
            }
        } else {
            session()->flash('error', 'No ticket found to regenerate');
        }
    }

    public function viewTicket($registrationId)
    {
        $this->selectedTicketRegistration = Registration::with(['event', 'user', 'ticket'])
            ->where('id', $registrationId)
            ->whereHas('event', function($query) {
                $query->where('created_by', Auth::id());
            })
            ->first();

        if ($this->selectedTicketRegistration && $this->selectedTicketRegistration->ticket) {
            $this->showTicketModal = true;
        } else {
            session()->flash('error', 'Ticket not found or you do not have permission to view it.');
        }
    }

    public function closeTicketModal()
    {
        $this->showTicketModal = false;
        $this->selectedTicketRegistration = null;
    }

    // Helper method to check if registration is eligible for ticket
    private function isEligibleForTicket($registration)
    {
        // For free events, always eligible
        if (!$registration->event->require_payment) {
            return true;
        }
        
        // For paid events, only eligible if payment is verified
        return $registration->isPaymentVerified();
    }

    // Helper method to determine what buttons to show
    public function getActionButtons($registration)
    {
        $buttons = [];
        
        if ($registration->event->require_payment) {
            // Paid event logic
            if ($registration->isPaymentPending()) {
                $buttons = [
                    'verify' => true,
                    'reject' => true,
                    'generate' => false,
                    'view' => false,
                    'regenerate' => false,
                    'reset' => false,
                ];
            } elseif ($registration->isPaymentVerified()) {
                $buttons = [
                    'verify' => false,
                    'reject' => false,
                    'generate' => !$registration->ticket || !$registration->ticket->isActive(),
                    'view' => $registration->ticket && $registration->ticket->isActive(),
                    'regenerate' => $registration->ticket && $registration->ticket->isActive(),
                    'reset' => true,
                ];
            } elseif ($registration->isPaymentRejected()) {
                $buttons = [
                    'verify' => false,
                    'reject' => false,
                    'generate' => false,
                    'view' => false,
                    'regenerate' => false,
                    'reset' => true,
                ];
            }
        } else {
            // Free event logic
            $buttons = [
                'verify' => false,
                'reject' => false,
                'generate' => !$registration->ticket || !$registration->ticket->isActive(),
                'view' => $registration->ticket && $registration->ticket->isActive(),
                'regenerate' => $registration->ticket && $registration->ticket->isActive(),
                'reset' => false,
            ];
        }
        
        return $buttons;
    }

    public function downloadTicketAsPdf($registrationId)
    {
        $registration = Registration::with(['event', 'ticket'])
            ->where('id', $registrationId)
            ->whereHas('event', function($query) {
                $query->where('created_by', Auth::id());
            })
            ->first();

        if ($registration && $registration->ticket && $registration->ticket->isActive()) {
            // Redirect to the download route
            return $this->redirect(route('ticket.download', $registration->ticket->id), navigate: false);
        } else {
            session()->flash('error', 'Ticket not found, inactive, or you do not have permission to download it.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.organizer-registrations', [
            'registrations' => $this->registrations,
        ]);
    }
}