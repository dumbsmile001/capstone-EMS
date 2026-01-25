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
    public ?int $grade_level = null;
    public ?int $year_level = null;
    public ?string $shs_strand = null;
    public ?string $college_program = null;
    public bool $terms = false;

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'student_id' => ['nullable', 'integer', 'unique:users,student_id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            'grade_level' => ['nullable', 'integer', 'min:11', 'max:12'],
            'year_level' => ['nullable', 'integer', 'min:1', 'max:5'],
            'shs_strand' => ['nullable', 'in:ABM,HUMSS,GAS,ICT'],
            'college_program' => ['nullable', 'in:BSIT,BSBA'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : [],
        ];
    }

    // Add validation messages
    protected function messages(): array
    {
        return [
            'shs_strand.in' => 'Please select a valid SHS Strand.',
            'college_program.in' => 'Please select a valid College Program.',
        ];
    }

    public function updated($propertyName)
    {
        // Reset fields when grade_level or year_level changes
        if ($propertyName === 'grade_level') {
            if ($this->grade_level) {
                $this->reset('year_level', 'college_program');
            }
        } elseif ($propertyName === 'year_level') {
            if ($this->year_level) {
                $this->reset('grade_level', 'shs_strand');
            }
        }
        
        $this->validateOnly($propertyName);
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
            'grade_level' => $this->grade_level,
            'year_level' => $this->year_level,
            'shs_strand' => $this->grade_level ? $this->shs_strand : null,
            'college_program' => $this->year_level ? $this->college_program : null,
            'password' => Hash::make($this->password),
        ]);

        // Assign default 'student' role (create if it doesn't exist)
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $user->assignRole($studentRole);

        Auth::login($user);

        session()->regenerate();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.register');
    }
}