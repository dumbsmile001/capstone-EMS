<!DOCTYPE html>
<html>
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
        }
        @page {
            margin: 0;
            size: A4;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8fafc;
        }
        .ticket-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border: 2px solid #3b82f6;
            border-radius: 12px;
            padding: 30px;
            position: relative;
        }
        .ticket-header {
            text-align: center;
            border-bottom: 2px dashed #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .ticket-title {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .ticket-subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .ticket-number {
            background: #3b82f6;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }
        .ticket-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        .detail-section h3 {
            font-size: 16px;
            color: #374151;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .detail-row {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }
        .detail-label {
            color: #6b7280;
            font-size: 13px;
        }
        .detail-value {
            color: #1f2937;
            font-weight: 500;
            font-size: 14px;
            text-align: right;
        }
        .qr-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }
        .qr-title {
            font-size: 16px;
            color: #374151;
            margin-bottom: 15px;
        }
        .qr-placeholder {
            width: 200px;
            height: 200px;
            background: white;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 12px;
        }
        .qr-code {
            width: 180px;
            height: 180px;
            background: white;
            margin: 0 auto;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #e5e7eb;
            color: #6b7280;
            font-size: 12px;
        }
        .event-banner {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
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
        .watermark {
            position: absolute;
            bottom: 20px;
            right: 20px;
            opacity: 0.1;
            font-size: 48px;
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
        
        <!-- Details Grid -->
        <div class="ticket-details">
            <!-- Event Details -->
            <div class="detail-section">
                <h3>Event Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Type:</span>
                    <span class="detail-value">{{ ucfirst($event->type) }}</span>
                </div>
                @if($event->type === 'face-to-face')
                <div class="detail-row">
                    <span class="detail-label">Venue:</span>
                    <span class="detail-value">{{ $event->place_link }}</span>
                </div>
                @else
                <div class="detail-row">
                    <span class="detail-label">Link:</span>
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
                <h3>Attendee Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value">{{ $user->first_name }} {{ $user->last_name }}</span>
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
        </div>
        
        <!-- QR Code Section -->
        <div class="qr-section">
            <div class="qr-title">Scan QR Code for Entry</div>
            <div class="qr-placeholder">
                <div style="margin-bottom: 10px;">QR Code Placeholder</div>
                <div style="font-size: 10px;">{{ $ticket->ticket_number }}</div>
            </div>
            <div style="font-size: 11px; color: #6b7280; margin-top: 10px;">
                Present this ticket at the event entrance
            </div>
        </div>
        
        <!-- Payment Information (if applicable) -->
        @if($event->require_payment)
        <div class="detail-section" style="margin-top: 20px;">
            <h3>Payment Information</h3>
            <div class="detail-row">
                <span class="detail-label">Amount:</span>
                <span class="detail-value">₱{{ number_format($event->payment_amount, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Status:</span>
                <span class="detail-value">
                    @if($registration->payment_status === 'verified')
                        <span style="color: #065f46; font-weight: bold;">Verified ✓</span>
                        @if($registration->payment_verified_at)
                            <div style="font-size: 11px; color: #6b7280;">
                                Verified on: {{ $registration->payment_verified_at->format('M j, Y g:i A') }}
                            </div>
                        @endif
                    @elseif($registration->payment_status === 'pending')
                        <span style="color: #92400e; font-weight: bold;">Pending</span>
                    @elseif($registration->payment_status === 'rejected')
                        <span style="color: #dc2626; font-weight: bold;">Rejected</span>
                    @endif
                </span>
            </div>
        </div>
        @endif
        
        <!-- Footer -->
        <div class="footer">
            <div>Ticket Generated: {{ $ticket->generated_at->format('F j, Y g:i A') }}</div>
            <div style="margin-top: 5px;">
                This is an electronic ticket. Please bring a digital or printed copy to the event.
            </div>
            <div style="margin-top: 5px; font-size: 10px;">
                Ticket ID: {{ $ticket->ticket_number }} | Event ID: {{ $event->id }}
            </div>
        </div>
    </div>
</body>
</html>