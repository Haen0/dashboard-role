<aside class="w-64 hidden md:block bg-white border-r border-gray-200 min-h-screen">
    <div class="grid min-h-screen p-4">
        <div>
            <div class="font-bold text-lg mb-4">Menu</div>
            <ul class="space-y-2">
                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
                        Dashboard
                    </a>
                </li>

                {{-- Manajemen User (Dropdown - Superadmin) --}}
                @if(auth()->user()->role === 'superadmin')
                    <li x-data="{ open: {{ request()->routeIs('users.*') || request()->routeIs('klients.*') || request()->routeIs('advokats.*') ? 'true' : 'false' }} }">
                        <button type="button"
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('users.*') || request()->routeIs('klients.*') || request()->routeIs('advokats.*') ? 'bg-gray-100 font-semibold' : '' }}">
                            <span>Manajemen User</span>
                            <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <ul x-show="open" x-transition class="ml-4 mt-2 space-y-2">
                            <li>
                                <a href="{{ route('users.index') }}"
                                    class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('users.*') ? 'bg-gray-100 font-semibold' : '' }}">
                                    Semua User
                                </a>
                            </li>
                            <li>
                                {{-- <a href="{{ route('klients.index') }}" --}}
                                <a href=""
                                    class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('klients.*') ? 'bg-gray-100 font-semibold' : '' }}">
                                    Data Klien
                                </a>
                            </li>
                            <li>
                                {{-- <a href="{{ route('advokats.index') }}" --}}
                                <a href=""
                                    class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('advokats.*') ? 'bg-gray-100 font-semibold' : '' }}">
                                    Data Advokat
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Ajukan Konsultasi (Klien + Admin + Superadmin) --}}
                @if(in_array(auth()->user()->role, ['klien', 'admin', 'superadmin']))
                    <li>
                        {{-- <a href="{{ route('konsultasis.create') }}" --}}
                        <a href=""
                            class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('konsultasis.create') ? 'bg-gray-100 font-semibold' : '' }}">
                            Ajukan Konsultasi
                        </a>
                    </li>
                @endif

                {{-- Konsultasi Hukum (Dropdown) --}}
                @if(in_array(auth()->user()->role, ['klien', 'admin', 'advokat', 'superadmin']))
                    <li x-data="{ open: {{ request()->routeIs('konsultasis.*') || request()->routeIs('jadwals.*') ? 'true' : 'false' }} }">
                        <button type="button"
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('konsultasis.*') || request()->routeIs('jadwals.*') ? 'bg-gray-100 font-semibold' : '' }}">
                            <span>Konsultasi Hukum</span>
                            <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <ul x-show="open" x-transition class="ml-4 mt-2 space-y-2">
                            <li>
                                {{-- <a href="{{ route('konsultasis.index') }}" --}}
                                <a href=""
                                    class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('konsultasis.index') ? 'bg-gray-100 font-semibold' : '' }}">
                                    Daftar Konsultasi
                                </a>
                            </li>
                            @if(in_array(auth()->user()->role, ['klien', 'admin', 'superadmin']))
                                <li>
                                    {{-- <a href="{{ route('jadwals.index') }}" --}}
                                    <a href=""
                                        class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('jadwals.index') ? 'bg-gray-100 font-semibold' : '' }}">
                                        Jadwal Konsultasi
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Dokumen Hukum --}}
                @if(in_array(auth()->user()->role, ['admin', 'advokat', 'superadmin']))
                    <li>
                        {{-- <a href="{{ route('dokumens.index') }}" --}}
                        <a href=""
                            class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dokumens.*') ? 'bg-gray-100 font-semibold' : '' }}">
                            Dokumen Hukum
                        </a>
                    </li>
                @endif

                {{-- Tagihan & Pembayaran --}}
                @if(in_array(auth()->user()->role, ['keuangan', 'superadmin']))
                    <li>
                        {{-- <a href="{{ route('pembayarans.index') }}" --}}
                        <a href=""
                            class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('pembayarans.*') ? 'bg-gray-100 font-semibold' : '' }}">
                            Tagihan & Pembayaran
                        </a>
                    </li>
                @endif

                {{-- Laporan --}}
                @if(in_array(auth()->user()->role, ['admin', 'keuangan', 'advokat', 'manajer', 'superadmin']))
                    <li>
                        {{-- <a href="{{ route('laporans.index') }}" --}}
                        <a href=""
                            class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('laporans.*') ? 'bg-gray-100 font-semibold' : '' }}">
                            Laporan
                        </a>
                    </li>
                @endif

                {{-- Profil Saya --}}
                <li>
                    <li href="{{ route('profile.edit') }}"
                        class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('profile.edit') ? 'bg-gray-100 font-semibold' : '' }}">
                        Profil
                    </a>
                </li>

                {{-- Logout --}}
            </ul>
        </div>
        <div class="grid pt-4 items-end">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left block px-3 py-2 rounded hover:bg-gray-100">
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
