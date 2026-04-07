<?php
// app/Http/Middleware/EnsureTermsAccepted.php

namespace App\Http\Middleware;

use App\Models\TermsVersion;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTermsAccepted
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $latestTerms = TermsVersion::getActiveVersion();
            
            // If terms exist and user hasn't accepted latest version
            if ($latestTerms && !Auth::user()->hasAcceptedLatestTerms()) {
                // Store intended URL
                session()->put('url.intended', $request->url());
                
                // Redirect to terms page
                return redirect()->route('terms.show');
            }
        }

        return $next($request);
    }
}