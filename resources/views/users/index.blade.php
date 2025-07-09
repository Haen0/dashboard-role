<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen User</h2>
    </x-slot>

    <div class="py-4 px-4 space-y-4">

        @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
            <div>
                <a href="{{ route('users.create') }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                    + Tambah User
                </a>
            </div>
        @endif

        <form method="GET" class="flex flex-wrap gap-2 items-center">
            <input name="name" value="{{ request('name') }}" placeholder="Nama" class="px-2 py-1 border rounded" />
            <input name="email" value="{{ request('email') }}" placeholder="Email" class="px-2 py-1 border rounded" />
            <select name="role" class="...">
                <option value="">-- Semua Role --</option>
                <option value="user" @selected(request('role') == 'user')>User</option>
                @if(auth()->user()->role === 'superadmin')
                    <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                    <option value="superadmin" @selected(request('role') == 'superadmin')>Superadmin</option>
                @endif
            </select>
            <select name="per_page" class="px-2 py-1 border rounded">
                <option value="10" @selected(request('per_page') == 10)>10</option>
                <option value="20" @selected(request('per_page') == 20)>20</option>
                <option value="50" @selected(request('per_page') == 50)>50</option>
            </select>
            <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Filter</button>
            <a href="{{ route('users.index') }}" class="text-sm text-gray-500">Reset</a>
        </form>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full text-sm text-left table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        @foreach (['name' => 'Nama', 'email' => 'Email', 'role' => 'Role', 'created_at' => 'Dibuat'] as $field => $label)
                            <th class="px-4 py-2">
                                <a href="{{ route('users.index', array_merge(request()->all(), ['sort' => $field, 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    {{ $label }}
                                    @if(request('sort') === $field)
                                        {{ request('direction') === 'asc' ? '▲' : '▼' }}
                                    @endif
                                </a>
                            </th>
                        @endforeach
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->role }}</td>
                            <td class="px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 space-x-2">
                                @php
                                    $canManage = auth()->user()->role === 'superadmin' || (auth()->user()->role === 'admin' && $user->role === 'user');
                                @endphp

                                @if($canManage)
                                    <a href="{{ route('users.edit', $user) }}" class="text-blue-600 text-sm hover:underline">Edit</a>

                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus user ini?')" class="text-red-600 text-sm hover:underline">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">Tidak bisa dikelola</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center px-4 py-2">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $users->links('vendor.pagination.custom') }}
        </div>
    </div>
</x-app-layout>
