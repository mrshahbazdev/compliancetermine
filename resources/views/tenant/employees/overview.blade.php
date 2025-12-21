@extends('layouts.tenant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Zuweisungs-Übersicht (Overview)</h1>
        <p class="text-slate-500 mt-2">Klicken Sie auf einen Namen oder eine Kategorie, um detaillierte Statusberichte zu sehen.</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-12">
        
        <div class="space-y-6">
            <h2 class="text-xl font-bold text-blue-700 border-b-2 border-blue-100 pb-2 flex items-center">
                <i class="fas fa-user-tag mr-2"></i>Mitarbeiter & ihre Kategorien
            </h2>
            <div class="grid gap-4">
                @foreach($employees as $emp)
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:border-blue-300 transition-colors">
                    <a href="{{ route('tenant.employees.show', ['tenantId' => request()->tenantId, 'employee' => $emp->id]) }}" 
                       class="font-bold text-slate-800 text-lg hover:text-blue-600 flex items-center group">
                        {{ $emp->name }}
                        <i class="fas fa-arrow-right ml-2 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </a>
                    
                    <div class="flex flex-wrap gap-2 mt-3">
                        @forelse($emp->trainings as $training)
                            <a href="{{ route('tenant.categories.show', ['tenantId' => request()->tenantId, 'category' => $training->category->id]) }}" 
                               class="bg-blue-50 text-blue-700 border border-blue-100 px-3 py-1 rounded-full text-xs font-semibold hover:bg-blue-100 transition">
                                {{ $training->category->name }}
                            </a>
                        @empty
                            <span class="text-slate-400 text-xs italic">Keine Kategorien zugewiesen</span>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <h2 class="text-xl font-bold text-emerald-700 border-b-2 border-emerald-100 pb-2 flex items-center">
                <i class="fas fa-tags mr-2"></i>Kategorien & ihre Mitarbeiter
            </h2>
            <div class="grid gap-4">
                @foreach($categories as $cat)
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:border-emerald-300 transition-colors">
                    <a href="{{ route('tenant.categories.show', ['tenantId' => request()->tenantId, 'category' => $cat->id]) }}" 
                       class="font-bold text-slate-800 text-lg hover:text-emerald-600 flex items-center group">
                        {{ $cat->name }}
                        <i class="fas fa-arrow-right ml-2 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </a>

                    <div class="flex flex-wrap gap-2 mt-3">
                        @forelse($cat->trainings as $training)
                            <a href="{{ route('tenant.employees.show', ['tenantId' => request()->tenantId, 'employee' => $training->employee->id]) }}" 
                               class="bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1 rounded-full text-xs font-semibold hover:bg-emerald-100 transition">
                                {{ $training->employee->name }}
                            </a>
                        @empty
                            <span class="text-slate-400 text-xs italic">Keine Mitarbeiter zugewiesen</span>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection