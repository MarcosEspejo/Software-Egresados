<nav x-data="{ open: false, userDropdown: false }" 
     class="bg-white border-b border-gray-100 sticky top-0 z-50 transition-all duration-300 ease-in-out shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('Imagenes/logo-full.png') }}" class="h-10 w-auto" alt="Logo">
                        <span class="hidden md:inline font-bold text-xl text-libertadores-green">SELL</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors duration-300
                               hover:text-libertadores-green group relative">
                        <i class="fas fa-home mr-2"></i>
                        {{ __('Dashboard') }}
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-libertadores-green scale-x-0 
                                   group-hover:scale-x-100 transition-transform duration-300"></span>
                    </x-nav-link>
                    
                    <!-- Agrega más enlaces de navegación aquí -->
                </div>
            </div>

            <!-- Right Side Items -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-libertadores-green transition-colors duration-300">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Settings Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center space-x-3 px-3 py-2 rounded-full border border-gray-200 
                                   hover:border-libertadores-green transition-all duration-300 focus:outline-none">
                        <img class="h-8 w-8 rounded-full object-cover" 
                             src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                             alt="{{ Auth::user()->name }}">
                        <div class="hidden md:block text-left">
                            <div class="text-sm font-semibold">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                           :class="{'rotate-180': open}"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 py-2 bg-white rounded-lg shadow-xl">
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-2 hover:bg-gray-50">
                            <i class="fas fa-user-circle mr-2"></i>
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <x-dropdown-link href="#" class="flex items-center px-4 py-2 hover:bg-gray-50">
                            <i class="fas fa-cog mr-2"></i>
                            {{ __('Configuración') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" 
                        class="p-2 rounded-md text-gray-600 hover:text-libertadores-green hover:bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-libertadores-green">
                    <span class="sr-only">Abrir menú</span>
                    <i class="fas" :class="{'fa-times': open, 'fa-bars': !open}"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="sm:hidden">
        <!-- Mobile navigation links -->
        <div class="px-2 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="flex items-center px-3 py-2 rounded-md text-base font-medium">
                <i class="fas fa-home mr-2"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <!-- Agrega más enlaces móviles aquí -->
        </div>

        <!-- Mobile user menu -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" 
                         src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                         alt="{{ Auth::user()->name }}">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                    class="flex items-center px-4 py-2">
                    <i class="fas fa-user-circle mr-2"></i>
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center px-4 py-2 text-red-600">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
