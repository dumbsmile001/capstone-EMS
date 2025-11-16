<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class Register extends Component
{
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $student_id = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'integer', 'unique:users,student_id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : [],
        ];
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'student_id' => $this->student_id,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Assign default 'student' role (create if it doesn't exist)
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $user->assignRole($studentRole);

        Auth::login($user);

        session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.register');
    }
}

