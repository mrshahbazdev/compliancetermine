<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #e2e8f0; border-radius: 10px; max-width: 600px; }
        .header { font-size: 18px; font-weight: bold; color: #2563eb; margin-bottom: 20px; }
        .details { background: #f8fafc; padding: 15px; border-radius: 8px; }
        .footer { margin-top: 20px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Neue Schulung wurde geplant!</div>
        
        <p>Hallo,</p>
        <p>Es wurde ein neuer Schulungstermin für einen Ihrer Mitarbeiter geplant:</p>
        
        <div class="details">
            <strong>Mitarbeiter:</strong> {{ $training->employee->name }}<br>
            <strong>Schulungstyp:</strong> {{ $training->category->name }}<br>
            <strong>Datum:</strong> {{ $training->last_event_date->format('d.m.Y') }}<br>
            <strong>Status:</strong> {{ ucfirst($training->status) }}
        </div>

        <p>Bitte stellen Sie sicher, dass der Mitarbeiter an diesem Termin teilnimmt.</p>
        
        <div class="footer">
            Dies ist eine automatische Benachrichtigung von ComplianceTermine.
        </div>
    </div>
</body>
</html>