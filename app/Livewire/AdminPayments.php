<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Registration;
use App\Models\Event;
use App\Traits\LogsActivity;

class AdminPayments extends Component
{
    use WithPagination, LogsActivity;

    public $paymentSearch = '';
    public $filterPaymentEvent = '';
    public $filterPaymentStatus = '';
    public $filterPaymentEventType = ''; // paid/free filter
    public $paymentsPerPage = 10;
    
    public $showExportPaymentsModal = false;
    public $exportFormat = 'xlsx';
    
    public $availableEvents = [];

    public function mount()
    {
        // Load all paid events for filter dropdown
        $this->availableEvents = Event::where('require_payment', true)
            ->orderBy('title')
            ->get()
            ->mapWithKeys(function ($event) {
                return [$event->id => $event->title];
            })
            ->toArray();
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

        // Log the export activity
        $this->logActivity('EXPORT_PAYMENTS');
        
        // Prepare data for export
        $data = $payments->map(function ($payment) {
            return [
                'Student Name' => $payment->user->first_name . ' ' . $payment->user->last_name,
                'Student ID' => $payment->user->student_id ?? 'N/A',
                'Email' => $payment->user->email,
                'Event' => $payment->event->title,
                'Event Organizer' => $payment->event->creator->first_name . ' ' . $payment->event->creator->last_name ?? 'N/A',
                'Event Date' => $payment->event->start_date ? \Carbon\Carbon::parse($payment->event->start_date)->format('Y-m-d') : 'N/A',
                'Amount' => '₱' . number_format($payment->event->payment_amount, 2),
                'Payment Status' => ucfirst($payment->payment_status),
                'Registered Date' => $payment->registered_at ? \Carbon\Carbon::parse($payment->registered_at)->format('Y-m-d H:i:s') : 'N/A',
                'Payment Verified At' => $payment->payment_verified_at ? \Carbon\Carbon::parse($payment->payment_verified_at)->format('Y-m-d H:i:s') : 'N/A',
                'Payment Verified By' => $payment->paymentVerifier->first_name ?? 'N/A',
            ];
        })->toArray();
        
        return $this->generateExportFile($data, 'all_payments');
    }

    private function getFilteredPaymentsForExport()
    {
        return Registration::with(['user', 'event', 'event.creator', 'ticket', 'paymentVerifier'])
            ->whereHas('event', function($query) {
                $query->where('require_payment', true);
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

    public function getPaymentsProperty()
    {
        return Registration::with(['user', 'event', 'event.creator', 'ticket', 'paymentVerifier'])
            ->whereHas('event', function($query) {
                $query->where('require_payment', true);
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
            ->paginate($this->paymentsPerPage);
    }

    public function resetPaymentFilters()
    {
        $this->reset(['paymentSearch', 'filterPaymentEvent', 'filterPaymentStatus', 'paymentsPerPage']);
        $this->resetPage();
    }

    public function render()
    {
        // Get all paid events for filter dropdown
        $paidEvents = Event::where('require_payment', true)
            ->orderBy('title')
            ->get();

        return view('livewire.admin-payments', [
            'payments' => $this->payments,
            'paidEvents' => $paidEvents,
        ]);
    }
}