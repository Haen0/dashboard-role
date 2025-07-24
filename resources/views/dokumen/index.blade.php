<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dokumen Hukum</h2>
    </x-slot>

    <div class="p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">{{ session('error') }}</div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3">Klien</th>
                        <th class="px-4 py-3">Advokat</th>
                        <th class="px-4 py-3">Dokumen Klien</th>
                        <th class="px-4 py-3">Dokumen Admin</th>
                        <th class="px-4 py-3">Dokumen Advokat</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($konsultasis as $k)
                        @php
                            $dok_klien = $k->dokumens->where('jenis_dokumen', 'klien')->first();
                            $dok_admin = $k->dokumens->where('jenis_dokumen', 'admin')->first();
                            $dok_adv   = $k->dokumens->where('jenis_dokumen', 'advokat')->first();
                        @endphp
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $k->klien->nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $k->advokat->nama ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if($dok_klien)
                                    <a href="{{ route('dokumens.preview', $dok_klien->id) }}" target="_blank" class="text-blue-600 underline">
                                        {{ $dok_klien->nama_dokumen }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Belum ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($dok_admin)
                                    <a href="{{ route('dokumens.preview', $dok_admin->id) }}" target="_blank" class="text-blue-600 underline">
                                        {{ $dok_admin->nama_dokumen }}
                                    </a>
                                @elseif(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                    <form action="{{ route('dokumen.hukum.upload.admin', $k->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="dokumen" class="text-sm mb-1">
                                        <button class="bg-blue-600 text-white px-2 py-1 rounded text-xs">Upload</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">Belum ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($dok_adv)
                                    <a href="{{ route('dokumens.preview', $dok_adv->id) }}" target="_blank" class="text-blue-600 underline">
                                        {{ $dok_adv->nama_dokumen }}
                                    </a>
                                @elseif(auth()->user()->role === 'advokat')
                                    <form action="{{ route('dokumen.hukum.upload.advokat', $k->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="dokumen" class="text-sm mb-1">
                                        <button class="bg-green-600 text-white px-2 py-1 rounded text-xs">Upload</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">Belum ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ ucfirst($k->status) }}</td>
                            <td class="px-4 py-2">
                                @if(($dok_klien && $dok_admin && $dok_adv) && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin') && $k->status !== 'selesai')
                                    <form action="{{ route('dokumen.hukum.selesaikan', $k->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-yellow-600 text-white px-3 py-1 rounded text-xs">Selesaikan</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $konsultasis->links('vendor.pagination.custom') }}
        </div>
    </div>
</x-app-layout>
