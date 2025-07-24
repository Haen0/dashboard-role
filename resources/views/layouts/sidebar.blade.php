<aside class="w-64 hidden sm:block bg-white border-r border-gray-200 min-h-screen">
    <div class="p-4">
        <div class="font-bold text-lg mb-4">Menu</div>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
                    Dashboard
                </a>
            </li>

            {{-- // Page Advokat --}}
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                <li>
                    <a href="{{ route('advokats.index') }}"
                    class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('advokats.*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Data Advokat
                    </a>
                </li>
            @endif

            {{-- // Page Konsultasi --}}
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                <li>
                    <a href="{{ route('konsultasi.index') }}"
                    class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('konsultasi.*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Konsultasi
                    </a>
                </li>
            @endif

            {{-- // Page User --}}
            <li>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('profile.edit') ? 'bg-gray-100 font-semibold' : '' }}">
                    Profil
                </a>
            </li>

            @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('users.index') ? 'bg-gray-100 font-semibold' : '' }}">
                        Manajemen User
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
