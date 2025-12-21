@extends('layouts.tenant')

@section('content')
<div class="container mx-auto pb-20">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ $employee->name }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-widest {{ Auth::user()->isAdmin() ? 'bg-red-100 text-red-600 border border-red-200' : 'bg-emerald-100 text-emerald-600 border border-emerald-200' }}">
                            {{ Auth::user()->isAdmin() ? 'Admin Mode' : 'Manager Mode' }}
                        </span>
                        <p class="text-slate-500 text-xs font-medium italic">Qualifikations-Akte</p>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('tenant.employees.index', request()->tenantId) }}" class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-slate-500 hover:text-slate-800 text-xs font-bold shadow-sm transition flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Zurück zur Liste
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-full -translate-y-12 translate-x-12"></div>
                
                <h3 class="font-black text-slate-800 mb-6 flex items-center relative z-10 text-sm uppercase tracking-wider">
                    <i class="fas fa-calendar-plus text-blue-600 mr-3"></i> Schulung Planen / Erfassen
                </h3>

                <form action="{{ route('tenant.trainings.store', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Wählen Sie die Kategorie</label>
                        <select name="category_id" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition shadow-inner">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Zertifikat Upload (Optional)</label>
                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-6 hover:border-blue-400 hover:bg-blue-50/50 transition text-center group">
                            <input type="file" name="certificate" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <i class="fas fa-file-upload text-slate-300 text-3xl group-hover:text-blue-500 transition mb-2"></i>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Datei hier ablegen</p>
                            <p class="text-[9px] text-slate-300 mt-1 italic">Kein Upload = Status "Geplant"</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Datum</label>
                            <input type="date" name="training_date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Gültigkeit</label>
                            <div class="relative">
                                <input type="number" name="duration_days" value="365" required class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner">
                                <span class="absolute right-4 top-3 text-[10px] font-bold text-slate-400">Tage</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-blue-600 shadow-xl shadow-slate-200 transition-all transform active:scale-95">
                        <i class="fas fa-check-double mr-2"></i> Datensatz Speichern
                    </button>
                </form>
            </div>

            <div class="bg-blue-600 rounded-[2rem] p-6 text-white shadow-lg">
                <h4 class="font-bold text-xs uppercase mb-3 flex items-center"><i class="fas fa-info-circle mr-2"></i> System-Hinweis</h4>
                <p class="text-[11px] leading-relaxed opacity-90 italic">
                    Wenn Sie nur ein Datum ohne Zertifikat speichern, wird der Termin im Kalender blau als <strong class="underline font-black">"Geplant"</strong> markiert. Nach dem Upload wechselt der Status automatisch.
                </p>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest flex items-center">
                        <i class="fas fa-history text-slate-400 mr-3"></i> Schulungshistorie
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 bg-slate-50/20">
                                <th class="px-8 py-5">Kategorie</th>
                                <th class="px-8 py-5 text-center">Status</th>
                                <th class="px-8 py-5">Datum</th>
                                <th class="px-8 py-5">Ablaufdatum</th>
                                <th class="px-8 py-5 text-right">Aktion</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($employee->trainings as $training)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <span class="font-black text-slate-800 text-sm tracking-tight">{{ $training->category->name }}</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @php
                                        $daysLeft = round(now()->diffInDays($training->expiry_date, false));
                                        $isPlanned = $training->status === 'planned';
                                        $isExpired = $daysLeft < 0 && !$isPlanned;
                                        $isCritical = !$isExpired && $daysLeft <= 90 && !$isPlanned;
                                    @endphp

                                    @if($isPlanned)
                                        <span class="px-3 py-1.5 bg-blue-100 text-blue-600 text-[9px] font-black rounded-xl border border-blue-200 uppercase tracking-tighter">
                                            <i class="fas fa-clock mr-1"></i> Geplant
                                        </span>
                                    @elseif($isExpired)
                                        <span class="px-3 py-1.5 bg-red-600 text-white text-[9px] font-black rounded-xl border border-red-700 uppercase tracking-tighter">
                                            Abgelaufen
                                        </span>
                                    @elseif($isCritical)
                                        <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-[9px] font-black rounded-xl border border-orange-200 uppercase tracking-tighter">
                                            {{ $daysLeft }} Tage
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded-xl border border-emerald-200 uppercase tracking-tighter">
                                            Gültig
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-sm text-slate-500 font-medium">
                                    {{ ($training->training_date ?? $training->last_event_date)->format('d.m.Y') }}
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black {{ $isExpired ? 'text-red-600' : 'text-slate-700' }}">
                                            {{ optional($training->expiry_date)->format('d.m.Y') ?? 'N/A' }}
                                        </span>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Frist</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if($training->certificate_path)
                                        <a href="{{ asset('storage/' . $training->certificate_path) }}" target="_blank" 
                                           class="inline-flex items-center justify-center w-10 h-10 bg-slate-900 text-white rounded-2xl hover:bg-blue-600 shadow-lg shadow-slate-200 transition transform hover:-translate-y-0.5">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @else
                                        <div class="group relative inline-block">
                                            <span class="w-10 h-10 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 border border-dashed border-slate-200">
                                                <i class="fas fa-file-slash"></i>
                                            </span>
                                            <div class="absolute bottom-full right-0 mb-2 hidden group-hover:block bg-slate-800 text-white text-[9px] p-2 rounded w-24 text-center">Kein Zertifikat</div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-white shadow-inner">
                                        <i class="fas fa-folder-open text-3xl"></i>
                                    </div>
                                    <p class="text-slate-400 text-xs font-black uppercase tracking-widest italic leading-loose">
                                        Keine Daten für diesen Mitarbeiter vorhanden.<br>Planen Sie jetzt die erste Schulung.
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Hover & Animation States */
    tr:last-child { border-bottom: none; }
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.5);
        cursor: pointer;
    }
    /* Smooth transition for all elements */
    * { transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 200ms; }
</style>
@endsection