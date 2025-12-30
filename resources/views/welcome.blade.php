<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ComplianceTermine - Rechtliche Schulungstermine im Blick</title>
    <meta name="description" content="Alle Compliance-Termine und Pflichtschulungen zentral verwalten – einfach, sicher, mit Frühwarnsystem. Jetzt anmelden auf compliancetermine.de.">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .step-card:hover .step-number {
            transform: scale(1.1) rotate(5deg);
            background-color: #2563eb;
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900">
                        Compliance<span class="text-blue-600">Termine</span>
                    </span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#vorteile" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Vorteile</a>
                    <a href="#ablauf" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Ablauf</a>
                    @auth
                        <a href="{{ route('tenant.dashboard', ['tenantId' => $tenant?->id ?? 'default']) }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-full font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            Dashboard
                        </a>
                    @else
                        <a href="https://digitalpackt.de/register" class="bg-blue-600 text-white px-6 py-2.5 rounded-full font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            Jetzt anmelden
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="relative pt-20 pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center space-x-2 bg-blue-50 border border-blue-100 px-4 py-2 rounded-full text-blue-700 text-sm font-bold mb-8 animate-bounce">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>Halten Sie Ihre Compliance-Termine an einem Ort im Blick!</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-8">
                    Compliance-Termine im Griff – <span class="gradient-text">einfach, sicher, zentral.</span>
                </h1>
                
                <p class="text-xl text-slate-600 mb-12 leading-relaxed">
                    Mit <strong>compliancetermine.de</strong> behalten Sie alle Pflichtschulungen und Unterweisungen im Blick. Für Unternehmen und Berater – ohne Stress, ohne Risiko.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="https://digitalpackt.de/register" class="w-full sm:w-auto bg-slate-900 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-slate-800 transition shadow-2xl">
                        Jetzt kostenlos anmelden
                    </a>
                    <a href="#" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-600 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-slate-50 transition">
                        Demo ansehen
                    </a>
                </div>
            </div>
        </div>
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-0 opacity-10 pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-400 rounded-full blur-[120px]"></div>
        </div>
    </header>

    <section id="vorteile" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-3xl font-extrabold mb-6 text-slate-900">Warum compliancetermine.de?</h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        Als Verantwortlicher für Arbeitssicherheit, HR oder Compliance stehen Sie vor der Herausforderung, alle Pflichtschulungen zu organisieren. Das kostet Zeit, Nerven und birgt Risiken.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4 p-6 rounded-2xl bg-red-50 border border-red-100">
                            <div class="text-red-500 mt-1"><i class="fas fa-circle-exclamation text-xl"></i></div>
                            <div>
                                <h4 class="font-bold text-red-900">Das Problem ohne System</h4>
                                <p class="text-red-700 text-sm">Unterlagen verstreut, vergessene Termine und Audits, die für Unsicherheit sorgen. Das Risiko: Strafen und Reputationsverlust.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-6 rounded-2xl bg-emerald-50 border border-emerald-100">
                            <div class="text-emerald-500 mt-1"><i class="fas fa-circle-check text-xl"></i></div>
                            <div>
                                <h4 class="font-bold text-emerald-900">Unsere Lösung</h4>
                                <p class="text-emerald-700 text-sm">Ein zentrales System mit integriertem Frühwarnsystem. Wir machen Compliance einfach und sicher – ohne Chaos.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100">
                        <div class="text-blue-600 mb-4 text-3xl"><i class="fas fa-shield-halved"></i></div>
                        <h3 class="font-bold mb-2">Rechtssicher</h3>
                        <p class="text-slate-500 text-sm">Keine Angst vor Kontrollen oder dem Verlust des Versicherungsschutzes.</p>
                    </div>
                    <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100">
                        <div class="text-blue-600 mb-4 text-3xl"><i class="fas fa-clock-rotate-left"></i></div>
                        <h3 class="font-bold mb-2">Zeitgewinn</h3>
                        <p class="text-slate-500 text-sm">Automatisierte Prozesse nehmen Ihnen die mühsame Verwaltung ab.</p>
                    </div>
                    <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 sm:mt-6">
                        <div class="text-blue-600 mb-4 text-3xl"><i class="fas fa-bell"></i></div>
                        <h3 class="font-bold mb-2">Frühwarnsystem</h3>
                        <p class="text-slate-500 text-sm">Rechtzeitige Erinnerungen an alle anstehenden Fristen.</p>
                    </div>
                    <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 sm:mt-6">
                        <div class="text-blue-600 mb-4 text-3xl"><i class="fas fa-users"></i></div>
                        <h3 class="font-bold mb-2">Berater-Tool</h3>
                        <p class="text-slate-500 text-sm">Stärken Sie die Kundenbindung durch professionelles Reporting.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="ablauf" class="py-24 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-extrabold mb-4">So einfach funktioniert es</h2>
                <p class="text-slate-400">In wenigen Schritten zur perfekten Übersicht.</p>
            </div>
            
            <div class="grid md:grid-cols-5 gap-8 relative">
                <div class="step-card text-center group">
                    <div class="step-number w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 font-bold transition-all duration-300">1</div>
                    <p class="text-sm font-medium">Auf compliancetermine.de anmelden</p>
                </div>
                <div class="step-card text-center group">
                    <div class="step-number w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 font-bold transition-all duration-300">2</div>
                    <p class="text-sm font-medium">Passenden Plan wählen</p>
                </div>
                <div class="step-card text-center group">
                    <div class="step-number w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 font-bold transition-all duration-300">3</div>
                    <p class="text-sm font-medium">Wunschdomain eingeben</p>
                </div>
                <div class="step-card text-center group">
                    <div class="step-number w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 font-bold transition-all duration-300">4</div>
                    <p class="text-sm font-medium">Schulungen kategorisiert eintragen</p>
                </div>
                <div class="step-card text-center group">
                    <div class="step-number w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 font-bold transition-all duration-300">5</div>
                    <p class="text-sm font-medium">Dokumente hochladen & Überblick behalten</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white overflow-hidden relative">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <div class="bg-red-50 border border-red-100 p-12 rounded-[3rem] relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold text-red-900 mb-6">Was passiert, wenn Sie nichts tun?</h2>
                    <p class="text-red-800 text-lg mb-8 max-w-2xl mx-auto">
                        Strafen durch Behörden, Verlust des Versicherungsschutzes, finanzielle Einbußen und Reputationsschäden sind die Folge. Setzen Sie das Vertrauen Ihrer Mitarbeiter nicht aufs Spiel.
                    </p>
                    <div class="flex flex-wrap justify-center gap-6 mb-10">
                        <span class="flex items-center text-red-700 font-bold"><i class="fas fa-xmark-circle mr-2"></i> Bußgelder</span>
                        <span class="flex items-center text-red-700 font-bold"><i class="fas fa-xmark-circle mr-2"></i> Haftungsrisiken</span>
                        <span class="flex items-center text-red-700 font-bold"><i class="fas fa-xmark-circle mr-2"></i> Audit-Fail</span>
                    </div>
                </div>
                <i class="fas fa-triangle-exclamation absolute -bottom-10 -right-10 text-[200px] text-red-100 z-0"></i>
            </div>

            <div class="mt-24">
                <h2 class="text-4xl font-extrabold text-slate-900 mb-6">Starten Sie jetzt und machen Sie <br>Compliance einfach und sicher.</h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="https://digitalpackt.de/register" class="bg-blue-600 text-white px-12 py-5 rounded-2xl font-bold text-xl hover:bg-blue-700 transition shadow-2xl shadow-blue-300">
                        Jetzt registrieren
                    </a>
                </div>
                <div class="mt-10 flex justify-center space-x-8 text-sm font-bold text-slate-400">
                    <a href="#" class="hover:text-blue-600">FAQ</a>
                    <a href="#" class="hover:text-blue-600">Kostenlose Leitfäden</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-50 border-t border-slate-200 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 mb-16">
                <div>
                    <span class="text-xl font-extrabold text-slate-900">Compliance<span class="text-blue-600">Termine</span></span>
                    <p class="mt-4 text-slate-500 max-w-sm">Die zentrale Lösung für Ihre gesetzlichen Unterweisungen und Fristen. Einfach. Sicher. Digital.</p>
                </div>
                <div class="flex md:justify-end space-x-12">
                    <div>
                        <h4 class="font-bold text-slate-900 mb-4">Rechtliches</h4>
                        <ul class="space-y-2 text-sm text-slate-500 font-medium">
                            @php
                                $isTenant = isset($tenant) && $tenant !== null;
                                $impLink = $isTenant && Route::has('tenant.legal.impressum') ? route('tenant.legal.impressum') : '#';
                                $datLink = $isTenant && Route::has('tenant.legal.datenschutz') ? route('tenant.legal.datenschutz') : '#';
                            @endphp
                            <li><a href="{{ $impLink }}" class="hover:text-blue-600 transition">Impressum</a></li>
                            <li><a href="{{ $datLink }}" class="hover:text-blue-600 transition">Datenschutz</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-slate-200 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-sm font-medium">&copy; {{ date('Y') }} ComplianceTermine. Alle Rechte vorbehalten.</p>
                @if(isset($tenant))
                    <div class="bg-white px-4 py-1.5 rounded-full border border-slate-200">
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-black">
                            Mandant: <span class="text-blue-600">{{ $tenant->subdomain }}</span>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </footer>

</body>
</html>