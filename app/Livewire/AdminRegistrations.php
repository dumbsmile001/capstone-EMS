<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Registration;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;

class AdminRegistrations extends Component
{
    use WithPagination, LogsActivity;

    // Search and filter properties
    public $search = '';
    public $filterEvent = '';
    public $filterPaymentStatus = '';
    public $filterTicketStatus = '';
    public $filterStatus = ''; // For registration status
    public $perPage = 10;
    
    // For payment verification modal
    public $showPaymentModal = false;
    public $showRejectModal = false;
    public $selectedRegistration;
    public $selectedRegistrationId;

    // Available filters
    public $availableEvents = [];
    public $availablePaymentStatuses = ['pending', 'verified', 'rejected'];
    public $availableTicketStatuses = ['active', 'pending_payment', 'used'];
    public $availableRegistrationStatuses = ['registered', 'attended', 'cancelled'];
    
    // For ticket view modal
    public $showTicketModal = false;
    public $selectedTicketRegistration = null;

    public $showExportModal = false;
    public $exportFormat = 'xlsx';

    public function mount()
    {
        // Load all events for the filter dropdown (admin sees all)
        $this->availableEvents = Event::orderBy('title')
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
        // Log the export activity
        $this->logActivity('EXPORT_REGISTRATIONS');

        $this->closeExportModal();
        
        $registrations = $this->getExportData();
        
        $data = $registrations->map(function ($registration) {
            return [
                'Student Name' => $registration->user->first_name . ' ' . $registration->user->last_name,
                'Student ID' => $registration->user->student_id ?? 'N/A',
                'Email' => $registration->user->email,
                'Event' => $registration->event->title,
                'Event Organizer' => $registration->event->creator->first_name . ' ' . $registration->event->creator->last_name ?? 'N/A',
                'Event Start Date' => $registration->event->start_date ? \Carbon\Carbon::parse($registration->event->start_date)->format('Y-m-d') : 'N/A',
                'Event Start Time' => $registration->event->start_time ? \Carbon\Carbon::parse($registration->event->start_time)->format('H:i') : 'N/A',
                'Event End Date' => $registration->event->end_date ? \Carbon\Carbon::parse($registration->event->end_date)->format('Y-m-d') : 'N/A',
                'Event End Time' => $registration->event->end_time ? \Carbon\Carbon::parse($registration->event->end_time)->format('H:i') : 'N/A',
                'Registration Date' => $registration->registered_at ? \Carbon\Carbon::parse($registration->registered_at)->format('Y-m-d H:i:s') : 'N/A',
                'Registration Status' => ucfirst($registration->status ?? 'N/A'),
                'Ticket Status' => $registration->ticket ? $registration->ticket->status : 'No Ticket',
                'Ticket Number' => $registration->ticket->ticket_number ?? 'N/A',
                'Payment Status' => $registration->payment_status ? ucfirst($registration->payment_status) : ($registration->event->require_payment ? 'N/A' : 'Free'),
                'Payment Verified At' => $registration->payment_verified_at ? \Carbon\Carbon::parse($registration->payment_verified_at)->format('Y-m-d H:i:s') : 'N/A',
                'Payment Verified By' => $registration->paymentVerifier->first_name ?? 'N/A',
                'Payment Amount' => $registration->event->require_payment ? '₱' . number_format($registration->event->payment_amount, 2) : 'Free',
            ];
        })->toArray();
        
        return $this->generateExportFile($data, 'all_registrations');
    }

    private function getExportData()
    {
        return Registration::with(['user', 'event', 'event.creator', 'ticket', 'paymentVerifier'])
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
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
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
                    ->setCreator("Admin Dashboard")
                    ->setTitle(ucfirst($reportType) . " Report")
                    ->setSubject(ucfirst($reportType) . " Data Export")
                    ->setDescription("Exported " . $reportType . " data from admin dashboard");
                
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
        return Registration::with(['event', 'event.creator', 'user', 'ticket', 'paymentVerifier'])
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
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('registered_at', 'desc')
            ->paginate($this->perPage);
    }

    // Reset filters
    public function resetFilters()
    {
        $this->reset(['search', 'filterEvent', 'filterPaymentStatus', 'filterTicketStatus', 'filterStatus']);
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
        $this->selectedRegistrationId = $registrationId;
        $this->showPaymentModal = true;
    }

    public function confirmPaymentVerification()
    {
        $registration = Registration::with(['user'])->find($this->selectedRegistrationId);

        $oldValues = ['payment_status' => $registration->payment_status];
        
        $registration->update([
            'payment_status' => 'verified',
            'payment_verified_at' => now(),
            'payment_verified_by' => Auth::id(),
        ]);

        // Log payment verification
        $this->logActivity('VERIFY_PAYMENT', $registration, null, $oldValues, [
            'payment_status' => 'verified',
            'payment_verified_at' => now()->toDateTimeString(),
            'payment_verified_by' => Auth::id()
        ]);

        $this->showPaymentModal = false;
        $this->selectedRegistration = null;
        $this->selectedRegistrationId = null;
        
        session()->flash('success', 'Payment verified successfully for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function rejectPayment($registrationId)
    {
        $this->selectedRegistration = Registration::with(['user', 'event'])->find($registrationId);
        $this->selectedRegistrationId = $registrationId;
        $this->showRejectModal = true;
    }

    public function confirmPaymentRejection()
    {
        $registration = Registration::with(['user', 'ticket'])->find($this->selectedRegistrationId);

        $oldValues = ['payment_status' => $registration->payment_status];
        
        $registration->update([
            'payment_status' => 'rejected',
            'payment_verified_at' => now(),
            'payment_verified_by' => Auth::id(),
        ]);

        // For rejected payments, if ticket exists, keep it but mark appropriately
        if ($registration->ticket && $registration->ticket->isPendingPayment()) {
            $registration->ticket->update([
                'status' => 'pending_payment',
            ]);
        }

        // Log payment rejection
        $this->logActivity('REJECT_PAYMENT', $registration, null, $oldValues, [
            'payment_status' => 'rejected',
            'payment_verified_at' => now()->toDateTimeString(),
            'payment_verified_by' => Auth::id()
        ]);

        $this->showRejectModal = false;
        $this->selectedRegistration = null;
        $this->selectedRegistrationId = null;

        session()->flash('info', 'Payment rejected for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->selectedRegistration = null;
        $this->selectedRegistrationId = null;
    }

    public function resetPaymentStatus($registrationId)
    {
        $registration = Registration::with(['user', 'ticket'])->find($registrationId);
        
        // Check if ticket is used - prevent reset
        if ($registration->ticket && $registration->ticket->isUsed()) {
            session()->flash('error', 'Cannot reset payment status for a registration with a used ticket.');
            return;
        }

        $oldValues = ['payment_status' => $registration->payment_status];
        
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

        // Log payment reset
        $this->logActivity('RESET_PAYMENT', $registration, null, $oldValues, [
            'payment_status' => 'pending'
        ]);

        session()->flash('info', 'Payment status reset to pending for ' . $registration->user->first_name . ' ' . $registration->user->last_name);
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedRegistration = null;
        $this->selectedRegistrationId = null;
    }

    public function generateTicket($registrationId)
    {
        $registration = Registration::with(['user', 'event', 'ticket'])->find($registrationId);
        
        // Check if ticket exists and is used - prevent generation
        if ($registration->ticket && $registration->ticket->isUsed()) {
            session()->flash('error', 'Cannot generate a new ticket for a registration with a used ticket.');
            return;
        }
        
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
                $oldStatus = $registration->ticket->status;
                $registration->regenerateTicket();
                $registration->ticket->update(['status' => 'active']);

                // Log ticket regeneration
                $this->logActivity('REGENERATE_TICKET', $registration, null, 
                    ['ticket_status' => $oldStatus, 'ticket_number' => $registration->ticket->ticket_number],
                    ['ticket_status' => 'active', 'ticket_number' => $registration->ticket->ticket_number]
                );

                session()->flash('success', 'Ticket regenerated for ' . $registration->user->first_name);
            } else {
                // Create new ticket
                $ticket = Ticket::create([
                    'registration_id' => $registration->id,
                    'ticket_number' => Registration::generateTicketNumber(),
                    'status' => 'active',
                    'generated_at' => now(),
                ]);

                // Log ticket generation
                $this->logActivity('GENERATE_TICKET', $registration, null, [], [
                    'ticket_number' => $ticket->ticket_number,
                    'ticket_status' => 'active'
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
        
        // Check if ticket is used - prevent regeneration
        if ($registration->ticket && $registration->ticket->isUsed()) {
            session()->flash('error', 'Cannot regenerate a used ticket.');
            return;
        }
        
        // Check if registration is eligible for ticket regeneration
        if (!$this->isEligibleForTicket($registration)) {
            session()->flash('error', 'Cannot regenerate ticket. Payment not verified or registration incomplete.');
            return;
        }

        if ($registration->ticket) {
            try {
                $oldStatus = $registration->ticket->status;
                $oldNumber = $registration->ticket->ticket_number;
                $registration->regenerateTicket();
                
                // Log ticket regeneration
                $this->logActivity('REGENERATE_TICKET', $registration, null, 
                    ['ticket_status' => $oldStatus, 'ticket_number' => $oldNumber],
                    ['ticket_status' => $registration->ticket->status, 'ticket_number' => $registration->ticket->ticket_number]
                );
                
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
            ->first();

        if ($this->selectedTicketRegistration && $this->selectedTicketRegistration->ticket) {
            $this->showTicketModal = true;
        } else {
            session()->flash('error', 'Ticket not found.');
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
        
        // First, check if ticket exists and is used - this overrides everything
        if ($registration->ticket && $registration->ticket->isUsed()) {
            return [
                'verify' => false,
                'reject' => false,
                'generate' => false,
                'view' => true, // Still allow viewing used tickets
                'regenerate' => false,
                'reset' => false,
            ];
        }
        
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

    public function render()
    {
        return view('livewire.admin-registrations', [
            'registrations' => $this->registrations,
        ]);
    }
}