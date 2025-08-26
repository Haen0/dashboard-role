<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit User</h2>
    </x-slot>

    <div class="p-4 mx-auto bg-white rounded-lg shadow-md border border-gray-200">
        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $user->name) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" id="email"
                    value="{{ old('email', $user->email) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                <select name="role" id="role"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    {{-- <option value="klien" @selected($user->role === 'klien')>Klien</option> --}}
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'manajer')
                        <option value="admin" @selected($user->role === 'admin')>Admin</option>
                        <option value="advokat" @selected($user->role === 'advokat')>Advokat</option>
                        <option value="keuangan" @selected($user->role === 'keuangan')>Keuangan</option>
                        <option value="manajer" @selected($user->role === 'manajer')>Manajer</option>
                        @if(auth()->user()->role === 'superadmin')
                            <option value="superadmin" @selected($user->role === 'superadmin')>Superadmin</option>
                        @endif
                    @endif
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-2">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Update
                </button>
                <a href="{{ route('users.index') }}"
                    class="text-gray-600 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
