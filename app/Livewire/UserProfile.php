<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class UserProfile extends Component
{
    use WithPagination;
    
    public $user;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $email;
    public $student_id;
    public $grade_level;
    public $year_level;
    public $shs_strand;
    public $college_program;
    
    // Password fields
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    
    // Role management
    public $selectedUserId;
    public $selectedRole;
    public $search = '';
    public $perPage = 10;
    
    // Export
    public $exportFormat = 'xlsx';
    public $showExportModal = false;
    
    // UI state
    public $activeTab = 'profile'; // profile, security, admin

    protected function rules()
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ];
        return $rules;
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $this->first_name = $this->user->first_name;
        $this->middle_name = $this->user->middle_name;
        $this->last_name = $this->user->last_name;
        $this->email = $this->user->email;
        $this->student_id = $this->user->student_id;
        $this->grade_level = $this->user->grade_level;
        $this->year_level = $this->user->year_level;
        $this->shs_strand = $this->user->shs_strand;
        $this->college_program = $this->user->college_program;
    }

    public function updateProfile()
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'student_id' => $this->student_id,
            'grade_level' => $this->grade_level,
            'year_level' => $this->year_level,
            'shs_strand' => $this->shs_strand,
            'college_program' => $this->college_program,
        ]);

        session()->flash('message', 'Profile updated successfully!');
        $this->dispatch('profile-updated');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $this->user->update([
            'password' => Hash::make($this->new_password)
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('password_message', 'Password updated successfully!');
    }

    public function updateUserRole($userId)
    {
        if (!$this->user->isAdmin()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $targetUser = User::find($userId);
        
        if (!$targetUser) {
            session()->flash('error', 'User not found.');
            return;
        }

        // Prevent admin from changing their own role
        if ($targetUser->id === $this->user->id) {
            session()->flash('error', 'You cannot change your own role.');
            return;
        }

        $targetUser->syncRoles([$this->selectedRole]);
        
        session()->flash('success', 'User role updated successfully!');
        $this->selectedUserId = null;
        $this->selectedRole = null;
        
        // Reset pagination to refresh the list
        $this->resetPage();
    }

    public function selectUserForRole($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::find($userId);
        $this->selectedRole = $user->getRoleNames()->first() ?? 'student';
    }

    public function getUserInitialsAttribute()
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    public function getFilteredUsersQuery()
    {
        return User::with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('student_id', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc');
    }

    public function exportUsers()
    {
        if (!$this->user->isAdmin()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $users = $this->getFilteredUsersQuery()->get();
        
        // Close the modal
        $this->showExportModal = false;
        
        // Prepare data for export
        $data = $users->map(function ($user) {
            return [
                'Name' => $user->first_name . ' ' . $user->last_name,
                'Email' => $user->email,
                'Student ID' => $user->student_id ?? 'N/A',
                'Grade Level' => $user->grade_level ? 'Grade ' . $user->grade_level : 'N/A',
                'Year Level' => $user->year_level ? $user->year_level . ' Year' : 'N/A',
                'SHS Strand' => $user->shs_strand ?? 'N/A',
                'College Program' => $user->college_program ?? 'N/A',
                'Role' => $user->getRoleNames()->first() ?? 'N/A',
                'Created At' => $user->created_at->format('Y-m-d H:i:s'),
                'Updated At' => $user->updated_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();
        
        // Generate filename with timestamp
        $filename = 'users_report_' . date('Y-m-d_H-i-s');
        
        // Add filter info to filename if search is applied
        if ($this->search) {
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
                    ->setCreator("User Profile - Admin")
                    ->setTitle("Users Report")
                    ->setSubject("Users Data Export")
                    ->setDescription("Exported users data from user management");
                
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

    public function render()
    {
        // Get all users with their roles for admin view
        $users = null;
        $availableRoles = null;
        
        if ($this->user->isAdmin()) {
            $users = $this->getFilteredUsersQuery()->paginate($this->perPage);
            $availableRoles = Role::pluck('name')->toArray();
        }
        
        return view('livewire.user-profile', [
            'userInitials' => $this->getUserInitialsAttribute(),
            'users' => $users,
            'availableRoles' => $availableRoles,
        ])->layout('layouts.app');
    }
}