<aside class="w-64 hidden md:block bg-white border-r border-blue-200 min-h-screen">
    <div class="grid min-h-screen p-4">
        <div>
            <div class="font-bold text-lg mb-4">
                <img src="{{ asset('logoPerusahaan.png') }}" alt="MR. OKY & PARTNERS" class="mx-auto w-32 h-auto">
            </div>
            <ul class="space-y-2">
                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('dashboard') ? 'bg-blue-100 font-semibold' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m-4 0h8m4 0h2"/>
                        </svg>
                        Dashboard
                    </a>
                </li>

                <hr class="p-2">

                {{-- Manajemen User --}}
                @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <li x-data="{ open: {{ request()->routeIs('users.*') || request()->routeIs('klients.*') || request()->routeIs('advokats.*') ? 'true' : 'false' }} }">
                        <button type="button"
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('users.*') || request()->routeIs('klients.*') || request()->routeIs('advokats.*') ? 'bg-blue-100 font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                                Manajemen User
                            </span>
                            <svg class="w-4 h-4 transition-transform transform text-blue-500" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <ul x-show="open" x-transition class="ml-4 mt-2 space-y-2">
                            @if(in_array(auth()->user()->role, ['superadmin']))
                                <li>
                                    <a href="{{ route('users.index') }}"
                                       class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('users.*') ? 'bg-blue-100 font-semibold' : '' }}">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                    Semua User
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('klients.index') }}"
                                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('klients.*') ? 'bg-blue-100 font-semibold' : '' }}">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 17l-4-4-4 4m8-4l-4-4-4 4"/>
                                    </svg>
                                    Data Klien
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('advokats.index') }}"
                                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('advokats.*') ? 'bg-blue-100 font-semibold' : '' }}">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 7h18M3 12h18M3 17h18"/>
                                    </svg>
                                    Data Advokat
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Konsultasi Hukum --}}
                @if(in_array(auth()->user()->role, ['klien', 'admin', 'advokat', 'superadmin']))
                    <li x-data="{ open: {{ request()->routeIs('konsultasis.*') || request()->routeIs('jadwals.*') ? 'true' : 'false' }} }">
                        <button type="button"
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('konsultasis.*') || request()->routeIs('jadwals.*') ? 'bg-blue-100 font-semibold' : '' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 10h8M8 14h4m-5 6l-5-5V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H7z"/>
                                </svg>
                                Konsultasi Hukum
                            </span>
                            <svg class="w-4 h-4 transition-transform transform text-blue-500" :class="{ 'rotate-180': open }"
                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <ul x-show="open" x-transition class="ml-4 mt-2 space-y-2">
                            @if(in_array(auth()->user()->role, ['klien', 'admin', 'superadmin']))
                                <li>
                                    <a href="{{ route('konsultasis.create') }}"
                                       class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('konsultasis.create') ? 'bg-blue-100 font-semibold' : '' }}">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Ajukan Konsultasi
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('konsultasis.index') }}"
                                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('konsultasis.index') ? 'bg-blue-100 font-semibold' : '' }}">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Daftar Konsultasi
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('jadwals.index') }}"
                                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('jadwals.index') ? 'bg-blue-100 font-semibold' : '' }}">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3M4 11h16M4 19h16"/>
                                    </svg>
                                    Jadwal Konsultasi
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Dokumen Hukum --}}
                @if(in_array(auth()->user()->role, ['admin', 'advokat', 'superadmin']))
                    <li>
                        <a href="{{ route('dokumen.hukum.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('dokumen.hukum.index') ? 'bg-blue-100 font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                            </svg>
                            Dokumen Hukum
                        </a>
                    </li>
                @endif

                {{-- Tagihan & Pembayaran --}}
                @if(in_array(auth()->user()->role, ['keuangan', 'superadmin']))
                    <li>
                        <a href="{{ route('pembayaran.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('pembayaran.index') ? 'bg-blue-100 font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>

                            Tagihan & Pembayaran
                        </a>
                    </li>
                @endif

                {{-- Laporan --}}
                @if(in_array(auth()->user()->role, ['admin', 'keuangan', 'advokat', 'manajer', 'superadmin']))
                    <li>
                        <a href="{{ route('laporans.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('laporans.*') ? 'bg-blue-100 font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                            Laporan
                        </a>
                    </li class="mb-2">
                @endif
                
                {{-- Profil Saya --}}
                <hr>
                <li>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('profile.edit') ? 'bg-blue-100 font-semibold' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                        </svg>

                        Profil
                    </a>
                </li>
            </ul>
        </div>

        {{-- Logout --}}
        <div class="grid pt-4 items-end">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 w-full text-left px-3 py-2 rounded hover:bg-blue-100">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
