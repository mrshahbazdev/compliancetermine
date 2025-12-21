<nav class="bg-white shadow-lg sticky top-0 z-50 border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-4">
                <a href="{{ route('tenant.dashboard', ['tenantId' => request()->tenantId]) }}" 
                   class="flex items-center space-x-2 text-xl font-bold text-blue-600 hover:text-blue-700 transition">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-shield text-white text-lg"></i>
                    </div>
                    <span class="hidden sm:block">ComplianceTermine</span>
                </a>

                <div class="hidden md:flex items-center space-x-1 ml-8">
                    <a href="{{ route('tenant.dashboard', ['tenantId' => request()->tenantId]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('tenant.dashboard') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="fas fa-chart-line mr-2"></i>Dashboard
                    </a>

                    <a href="{{ route('tenant.categories.index', ['tenantId' => request()->tenantId]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('tenant.categories.*') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="fas fa-tags mr-2"></i>Kategorien
                    </a>

                    <a href="{{ route('tenant.employees.index', ['tenantId' => request()->tenantId]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('tenant.employees.*') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="fas fa-users mr-2"></i>Mitarbeiter
                    </a>

                    <a href="{{ route('tenant.calendar', ['tenantId' => request()->tenantId]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('tenant.calendar') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="fas fa-calendar-alt mr-2"></i>Kalender
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <div class="hidden md:block">
                    @if(Auth::user()->isAdmin())
                        <span class="px-3 py-1.5 bg-red-100 text-red-800 text-xs font-bold rounded-full border border-red-200 shadow-sm">
                            <i class="fas fa-crown mr-1"></i>SUPERUSER
                        </span>
                    @else
                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full border border-emerald-200 shadow-sm">
                            <i class="fas fa-user-check mr-1"></i>VERANTWORTLICHER
                        </span>
                    @endif
                </div>

                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" 
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-900">{{ Str::limit(Auth::user()->name, 15) }}</p>
                            <p class="text-xs text-gray-500 uppercase">{{ Auth::user()->role }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-xs hidden md:block transition-transform" :class="{ 'rotate-180': userOpen }"></i>
                    </button>

                    <div x-show="userOpen" 
                         @click.away="userOpen = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50"
                         style="display: none;">
                        
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-2">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('tenant.admin.users.index', ['tenantId' => request()->tenantId]) }}" 
                                   class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                    <i class="fas fa-users-cog w-5 mr-3 text-blue-500"></i>
                                    <span class="font-medium">Benutzerverwaltung</span>
                                </a>
                            @endif
                        </div>

                        <div class="border-t border-gray-100 my-2"></div>

                        <form method="POST" action="{{ route('tenant.logout', ['tenantId' => request()->tenantId]) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors font-semibold">
                                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                Abmelden
                            </button>
                        </form>
                    </div>
                </div>

                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen" 
         @click.away="mobileMenuOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden border-t border-gray-200 bg-white shadow-lg"
         style="display: none;">
        
        <div class="px-4 py-4 space-y-2">
            <a href="{{ route('tenant.dashboard', ['tenantId' => request()->tenantId]) }}" 
               class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('tenant.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-home mr-3"></i>Dashboard
            </a>
            <a href="{{ route('tenant.categories.index', ['tenantId' => request()->tenantId]) }}" 
               class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('tenant.categories.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tags mr-3"></i>Kategorien
            </a>
            <a href="{{ route('tenant.employees.index', ['tenantId' => request()->tenantId]) }}" 
               class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('tenant.employees.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-users mr-3"></i>Mitarbeiter
            </a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('tenant.admin.users.index', ['tenantId' => request()->tenantId]) }}" 
                   class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 border-t mt-2">
                    <i class="fas fa-shield-alt mr-3"></i>Admin Panel
                </a>
            @endif
        </div>
    </div>
</nav>