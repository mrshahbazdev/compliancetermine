<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Management Portal</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .sidebar-link-active {
            background-color: rgba(59, 130, 246, 0.1);
            color: #2563eb;
            border-right: 4px solid #2563eb;
        }
    </style>
</head>
<body class="bg-slate-50">

    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-white border-r border-slate-200 flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6">
                <h1 class="text-xl font-bold text-blue-600">ComplianceTool</h1>
            </div>
            
            <nav class="flex-1 space-y-1 px-3">
                <a href="{{ route('tenant.dashboard', request()->tenantId) }}" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-lg transition {{ request()->routeIs('tenant.dashboard') ? 'sidebar-link-active' : '' }}">
                    <i class="fas fa-th-large mr-3 w-5"></i> Dashboard
                </a>
                
                <a href="{{ route('tenant.categories.index', request()->tenantId) }}" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-lg transition {{ request()->routeIs('tenant.categories.*') ? 'sidebar-link-active' : '' }}">
                    <i class="fas fa-tags mr-3 w-5"></i> Kategorien
                </a>
                
                <a href="{{ route('tenant.employees.index', request()->tenantId) }}" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-lg transition {{ request()->routeIs('tenant.employees.*') ? 'sidebar-link-active' : '' }}">
                    <i class="fas fa-users mr-3 w-5"></i> Mitarbeiter
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-lg transition">
                    <i class="fas fa-calendar-alt mr-3 w-5"></i> Terminkalender
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                        <i class="fas fa-sign-out-alt mr-3"></i> Abmelden
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-8 sticky top-0 z-10">
                <div class="text-sm text-slate-500">
                    Mandant: <span class="font-bold text-slate-800">{{ request()->tenantId }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-slate-700">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>