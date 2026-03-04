<?php

namespace App\Livewire;

use App\Models\AuditLog;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity; // Add this if you want to log exports

class AuditLogs extends Component
{
    use WithPagination, LogsActivity;
    // Add LogsActivity trait if you want to log exports
    // use LogsActivity;

    public $search = '';
    public $filterAction = '';
    public $filterUser = '';
    public $filterModel = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 15;

    // New export properties
    public $exportFormat = 'xlsx';
    public $showExportModal = false;

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

    // New method to open export modal
    public function openExportModal()
    {
        $this->exportFormat = 'xlsx'; // Reset to default
        $this->showExportModal = true;
    }

    // New method to close export modal
    public function closeExportModal()
    {
        $this->showExportModal = false;
    }

    // New export method
    public function exportAuditLogs()
    {
        $logs = $this->getFilteredLogsQuery()->get();
        $this->logActivity('EXPORT', null,
            auth()->user()->first_name . ' ' . auth()->user()->last_name . ' exported audit logs (' . $logs->count() . ' records)');

        $this->showExportModal = false;
        
        // Prepare data for export
        $data = $logs->map(function ($log) {
            return [
                'ID' => $log->id,
                'Date & Time' => $log->created_at->format('Y-m-d H:i:s'),
                'User' => $log->user ? $log->user->first_name . ' ' . $log->user->last_name . ' (' . $log->user->email . ')' : 'System',
                'Action' => $log->action,
                'Description' => $log->description,
                'Model Type' => $log->model_name ?: '-',
                'Model ID' => $log->model_id ?: '-',
                'IP Address' => $log->ip_address ?: '-',
                'User Agent' => $log->user_agent ?: '-',
                'Old Values' => !empty($log->old_values) ? json_encode($log->old_values) : '-',
                'New Values' => !empty($log->new_values) ? json_encode($log->new_values) : '-',
            ];
        })->toArray();
        
        // Generate filename with timestamp
        $filename = 'audit_logs_' . date('Y-m-d_H-i-s');
        
        // Add filter info to filename if filters are applied
        if ($this->search || $this->filterAction || $this->filterUser || $this->filterModel || $this->dateFrom || $this->dateTo) {
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
                    ->setCreator("Admin Dashboard")
                    ->setTitle("Audit Logs Report")
                    ->setSubject("Audit Logs Data Export")
                    ->setDescription("Exported audit logs data from admin dashboard");
                
                // Add headers with styling
                $headers = !empty($data) ? array_keys($data[0]) : [];
                $column = 'A';
                foreach ($headers as $header) {
                    $sheet->setCellValue($column . '1', $header);
                    // Style the header
                    $sheet->getStyle($column . '1')->getFont()->setBold(true);
                    $sheet->getStyle($column . '1')->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF2563EB'); // Blue color for audit logs
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
                
                // Freeze header row
                $sheet->freezePane('A2');
                
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save('php://output');
            }, $filename, $headers);
        }
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