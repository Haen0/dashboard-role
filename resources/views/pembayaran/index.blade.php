<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Data Tagihan</h2>
    </x-slot>

    <div class="p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
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
                    <option value="belum_bayar" @selected(request('status') == 'belum_bayar')>Belum Bayar</option>
                    <option value="menunggu_konfirmasi" @selected(request('status') == 'menunggu_konfirmasi')>Menunggu Konfirmasi</option>
                    <option value="sudah_bayar" @selected(request('status') == 'sudah_bayar')>Sudah Bayar</option>
                </select>
            </div>

            <div>
                <input name="tanggal" value="{{ request('tanggal') }}"
                    type="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Filter
                </button>
                <a href="{{ route('pembayaran.index') }}"
                    class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Reset
                </a>
            </div>
        </form>

        <div class="overflow-x-auto relative shadow-md rounded-lg bg-white">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Klien</th>
                        <th class="px-4 py-3">Advokat</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Invoice</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayarans as $p)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $p->konsultasi->klien->nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $p->konsultasi->advokat->nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $p->jumlah ? 'Rp '.number_format($p->jumlah, 0, ',', '.') : '-' }}</td>
                            <td class="px-4 py-2">{{ $p->tanggal ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('pembayaran.invoice', $p->id) }}"
                                    class="text-blue-600 hover:underline">Unduh</a>
                            </td>
                            <td class="px-4 py-2">{{ ucfirst(str_replace('_',' ',$p->status)) }}</td>
                            <td class="px-4 py-2 space-x-2">
                                @if($p->tanggal === '')
                                    <a href="{{ route('pembayaran.edit', $p->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                @endif

                                @if($p->status === 'belum_bayar')
                                    <form action="{{ route('pembayaran.konfirmasi', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="text-green-600 hover:underline">Konfirmasi</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pembayarans->links('vendor.pagination.custom') }}</div>
    </div>
</x-app-layout>
