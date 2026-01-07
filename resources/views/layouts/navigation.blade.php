<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                @if (auth()->user()->role === 'ADMIN')
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard.admin') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    </div>
                @else
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard.user') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    </div>
                @endif
        
                
                <!-- Navigation Links -->
                @if(auth()->user()->role === 'ADMIN')        
                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex ">
                        <x-nav-link :href="route('area')" :active="request()->routeIs('area')">
                            {{ __('Areas') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex ">
                        <x-nav-link :href="route('grouptype')" :active="request()->routeIs('grouptype')">
                            {{ __('Tipo Grupo') }}
                        </x-nav-link>
                    </div>   
                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex ">
                        <x-nav-link :href="route('girotype')" :active="request()->routeIs('girotype')">
                            {{ __('Derivaciones') }}
                        </x-nav-link>
                    </div>     
                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex ">
                        <x-nav-link :href="route('doctype')" :active="request()->routeIs('doctype')">
                            {{ __('Documentos') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex">
                        <x-nav-link :href="route('entity')" :active="request()->routeIs('entity')">
                            {{ __('Entidades') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex">
                        <x-nav-link :href="route('publictype')" :active="request()->routeIs('publictype')">
                            {{ __('Públicos') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex">
                        <x-nav-link :href="route('user')" :active="request()->routeIs('user')">
                            {{ __('Usuarios') }}
                        </x-nav-link>
                    </div>
                    
                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex relative group">
                        <x-nav-link href="#" class="cursor-default">
                            {{ __('Números') }}
                        </x-nav-link>
                        <div class="absolute hidden group-hover:flex flex-col bg-white border border-gray-300 rounded-lg shadow-lg top-full left-0 z-10 w-48">
                            @foreach(App\Models\GiroType::all() as $type)
                                <x-nav-link :href="route('prontuario', $type->slug)" :active="request()->routeIs('prontuario', $type->slug)" class="px-4 py-2 hover:bg-gray-100">
                                    {{ __($type->description) }}
                                </x-nav-link>
                            @endforeach
                        </div>
                    </div>

                    <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex relative group">
                        <x-nav-link href="#" class="cursor-default">
                            {{ __('Configuración') }}
                        </x-nav-link>
                    
                        <div class="absolute hidden group-hover:flex flex-col bg-white border border-gray-300 rounded-lg shadow-lg top-full left-0 z-10 w-48">
                            <x-nav-link :href="route('prontuario.initial.numbers')" :active="request()->routeIs('prontuario.initial.numbers')" class="px-4 py-2 hover:bg-gray-100">
                                {{ __('Inicializar Números') }}
                            </x-nav-link>
                            <x-nav-link :href="route('prontuario.ask')" :active="request()->routeIs('prontuario.ask')" class="px-4 py-2 hover:bg-gray-100">
                                {{ __('Reiniciar Prontuario') }}
                            </x-nav-link>
                            <x-nav-link :href="route('prontuario.clean')" :active="request()->routeIs('prontuario.clean')" class="px-4 py-2 hover:bg-gray-100">
                                {{ __('Reestablecer Sistema') }}
                            </x-nav-link>
                        </div>
                    </div>
                @else

                    @foreach(App\Models\GiroType::all() as $type)
                        <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex">
                            <x-nav-link 
                                :href="route('prontuario.show', ['slug' => $type->slug, 'id' => Auth::user()->worker->id])"
                                :active="request()->routeIs('prontuario.show') && request()->slug == $type->slug">
                                {{ ucfirst(mb_strtolower($type->description, 'UTF-8')) }}
                            </x-nav-link>
                        </div>
                    @endforeach

                    @if(auth()->user()->isJefatura()) 

                        <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex relative group">
                            <x-nav-link href="#" class="cursor-default">
                                {{ __('Firmar Documentos') }}
                            </x-nav-link>
                        
                            <div class="absolute hidden group-hover:flex flex-col bg-white border border-gray-300 rounded-lg shadow-lg top-full left-0 z-10 w-48">
                                <x-nav-link :href="route('firma.signed')" :active="request()->routeIs('firma.signed')" class="px-4 py-2 hover:bg-gray-100">
                                    {{ __('Firmados') }}
                                </x-nav-link>
                                <x-nav-link :href="route('firma.unsigned')" :active="request()->routeIs('firma.unsigned')" class="px-4 py-2 hover:bg-gray-100">
                                    {{ __('Por Firmar') }}
                                </x-nav-link>
                            </div>
                        </div>
                    @endif

                @endif
                <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex">
                    <x-nav-link :href="route('report')" :active="request()->routeIs('report')">
                        {{ __('Reportes') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>
                                @if (Auth::user()->role === 'USER')
                                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->worker->name }}</p>
                                    <p class="text-sm text-gray-600">{{ Auth::user()->worker->position }}</p>
                                @elseif (Auth::user()->role === 'ADMIN')
                                    <p class="text-sm font-bold text-gray-800">Admin</p>
                                @endif
                            </div>
                            
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->role === 'ADMIN')
                <x-responsive-nav-link :href="route('dashboard.admin')" :active="request()->routeIs('dashboard.admin')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('area')" :active="request()->routeIs('area')">
                    {{ __('Áreas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('grouptype')" :active="request()->routeIs('grouptype')">
                    {{ __('Tipo Grupo') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('girotype')" :active="request()->routeIs('girotype')">
                    {{ __('Derivaciones') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('doctype')" :active="request()->routeIs('doctype')">
                    {{ __('Documentos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('entity')" :active="request()->routeIs('entity')">
                    {{ __('Entidades') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('publictype')" :active="request()->routeIs('publictype')">
                    {{ __('Públicos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user')" :active="request()->routeIs('user')">
                    {{ __('Usuarios') }}
                </x-responsive-nav-link>

                <!-- Menú desplegable de Números -->
                <div class="space-y-1">
                    <span class="block px-4 py-2 text-gray-600 font-bold">{{ __('Números') }}</span>
                    @foreach(App\Models\GiroType::all() as $type)
                        <x-responsive-nav-link :href="route('prontuario', $type->slug)" :active="request()->routeIs('prontuario', $type->slug)">
                            {{ __($type->description) }}
                        </x-responsive-nav-link>
                    @endforeach
                </div>
    
                <!-- Menú desplegable de Configuración -->
                <div class="space-y-1">
                    <span class="block px-4 py-2 text-gray-600 font-bold">{{ __('Configuración') }}</span>
                    <x-responsive-nav-link :href="route('prontuario.ask')" :active="request()->routeIs('prontuario.ask')">
                        {{ __('Reiniciar Prontuario') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('prontuario.initial.numbers')" :active="request()->routeIs('prontuario.initial.numbers')">
                        {{ __('Inicializar Números') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('prontuario.clean')" :active="request()->routeIs('prontuario.clean')">
                        {{ __('Reestablecer Sistema') }}
                    </x-responsive-nav-link>
                </div>
            @else
                 <x-responsive-nav-link :href="route('dashboard.user')" :active="request()->routeIs('dashboard.user')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                @php
                    $options = [
                        'internos' => 'Internos',
                        'externos' => 'Externos',
                        'publicos' => 'Públicos',
                        'entre-equipos' => 'Entre Equipos',
                        'personales' => 'Personales',
                    ];
                @endphp

                @foreach($options as $slug => $label)
                <x-responsive-nav-link :href="route('prontuario.show', ['slug' => $slug, 'id' => Auth::user()->worker->id])"
                                    :active="request()->routeIs('prontuario.show') && request()->slug == $slug">
                    {{ __($label) }}
                </x-responsive-nav-link>
                @endforeach
            @endif

            @if(auth()->user()->isJefatura())
                <!-- Menú desplegable de Firmar Documentos (responsive) -->
                <div class="space-y-1">
                    <span class="block px-4 py-2 text-gray-600 font-bold">{{ __('Firmar Documentos') }}</span>
                    <x-responsive-nav-link :href="route('firma.signed')" :active="request()->routeIs('firma.signed')">
                        {{ __('Firmados') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('firma.unsigned')" :active="request()->routeIs('firma.unsigned')">
                        {{ __('Por Firmar') }}
                    </x-responsive-nav-link>
                </div>
            @endif

            <x-responsive-nav-link :href="route('report')" :active="request()->routeIs('report')">
                {{ __('Reportes') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    @if (Auth::user()->role === 'USER')
                        {{ Auth::user()->worker->name }}
                    @elseif (Auth::user()->role === 'ADMIN')
                        ADMIN
                    @endif
                </div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
