@extends('layouts.tenant')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Willkommen zurück, {{ Auth::user()->name }}! 👋
            </h2>
            <p class="text-slate-500 mt-2 font-medium">
                Überblick über die gesetzlichen Fristen von <span class="text-blue-600">{{ ucfirst($tenant->subdomain) }}</span>
            </p>
        </div>
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 hidden md:block text-right">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aktuelles Datum</p>
            <p class="text-lg font-black text-blue-600 leading-none mt-1">{{ now()->format('d.m.Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Mitarbeiter</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['total_employees'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-50 w-12 h-12 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-50 flex items-center text-[10px] text-slate-400 font-bold uppercase">
                <i class="fas fa-database mr-2"></i> System-Bestand
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Kategorien</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['total_categories'] ?? 0 }}</p>
                </div>
                <div class="bg-indigo-50 w-12 h-12 rounded-xl flex items-center justify-center text-indigo-600">
                    <i class="fas fa-tags text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-50 text-[10px] text-slate-400 font-bold uppercase">
                z.B. ADR, Stapler, Ersthelfer
            </div>
        </div>

        <div class="bg-red-50 border border-red-100 rounded-2xl shadow-sm p-6 transition hover:shadow-md relative overflow-hidden group">
            <div class="absolute -right-2 -top-2 text-red-100 opacity-50 group-hover:scale-110 transition duration-500">
                <i class="fas fa-exclamation-triangle text-6xl"></i>
            </div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-xs font-bold uppercase tracking-wider italic">Kritisch (< 90 Tage)</p>
                    <p class="text-3xl font-black text-red-700 mt-1">{{ $stats['critical_trainings'] ?? 0 }}</p>
                </div>
                <div class="bg-red-500 w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-200 animate-pulse">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-red-100 flex items-center text-[10px] text-red-500 font-bold uppercase">
                <i class="fas fa-bell mr-2"></i> Handlungsbedarf
            </div>
        </div>

        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl shadow-sm p-6 transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-600 text-xs font-bold uppercase tracking-wider">Zertifikate</p>
                    <p class="text-3xl font-black text-emerald-700 mt-1">{{ $stats['total_certificates'] ?? 0 }}</p>
                </div>
                <div class="bg-emerald-500 w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-emerald-100 text-[10px] text-emerald-600 font-bold uppercase">
                Gültige Nachweise im Archiv
            </div>
        </div>

    </div>

    <div class="grid lg:grid-cols-3 gap-8 mb-12">
        
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-800 flex items-center">
                    <i class="fas fa-calendar-check text-blue-600 mr-2"></i>
                    Anstehende Termine
                </h3>
                <a href="{{ route('tenant.calendar', ['tenantId' => request()->tenantId]) }}" class="text-blue-600 text-xs font-black uppercase tracking-widest hover:text-blue-800">Alle anzeigen</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-white border-b border-slate-100">
                            <th class="px-6 py-4">Mitarbeiter</th>
                            <th class="px-6 py-4">Schulung</th>
                            <th class="px-6 py-4">Fälligkeit</th>
                            <th class="px-6 py-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($expiringTrainings as $training)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-bold text-slate-900 text-sm">{{ $training->employee->name }}</td>
                                <td class="px-6 py-4 text-slate-600 text-sm">
                                    <span class="bg-slate-100 px-2 py-1 rounded text-xs">{{ $training->category->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 text-sm font-medium">{{ $training->expiry_date->format('d.m.Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    @php
                                        // Aaj ki date aur expiry ka farq nikaal kar round kar rahe hain
                                        $daysLeft = round(now()->diffInDays($training->expiry_date, false));
                                    @php

                                    @if($daysLeft < 0)
                                        {{-- Expired Case --}}
                                        <span class="px-3 py-1 bg-red-600 text-white text-[10px] font-black rounded-full uppercase tracking-tighter">
                                            Abgelaufen ({{ abs($daysLeft) }} Tage)
                                        </span>
                                    @elseif($daysLeft <= 90)
                                        {{-- Critical Case --}}
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-[10px] font-black rounded-full uppercase tracking-tighter">
                                            Kritisch ({{ $daysLeft }} Tage)
                                        </span>
                                    @else
                                        {{-- OK Case --}}
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase tracking-tighter">
                                            {{ $daysLeft }} Tage verbleibend
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <i class="fas fa-check-circle text-slate-200 text-4xl mb-3"></i>
                                    <p class="text-slate-400 text-sm font-medium">Alles im grünen Bereich!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-4 translate-y-4 group-hover:scale-125 transition duration-700">
                    <i class="fas fa-rocket text-8xl"></i>
                </div>
                <h3 class="font-bold mb-4 flex items-center relative z-10">
                    <i class="fas fa-bolt text-yellow-400 mr-2"></i> Schnellzugriff
                </h3>
                <div class="space-y-3 relative z-10">
                    <a href="{{ route('tenant.employees.create', ['tenantId' => request()->tenantId]) }}" class="flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-xl font-bold text-sm transition transform active:scale-95 shadow-lg shadow-blue-900/20">
                        <i class="fas fa-plus mr-2"></i> Neuer Mitarbeiter
                    </a>
                    <a href="{{ route('tenant.categories.index', ['tenantId' => request()->tenantId]) }}" class="flex items-center justify-center w-full bg-white/10 hover:bg-white/20 py-3 rounded-xl font-bold text-sm transition">
                        <i class="fas fa-cog mr-2"></i> Kategorien pflegen
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="font-bold text-slate-800 mb-5 flex items-center justify-between">
                    <span>Verantwortliche</span>
                    <i class="fas fa-user-shield text-slate-300"></i>
                </h3>
                <div class="space-y-4">
                    @foreach($recentUsers as $admin)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-black shadow-inner">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 leading-none">{{ $admin->name }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-wider">{{ $admin->role }}</p>
                                </div>
                            </div>
                            <div class="w-2 h-2 rounded-full {{ $admin->is_active ? 'bg-green-500' : 'bg-slate-300' }}"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<footer class="mt-auto py-6 text-center border-t border-slate-200">
    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
        © {{ date('Y') }} {{ $tenant->subdomain }} • Powered by ComplianceTermine
    </p>
</footer>
@endsection