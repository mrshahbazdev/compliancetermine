@extends('layouts.tenant')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-4xl font-black text-slate-900 tracking-tight italic">
                Willkommen, {{ explode(' ', Auth::user()->name)[0] }}! 👋
            </h2>
            <p class="text-slate-500 font-medium flex items-center">
                <i class="fas fa-chart-line mr-2 text-blue-500"></i>
                Hier ist der aktuelle Status von <span class="mx-1 font-bold text-slate-700 underline decoration-blue-500/30 decoration-4">{{ ucfirst($tenant->subdomain) }}</span>
            </p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-3 transition hover:shadow-md">
                <div class="bg-blue-50 p-2 rounded-lg text-blue-600">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Datum</p>
                    <p class="text-sm font-extrabold text-slate-800 mt-1 leading-none">{{ now()->format('d. F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <a href="{{ route('tenant.employees.index', request()->tenantId) }}" 
           class="group bg-white border border-slate-200 rounded-3xl p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-blue-500/50 relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 text-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500 transform group-hover:scale-110">
                <i class="fas fa-users text-8xl"></i>
            </div>
            <div class="relative flex items-center justify-between">
                <div class="space-y-1">
                    <p class="text-slate-500 text-[11px] font-black uppercase tracking-widest group-hover:text-blue-600 transition">Mitarbeiter</p>
                    <p class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stats['total_employees'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-600 w-14 h-14 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-user-friends text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-50 flex items-center text-[10px] font-bold text-slate-400 uppercase group-hover:text-blue-500">
                <i class="fas fa-external-link-alt mr-2"></i> Details ansehen
            </div>
        </a>

        <div class="group bg-red-600 border border-red-700 rounded-3xl p-6 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:bg-red-700 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-full -translate-x-8 -translate-y-8 blur-2xl"></div>
            <div class="relative flex items-center justify-between">
                <div class="space-y-1">
                    <p class="text-red-100 text-[11px] font-black uppercase tracking-widest italic opacity-80">Abgelaufen</p>
                    <p class="text-4xl font-black text-white tracking-tighter">{{ $stats['expired'] ?? 0 }}</p>
                </div>
                <div class="bg-white/20 backdrop-blur-md w-14 h-14 rounded-2xl flex items-center justify-center text-white border border-white/30 animate-pulse group-hover:animate-none">
                    <i class="fas fa-exclamation-triangle text-xl text-yellow-300"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-white/20 flex items-center text-[10px] font-bold text-white uppercase italic">
                <i class="fas fa-bolt mr-2 text-yellow-300"></i> Kritische Fehler
            </div>
        </div>

        <div class="group bg-orange-500 border border-orange-600 rounded-3xl p-6 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:bg-orange-600 relative overflow-hidden">
            <div class="relative flex items-center justify-between">
                <div class="space-y-1">
                    <p class="text-orange-50 text-[11px] font-black uppercase tracking-widest opacity-80 italic">Ablaufend (30T)</p>
                    <p class="text-4xl font-black text-white tracking-tighter">{{ $stats['warning'] ?? 0 }}</p>
                </div>
                <div class="bg-white/20 w-14 h-14 rounded-2xl flex items-center justify-center text-white">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-white/20 flex items-center text-[10px] font-bold text-white uppercase">
                <i class="fas fa-hourglass-half mr-2"></i> Demnächst fällig
            </div>
        </div>

        <div class="group bg-indigo-600 border border-indigo-700 rounded-3xl p-6 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:bg-indigo-700 relative overflow-hidden text-white">
            <div class="relative flex items-center justify-between">
                <div class="space-y-1">
                    <p class="text-indigo-100 text-[11px] font-black uppercase tracking-widest opacity-80">Geplant</p>
                    <p class="text-4xl font-black text-white tracking-tighter">{{ $stats['planned'] ?? 0 }}</p>
                </div>
                <div class="bg-white w-14 h-14 rounded-2xl flex items-center justify-center text-indigo-600 shadow-lg group-hover:rotate-12 transition-transform">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-indigo-500/50 flex items-center text-[10px] font-bold text-indigo-100 uppercase">
                <i class="fas fa-tasks mr-2"></i> Offene Termine
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-800 tracking-tight uppercase text-sm">Dringende Termine</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Top 10 fällige Schulungen</p>
                    </div>
                </div>
                <a href="{{ route('tenant.calendar', ['tenantId' => request()->tenantId]) }}" 
                   class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-slate-50 transition shadow-sm">
                    Kalender öffnen
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/30 border-b border-slate-100">
                            <th class="px-8 py-5">Mitarbeiter</th>
                            <th class="px-8 py-5">Schulung</th>
                            <th class="px-8 py-5">Fälligkeit</th>
                            <th class="px-8 py-5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($expiringTrainings as $training)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center text-xs font-bold group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                                            {{ strtoupper(substr($training->employee->name, 0, 1)) }}
                                        </div>
                                        <span class="font-bold text-slate-700 text-sm tracking-tight">{{ $training->employee->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter group-hover:bg-white transition">
                                        {{ $training->category->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-slate-700 text-sm font-black">{{ $training->expiry_date->format('d.m.Y') }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold">{{ $training->expiry_date->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @php
                                        $daysLeft = round(now()->startOfDay()->diffInDays($training->expiry_date->startOfDay(), false));
                                    @endphp
                                    @if($daysLeft < 0)
                                        <span class="px-3 py-1.5 bg-red-100 text-red-600 text-[10px] font-black rounded-xl border border-red-200 uppercase tracking-tighter">
                                            Überfällig
                                        </span>
                                    @elseif($daysLeft <= 30)
                                        <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-[10px] font-black rounded-xl border border-orange-200 uppercase tracking-tighter">
                                            Binnen {{ $daysLeft }} Tagen
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-xl border border-emerald-200 uppercase tracking-tighter">
                                            Noch {{ $daysLeft }} Tage
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-400 italic font-bold uppercase text-xs tracking-widest">
                                    Keine dringenden Termine.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-32 h-32 bg-blue-500/20 rounded-full -translate-x-4 -translate-y-8 blur-3xl"></div>
                <h3 class="font-black text-xs uppercase tracking-[0.2em] mb-6 flex items-center text-blue-400">
                    <i class="fas fa-bolt mr-2"></i> Schnellzugriff
                </h3>
                <div class="space-y-4 relative z-10">
                    <a href="{{ route('tenant.employees.create', ['tenantId' => request()->tenantId]) }}" 
                       class="group/btn flex items-center justify-between w-full bg-blue-600 hover:bg-white hover:text-blue-600 p-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-lg shadow-blue-900/50">
                        <span>Neuer Mitarbeiter</span>
                        <i class="fas fa-plus transition-transform group-hover/btn:rotate-90"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm italic">Verantwortliche</h3>
                    <i class="fas fa-shield-alt text-slate-200 text-xl"></i>
                </div>
                <div class="space-y-6">
                    @foreach($recentUsers as $admin)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center space-x-4">
                                <div class="w-11 h-11 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center text-sm font-black border border-slate-100 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow-sm">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm font-black text-slate-900 tracking-tight leading-none">{{ $admin->name }}</p>
                                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Administrator</p>
                                </div>
                            </div>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <footer class="py-12 flex flex-col items-center justify-center space-y-4 text-slate-300">
        <div class="h-px w-24 bg-slate-200"></div>
        <p class="text-[10px] font-black uppercase tracking-[0.4em]">
            © {{ date('Y') }} {{ strtoupper($tenant->subdomain) }} • COMPLIANCETERMINE
        </p>
    </footer>
</div>

<style>
    .shadow-sm { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05); }
    .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); }
    * { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 200ms; }
</style>
@endsection