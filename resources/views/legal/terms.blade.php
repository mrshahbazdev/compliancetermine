@extends('layouts.central')


@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 p-10">
        <h1 class="text-3xl font-black text-slate-900 italic mb-8">Nutzungsbedingungen</h1>
        
        <div class="space-y-6 text-slate-600 text-sm">
            <p>Willkommen bei ComplianceTermine. Durch die Nutzung unserer Plattform erklären Sie sich mit den folgenden Bedingungen einverstanden:</p>
            
            <ul class="list-disc pl-6 space-y-3">
                <li><strong>Systemzugang:</strong> Der Zugang ist nur autorisierten Administratoren und Verantwortlichen gestattet.</li>
                <li><strong>Datenverantwortung:</strong> Jeder Tenant ist selbst für die Richtigkeit der eingetragenen Schulungsdaten verantwortlich.</li>
                <li><strong>Verfügbarkeit:</strong> Wir bemühen uns um eine 99%ige Verfügbarkeit, können jedoch keine Haftung für kurzzeitige Serverausfälle übernehmen.</li>
                <li><strong>Kündigung:</strong> Accounts können gemäß der vereinbarten Vertragslaufzeit gekündigt werden.</li>
            </ul>
        </div>
    </div>
</div>
@endsection