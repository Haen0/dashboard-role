<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="p-4">
        @if(auth()->user()->role === 'klien')
            <h3 class="text-lg font-semibold mb-3">Tagihan Anda</h3>

            {{-- Filter Form --}}
            <form method="GET" class="flex flex-wrap gap-3 items-center mb-4">
                <div>
                    <input name="jenis_kasus" value="{{ request('jenis_kasus') }}"
                        type="text"
                        placeholder="Cari jenis kasus"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5" />
                </div>

                <div>
                    <select name="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-36 p-2.5">
                        <option value="">Semua Status</option>
                        <option value="belum_bayar" @selected(request('status') == 'belum_bayar')>Belum Bayar</option>
                        <option value="lunas" @selected(request('status') == 'lunas')>Lunas</option>
                    </select>
                </div>

                <div>
                    <input name="start_date" value="{{ request('start_date') }}"
                        type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-44 p-2.5" />
                </div>

                <div>
                    <input name="end_date" value="{{ request('end_date') }}"
                        type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-44 p-2.5" />
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                        Filter
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Tabel Tagihan --}}
            <div class="overflow-x-auto relative shadow-md rounded-lg bg-white">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Tanggal Dibuat</th>
                            <th class="px-4 py-3">Biaya Tagihan</th>
                            <th class="px-4 py-3">Jenis Kasus</th>
                            <th class="px-4 py-3">Ringkasan</th>
                            <th class="px-4 py-3">Unduh Invoice</th>
                            <th class="px-4 py-3">Status Pembayaran</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tagihan as $t)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $t->tanggal }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $t->konsultasi->jenis_kasus ?? '-' }}</td>
                                <td class="px-4 py-2">{{ Str::limit($t->konsultasi->ringkasan, 40, '...') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('pembayaran.invoice', $t->id) }}"
                                        class="text-blue-600 hover:underline text-xs">Unduh</a>
                                </td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded 
                                        {{ $t->status === 'belum_bayar' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst(str_replace('_',' ', $t->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @if($t->status === 'belum_bayar')
                                        <a href="{{ route('pembayaran.bayar', $t->id) }}"
                                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                            Bayar / Upload Bukti
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                                    Tidak ada tagihan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tagihan->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        @else
            <p class="text-gray-600">Selamat datang di dashboard.</p>
        @endif
    </div>
</x-app-layout>
