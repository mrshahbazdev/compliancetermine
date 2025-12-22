<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Rechtliche Schulungstermine im Blick</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.15);
        }

        .status-badge-red {
            background: #fee2e2;
            color: #ef4444;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body class="bg-slate-50">
    
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-extrabold gradient-text">ComplianceTermine</h1>
                    @if($tenant)
                        <span class="ml-4 bg-blue-50 text-blue-700 px-3 py-1 rounded-md text-sm font-bold border border-blue-200">
                            {{ strtoupper($tenant->subdomain) }}
                        </span>
                    @endif
                </div>
                
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ route('tenant.dashboard', ['tenantId' => $tenant?->id ?? 'default']) }}" class="text-slate-600 hover:text-blue-600 font-semibold transition">
                            <i class="fas fa-chart-pie mr-2"></i>Dashboard
                        </a>
                    @else
                        @if($tenant)
                            <a href="{{ route('tenant.login', ['tenantId' => $tenant->id]) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="gradient-bg text-white py-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 opacity-10">
            <i class="fas fa-file-shield text-[300px]"></i>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="inline-flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-full text-sm font-medium mb-6 border border-white/20">
                        <span class="flex h-2 w-2 rounded-full bg-green-400 mr-3"></span>
                        Rechtssicherheit & Fristenmanagement
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                        Alle Schulungstermine <br><span class="text-blue-200">immer im Blick.</span>
                    </h1>
                    <p class="text-xl text-blue-50/90 mb-10 leading-relaxed">
                        Verwalten Sie ADR-Zertifikate, Gabelstaplerführerscheine und gesetzliche Unterweisungen zentral. Automatische E-Mail-Warnungen bei Fristablauf schützen Ihr Unternehmen.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('tenant.dashboard', ['tenantId' => $tenant?->id ?? 'default']) }}" class="bg-white text-blue-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-50 transition shadow-xl">
                                Zum Mitarbeiter-Kalender
                            </a>
                        @else
                            <a href="https://cip-tools.de/register" class="bg-white text-blue-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-50 transition shadow-xl">
                                Jetzt Anmelden
                            </a>
                        @endauth
                    </div>
                </div>
                
                <div class="hidden md:block">
                    <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 shadow-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <div class="h-3 w-12 bg-white/30 rounded"></div>
                            <div class="h-3 w-24 bg-red-400 rounded-full animate-pulse"></div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white rounded-lg p-4 flex items-center shadow-sm">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mr-4">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="h-2 w-20 bg-gray-200 rounded mb-2"></div>
                                    <div class="h-2 w-32 bg-gray-100 rounded"></div>
                                </div>
                                <span class="status-badge-red text-[10px] px-2 py-1 rounded font-bold">90 TAGE</span>
                            </div>
                            <div class="bg-white/5 rounded-lg p-4 border border-white/10 flex items-center">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-white mr-4">
                                    <i class="fas fa-truck-moving"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="h-2 w-20 bg-white/20 rounded mb-2"></div>
                                    <div class="h-2 w-32 bg-white/10 rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Optimiert für Compliance & Sicherheit</h2>
                <p class="text-slate-600">Speziell entwickelt für die Verwaltung gesetzlicher Mitarbeiter-Qualifikationen.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 card-hover transition duration-300">
                    <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-blue-200">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">90-Tage Warnsystem</h3>
                    <p class="text-slate-600 leading-relaxed">Sobald eine Gültigkeit weniger als 90 Tage beträgt, färbt sich der Eintrag rot und die Verantwortlichen werden automatisch per E-Mail informiert.</p>
                </div>

                <div class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 card-hover transition duration-300">
                    <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-indigo-200">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Interaktiver Kalender</h3>
                    <p class="text-slate-600 leading-relaxed">Filtern Sie nach Monaten, Quartalen oder einzelnen Personen. Behalten Sie die kommenden Termine Ihres Teams lückenlos im Blick.</p>
                </div>

                <div class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 card-hover transition duration-300">
                    <div class="w-14 h-14 bg-emerald-600 rounded-xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-emerald-200">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Zertifikats-Archiv</h3>
                    <h3 class="text-xl font-bold mb-4">Zertifikats-Archiv</h3>
                    <p class="text-slate-600 leading-relaxed">Laden Sie Scans von Führerscheinen und Zertifikaten direkt hoch. Alles ist digital hinterlegt und jederzeit für Prüfungen abrufbar.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-10 md:mb-0 md:max-w-md">
                    <h2 class="text-3xl font-bold mb-6">Unbegrenzte Kategorien</h2>
                    <p class="text-slate-400 mb-8">Passen Sie das Tool an Ihre Bedürfnisse an. Ob Arbeitssicherheit, Logistik oder Hygiene – erstellen Sie eigene Schulungsgruppen.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center text-slate-300"><i class="fas fa-check-circle text-blue-400 mr-3"></i> ADR-Bescheinigungen</li>
                        <li class="flex items-center text-slate-300"><i class="fas fa-check-circle text-blue-400 mr-3"></i> Gabelstaplerschulung</li>
                        <li class="flex items-center text-slate-300"><i class="fas fa-check-circle text-blue-400 mr-3"></i> Ersthelfer-Kurse</li>
                    </ul>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/5 p-6 rounded-xl border border-white/10 text-center">
                        <div class="text-3xl font-bold text-blue-400">10+</div>
                        <div class="text-sm text-slate-400">Kategorien</div>
                    </div>
                    <div class="bg-white/5 p-6 rounded-xl border border-white/10 text-center">
                        <div class="text-3xl font-bold text-blue-400">Auto</div>
                        <div class="text-sm text-slate-400">E-Mail Alerts</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 font-medium">
                &copy; {{ date('Y') }} ComplianceTermine. Alle Rechte vorbehalten.
            </p>

            <div class="mt-4 flex flex-wrap justify-center items-center gap-6">
                @php
                    // Check karein ke hum tenant context mein hain ya central
                    $routePrefix = isset($tenant) ? 'tenant.legal.' : 'legal.';
                    $routeParam = isset($tenant) ? ['tenantId' => $tenant->id] : [];
                @endphp

                <a href="{{ route($routePrefix . 'impressum', $routeParam) }}" 
                class="text-xs font-bold text-slate-400 hover:text-blue-600 uppercase tracking-widest transition">
                    Impressum
                </a>
                
                <a href="{{ route($routePrefix . 'datenschutz', $routeParam) }}" 
                class="text-xs font-bold text-slate-400 hover:text-blue-600 uppercase tracking-widest transition">
                    Datenschutz
                </a>
                
                <a href="{{ route($routePrefix . 'terms', $routeParam) }}" 
                class="text-xs font-bold text-slate-400 hover:text-blue-600 uppercase tracking-widest transition">
                    Nutzungsbedingungen
                </a>
            </div>

            @if(isset($tenant))
                <div class="mt-6 pt-6 border-t border-slate-50">
                    <p class="text-[10px] text-slate-300 uppercase tracking-[0.2em] font-black">
                        Mandant: <span class="text-slate-400">{{ $tenant->subdomain }}</span>
                    </p>
                </div>
            @endif
        </div>
    </footer>

</body>
</html>