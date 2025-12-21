<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Compliance Management</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        
        [x-cloak] { display: none !important; }

        .sidebar-link-active {
            background: linear-gradient(to right, rgba(37, 99, 235, 0.1), rgba(37, 99, 235, 0));
            color: #2563eb;
            border-left: 4px solid #2563eb;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900" x-data="{ mobileSidebarOpen: false }">

    <div x-show="mobileSidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         @click="mobileSidebarOpen = false"
         class="fixed inset-0 bg-slate-900/50 z-40 md:hidden" x-cloak></div>

    <div class="flex h-screen overflow-hidden">
        
        <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 z-50 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shadow-xl md:shadow-none">
            
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-800">Compliance<span class="text-blue-600">Termine</span></span>
                </div>
                <button @click="mobileSidebarOpen = false" class="md:hidden text-slate-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar">
                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-4">Main Menu</p>
                
                <a href="{{ route('tenant.dashboard', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('tenant.dashboard') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-chart-pie mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="font-medium text-sm">Dashboard</span>
                </a>
                
                <a href="{{ route('tenant.employees.overview', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('tenant.employees.overview') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-layer-group mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="font-medium text-sm">Übersicht (Matrix)</span>
                </a>

                <a href="{{ route('tenant.calendar', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('tenant.calendar') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-calendar-alt mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="font-medium text-sm">Terminkalender</span>
                </a>

                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Management</p>

                <a href="{{ route('tenant.employees.index', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('tenant.employees.*') && !request()->routeIs('tenant.employees.overview') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-users mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="font-medium text-sm">Mitarbeiter</span>
                </a>

                <a href="{{ route('tenant.categories.index', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('tenant.categories.*') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-tags mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="font-medium text-sm">Kategorien</span>
                </a>

                @if(Auth::user()->isAdmin())
                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Administration</p>
                <a href="{{ route('tenant.admin.users.index', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('tenant.admin.users.*') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-user-shield mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="font-medium text-sm">Benutzerverwaltung</span>
                </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex items-center p-2 mb-2">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-slate-500 uppercase">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('tenant.logout', ['tenantId' => request()->tenantId]) }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-red-100 rounded-lg text-xs font-bold transition">
                        <i class="fas fa-sign-out-alt mr-3"></i> Abmelden
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 bg-slate-50">
            
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
                <div class="flex items-center">
                    <button @click="mobileSidebarOpen = true" class="md:hidden p-2 text-slate-600 mr-2">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="hidden sm:flex items-center text-xs text-slate-400">
                        <i class="fas fa-building mr-2"></i> 
                        Mandant: <span class="ml-1 font-bold text-slate-700 uppercase tracking-tight">{{ request()->tenantId }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="hidden md:block text-right mr-2">
                        <p class="text-[10px] font-bold text-slate-400 leading-none">ROLE</p>
                        <p class="text-xs font-black text-blue-600 leading-none mt-1 uppercase">{{ Auth::user()->role }}</p>
                    </div>
                    <button class="w-10 h-10 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-8 custom-scrollbar">
                
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded shadow-sm flex justify-between items-center">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                        <span class="text-sm font-medium text-emerald-800">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600"><i class="fas fa-times"></i></button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>