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

        @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin')
            <a href="{{ route('konsultasi.create') }}"
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">+ Tambah Konsultasi</a>
        @endif

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
                                @if($konsultasi->dokumen)
                                    <a href="{{ route('konsultasi.preview', $konsultasi->id) }}"
                                       class="text-indigo-600 hover:underline" target="_blank">Lihat Dokumen</a>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                    <a href="{{ route('konsultasi.edit', $konsultasi->id) }}"
                                       class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('konsultasi.destroy', $konsultasi->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                class="text-red-600 hover:underline">Hapus</button>
                                    </form>
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

        {{ $konsultasis->links() }}
    </div>
</x-app-layout>
