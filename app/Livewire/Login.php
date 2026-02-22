<?php

namespace App\Livewire;

use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    use LogsActivity;

    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    // In Login.php login() method
    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }
        $this->logActivity('LOGIN');
        session()->regenerate();

        return redirect()->intended(route('home')); // This now goes to dashboard
    }

    public function render()
    {
        return view('livewire.login');
    }
}

