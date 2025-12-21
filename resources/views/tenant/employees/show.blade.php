@extends('layouts.tenant')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ $employee->name }}</h1>
            <p class="text-slate-500">Geburtsdatum: {{ $employee->dob->format('d.m.Y') }}</p>
        </div>
        <a href="{{ route('tenant.trainings.employee.index', [request()->tenantId, $employee->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold">
            <i class="fas fa-plus mr-2"></i>Training bearbeiten
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-sm font-bold">Kategorie</th>
                    <th class="px-6 py-4 text-sm font-bold">Zuletzt abgeschlossen</th>
                    <th class="px-6 py-4 text-sm font-bold">Nächster Termin (Due)</th>
                    <th class="px-6 py-4 text-sm font-bold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($employee->trainings as $training)
                <tr>
                    <td class="px-6 py-4 font-medium">{{ $training->category->name }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $training->last_event_date->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 font-bold">{{ $training->expiry_date->format('d.m.Y') }}</td>
                    <td class="px-6 py-4">
                        @if($training->expiry_date->isPast())
                            <span class="text-red-600 font-bold uppercase text-xs">Abgelaufen</span>
                        @else
                            <span class="text-green-600 font-bold uppercase text-xs">Gültig</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection