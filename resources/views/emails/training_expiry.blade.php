<div style="font-family: sans-serif; padding: 20px; border: 1px solid #eee;">
    <h2 style="color: #ef4444;">Ablaufwarnung für Schulung</h2>
    <p>Hallo,</p>
    <p>Dies ist eine automatische Erinnerung: Die folgende Schulung läuft in <strong>{{ $daysLeft }} Tagen</strong> ab.</p>
    
    <div style="background: #fff5f5; padding: 15px; border-left: 4px solid #ef4444;">
        <strong>Mitarbeiter:</strong> {{ $training->employee->name }}<br>
        <strong>Kategorie:</strong> {{ $training->category->name }}<br>
        <strong>Ablaufdatum:</strong> {{ $training->expiry_date->format('d.m.Y') }}
    </div>

    <p>Bitte planen Sie rechtzeitig eine Auffrischungsschulung.</p>
</div>