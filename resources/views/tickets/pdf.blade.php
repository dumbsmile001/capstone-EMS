<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket: {{ $ticket->ticket_number }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/dejavu-sans/DejaVuSans.ttf') }}) format('truetype');
        }
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: bold;
            src: url({{ storage_path('fonts/dejavu-sans/DejaVuSans-Bold.ttf') }}) format('truetype');
        }
        * {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        @page {
            margin: 20mm;
            size: A4;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #1f2937;
            background: #ffffff;
        }
        .ticket-container {
            width: 100%;
            max-width: 100%;
            background: white;
            border: 3px solid #3b82f6;
            border-radius: 8px;
            padding: 25px;
            position: relative;
        }
        
        /* Header Section */
        .ticket-header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .event-banner {
            width: 100%;
            max-height: 120px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .ticket-title {
            font-size: 24pt;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .ticket-subtitle {
            color: #6b7280;
            font-size: 11pt;
            margin-bottom: 10px;
        }
        .ticket-number {
            background: #3b82f6;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 14pt;
            font-weight: bold;
            display: inline-block;
            margin-top: 8px;
        }
        
        /* Main Content Section */
        .ticket-content {
            margin-bottom: 25px;
        }
        .ticket-details {
            width: 100%;
            margin-bottom: 20px;
        }
        .detail-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
        }
        .detail-section h3 {
            font-size: 14pt;
            color: #1f2937;
            margin-bottom: 12px;
            font-weight: bold;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }
        .detail-row {
            margin-bottom: 10px;
            display: table;
            width: 100%;
        }
        .detail-label {
            color: #6b7280;
            font-size: 11pt;
            display: table-cell;
            width: 35%;
            padding-right: 10px;
            vertical-align: top;
        }
        .detail-value {
            color: #1f2937;
            font-weight: 500;
            font-size: 11pt;
            display: table-cell;
            width: 65%;
            vertical-align: top;
        }
        
        /* QR Code Section */
        .qr-section {
            text-align: center;
            margin: 25px 0;
            padding: 20px;
            background: #f9fafb;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
        }
        .qr-title {
            font-size: 14pt;
            color: #374151;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .qr-placeholder {
            width: 180px;
            height: 180px;
            background: white;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 10pt;
        }
        
        /* Payment Information */
        .payment-section {
            margin-top: 20px;
            padding: 15px;
            background: #fef3c7;
            border-radius: 6px;
            border-left: 4px solid #f59e0b;
        }
        .payment-section h3 {
            font-size: 14pt;
            color: #1f2937;
            margin-bottom: 12px;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px dashed #e5e7eb;
            color: #6b7280;
            font-size: 9pt;
        }
        .footer-line {
            margin-bottom: 5px;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10pt;
            font-weight: 600;
        }
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        /* Watermark */
        .watermark {
            position: absolute;
            bottom: 30px;
            right: 30px;
            opacity: 0.08;
            font-size: 36pt;
            font-weight: bold;
            color: #3b82f6;
            transform: rotate(-15deg);
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- Watermark -->
        <div class="watermark">EVENT TICKET</div>
        
        <!-- Header -->
        <div class="ticket-header">
            @if($event->banner)
                <img src="{{ storage_path('app/public/' . $event->banner) }}" alt="Event Banner" class="event-banner">
            @endif
            <div class="ticket-title">{{ $event->title }}</div>
            <div class="ticket-subtitle">{{ ucfirst($event->category) }} Event</div>
            <div class="ticket-number">{{ $ticket->ticket_number }}</div>
        </div>
        
        <!-- Main Content -->
        <div class="ticket-content">
            <!-- Event Details -->
            <div class="detail-section">
                <h3>Event Information</h3>
                <div class="detail-row">
                    <span class="detail-label">Event Date:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Event Time:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Event Type:</span>
                    <span class="detail-value">{{ ucfirst(str_replace('-', ' ', $event->type)) }}</span>
                </div>
                @if($event->type === 'face-to-face')
                <div class="detail-row">
                    <span class="detail-label">Venue:</span>
                    <span class="detail-value">{{ $event->place_link }}</span>
                </div>
                @else
                <div class="detail-row">
                    <span class="detail-label">Meeting Link:</span>
                    <span class="detail-value">{{ $event->place_link }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Organizer:</span>
                    <span class="detail-value">
                        @if($organizer)
                            {{ $organizer->first_name }} {{ $organizer->last_name }}
                        @else
                            Event Organizer
                        @endif
                    </span>
                </div>
            </div>
            
            <!-- Attendee Details -->
            <div class="detail-section">
                <h3>Attendee Information</h3>
                <div class="detail-row">
                    <span class="detail-label">Full Name:</span>
                    <span class="detail-value">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</span>
                </div>
                @if($user->student_id)
                <div class="detail-row">
                    <span class="detail-label">Student ID:</span>
                    <span class="detail-value">{{ $user->student_id }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Email Address:</span>
                    <span class="detail-value">{{ $user->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Registration Date:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($registration->registered_at)->format('F j, Y g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ticket Status:</span>
                    <span class="detail-value">
                        @if($ticket->isActive())
                            <span class="status-badge status-active">Active</span>
                        @elseif($ticket->isPendingPayment())
                            <span class="status-badge status-pending">Pending Payment</span>
                        @elseif($ticket->isUsed())
                            <span class="status-badge">Used</span>
                        @endif
                    </span>
                </div>
            </div>
            
            <!-- Payment Information (if applicable) -->
            @if($event->require_payment)
            <div class="payment-section">
                <h3>Payment Information</h3>
                <div class="detail-row">
                    <span class="detail-label">Amount:</span>
                    <span class="detail-value"><strong>₱{{ number_format($event->payment_amount, 2) }}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Status:</span>
                    <span class="detail-value">
                        @if($registration->payment_status === 'verified')
                            <strong style="color: #065f46;">Verified ✓</strong>
                            @if($registration->payment_verified_at)
                                <div style="font-size: 9pt; color: #6b7280; margin-top: 3px;">
                                    Verified on: {{ $registration->payment_verified_at->format('M j, Y g:i A') }}
                                </div>
                            @endif
                        @elseif($registration->payment_status === 'pending')
                            <strong style="color: #92400e;">Pending</strong>
                        @elseif($registration->payment_status === 'rejected')
                            <strong style="color: #dc2626;">Rejected</strong>
                        @endif
                    </span>
                </div>
            </div>
            @endif
        </div>
        
        <!-- QR Code Section -->
        <div class="qr-section">
            <div class="qr-title">Scan QR Code for Entry</div>
            @if(isset($qrCodeDataUri))
                <div style="text-align: center;">
                    <img src="{{ $qrCodeDataUri }}" alt="QR Code" style="width: 180px; height: 180px; border: 2px solid #d1d5db; border-radius: 6px; padding: 10px; background: white;" />
                </div>
            @else
                <div class="qr-placeholder">
                    <div style="margin-bottom: 8px;">QR Code Placeholder</div>
                    <div style="font-size: 9pt;">{{ $ticket->ticket_number }}</div>
                </div>
            @endif
            <div style="font-size: 10pt; color: #6b7280; margin-top: 10px;">
                Present this ticket at the event entrance
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-line"><strong>Ticket Generated:</strong> {{ $ticket->generated_at->format('F j, Y g:i A') }}</div>
            <div class="footer-line" style="margin-top: 8px;">
                This is an electronic ticket. Please bring a digital or printed copy to the event.
            </div>
            <div class="footer-line" style="margin-top: 5px; font-size: 8pt;">
                Ticket ID: {{ $ticket->ticket_number }} | Event ID: {{ $event->id }}
            </div>
        </div>
    </div>
</body>
</html>
