@extends('layouts.tenant')

@section('content')
<div class="container mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-bold text-slate-800">Schulungen: {{ $employee->name }}</h1>
                <span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-widest {{ Auth::user()->isAdmin() ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                    {{ Auth::user()->isAdmin() ? 'Admin Mode' : 'Manager Mode' }}
                </span>
            </div>
            <p class="text-slate-500 mt-1">Verwaltung der gesetzlichen Fristen und Zertifikate.</p>
        </div>
        <a href="{{ route('tenant.employees.index', request()->tenantId) }}" class="text-slate-500 hover:text-slate-800 text-sm font-medium flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Zurück zur Liste
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-fit">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center">
                <i class="fas fa-calendar-plus text-blue-600 mr-2"></i> Termin erfassen
            </h3>
            <form action="{{ route('tenant.trainings.store', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategorie</label>
                    <select name="category_id" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Zertifikat (PDF/Bild)</label>
                    <div class="relative border-2 border-dashed border-slate-200 rounded-xl p-4 hover:border-blue-400 transition text-center group">
                        <input type="file" name="certificate" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-slate-300 text-2xl group-hover:text-blue-500 transition"></i>
                        <p class="text-[10px] text-slate-400 mt-1">Klicken oder Datei ziehen</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Datum der Schulung</label>
                    <input type="date" name="last_event_date" required class="w-full border border-slate-300 rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Gültigkeit (Tage)</label>
                    <input type="number" name="duration_days" value="365" required class="w-full border border-slate-300 rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <p class="text-[10px] text-slate-400 mt-1 italic">Standard: 1 Jahr = 365 Tage</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition transform active:scale-95">
                    <i class="fas fa-save mr-2"></i> Speichern
                </button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                <h3 class="font-bold text-slate-700 uppercase text-xs tracking-widest">Aktuelle Qualifikationen</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b">
                            <th class="px-6 py-4">Kategorie</th>
                            <th class="px-6 py-4">Letzter Termin</th>
                            <th class="px-6 py-4">Ablaufdatum</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Zertifikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($employee->trainings as $training)
                        @php
                            $daysLeft = round(now()->diffInDays($training->expiry_date, false));
                            $isExpired = $daysLeft < 0;
                            $isCritical = !$isExpired && $daysLeft <= 90;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-800 text-sm">{{ $training->category->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $training->last_event_date->format('d.m.Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold {{ $isExpired ? 'text-red-600' : ($isCritical ? 'text-orange-500' : 'text-slate-700') }}">
                                {{ $training->expiry_date->format('d.m.Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($isExpired)
                                    <span class="bg-red-600 text-white text-[9px] px-2 py-1 rounded-full font-black uppercase">Abgelaufen</span>
                                @elseif($isCritical)
                                    <span class="bg-orange-100 text-orange-700 text-[9px] px-2 py-1 rounded-full font-black uppercase">{{ $daysLeft }} Tage</span>
                                @else
                                    <span class="bg-emerald-100 text-emerald-700 text-[9px] px-2 py-1 rounded-full font-black uppercase">Gültig</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($training->certificate_path)
                                    <a href="{{ asset('storage/' . $training->certificate_path) }}" target="_blank" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                @else
                                    <span class="text-slate-300 text-xs italic">N/A</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if($employee->trainings->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <i class="fas fa-folder-open text-4xl mb-3 block opacity-20"></i>
                                    Keine Schulungsdaten vorhanden.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection