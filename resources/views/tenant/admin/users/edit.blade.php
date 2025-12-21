<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer bearbeiten - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="{ showPassword: false, selectedRole: '{{ $user->role }}' }">

    @include('tenant.partials.nav')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('tenant.admin.users.index', ['tenantId' => $tenant->id]) }}" 
                   class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Benutzer bearbeiten</h1>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
            
            <span class="px-4 py-2 rounded-full text-xs font-black uppercase border {{ $user->role === 'admin' ? 'bg-red-50 text-red-600 border-red-200' : 'bg-blue-50 text-blue-600 border-blue-200' }}">
                {{ $user->role }}
            </span>
        </div>

        <form method="POST" action="{{ route('tenant.admin.users.update', ['tenantId' => $tenant->id, 'user' => $user->id]) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user-circle text-blue-600 mr-2"></i> Stammdaten
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Vollständiger Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">E-Mail-Adresse</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-key text-blue-600 mr-2"></i> Passwort ändern
                        </h2>
                        <p class="text-xs text-gray-500 mb-4 italic">Leer lassen, wenn das Passwort nicht geändert werden soll.</p>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Neues Passwort"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                                <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-gray-400">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                            <div>
                                <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" placeholder="Passwort bestätigen"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user-shield text-blue-600 mr-2"></i> Benutzerrolle
                        </h2>

                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer group">
                                <input type="radio" name="role" value="admin" x-model="selectedRole" class="sr-only">
                                <div :class="selectedRole === 'admin' ? 'border-red-500 bg-red-50' : 'border-gray-200'" 
                                     class="p-4 border-2 rounded-xl transition hover:border-red-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <i class="fas fa-crown" :class="selectedRole === 'admin' ? 'text-red-600' : 'text-gray-400'"></i>
                                        <div x-show="selectedRole === 'admin'" class="w-4 h-4 bg-red-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-[8px] text-white"></i>
                                        </div>
                                    </div>
                                    <p class="font-bold text-sm">Superuser</p>
                                    <p class="text-[10px] text-gray-500">Voller Systemzugriff</p>
                                </div>
                            </label>

                            <label class="cursor-pointer group">
                                <input type="radio" name="role" value="standard" x-model="selectedRole" class="sr-only">
                                <div :class="selectedRole === 'standard' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'" 
                                     class="p-4 border-2 rounded-xl transition hover:border-blue-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <i class="fas fa-user-check" :class="selectedRole === 'standard' ? 'text-blue-600' : 'text-gray-400'"></i>
                                        <div x-show="selectedRole === 'standard'" class="w-4 h-4 bg-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-[8px] text-white"></i>
                                        </div>
                                    </div>
                                    <p class="font-bold text-sm">Verantwortlicher</p>
                                    <p class="text-[10px] text-gray-500">Eingeschränkter Zugriff</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-widest">Account Status</h2>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium">Aktiviert</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-3 italic">Inaktive Benutzer können sich nicht anmelden.</p>
                    </div>

                    <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-200">
                        <h2 class="text-xs font-bold uppercase mb-4 opacity-75">System-Info</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] opacity-75">Mitglied seit</p>
                                <p class="text-sm font-bold">{{ $user->created_at->format('d.m.Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] opacity-75">Letztes Update</p>
                                <p class="text-sm font-bold">{{ $user->updated_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <div class="pt-4 border-t border-white/20 text-center">
                                <p class="text-[10px] opacity-75 italic">Benutzer-ID: {{ $user->id }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                            <i class="fas fa-save mr-2"></i> Speichern
                        </button>
                        <a href="{{ route('tenant.admin.users.index', ['tenantId' => $tenant->id]) }}" class="block text-center w-full bg-white border border-gray-300 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition">
                            Abbrechen
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>
</html>