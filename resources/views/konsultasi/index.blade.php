<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Data Konsultasi</h2>
    </x-slot>

    <div class="p-4 space-y-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter Form --}}
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
                <select name="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-36 p-2.5">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                    <option value="diproses" @selected(request('status') == 'diproses')>Diproses</option>
                    <option value="selesai" @selected(request('status') == 'selesai')>Selesai</option>
                </select>
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
                <a href="{{ route('konsultasis.index') }}"
                    class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Reset
                </a>
            </div>
        </form>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Klien</th>
                        <th class="px-6 py-3">Advokat</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Jenis Kasus</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Dokumen</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konsultasis as $konsultasi)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $konsultasi->klien->nama ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $konsultasi->advokat->nama ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $konsultasi->tanggal }}</td>
                            <td class="px-6 py-4">{{ $konsultasi->jenis_kasus }}</td>
                            <td class="px-6 py-4">{{ $konsultasi->status }}</td>
                            <td class="px-6 py-4">
                                @if($konsultasi->dokumens->isNotEmpty())
                                    @foreach($konsultasi->dokumens as $dokumen)
                                        <a href="{{ route('dokumens.preview', $dokumen->id) }}" 
                                        class="text-indigo-600 hover:underline" target="_blank">
                                            {{ $dokumen->nama_dokumen }}
                                        </a><br>
                                    @endforeach
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                                    @if($konsultasi->status === 'pending')
                                        <a href="{{ route('konsultasis.edit', $konsultasi->id) }}"
                                            class="text-blue-600 hover:underline">Atur Advokat & Jadwal</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $konsultasis->links('vendor.pagination.custom') }}
        </div>
    </div>
</x-app-layout>
