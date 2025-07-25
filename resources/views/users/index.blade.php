<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen User</h2>
    </x-slot>

    <div class="py-4 px-4 space-y-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
        @endif

        @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
            <div class="mb-4">
                <a href="{{ route('users.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                    + Tambah User
                </a>
            </div>
        @endif

        <form method="GET" class="flex flex-wrap gap-3 items-center mb-4">
            <div>
                <input name="name" value="{{ request('name') }}"
                    type="text"
                    placeholder="Nama"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>

            <div>
                <input name="email" value="{{ request('email') }}"
                    type="text"
                    placeholder="Email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>

            <div>
                <select name="role" class="w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">-- Semua Role --</option>
                    <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                    <option value="keuangan" @selected(request('role') == 'keuangan')>Keuangan</option>
                    <option value="manajer" @selected(request('role') == 'manajer')>Manajer</option>
                    <option value="advokat" @selected(request('role') == 'advokat')>Advokat</option>
                    <option value="klien" @selected(request('role') == 'klien')>Klien</option>
                    @if(auth()->user()->role === 'superadmin')
                        <option value="superadmin" @selected(request('role') == 'superadmin')>Superadmin</option>
                    @endif
                </select>
            </div>

            <div>
                <select name="per_page"
                        class="w-16 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="10" @selected(request('per_page') == 10)>10</option>
                    <option value="20" @selected(request('per_page') == 20)>20</option>
                    <option value="50" @selected(request('per_page') == 50)>50</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Filter
                </button>
                <a href="{{ route('users.index') }}"
                class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Reset
                </a>
            </div>
        </form>

        <div class="relative overflow-x-auto shadow-md rounded-lg bg-white">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        @foreach (['name' => 'Nama', 'email' => 'Email', 'role' => 'Role', 'created_at' => 'Dibuat'] as $field => $label)
                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('users.index', array_merge(request()->all(), ['sort' => $field, 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:underline font-semibold text-gray-700">
                                    {{ $label }}
                                    @if(request('sort') === $field)
                                        {{ request('direction') === 'asc' ? '▲' : '▼' }}
                                    @endif
                                </a>
                            </th>
                        @endforeach
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $user->name }}
                            </th>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 capitalize">{{ $user->role }}</td>
                            <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 space-x-2">
                                @php
                                    $canManage = auth()->user()->role === 'superadmin'
                                        || (auth()->user()->role === 'admin' && $user->role === 'klien');
                                @endphp

                                @if($canManage)
                                    <a href="{{ route('users.edit', $user) }}" class="font-medium text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus user ini?')" class="font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">Tidak bisa dikelola</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $users->links('vendor.pagination.custom') }}
        </div>
    </div>
</x-app-layout>
