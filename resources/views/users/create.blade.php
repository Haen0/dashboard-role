<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah User</h2>
    </x-slot>

    <div class="p-4 mx-auto bg-white rounded-lg shadow-md border border-gray-200">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
            @csrf

            {{-- Nama --}}
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Nama lengkap" required value="{{ old('name') }}">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="email@contoh.com" required value="{{ old('email') }}">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <input type="password" name="password" id="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                <select name="role" id="role"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="klien" @selected(old('role') === 'klien')>Klien</option>
                    @if(auth()->user()->role === 'superadmin')
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                        <option value="advokat" @selected(old('role') === 'advokat')>Advokat</option>
                        <option value="keuangan" @selected(old('role') === 'keuangan')>Keuangan</option>
                        <option value="manajer" @selected(old('role') === 'manajer')>Manajer</option>
                        <option value="superadmin" @selected(old('role') === 'superadmin')>Superadmin</option>
                    @endif
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-2">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Simpan
                </button>
                <a href="{{ route('users.index') }}"
                    class="text-gray-600 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
