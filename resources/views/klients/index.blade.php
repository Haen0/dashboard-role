<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Data Klien</h2>
    </x-slot>

    <div class="p-4 space-y-4">

        {{-- Filter Form --}}
        <form method="GET" class="flex flex-wrap gap-3 items-center mb-4">
            <div>
                <input name="nama" value="{{ request('nama') }}"
                    type="text"
                    placeholder="Nama Klien"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>

            <div>
                <input name="email" value="{{ request('email') }}"
                    type="text"
                    placeholder="Email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>

            <div>
                <input name="telepon" value="{{ request('telepon') }}"
                    type="text"
                    placeholder="Telepon"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>

            <div>
                <select name="per_page"
                        class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
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
                <a href="{{ route('klients.index') }}"
                    class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Reset
                </a>
            </div>
        </form>

        {{-- Tabel Klien --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Telepon</th>
                        <th class="px-6 py-3">Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($klients as $klient)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $klient->nama }}</td>
                            <td class="px-6 py-4">{{ $klient->email }}</td>
                            <td class="px-6 py-4">{{ $klient->telepon }}</td>
                            <td class="px-6 py-4">{{ $klient->alamat }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-4 text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>
            {{ $klients->links('vendor.pagination.custom') }}
        </div>
    </div>
</x-app-layout>
