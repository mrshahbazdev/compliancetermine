<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Compliance Tool</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }

        .sidebar-link-active {
            background: linear-gradient(to right, rgba(37, 99, 235, 0.08), rgba(37, 99, 235, 0));
            color: #2563eb;
            border-left: 4px solid #2563eb;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900" x-data="{ mobileSidebarOpen: false }">

    <div x-show="mobileSidebarOpen" x-cloak @click="mobileSidebarOpen = false"
         class="fixed inset-0 bg-slate-900/50 z-40 md:hidden backdrop-blur-sm transition-opacity"></div>

    <div class="flex h-screen overflow-hidden">
        
        <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 z-50 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shadow-2xl md:shadow-none">
            
            <div class="p-6">
                <a href="{{ route('tenant.dashboard', request()->tenantId) }}" class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <i class="fas fa-clipboard-check text-lg"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-800">Compliance<span class="text-blue-600">Pro</span></span>
                </a>
            </div>
            
            <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar">
                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-4">Menü</p>
                
                <a href="{{ route('tenant.dashboard', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('tenant.dashboard') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-th-large mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="text-sm">Dashboard</span>
                </a>
                
                <a href="{{ route('tenant.employees.overview', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('tenant.employees.overview') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-columns mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="text-sm">Matrix-Übersicht</span>
                </a>

                <a href="{{ route('tenant.calendar', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('tenant.calendar') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-calendar-alt mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="text-sm">Terminkalender</span>
                </a>

                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Verwaltung</p>

                <a href="{{ route('tenant.employees.index', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all group {{ (request()->routeIs('tenant.employees.*') && !request()->routeIs('tenant.employees.overview')) ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-users mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="text-sm">Mitarbeiter</span>
                </a>

                @if(Auth::user()->isAdmin())
                <a href="{{ route('tenant.categories.index', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('tenant.categories.*') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-tags mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="text-sm">Schulungstypen</span>
                </a>
                @endif

                @if(Auth::user()->isAdmin())
                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">System</p>
                <a href="{{ route('tenant.admin.users.index', request()->tenantId) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('tenant.admin.users.*') ? 'sidebar-link-active' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fas fa-user-lock mr-3 w-5 text-center group-hover:scale-110 transition"></i> 
                    <span class="text-sm">Benutzerverwaltung</span>
                </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex items-center p-3 mb-3 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-xs mr-3">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[11px] font-black text-slate-800 truncate leading-none mb-1">{{ Auth::user()->name }}</p>
                        <span class="px-1.5 py-0.5 rounded bg-{{ Auth::user()->isAdmin() ? 'red' : 'green' }}-100 text-{{ Auth::user()->isAdmin() ? 'red' : 'green' }}-600 text-[8px] font-bold uppercase tracking-tighter">
                            {{ Auth::user()->isAdmin() ? 'Admin' : 'Verantwortlicher' }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('tenant.logout', ['tenantId' => request()->tenantId]) }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl text-xs font-bold transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i> Abmelden
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 bg-slate-50">
            
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
                <div class="flex items-center">
                    <button @click="mobileSidebarOpen = true" class="md:hidden p-2 text-slate-500 mr-2 hover:bg-slate-100 rounded-lg transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-building text-slate-300 text-sm"></i> 
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ request()->tenantId }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] font-bold text-slate-400 leading-none uppercase">Status</p>
                        <p class="text-[11px] font-bold text-emerald-500 leading-none mt-1 uppercase">Online</p>
                    </div>
                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 border border-slate-200">
                        <i class="fas fa-bell"></i>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-8 custom-scrollbar pb-12">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>