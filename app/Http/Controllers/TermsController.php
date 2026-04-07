<?php
// app/Http/Controllers/TermsController.php

namespace App\Http\Controllers;

use App\Models\TermsVersion;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function show()
    {
        $terms = TermsVersion::getActiveVersion();
        
        if (!$terms) {
            // Fallback to default terms if none exist in database
            $defaultTerms = $this->getDefaultTerms();
            return view('terms.show', ['terms' => null, 'defaultTerms' => $defaultTerms]);
        }
        
        return view('terms.show', compact('terms'));
    }

    private function getDefaultTerms()
    {
        return <<<'HTML'
        <h2>Terms and Conditions</h2>
        
        <h3>1. Acceptance of Terms</h3>
        <p>By registering for and using the SPCC Events Management System, you agree to be bound by these Terms and Conditions.</p>
        
        <h3>2. User Accounts</h3>
        <p>You are responsible for maintaining the confidentiality of your account credentials. You agree to accept responsibility for all activities that occur under your account.</p>
        
        <h3>3. Event Registration</h3>
        <p>Registration for events is subject to availability. SPCC reserves the right to cancel or modify events at any time.</p>
        
        <h3>4. Code of Conduct</h3>
        <p>Users must behave respectfully at all events. Harassment, discrimination, or disruptive behavior will not be tolerated.</p>
        
        <h3>5. Privacy</h3>
        <p>Your personal information will be handled in accordance with our Privacy Policy and applicable data protection laws.</p>
        
        <h3>6. Changes to Terms</h3>
        <p>We may modify these terms at any time. Continued use of the system constitutes acceptance of modified terms.</p>
        
        <h3>7. Limitation of Liability</h3>
        <p>SPCC shall not be liable for any indirect, incidental, or consequential damages arising from your use of the system.</p>
        
        <h3>8. Governing Law</h3>
        <p>These terms shall be governed by the laws of the Republic of the Philippines.</p>
        
        <h3>9. Contact Information</h3>
        <p>For questions about these Terms, contact us at: <a href="mailto:info@systemsplus.edu.ph">info@systemsplus.edu.ph</a></p>
        
        <p class="text-center mt-4"><strong>Last Updated: January 1, 2024</strong></p>
        HTML;
    }
}