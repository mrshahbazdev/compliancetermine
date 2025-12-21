@extends('layouts.tenant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Mitarbeiterliste</h1>
            <p class="text-slate-500 mt-1">
                @if(Auth::user()->isAdmin())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200 uppercase tracking-wider mr-2">
                        <i class="fas fa-crown mr-1"></i> Admin View
                    </span>
                    Alle Mitarbeiter im System verwalten.
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 uppercase tracking-wider mr-2">
                        <i class="fas fa-user-check mr-1"></i> Manager View
                    </span>
                    Ihre zugewiesenen Mitarbeiter verwalten.
                @endif
            </p>
        </div>

        @if(Auth::user()->isAdmin())
        <a href="{{ route('tenant.employees.create', ['tenantId' => request()->tenantId]) }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 transform active:scale-95">
            <i class="fas fa-plus mr-2"></i>Neuer Mitarbeiter
        </a>
        @endif
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-emerald-500 text-xl mr-3"></i>
                <p class="text-emerald-800 font-bold">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600"><i class="fas fa-times"></i></button>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Name</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Geburtsdatum</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Verantwortliche</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Aktionen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($employees as $employee)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs mr-3 border border-blue-100">
                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                </div>
                                <a href="{{ route('tenant.employees.show', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" 
                                class="font-bold text-slate-800 hover:text-blue-600 transition underline-offset-4 hover:underline">
                                    {{ $employee->name }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm font-medium">
                            {{ $employee->dob->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($employee->responsibles as $responsible)
                                    <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded border border-slate-200">
                                        {{ $responsible->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('tenant.trainings.employee.index', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" 
                                   class="inline-flex items-center text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg text-xs font-black transition border border-emerald-100 hover:border-emerald-200">
                                    <i class="fas fa-graduation-cap mr-1.5"></i> SCHULUNGEN
                                </a>

                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('tenant.employees.edit', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" 
                                   class="text-slate-400 hover:text-blue-600 transition" title="Bearbeiten">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('tenant.employees.destroy', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" method="POST" class="inline" onsubmit="return confirm('Mitarbeiter wirklich löschen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-600 transition" title="Löschen">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 text-slate-400 rounded-full mb-4 text-2xl">
                                <i class="fas fa-users"></i>
                            </div>
                            <p class="text-slate-500 font-bold">Keine Mitarbeiter gefunden.</p>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('tenant.employees.create', request()->tenantId) }}" class="text-blue-600 font-bold hover:underline text-sm mt-2 block">Leg jetzt einen an.</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection