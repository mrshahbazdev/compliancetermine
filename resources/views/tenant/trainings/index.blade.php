@extends('layouts.tenant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Schulungen: {{ $employee->name }}</h1>
        <p class="text-slate-500">Hier können Sie die Termine für die verschiedenen Kategorien verwalten.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
            <h3 class="font-bold text-lg mb-4">Termin erfassen</h3>
            <form action="{{ route('tenant.trainings.store', ['tenantId' => request()->tenantId, 'employee' => $employee->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Kategorie</label>
                    <select name="category_id" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Zertifikat (PDF/Bild)</label>
                    <input type="file" name="certificate" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Letztes Ereignis</label>
                    <input type="date" name="last_event_date" required class="w-full border rounded-lg px-3 py-2 outline-none">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Gültigkeit (in Tagen)</label>
                    <input type="number" name="duration_days" value="365" required class="w-full border rounded-lg px-3 py-2 outline-none">
                    <p class="text-[10px] text-slate-400 mt-1">Standard: 365 Tage (1 Jahr)</p>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                    Speichern
                </button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold">Kategorie</th>
                        <th class="px-6 py-4 text-sm font-semibold">Letzter Termin</th>
                        <th class="px-6 py-4 text-sm font-semibold">Ablaufdatum</th>
                        <th class="px-6 py-4 text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold">Zertifikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($employee->trainings as $training)
                    @php
                        $daysLeft = now()->diffInDays($training->expiry_date, false);
                        $isCritical = $daysLeft <= 90;
                    @endphp
                    <tr class="{{ $isCritical ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 font-medium">{{ $training->category->name }}</td>
                        <td class="px-6 py-4">{{ $training->last_event_date->format('d.m.Y') }}</td>
                        <td class="px-6 py-4 font-bold {{ $isCritical ? 'text-red-600' : 'text-slate-700' }}">
                            {{ $training->expiry_date->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($daysLeft < 0)
                                <span class="bg-red-600 text-white text-[10px] px-2 py-1 rounded font-bold uppercase">Abgelaufen</span>
                            @elseif($isCritical)
                                <span class="bg-red-100 text-red-700 text-[10px] px-2 py-1 rounded font-bold uppercase">{{ $daysLeft }} Tage übrig</span>
                            @else
                                <span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded font-bold uppercase">Gültig</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($training->certificate_path)
                                <a href="{{ asset('storage/' . $training->certificate_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center">
                                    <i class="fas fa-file-download mr-1"></i> View
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">Kein Upload</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection