@extends('layouts.tenant')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="mb-8 border-b pb-4">
        <h1 class="text-3xl font-bold text-slate-900">Kategorie: {{ $category->name }}</h1>
        <p class="text-slate-500 mt-2">Übersicht aller Mitarbeiter in dieser Schulungskategorie</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-sm font-bold">Mitarbeiter</th>
                    <th class="px-6 py-4 text-sm font-bold">Abschlussdatum</th>
                    <th class="px-6 py-4 text-sm font-bold">Fällig am (Due)</th>
                    <th class="px-6 py-4 text-sm font-bold">Zertifikat</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($category->trainings as $training)
                <tr>
                    <td class="px-6 py-4 font-bold text-blue-600">
                        <a href="{{ route('tenant.employees.show', [request()->tenantId, $training->employee->id]) }}">
                            {{ $training->employee->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $training->last_event_date->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 font-bold {{ $training->expiry_date->isPast() ? 'text-red-600' : '' }}">
                        {{ $training->expiry_date->format('d.m.Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($training->certificate_path)
                            <a href="{{ asset('storage/' . $training->certificate_path) }}" target="_blank" class="text-blue-500"><i class="fas fa-file-pdf"></i></a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection