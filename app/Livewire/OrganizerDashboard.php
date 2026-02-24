<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Registration;
use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination; // Add this

class OrganizerDashboard extends Component
{
    use WithFileUploads, WithPagination, LogsActivity;

    // Add these properties for editing
    public $editingEvent = null;
    public $deletingEvent = null;

    // Add computed properties for dynamic card data
    public $eventRegistrationsCount;
    public $ongoingEventsCount;
    public $upcomingEventsCount;
    public $pendingPaymentsCount;

    // Add these properties to the OrganizerDashboard class
    public $paymentSearch = '';
    public $filterPaymentEvent = '';
    public $filterPaymentStatus = '';
    public $paymentsPerPage = 10;
    
    // Add this property to control payments tab
    public $activeTab = 'registrations';

    // Add these properties to the OrganizerDashboard class (around line 40-50)
    public $showExportPaymentsModal = false;
    public $exportFormat = 'xlsx';

    public $registrationsSearch = '';
    public $filterRegistrationsEvent = '';
    public $filterRegistrationsPaymentStatus = '';
    public $filterRegistrationsTicketStatus = '';

    // Add these properties to your OrganizerDashboard class
    public $showEventDetailsModal = false;
    public $showDateEventsModal = false;
    public $selectedEvent = null;

    // Add these properties
    public $showCalendarEventsModal = false;
    public $selectedCalendarDate = null;
    public $selectedCalendarEvents = [];
    public $calendarEventCount = 0;

    // Initialize or update the card data
    public function mount()
    {
        $this->updateCardData();
    }

    public function openExportModal()
    {
        $this->showExportPaymentsModal = true;
    }

    public function closeExportModal()
    {
         $this->showExportPaymentsModal = false;
    }

    public function exportData()
    {
        return $this->exportPayments();
    }

    private function exportPayments()
    {
        // Close the modal
        $this->closeExportModal();
        
        // Get filtered payments data
        $payments = $this->getFilteredPaymentsForExport();

       // Log the export activity before closing modal
        $this->logActivity('EXPORT_PAYMENTS');
        
        // Prepare data for export
        $data = $payments->map(function ($payment) {
            return [
                'Student Name' => $payment->user->first_name . ' ' . $payment->user->last_name,
                'Student ID' => $payment->user->student_id ?? 'N/A',
                'Email' => $payment->user->email,
                'Event' => $payment->event->title,
                'Event Date' => $payment->event->date ? \Carbon\Carbon::parse($payment->event->date)->format('Y-m-d') : 'N/A',
                'Amount' => '₱' . number_format($payment->event->payment_amount, 2),
                'Payment Status' => ucfirst($payment->payment_status),
                'Registered Date' => $payment->registered_at ? \Carbon\Carbon::parse($payment->registered_at)->format('Y-m-d H:i:s') : 'N/A',
                'Payment Verified At' => $payment->payment_verified_at ? \Carbon\Carbon::parse($payment->payment_verified_at)->format('Y-m-d H:i:s') : 'N/A',
                'Payment Verified By' => $payment->payment_verified_by ? ($payment->verifier->name ?? 'Admin') : 'N/A',
            ];
        })->toArray();
        
        return $this->generateExportFile($data, 'payments');
    }

    private function getFilteredPaymentsForExport()
    {
        $userId = Auth::id();
        
        return Registration::with(['user', 'event', 'ticket'])
            ->whereHas('event', function($query) use ($userId) {
                $query->where('created_by', $userId)
                    ->where('require_payment', true);
            })
            ->whereNotNull('payment_status')
            ->where('payment_status', '!=', '')
            ->when($this->paymentSearch, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($userQuery) {
                        $userQuery->where('first_name', 'like', '%' . $this->paymentSearch . '%')
                                ->orWhere('last_name', 'like', '%' . $this->paymentSearch . '%')
                                ->orWhere('email', 'like', '%' . $this->paymentSearch . '%')
                                ->orWhere('student_id', 'like', '%' . $this->paymentSearch . '%');
                    });
                });
            })
            ->when($this->filterPaymentEvent, function ($query) {
                $query->where('event_id', $this->filterPaymentEvent);
            })
            ->when($this->filterPaymentStatus, function ($query) {
                $query->where('payment_status', $this->filterPaymentStatus);
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

    // Method to update all card data
    public function updateCardData()
    {
        $userId = Auth::id();
        $today = now()->format('Y-m-d');
        
        // 1. Total Event Registrations (all registrations for organizer's events)
        $this->eventRegistrationsCount = Registration::whereHas('event', function($query) use ($userId) {
            $query->where('created_by', $userId);
        })->count();

        // 2. Ongoing Events (events happening today)
        $this->ongoingEventsCount = Event::where('created_by', $userId)
            ->where('date', $today)
            ->where('status', 'published')
            ->count();

        // 3. Upcoming Events (events with future dates)
        $this->upcomingEventsCount = Event::where('created_by', $userId)
            ->where('date', '>', $today)
            ->where('status', 'published')
            ->count();

        // 4. Pending Payments - ONLY for paid events
        // Option 1: Using Registration model with event join
        $this->pendingPaymentsCount = Registration::whereHas('event', function($query) use ($userId) {
                $query->where('created_by', $userId)
                    ->where('require_payment', true); // Only count registrations for paid events
            })
            ->where('payment_status', 'pending') // Only count pending payments
            ->count();
    }
     // Update the loadPayments method to be a computed property
    public function getPaymentsProperty()
    {
        $userId = Auth::id();
        
        $paymentsQuery = Registration::with(['user', 'event', 'ticket'])
            ->whereHas('event', function($query) use ($userId) {
                $query->where('created_by', $userId)
                    ->where('require_payment', true);
            })
            ->whereNotNull('payment_status')
            ->where('payment_status', '!=', '');
        
        // Apply search filter
        if ($this->paymentSearch) {
            $paymentsQuery->where(function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('first_name', 'like', '%' . $this->paymentSearch . '%')
                            ->orWhere('last_name', 'like', '%' . $this->paymentSearch . '%')
                            ->orWhere('email', 'like', '%' . $this->paymentSearch . '%')
                            ->orWhere('student_id', 'like', '%' . $this->paymentSearch . '%');
                });
            });
        }
        
        // Apply event filter
        if ($this->filterPaymentEvent) {
            $paymentsQuery->where('event_id', $this->filterPaymentEvent);
        }
        
        // Apply status filter
        if ($this->filterPaymentStatus) {
            $paymentsQuery->where('payment_status', $this->filterPaymentStatus);
        }
        
        return $paymentsQuery
            ->orderBy('registered_at', 'desc')
            ->paginate($this->paymentsPerPage);
    }

   // Add reset filters method for payments
    public function resetPaymentFilters()
    {
        $this->reset(['paymentSearch', 'filterPaymentEvent', 'filterPaymentStatus', 'paymentsPerPage']);
        $this->resetPage();
    }

    // Refresh card data after creating/updating/deleting events
    public function updated($propertyName)
    {
        // If any event-related operation happened, refresh card data
        if (in_array($propertyName, ['showCreateModal', 'showEditModal', 'showDeleteModal'])) {
            $this->updateCardData();
            $this->loadPayments();
        }
    }

    // Add a refresh method that can be called from the frontend
    public function refreshCards()
    {
        $this->updateCardData();
        $this->dispatch('cards-refreshed');
    }
    // Add a refresh method for payments
    public function refreshPayments()
    {
        $this->loadPayments();
        $this->dispatch('payments-refreshed');
    }

    public function viewAllRegistrations()
    {
        $this->dispatch('open-modal', modal: 'view-all-registrations');
    }

    public function getUpcomingEvents()
    {
        $userId = Auth::id();
        
        return Event::where('created_by', $userId)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->where('status', 'published')
            ->where('is_archived', false)
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->limit(5) // You can adjust this limit
            ->get();
    }

    // Add these modal methods
    public function openEventDetailsModal($eventId)
    {
        $this->selectedEvent = Event::where('created_by', Auth::id())
            ->findOrFail($eventId);
        $this->showEventDetailsModal = true;
    }

    public function closeEventDetailsModal()
    {
        $this->showEventDetailsModal = false;
        $this->selectedEvent = null;
    }

    // Add this method to handle the dispatched event
    public function showDateEventsModal($data)
    {
        $this->selectedCalendarDate = Carbon::parse($data['date']);
        $this->selectedCalendarEvents = $data['events'];
        $this->calendarEventCount = $data['eventCount'];
        $this->showCalendarEventsModal = true;
    }

    // Add this method to your OrganizerDashboard class
    public function openEventDetailsFromCalendar($eventId)
    {
        $this->selectedEvent = Event::where('created_by', Auth::id())
            ->findOrFail($eventId);
        $this->showEventDetailsModal = true;
        
        // Also close the calendar events modal when opening event details
        $this->closeCalendarEventsModal();
    }

    public function handleEventClick($eventId)
    {
        $this->dispatch('openEventDetails', eventId: $eventId);
        $this->closeCalendarEventsModal();
    }

    public function closeCalendarEventsModal()
    {
        $this->showCalendarEventsModal = false;
        $this->selectedCalendarDate = null;
        $this->selectedCalendarEvents = [];
        $this->calendarEventCount = 0;
    }

    // Add to your existing listeners array
    protected function getListeners()
    {
        return array_merge(parent::getListeners(), [
            'showDateEventsModal' => 'showDateEventsModal',
            'openEventDetails' => 'openEventDetailsFromCalendar',
        ]);
    }

     public function render()
    {
        $user = Auth::user();
        $userInitials = strtoupper(substr($user->first_name ?? 'O', 0, 1) . substr($user->last_name ?? 'U', 0, 1));
        
        // Fetch events from database
        $events = Event::where('created_by', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->get();

        // Get upcoming events for the organizer
        $upcomingEventsData = $this->getUpcomingEvents();

        // Get events for payment filter dropdown (only paid events)
        $paidEvents = Event::where('created_by', Auth::id())
            ->where('require_payment', true)
            ->orderBy('title')
            ->get();
        
        return view('livewire.organizer-dashboard', [
            'userInitials' => $userInitials,
            'events' => $events,
            'paidEvents' => $paidEvents, // Add this for payment filter
            'upcomingEventsData' => $upcomingEventsData, // Add this
            'eventRegistrationsCount' => $this->eventRegistrationsCount,
            'ongoingEventsCount' => $this->ongoingEventsCount,
            'upcomingEventsCount' => $this->upcomingEventsCount,
            'pendingPaymentsCount' => $this->pendingPaymentsCount,
            'payments' => $this->payments, // This will use the computed property
        ])->layout('layouts.app');
    }
}