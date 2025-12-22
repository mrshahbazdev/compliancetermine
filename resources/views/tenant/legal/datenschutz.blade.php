@extends('layouts.tenant')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 p-10">
        <h1 class="text-3xl font-black text-slate-900 italic mb-8">Datenschutz-erklärung</h1>
        
        <div class="space-y-8 text-slate-600 text-sm leading-loose">
            <section>
                <h2 class="text-xl font-black text-slate-800 mb-3 uppercase tracking-tight">1. Datenschutz auf einen Blick</h2>
                <p>Wir nehmen den Schutz Ihrer persönlichen Daten sehr ernst. Als Software-Anbieter für Schulungsmanagement verarbeiten wir personenbezogene Daten (Mitarbeitername, Schulungsdaten) ausschließlich auf Basis der DSGVO.</p>
            </section>

            <section>
                <h2 class="text-xl font-black text-slate-800 mb-3 uppercase tracking-tight">2. Hosting</h2>
                <p>Unsere Software wird bei <strong>SiteGround</strong> gehostet. Hierfür haben wir einen Vertrag zur Auftragsverarbeitung (AVV) abgeschlossen, um sicherzustellen, dass Ihre Daten sicher und DSGVO-konform gespeichert werden.</p>
            </section>

            <section>
                <h2 class="text-xl font-black text-slate-800 mb-3 uppercase tracking-tight">3. Ihre Rechte</h2>
                <p>Sie haben jederzeit das Recht auf Auskunft, Berichtigung oder Löschung Ihrer gespeicherten Daten gemäß Art. 15-17 DSGVO.</p>
            </section>
        </div>
    </div>
</div>
@endsection