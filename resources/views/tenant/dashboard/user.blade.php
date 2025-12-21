@extends('layouts.tenant')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Hallo, {{ Auth::user()->name }}! 👋
            </h2>
            <p class="text-slate-500 mt-2 font-medium">
                Überblick über Ihre zugewiesenen Mitarbeiter und Fristen.
            </p>
        </div>
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 hidden md:block text-right">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aktuelles Datum</p>
            <p class="text-lg font-black text-blue-600 leading-none mt-1">{{ now()->format('d.m.Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Meine Mitarbeiter</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['total_employees'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-50 w-12 h-12 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
            </div>
            <p class="mt-4 text-[10px] text-slate-400 font-bold uppercase italic">Ihnen direkt zugeordnet</p>
        </div>

        <div class="bg-red-50 border border-red-100 rounded-2xl shadow-sm p-6 relative group">
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-xs font-bold uppercase tracking-wider italic">Kritisch (< 90 Tage)</p>
                    <p class="text-3xl font-black text-red-700 mt-1">{{ $stats['critical_trainings'] ?? 0 }}</p>
                </div>
                <div class="bg-red-500 w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-200">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
            <p class="mt-4 text-[10px] text-red-500 font-bold uppercase">Handlungsbedarf</p>
        </div>

        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-600 text-xs font-bold uppercase tracking-wider">Zertifikate</p>
                    <p class="text-3xl font-black text-emerald-700 mt-1">{{ $stats['total_certificates'] ?? 0 }}</p>
                </div>
                <div class="bg-emerald-500 w-12 h-12 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>
            </div>
            <p class="mt-4 text-[10px] text-emerald-600 font-bold uppercase">Gültige Nachweise</p>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-12">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 flex items-center">
                <i class="fas fa-list-ul text-blue-600 mr-2"></i>
                Meine anstehenden Termine
            </h3>
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
                                    $daysLeft = round(now()->diffInDays($training->expiry_date, false));
                                @endphp
                                @if($daysLeft < 0)
                                    <span class="px-3 py-1 bg-red-600 text-white text-[10px] font-black rounded-full uppercase tracking-tighter">
                                        Abgelaufen ({{ abs($daysLeft) }} Tage)
                                    </span>
                                @elseif($daysLeft <= 90)
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 text-[10px] font-black rounded-full uppercase tracking-tighter">
                                        {{ $daysLeft }} Tage
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase tracking-tighter">
                                        Gültig
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <i class="fas fa-check-circle text-slate-200 text-4xl mb-3"></i>
                                <p class="text-slate-400 text-sm font-medium">Keine anstehenden Termine für Ihre Mitarbeiter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection