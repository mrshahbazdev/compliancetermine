<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerverwaltung - {{ $tenant->subdomain }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .user-row { transition: all 0.3s ease; }
        .user-row:hover { background-color: #F9FAFB; transform: translateX(4px); }
    </style>
</head>
<body class="bg-gray-50" x-data="{ deleteModal: false, selectedUser: null, selectedUserName: '' }">

    @include('tenant.partials.nav')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-user-shield text-blue-600 mr-3"></i>
                        Benutzerverwaltung
                    </h1>
                    <p class="text-gray-600 mt-2">Verwalten Sie die Verantwortlichen und Administratoren Ihrer Organisation</p>
                </div>
                <a href="{{ route('tenant.admin.users.create', ['tenantId' => $tenant->id]) }}" 
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg transform hover:scale-105 inline-flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>Neuer Benutzer
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Gesamt</p>
                <p class="text-3xl font-black text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-green-500 uppercase font-bold tracking-wider">Aktiv</p>
                <p class="text-3xl font-black text-green-600">{{ $stats['active_users'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-red-500 uppercase font-bold tracking-wider">Admins</p>
                <p class="text-3xl font-black text-red-600">{{ $stats['admins'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-blue-500 uppercase font-bold tracking-wider">Standard</p>
                <p class="text-3xl font-black text-blue-600">{{ $stats['standard'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                    <input type="text" id="searchInput" onkeyup="filterUsers()" placeholder="Suche nach Name oder E-Mail..." 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <select id="roleFilter" onchange="filterUsers()" class="px-4 py-2.5 border border-gray-300 rounded-lg outline-none">
                    <option value="">Alle Rollen</option>
                    <option value="admin">Admin</option>
                    <option value="standard">Standard</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Benutzer</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Rolle</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Beigetreten</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Aktionen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="usersTableBody">
                    @forelse($users as $user)
                        <tr class="user-row" 
                            data-name="{{ strtolower($user->name) }}" 
                            data-email="{{ strtolower($user->email) }}"
                            data-role="{{ $user->role }}"
                            data-status="{{ $user->is_active ? 'active' : 'inactive' }}">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold mr-3 shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $user->role === 'admin' ? 'bg-red-50 text-red-600 border-red-200' : 'bg-blue-50 text-blue-600 border-blue-200' }}">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <form method="POST" action="{{ route('tenant.admin.users.toggle-status', ['tenantId' => $tenant->id, 'user' => $user->id]) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        <i class="fas fa-circle mr-1 text-[8px]"></i>
                                        {{ $user->is_active ? 'AKTIV' : 'INAKTIV' }}
                                    </button>
                                </form>
                            </td>

                            <td class="px-6 py-4 text-center text-sm text-gray-600">
                                {{ $user->created_at->format('d.m.Y') }}
                            </td>

                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('tenant.admin.users.edit', ['tenantId' => $tenant->id, 'user' => $user->id]) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== Auth::id())
                                    <button @click="selectedUser = {{ $user->id }}; selectedUserName = '{{ $user->name }}'; deleteModal = true" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Keine Benutzer gefunden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" style="display: none;">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-2xl" @click.away="deleteModal = false">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Benutzer löschen?</h3>
                <p class="text-gray-500 mt-2">Sind Sie sicher, dass Sie <span class="font-bold text-gray-900" x-text="selectedUserName"></span> löschen möchten? Dieser Vorgang kann nicht rückgängig gemacht werden.</p>
            </div>
            <div class="flex gap-3 mt-8">
                <button @click="deleteModal = false" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg font-bold text-gray-700 hover:bg-gray-50">Abbrechen</button>
                <form :action="'/tenant/{{ $tenant->id }}/admin/users/' + selectedUser" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700">Löschen</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function filterUsers() {
            let search = document.getElementById('searchInput').value.toLowerCase();
            let role = document.getElementById('roleFilter').value;
            let rows = document.querySelectorAll('.user-row');

            rows.forEach(row => {
                let text = row.dataset.name + row.dataset.email;
                let userRole = row.dataset.role;
                let matchesSearch = text.includes(search);
                let matchesRole = role === "" || userRole === role;
                row.style.display = (matchesSearch && matchesRole) ? "" : "none";
            });
        }
    </script>

</body>
</html>