<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Data Advokat</h2>
    </x-slot>

    <div class="p-4 space-y-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
            <a href="{{ route('advokats.create') }}"
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">+ Tambah Advokat</a>
        @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Spesialis</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Telepon</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advokats as $advokat)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $advokat->nama }}</td>
                            <td class="px-6 py-4">{{ $advokat->spesialis }}</td>
                            <td class="px-6 py-4">{{ $advokat->email }}</td>
                            <td class="px-6 py-4">{{ $advokat->telepon }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                    <a href="{{ route('advokats.edit', $advokat) }}"
                                       class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('advokats.destroy', $advokat) }}"
                                          method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Yakin hapus data ini?')"
                                                class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $advokats->links() }}
    </div>
</x-app-layout>
