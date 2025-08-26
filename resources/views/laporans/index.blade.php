<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Laporan</h2>
    </x-slot>

    <div class="p-4 space-y-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif

        <div class="flex justify-between">
            @if(in_array(auth()->user()->role, ['admin', 'superadmin', 'keuangan', 'manajer']))
                <a href="{{ route('laporans.create') }}"
                   class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">Input Laporan</a>
            @endif
            {{-- <a href="#" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2">Cetak PDF</a> --}}
            <a href="{{ route('laporans.pdf') }}" target="_blank"
                class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2">
                Cetak PDF
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Periode Laporan</th>
                        <th class="px-6 py-3">Jumlah Kasus</th>
                        <th class="px-6 py-3">Jumlah Konsultasi</th>
                        <th class="px-6 py-3">Catatan</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporans as $laporan)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($laporan->tanggal_dari)->format('d-m-Y') }}
                                s/d
                                {{ \Carbon\Carbon::parse($laporan->tanggal_ke)->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4">{{ $laporan->jumlah_kasus }}</td>
                            <td class="px-6 py-4">{{ $laporan->jumlah_konsultasi }}</td>
                            <td class="px-6 py-4">{{ $laporan->catatan_manajer ?? '-' }}</td>
                            <td class="px-6 py-4 space-x-2">
                                @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'manajer')
                                    @if(!$laporan->catatan_manajer)
                                        <a href="{{ route('laporans.edit', $laporan->id) }}"
                                           class="text-blue-600 hover:underline">Isi Catatan</a>
                                    @else
                                        <span class="text-green-600">✔️ Sudah Diisi</span>
                                    @endif
                                @endif
                                @if(in_array(auth()->user()->role, ['admin', 'superadmin', 'keuangan', 'manajer']))
                                    <form action="{{ route('laporans.destroy', $laporan->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>{{ $laporans->links() }}</div>
    </div>
</x-app-layout>
