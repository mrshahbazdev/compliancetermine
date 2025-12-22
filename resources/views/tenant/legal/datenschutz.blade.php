@extends(isset($tenant) ? 'layouts.tenant' : 'layouts.central')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-6">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 italic tracking-tight">Datenschutzerklärung</h1>
        <div class="h-1.5 w-24 bg-emerald-500 mt-4 rounded-full"></div>
        <p class="text-slate-500 mt-4 font-medium max-w-2xl leading-relaxed">
            Der Schutz Ihrer persönlichen Daten ist uns wichtig. In dieser Datenschutzerklärung erfahren Sie, welche Daten wir erfassen, wie wir sie verwenden und wie wir sie schützen.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4 space-y-4 order-2 lg:order-1">
            <div class="sticky top-6 space-y-4">
                <div class="bg-white rounded-[2rem] border border-slate-200 p-6 shadow-sm">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Schnellzugriff</h3>
                    <ul class="space-y-3">
                        <li><a href="#erfasste-daten" class="text-sm font-bold text-slate-600 hover:text-emerald-600 flex items-center"><i class="fas fa-check-circle mr-2 text-emerald-500"></i> Erfasste Daten</a></li>
                        <li><a href="#verwendung" class="text-sm font-bold text-slate-600 hover:text-emerald-600 flex items-center"><i class="fas fa-check-circle mr-2 text-emerald-500"></i> Verwendung</a></li>
                        <li><a href="#rechte" class="text-sm font-bold text-slate-600 hover:text-emerald-600 flex items-center"><i class="fas fa-check-circle mr-2 text-emerald-500"></i> Ihre Rechte</a></li>
                    </ul>
                </div>

                <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-xl">
                    <h4 class="font-black text-lg mb-4">Fragen?</h4>
                    <p class="text-slate-400 text-xs leading-relaxed mb-6">Bei Fragen zum Datenschutz erreichen Sie uns unter:</p>
                    <a href="mailto:info@work-bees.de" class="inline-flex items-center text-emerald-400 font-bold hover:text-emerald-300 transition">
                        <i class="fas fa-envelope mr-2"></i> info@work-bees.de
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6 order-1 lg:order-2">
            
            <section id="erfasste-daten" class="bg-white rounded-[2.5rem] border border-slate-200 p-8 md:p-10 shadow-sm transition hover:shadow-md">
                <h2 class="text-xl font-black text-slate-900 mb-4 flex items-center">
                    <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mr-3 text-sm">01</span>
                    Erfasste Daten
                </h2>
                <p class="text-slate-600 text-sm leading-loose font-medium">
                    Wir erfassen personenbezogene Daten wie Name, E-Mail-Adresse, Telefonnummer, Firmenname sowie Nachrichten über Kontakt- oder Registrierungsformulare. Bei Beratern können zusätzlich Qualifikationen, Fachgebiete und Standortdaten erfasst werden.
                </p>
            </section>

            <section id="verwendung" class="bg-white rounded-[2.5rem] border border-slate-200 p-8 md:p-10 shadow-sm transition hover:shadow-md">
                <h2 class="text-xl font-black text-slate-900 mb-4 flex items-center">
                    <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mr-3 text-sm">02</span>
                    Verwendung der Daten
                </h2>
                <p class="text-slate-600 text-sm leading-loose font-medium">
                    Ihre Daten werden ausschließlich verwendet, um Anfragen zu beantworten, Berateranträge zu bearbeiten, Dienstleistungen bereitzustellen und die Kommunikation aufrechtzuerhalten. Aggregierte Daten können zur Verbesserung unseres Angebots genutzt werden.
                </p>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-200">
                    <h3 class="font-black text-slate-900 mb-3 uppercase tracking-tighter text-sm">Cookies & Tracking</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Unsere Website verwendet Cookies zur Verbesserung der Benutzerfreundlichkeit und zur Analyse. Sie können Cookies über Ihre Browser-Einstellungen steuern.</p>
                </div>
                <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-200">
                    <h3 class="font-black text-slate-900 mb-3 uppercase tracking-tighter text-sm">Weitergabe</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Wir verkaufen Ihre Daten nicht. Eine Weitergabe erfolgt nur an vertrauenswürdige Dienstleister (z.B. Hosting).</p>
                </div>
            </div>

            <section id="rechte" class="bg-emerald-600 rounded-[2.5rem] p-8 md:p-10 text-white shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h2 class="text-xl font-black mb-4 italic">Datensicherheit</h2>
                        <p class="text-emerald-100 text-sm leading-relaxed font-medium">
                            Wir setzen angemessene technische und organisatorische Maßnahmen ein, um Ihre Daten vor unbefugtem Zugriff oder Offenlegung zu schützen.
                        </p>
                    </div>
                    <div>
                        <h2 class="text-xl font-black mb-4 italic">Ihre Rechte</h2>
                        <p class="text-emerald-100 text-sm leading-relaxed font-medium">
                            Sie haben das Recht auf Auskunft, Berichtigung oder Löschung Ihrer Daten. Sie können Ihre Einwilligung jederzeit widerrufen.
                        </p>
                    </div>
                </div>
            </section>

            <div class="p-8 border-l-4 border-slate-200">
                <p class="text-slate-400 text-[11px] leading-relaxed uppercase font-bold italic">
                    Änderungen: Diese Datenschutzerklärung kann bei Bedarf aktualisiert werden. Letzte Aktualisierung: {{ date('d.m.Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection