@extends('layouts.tenant')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="mb-8">
        <a href="{{ route('tenant.trainings.employee.index', [request()->tenantId, $training->employee_id]) }}" class="text-slate-400 hover:text-blue-600 transition flex items-center text-sm font-bold uppercase tracking-widest">
            <i class="fas fa-arrow-left mr-2"></i> Zurück zur Liste
        </a>
        <h2 class="text-3xl font-black text-slate-900 mt-4 italic">Eintrag bearbeiten</h2>
        <p class="text-slate-500 font-medium">Korrigieren Sie die Daten für: <span class="text-slate-800 font-bold">{{ $training->employee->name }}</span></p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
        <form action="{{ route('tenant.trainings.update', [request()->tenantId, $training->id]) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Schulungstyp</label>
                    <select name="category_id" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition font-bold text-slate-700">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $training->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Datum der Schulung</label>
                    <input type="date" name="last_event_date" value="{{ $training->last_event_date->format('Y-m-d') }}" 
                           class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition font-bold text-slate-700">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Gültigkeit (Tage)</label>
                    <input type="number" name="duration_days" value="{{ $training->duration_days }}" 
                           class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition font-bold text-slate-700">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Aktueller Status</label>
                    <div class="py-3 px-4 rounded-2xl bg-slate-100 flex items-center">
                        @if($training->status === 'planned')
                            <span class="w-3 h-3 bg-blue-500 rounded-full animate-pulse mr-2"></span>
                            <span class="text-xs font-black text-blue-600 uppercase">Geplant (Wartet auf Zertifikat)</span>
                        @else
                            <span class="w-3 h-3 bg-emerald-500 rounded-full mr-2"></span>
                            <span class="text-xs font-black text-emerald-600 uppercase">Abgeschlossen</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 text-blue-600">Neues Zertifikat hochladen (Optional)</label>
                <div class="relative group">
                    <input type="file" name="certificate" 
                           class="w-full bg-blue-50/50 border-2 border-dashed border-blue-200 rounded-2xl p-8 text-center cursor-pointer group-hover:border-blue-400 transition group-hover:bg-blue-50">
                    @if($training->certificate_path)
                        <p class="mt-2 text-[10px] text-slate-400 italic font-medium">
                            <i class="fas fa-paperclip mr-1"></i> Aktuelle Datei: {{ basename($training->certificate_path) }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="pt-6 flex items-center space-x-4">
                <button type="submit" class="flex-1 bg-slate-900 hover:bg-blue-600 text-white font-black py-4 rounded-2xl text-xs uppercase tracking-[0.2em] transition-all shadow-xl shadow-slate-200 hover:shadow-blue-500/30">
                    Änderungen speichern
                </button>
            </div>
        </form>

        <div class="bg-red-50/50 border-t border-red-100 p-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-black text-red-600 uppercase tracking-widest">Gefahrenzone</p>
                <p class="text-[10px] text-slate-400 font-medium">Diesen Eintrag dauerhaft löschen</p>
            </div>
            <form action="{{ route('tenant.trainings.destroy', [request()->tenantId, $training->id]) }}" method="POST" onsubmit="return confirm('Möchten Sie diesen Eintrag wirklich löschen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-white border border-red-200 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-sm">
                    Löschen
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.5);
        cursor: pointer;
    }
</style>
@endsection