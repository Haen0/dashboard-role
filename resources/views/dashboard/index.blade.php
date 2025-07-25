<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="p-4">
        @if(auth()->user()->role === 'klien')
            <h3 class="text-lg font-semibold mb-3">Tagihan Anda</h3>
            <div class="overflow-x-auto relative shadow-md rounded-lg bg-white">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3">Tanggal</th>
                            <th scope="col" class="px-4 py-3">Advokat</th>
                            <th scope="col" class="px-4 py-3">Jumlah</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tagihan as $t)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $t->tanggal }}</td>
                                <td class="px-4 py-2">{{ $t->konsultasi->advokat->nama ?? '-' }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded 
                                        {{ $t->status === 'belum_bayar' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @if($t->status === 'belum_bayar')
                                        <a href="{{ route('pembayaran.bayar', $t->id) }}"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                            Bayar / Upload Bukti
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-gray-400">
                                    Tidak ada tagihan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">Selamat datang di dashboard.</p>
        @endif
    </div>
</x-app-layout>
