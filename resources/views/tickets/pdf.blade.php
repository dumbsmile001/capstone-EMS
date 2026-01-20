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
            margin: 15mm;
            size: A4;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #1f2937;
            background: #ffffff;
        }
        .ticket-container {
            width: 100%;
            max-width: 100%;
            background: white;
            border: 2px solid #3b82f6;
            border-radius: 6px;
            padding: 15px;
            position: relative;
        }
        
        /* Header Section with QR Code */
        .ticket-header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .header-left {
            display: table-cell;
            width: 65%;
            vertical-align: top;
            padding-right: 15px;
        }
        .header-right {
            display: table-cell;
            width: 35%;
            vertical-align: top;
            text-align: center;
        }
        .event-banner {
            width: 100%;
            max-height: 80px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 10px;
            display: block;
        }
        .ticket-title {
            font-size: 16pt;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 3px;
        }
        .ticket-subtitle {
            color: #6b7280;
            font-size: 9pt;
            margin-bottom: 6px;
        }
        .ticket-number {
            background: #3b82f6;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 10pt;
            font-weight: bold;
            display: inline-block;
            margin-top: 4px;
        }
        
        /* QR Code in Header */
        .qr-section {
            text-align: center;
            padding: 10px;
            background: #f9fafb;
            border: 2px dashed #d1d5db;
            border-radius: 6px;
        }
        .qr-title {
            font-size: 9pt;
            color: #374151;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .qr-placeholder {
            width: 120px;
            height: 120px;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 8pt;
        }
        
        /* Main Content Section */
        .ticket-content {
            margin-bottom: 12px;
        }
        .content-columns {
            display: table;
            width: 100%;
        }
        .column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 10px;
        }
        .column:last-child {
            padding-right: 0;
            padding-left: 10px;
        }
        .detail-section {
            margin-bottom: 12px;
            padding: 10px;
            background: #f9fafb;
            border-radius: 4px;
            border-left: 3px solid #3b82f6;
        }
        .detail-section h3 {
            font-size: 10pt;
            color: #1f2937;
            margin-bottom: 8px;
            font-weight: bold;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
        }
        .detail-row {
            margin-bottom: 6px;
            display: table;
            width: 100%;
        }
        .detail-label {
            color: #6b7280;
            font-size: 8pt;
            display: table-cell;
            width: 40%;
            padding-right: 8px;
            vertical-align: top;
        }
        .detail-value {
            color: #1f2937;
            font-weight: 500;
            font-size: 8pt;
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }
        
        /* Payment Information */
        .payment-section {
            margin-top: 12px;
            padding: 10px;
            background: #fef3c7;
            border-radius: 4px;
            border-left: 3px solid #f59e0b;
        }
        .payment-section h3 {
            font-size: 10pt;
            color: #1f2937;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px dashed #e5e7eb;
            color: #6b7280;
            font-size: 7pt;
        }
        .footer-line {
            margin-bottom: 3px;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8pt;
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
            bottom: 20px;
            right: 20px;
            opacity: 0.05;
            font-size: 24pt;
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
        
        <!-- Header with QR Code -->
        <div class="ticket-header">
            <div class="header-left">
                @if($event->banner)
                    <img src="{{ storage_path('app/public/' . $event->banner) }}" alt="Event Banner" class="event-banner">
                @endif
                <div class="ticket-title">{{ $event->title }}</div>
                <div class="ticket-subtitle">{{ ucfirst($event->category) }} Event</div>
                <div class="ticket-number">{{ $ticket->ticket_number }}</div>
            </div>
            <div class="header-right">
                <div class="qr-section">
                    <div class="qr-title">Scan for Entry</div>
                    @if(isset($qrCodeDataUri))
                        <div style="text-align: center;">
                            <img src="{{ $qrCodeDataUri }}" alt="QR Code" style="width: 120px; height: 120px; border: 1px solid #d1d5db; border-radius: 4px; padding: 8px; background: white;" />
                        </div>
                    @else
                        <div class="qr-placeholder">
                            <div style="margin-bottom: 5px;">QR Code</div>
                            <div style="font-size: 7pt;">{{ $ticket->ticket_number }}</div>
                        </div>
                    @endif
                    <div style="font-size: 7pt; color: #6b7280; margin-top: 6px;">
                        Present at entrance
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="ticket-content">
            <div class="content-columns">
                <!-- Left Column -->
                <div class="column">
                    <!-- Event Details -->
                    <div class="detail-section">
                        <h3>Event Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Event Date:</span>
                            <span class="detail-value">{{ \Carbon\Carbon::parse($event->date)->format('M j, Y') }}</span>
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
                </div>
                
                <!-- Right Column -->
                <div class="column">
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
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">{{ $user->email }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Registered:</span>
                            <span class="detail-value">{{ \Carbon\Carbon::parse($registration->registered_at)->format('M j, Y g:i A') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
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
                </div>
            </div>
            
            <!-- Payment Information (if applicable) -->
            @if($event->require_payment)
            <div class="payment-section">
                <h3>Payment Information</h3>
                <div style="display: table; width: 100%;">
                    <div style="display: table-cell; width: 50%; padding-right: 10px;">
                        <div class="detail-row">
                            <span class="detail-label">Amount:</span>
                            <span class="detail-value"><strong>₱{{ number_format($event->payment_amount, 2) }}</strong></span>
                        </div>
                    </div>
                    <div style="display: table-cell; width: 50%; padding-left: 10px;">
                        <div class="detail-row">
                            <span class="detail-label">Payment Status:</span>
                            <span class="detail-value">
                                @if($registration->payment_status === 'verified')
                                    <strong style="color: #065f46;">Verified ✓</strong>
                                    @if($registration->payment_verified_at)
                                        <div style="font-size: 7pt; color: #6b7280; margin-top: 2px;">
                                            {{ $registration->payment_verified_at->format('M j, Y') }}
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
                </div>
            </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-line"><strong>Generated:</strong> {{ $ticket->generated_at->format('M j, Y g:i A') }}</div>
            <div class="footer-line" style="margin-top: 5px;">
                This is an electronic ticket. Please bring a digital or printed copy to the event.
            </div>
            <div class="footer-line" style="margin-top: 3px; font-size: 6pt;">
                Ticket ID: {{ $ticket->ticket_number }} | Event ID: {{ $event->id }}
            </div>
        </div>
    </div>
</body>
</html>