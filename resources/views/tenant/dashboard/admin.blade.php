<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $tenant->subdomain }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-gray-50">

    @include('tenant.partials.nav')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">
                    Willkommen zurück, {{ $user->name }}! 👋
                </h2>
                <p class="text-gray-600 mt-2">
                    Überblick über die gesetzlichen Fristen von {{ ucfirst($tenant->subdomain) }}
                </p>
            </div>
            <div class="text-right hidden md:block">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Aktuelles Datum</p>
                <p class="text-lg font-bold text-blue-600">{{ now()->format('d.m.Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="stat-card bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Mitarbeiter</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_employees'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg text-blue-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-4 flex items-center">
                    <i class="fas fa-database mr-1"></i> Gesamt im System
                </p>
            </div>

            <div class="stat-card bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Kategorien</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_categories'] ?? 0 }}</p>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-lg text-indigo-600">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-4">z.B. ADR, Stapler, Ersthelfer</p>
            </div>

            <div class="stat-card bg-red-50 border border-red-100 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 text-sm font-bold uppercase">Kritisch (< 90 Tage)</p>
                        <p class="text-3xl font-bold text-red-700 mt-1">{{ $stats['critical_trainings'] ?? 0 }}</p>
                    </div>
                    <div class="bg-red-500 p-3 rounded-lg text-white shadow-lg animate-pulse">
                        <i class="fas fa-exclamation-triangle text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs text-red-500 mt-4 font-semibold">
                    <i class="fas fa-envelope-open-text mr-1"></i> E-Mail Alerts gesendet
                </p>
            </div>

            <div class="stat-card bg-green-50 border border-green-100 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-bold uppercase">Zertifikate</p>
                        <p class="text-3xl font-bold text-green-700 mt-1">{{ $stats['total_certificates'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-500 p-3 rounded-lg text-white">
                        <i class="fas fa-certificate text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 mt-4">Gültige Nachweise im Archiv</p>
            </div>

        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <i class="fas fa-clock text-orange-500 mr-2"></i>
                        Nächste anstehende Termine
                    </h3>
                    <a href="{{ route('tenant.calendar', ['tenantId' => request()->tenantId]) }}" class="text-blue-600 text-sm font-semibold hover:underline">Vollständiger Kalender</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs font-bold text-gray-500 uppercase bg-gray-50 border-b">
                                <th class="px-6 py-3">Mitarbeiter</th>
                                <th class="px-6 py-3">Schulung</th>
                                <th class="px-6 py-3">Ablaufdatum</th>
                                <th class="px-6 py-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($expiringTrainings as $training)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $training->employee->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $training->category->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $training->expiry_date->format('d.m.Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        @if($training->isExpiringSoon())
                                            <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded uppercase">Kritisch</span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded uppercase">OK</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">Keine anstehenden Termine gefunden.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-900 rounded-xl p-6 text-white shadow-xl">
                    <h3 class="font-bold mb-4 flex items-center">
                        <i class="fas fa-bolt text-yellow-400 mr-2"></i> Schnellzugriff
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('tenant.employees.create', ['tenantId' => request()->tenantId]) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 py-2 rounded-lg font-semibold transition">
                            Neuer Mitarbeiter
                        </a>
                        <a href="{{ route('tenant.categories.index', ['tenantId' => request()->tenantId]) }}" class="block w-full text-center bg-white/10 hover:bg-white/20 py-2 rounded-lg font-semibold transition">
                            Kategorien verwalten
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Verantwortliche (Admins)</h3>
                    <div class="space-y-4">
                        @foreach($recentUsers as $admin)
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 leading-none">{{ $admin->name }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase mt-1">{{ $admin->role }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-gray-500">
                © {{ date('Y') }} {{ $tenant->subdomain }} • ComplianceTermine Tool
            </p>
        </div>
    </footer>

</body>
</html>