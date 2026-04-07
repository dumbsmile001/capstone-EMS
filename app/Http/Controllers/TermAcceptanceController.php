<?php
// app/Http/Controllers/TermAcceptanceController.php

namespace App\Http\Controllers;

use App\Models\TermAgreement;
use App\Models\TermsVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermAcceptanceController extends Controller
{
    public function accept(Request $request)
    {
        $request->validate([
            'terms_version_id' => 'required|exists:terms_versions,id',
        ]);

        $user = Auth::user();
        $termsVersion = TermsVersion::findOrFail($request->terms_version_id);

        // Check if already accepted this version
        if ($user->termAgreements()->where('terms_version_id', $termsVersion->id)->exists()) {
            return redirect()->route('terms.show')->with('info', 'You have already accepted these terms.');
        }

        // Record acceptance
        TermAgreement::create([
            'user_id' => $user->id,
            'terms_version_id' => $termsVersion->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Redirect back to intended page or dashboard
        $intended = session()->pull('url.intended', route('home'));
        
        return redirect($intended)->with('success', 'Thank you for accepting the Terms and Conditions.');
    }
}