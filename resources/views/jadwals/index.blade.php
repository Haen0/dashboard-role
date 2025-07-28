<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Jadwal Konsultasi</h2>
    </x-slot>

    <form method="GET" class="flex flex-wrap gap-3 items-center mb-4">
        <div>
            <input name="klien" value="{{ request('klien') }}"
                type="text"
                placeholder="Nama Klien"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
        </div>

        <div>
            <input name="advokat" value="{{ request('advokat') }}"
                type="text"
                placeholder="Nama Advokat"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
        </div>

        <div>
            <input name="lokasi" value="{{ request('lokasi') }}"
                type="text"
                placeholder="Lokasi"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
        </div>

        <div>
            <input name="tanggal" value="{{ request('tanggal') }}"
                type="date"
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
            <a href="{{ route('jadwals.index') }}"
                class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                Reset
            </a>
        </div>
    </form>

    <div class="relative overflow-x-auto shadow-md rounded-lg bg-white">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Waktu</th>
                    <th class="px-6 py-3">Lokasi</th>
                    <th class="px-6 py-3">Klien</th>
                    <th class="px-6 py-3">Advokat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $jadwal->tanggal }}</td>
                        <td class="px-6 py-4">{{ $jadwal->waktu }}</td>
                        <td class="px-6 py-4">{{ $jadwal->lokasi }}</td>
                        <td class="px-6 py-4">{{ $jadwal->konsultasi->klien->nama ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $jadwal->konsultasi->advokat->nama ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada jadwal.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $jadwals->links('vendor.pagination.custom') }}
    </div>
</x-app-layout>
