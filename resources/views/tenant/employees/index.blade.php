@extends('layouts.tenant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Mitarbeiterliste</h1>
            <p class="text-slate-500">Verwaltung der Mitarbeiter und ihrer Verantwortlichen.</p>
        </div>
        <a href="{{ route('tenant.employees.create', ['tenantId' => request()->tenantId]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Neuer Mitarbeiter
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Name</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Geburtsdatum</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Verantwortliche</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600 text-right">Aktionen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($employees as $employee)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-800">{{ $employee->name }}</div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $employee->dob->format('d.m.Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach($employee->responsibles as $responsible)
                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full border border-blue-200">
                                    {{ $responsible->name }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('tenant.employees.edit', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('tenant.employees.destroy', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" method="POST" class="inline" onsubmit="return confirm('Mitarbeiter wirklich löschen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                        Keine Mitarbeiter gefunden. <a href="{{ route('tenant.employees.create', request()->tenantId) }}" class="text-blue-600 hover:underline">Leg jetzt einen an.</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection