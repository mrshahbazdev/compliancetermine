@extends('layouts.tenant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-slate-800 mb-8">Zuweisungs-Übersicht (Overview)</h1>

    <div class="grid lg:grid-cols-2 gap-12">
        
        <div class="space-y-6">
            <h2 class="text-xl font-bold text-blue-700 border-b-2 border-blue-100 pb-2">
                <i class="fas fa-user-tag mr-2"></i>Mitarbeiter & ihre Kategorien
            </h2>
            <div class="space-y-4">
                @foreach($employees as $emp)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
                    <div class="font-bold text-slate-800 text-lg mb-2">{{ $emp->name }}</div>
                    <div class="flex flex-wrap gap-2">
                        @forelse($emp->trainings as $training)
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $training->category->name }}
                            </span>
                        @empty
                            <span class="text-slate-400 text-xs italic">Keine Kategorien zugewiesen</span>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <h2 class="text-xl font-bold text-emerald-700 border-b-2 border-emerald-100 pb-2">
                <i class="fas fa-tags mr-2"></i>Kategorien & ihre Mitarbeiter
            </h2>
            <div class="space-y-4">
                @foreach($categories as $cat)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
                    <div class="font-bold text-slate-800 text-lg mb-2">{{ $cat->name }}</div>
                    <div class="flex flex-wrap gap-2">
                        @forelse($cat->trainings as $training)
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $training->employee->name }}
                            </span>
                        @empty
                            <span class="text-slate-400 text-xs italic">Keine Mitarbeiter in dieser Kategorie</span>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection