@extends('layouts.tenant')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Mitarbeiter bearbeiten</h1>
        <p class="text-slate-500">Daten von {{ $employee->name }} aktualisieren.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('tenant.employees.update', [request()->tenantId, $employee->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Vollständiger Name</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}" 
                           class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Geburtsdatum</label>
                    <input type="date" name="dob" value="{{ old('dob', $employee->dob->format('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Verantwortliche (Max. 3)</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        @foreach($users as $user)
                            <label class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-white rounded-lg transition">
                                <input type="checkbox" name="responsible_ids[]" value="{{ $user->id }}"
                                    {{ in_array($user->id, $selectedResponsibles) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm font-medium text-slate-700">{{ $user->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 flex items-center justify-between border-t border-slate-100">
                    <a href="{{ route('tenant.employees.index', request()->tenantId) }}" class="text-slate-500 font-bold hover:text-slate-700">Abbrechen</a>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
                        Änderungen speichern
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection