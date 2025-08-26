<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> --}}
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                {{-- <x-dropdown align="right" width="48"> --}}
                    <div name="trigger">
                        {{-- <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"> --}}
                            <div class="flex items-center gap-2 pr-10">
                                <p>Halo selamat datang</p>{{ Auth::user()->name }}</div>

                            {{-- <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div> --}}
                        {{-- </button> --}}
                    </div>

                    {{-- <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profisdle') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown> --}}
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
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
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @if(auth()->user()->role === 'superadmin')
                <div class="border-t border-gray-200"></div>

                {{-- Dropdown Toggle --}}
                <div x-data="{ openUserDropdown: false }" class="px-4 pt-2">
                    <button @click="openUserDropdown = !openUserDropdown" class="w-full text-left text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                        Manajemen User
                        <svg class="inline-block w-4 h-4 ml-1 transform transition-transform duration-200"
                            :class="{ 'rotate-180': openUserDropdown }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Items --}}
                    <div x-show="openUserDropdown" class="mt-2 space-y-1" x-cloak>
                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            Semua User
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('klients.*')">
                            Data Klien
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('advokats.*')">
                            Data Advokat
                        </x-responsive-nav-link>
                    </div>
                </div>
            @endif

            @if(in_array(auth()->user()->role, ['klien', 'admin', 'superadmin']))
                <x-responsive-nav-link :href="route('users.create')" :active="request()->routeIs('konsultasis.create')">
                    Ajukan Konsultasi
                </x-responsive-nav-link>
            @endif

            @if(in_array(auth()->user()->role, ['klien', 'admin', 'advokat', 'superadmin']))
                <div class="border-t border-gray-200"></div>

                {{-- Dropdown Toggle --}}
                <div x-data="{ openKonsultasiDropdown: false }" class="px-4 pt-2">
                    <button @click="openKonsultasiDropdown = !openKonsultasiDropdown"
                            class="w-full text-left text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                        Konsultasi Hukum
                        <svg class="inline-block w-4 h-4 ml-1 transform transition-transform duration-200"
                            :class="{ 'rotate-180': openKonsultasiDropdown }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Items --}}
                    <div x-show="openKonsultasiDropdown" class="mt-2 space-y-1" x-cloak>
                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('konsultasis.index')">
                            Daftar Konsultasi
                        </x-responsive-nav-link>
                        @if(in_array(auth()->user()->role, ['klien', 'admin', 'superadmin']))
                            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('jadwals.index')">
                                Jadwal Konsultasi
                            </x-responsive-nav-link>
                        @endif
                    </div>
                </div>
            @endif

            @if(in_array(auth()->user()->role, ['admin', 'advokat', 'superadmin']))
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('dokumens.*')">
                    Dokumen Hukum
                </x-responsive-nav-link>
            @endif

            @if(in_array(auth()->user()->role, ['keuangan', 'superadmin']))
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('pembayarans.*')">
                    Tagihan & Pembayaran
                </x-responsive-nav-link>
            @endif

            @if(in_array(auth()->user()->role, ['admin', 'keuangan', 'advokat', 'manajer', 'superadmin']))
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('laporans.*')">
                    Laporan
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
