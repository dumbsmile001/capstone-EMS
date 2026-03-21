<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfile extends Component
{
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
    
    // Role management (admin only)
    public $roles;
    public $selectedRole;
    public $users;
    public $selectedUserId;
    public $showUserManagement = false;
    
    // UI state
    public $activeTab = 'profile'; // profile, security, admin (for admin users)

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
        
        if ($this->user->isAdmin()) {
            $this->loadUsers();
        }
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

    public function loadUsers()
    {
        $this->users = User::with('roles')->get();
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
            return;
        }

        $targetUser = User::find($userId);
        $targetUser->syncRoles([$this->selectedRole]);
        
        $this->loadUsers();
        session()->flash('admin_message', 'User role updated successfully!');
    }

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::find($userId);
        $this->selectedRole = $user->getRoleNames()->first() ?? 'student';
    }

    public function getUserInitialsAttribute()
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    public function render()
    {
        return view('livewire.user-profile', [
            'userInitials' => $this->getUserInitialsAttribute()
        ])->layout('layouts.app');
    }
}