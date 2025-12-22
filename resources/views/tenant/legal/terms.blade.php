@extends(isset($tenant) ? 'layouts.tenant' : 'layouts.central')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-6">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 italic tracking-tight">Nutzungsbedingungen</h1>
        <div class="h-1.5 w-24 bg-blue-500 mt-4 rounded-full"></div>
        <p class="text-slate-500 mt-4 font-medium max-w-2xl leading-relaxed italic">
            Zuletzt aktualisiert am: {{ date('d.m.Y') }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-8 space-y-12 pb-20">
            
            @php
                $sections = [
                    '1. Einleitung' => 'Diese Nutzungsbedingungen regeln die Nutzung der Plattform https://compliancetermine.de/ durch registrierte und nicht registrierte Nutzer. Mit dem Zugriff auf Work-Bees.de und der Nutzung der angebotenen Dienste erklären Sie sich mit diesen Bedingungen einverstanden.',
                    '2. Definitionen' => '„Plattform“: https://compliancetermine.de/, einschließlich aller Subdomains und Funktionen. <br> „Nutzer“: Jede natürliche oder juristische Person, die die Plattform nutzt.',
                    '3. Registrierung und Konten' => 'Um bestimmte Funktionen der Plattform nutzen zu können, müssen Sie ein Konto erstellen. Sie verpflichten sich, bei der Registrierung wahrheitsgemäße und vollständige Angaben zu machen und Ihr Konto sicher zu halten. https://compliancetermine.de/ behält sich das Recht vor, Konten bei Verstößen gegen diese Bedingungen zu sperren oder zu löschen.',
                    '4. Leistungen' => 'https://compliancetermine.de/ bietet eine Plattform zur Erstellung der Terminübersicht von Gesetzlichen Schulungen und Unterweisungen. Nutzer können Mitarbeiter erstellen, Kategorien und Termine verwalten. Die Plattform stellt lediglich die technische Infrastruktur bereit.',
                    '5. Zahlungen und Gebühren' => 'Für bestimmte Funktionen können Gebühren anfallen. Die Zahlungsabwicklung erfolgt über externe Zahlungsdienstleister. Work-Bees.de erhebt ggf. eine Vermittlungsprovision. Alle Preise verstehen sich inklusive gesetzlicher Umsatzsteuer.',
                    '6. Verhalten der Nutzer' => 'Nutzer verpflichten sich, keine rechtswidrigen, beleidigenden oder irreführenden Inhalte zu veröffentlichen. Die Plattform darf nicht für illegale Aktivitäten genutzt werden.',
                    '7. Geistiges Eigentum' => 'Nutzer räumen uns ein einfaches Nutzungsrecht an den eingestellten Inhalten ein. Die Rechte an den Inhalten verbleiben beim jeweiligen Nutzer. Inhalte von https://compliancetermine.de/ dürfen nicht ohne Genehmigung kopiert werden.',
                    '8. Haftung und Gewährleistung' => 'Wir haften nicht für Inhalte oder Handlungen von Nutzern. Wir übernehmen keine Gewähr für die ständige Verfügbarkeit oder Richtigkeit der angebotenen Dienstleistungen.',
                    '9. Kündigung' => 'Nutzer können ihr Konto jederzeit kündigen. Wir behalten uns vor, Nutzer bei Verstößen zu sperren. Bereits gezahlte Gebühren werden in der Regel nicht erstattet.',
                    '12. Gerichtsstand' => 'Es gilt das Recht der Bundesrepublik Deutschland. Gerichtsstand ist, soweit gesetzlich zulässig, der Sitz von Work-Bees.de.'
                ];
            @endphp

            @foreach($sections as $title => $text)
                <section class="border-b border-slate-100 pb-8 last:border-0">
                    <h2 class="text-xl font-black text-slate-800 mb-4 uppercase tracking-tighter">{{ $title }}</h2>
                    <p class="text-slate-600 text-sm leading-loose font-medium">
                        {!! $text !!}
                    </p>
                </section>
            @endforeach

        </div>

        <div class="lg:col-span-4">
            <div class="sticky top-6 space-y-6">
                <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-200">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-gavel text-xl"></i>
                    </div>
                    <h3 class="text-xl font-black mb-4">Wichtiger Hinweis</h3>
                    <p class="text-blue-100 text-sm leading-relaxed font-medium">
                        Bitte lesen Sie diese Bedingungen sorgfältig durch. Durch die Nutzung von ComplianceTermine akzeptieren Sie diese rechtlich bindenden Vereinbarungen.
                    </p>
                </div>

                <div class="bg-white rounded-[2.5rem] border border-slate-200 p-8 shadow-sm">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 text-center">Inhaltsverzeichnis</h3>
                    <div class="space-y-3">
                        @foreach($sections as $title => $text)
                            <div class="flex items-center text-[11px] font-bold text-slate-500 border-b border-slate-50 pb-2">
                                <span class="w-6 h-6 bg-slate-100 rounded flex items-center justify-center mr-3 text-[9px]">{{ $loop->iteration }}</span>
                                {{ explode(' ', $title)[1] ?? $title }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection