<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class GoogleAuthController extends Controller
{
    use LogsActivity;

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user exists
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                // User exists, log them in
                Auth::login($existingUser);
                $this->logActivity('GOOGLE_LOGIN');
                session()->regenerate();
                
                // Check if user needs to accept terms
                if (!$existingUser->hasAcceptedLatestTerms()) {
                    return redirect()->route('terms.accept');
                }
                
                return redirect()->intended(route('home'));
            } else {
                // Store Google user data in session for registration
                session([
                    'google_registration' => true,
                    'google_auth' => [
                        'email' => $googleUser->getEmail(),
                        'first_name' => $googleUser->user['given_name'] ?? '',
                        'last_name' => $googleUser->user['family_name'] ?? '',
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]
                ]);
                
                // Redirect to registration with Google flag
                return redirect()->route('register')->with('google_registration', true);
            }
        } catch (\Exception $e) {
            \Log::error('Google Authentication Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['email' => 'Google authentication failed. Please try again.']);
        }
    }
}