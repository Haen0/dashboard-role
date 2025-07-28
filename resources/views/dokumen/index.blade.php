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
                <a href="{{ route('dokumen.hukum.index') }}"
                    class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Reset
                </a>
            </div>
        </form>

        <div class="overflow-x-auto relative shadow-md rounded-lg bg-white">
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
                                    <a href="{{ route('dokumens.preview', $dok_admin->id) }}" target="_blank"
                                    class="text-blue-600 hover:underline font-medium">
                                        {{ $dok_admin->nama_dokumen }}
                                    </a>
                                @elseif(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                    <form action="{{ route('dokumen.hukum.upload.admin', $k->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                        @csrf
                                        <input type="file" name="dokumen"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none">
                                        <button type="submit"
                                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                            Upload
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">Belum ada</span>
                                @endif
                            </td>

                            <td class="px-4 py-2">
                                @if($dok_adv)
                                    <a href="{{ route('dokumens.preview', $dok_adv->id) }}" target="_blank"
                                    class="text-blue-600 hover:underline font-medium">
                                        {{ $dok_adv->nama_dokumen }}
                                    </a>
                                @elseif(auth()->user()->role === 'advokat')
                                    <form action="{{ route('dokumen.hukum.upload.advokat', $k->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                        @csrf
                                        <input type="file" name="dokumen"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none">
                                        <button type="submit"
                                                class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                            Upload
                                        </button>
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
