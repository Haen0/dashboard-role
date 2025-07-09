<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit User</h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto bg-white shadow rounded">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')

            <x-input-label for="name" value="Nama" />
            <x-text-input name="name" type="text" class="w-full mb-2" value="{{ old('name', $user->name) }}" required />

            <x-input-label for="email" value="Email" />
            <x-text-input name="email" type="email" class="w-full mb-2" value="{{ old('email', $user->email) }}" required />

            <x-input-label for="role" value="Role" />
            <select name="role" class="w-full border rounded mb-4">
                <option value="user" @selected($user->role === 'user')>User</option>
                @if(auth()->user()->role === 'superadmin')
                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                    <option value="superadmin" @selected($user->role === 'superadmin')>Superadmin</option>
                @endif
            </select>

            <x-primary-button>Update</x-primary-button>
            <a href="{{ route('users.index') }}" class="ml-2 text-sm text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>
