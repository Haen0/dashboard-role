<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah User</h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto bg-white shadow rounded">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <x-input-label for="name" value="Nama" />
            <x-text-input name="name" type="text" class="w-full mb-2 text-lg" required />

            <x-input-label for="email" value="Email" />
            <x-text-input name="email" type="email" class="w-full mb-2 text-lg" required />

            <x-input-label for="password" value="Password" />
            <x-text-input name="password" type="password" class="w-full mb-2 text-lg" required />

            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input name="password_confirmation" type="password" class="w-full mb-2 text-lg" required />

            <x-input-label for="role" value="Role" />
            <select name="role" class="w-full border rounded mb-4">
                <option value="klien">Klien</option>
                @if(auth()->user()->role === 'superadmin')
                    <option value="admin">Admin</option>
                    <option value="advokat">Advokat</option>
                    <option value="keuangan">Keuangan</option>
                    <option value="manajer">Manajer</option>
                    <option value="superadmin">Superadmin</option>
                @endif
            </select>

            <x-primary-button>Simpan</x-primary-button>
            <a href="{{ route('users.index') }}" class="ml-2 text-sm text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>
