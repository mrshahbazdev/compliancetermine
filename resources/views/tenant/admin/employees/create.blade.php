@extends('layouts.tenant')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="{{ route('tenant.employees.index', request()->tenantId) }}" class="text-blue-600 font-medium hover:underline">
            <i class="fas fa-arrow-left mr-2"></i>Zurück zur Liste
        </a>
        <h1 class="text-3xl font-bold text-slate-800 mt-4">Mitarbeiter anlegen</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('tenant.employees.store', request()->tenantId) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Vollständiger Name</label>
                    <input type="text" name="name" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Geburtsdatum</label>
                    <input type="date" name="dob" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="mb-8 border-t border-slate-100 pt-6">
                <label class="block text-sm font-medium text-slate-700 mb-4">
                    Verantwortliche Personen (Max. 3 auswählen)
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($users as $user)
                        <label class="flex items-center p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer transition">
                            <input type="checkbox" name="responsible_ids[]" value="{{ $user->id }}" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 mr-3">
                            <span class="text-slate-700">{{ $user->name }} ({{ $user->email }})</span>
                        </label>
                    @endforeach
                </div>
                @error('responsible_ids')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                Mitarbeiter Speichern
            </button>
        </form>
    </div>
</div>
@endsection