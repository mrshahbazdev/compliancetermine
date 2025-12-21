@extends('layouts.tenant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Schulungskategorien</h1>
        <button onclick="toggleModal('add-category-modal')" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Neue Kategorie
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Name der Kategorie</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600 text-right">Aktionen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($categories as $category)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <a href="{{ route('tenant.categories.show', ['tenantId' => request()->tenantId, 'category' => $category->id]) }}" 
                        class="font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                            {{ $category->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('tenant.categories.destroy', ['tenantId' => request()->tenantId, 'category' => $category->id]) }}" method="POST" onsubmit="return confirm('Möchten Sie diese Kategorie wirklich löschen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="add-category-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl">
        <h2 class="text-2xl font-bold mb-6">Kategorie hinzufügen</h2>
        <form action="{{ route('tenant.categories.store', ['tenantId' => request()->tenantId]) }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Name (z.B. ADR-Zertifikat)</label>
                <input type="text" name="name" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="toggleModal('add-category-modal')" class="text-slate-500 font-medium">Abbrechen</button>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold">Speichern</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }
</script>
@endsection