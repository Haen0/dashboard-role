<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Ajukan Konsultasi</h2>
    </x-slot>

    <div class="p-6 mx-auto bg-white rounded-lg shadow-md border border-gray-200">
        <form action="{{ route('konsultasis.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Klien ( hanya tampil jika role = admin ) --}}
            @if(in_array(auth()->user()->role, ['admin', 'superadmin', 'manajer']))
                <div>
                    <label for="klien_id" class="block mb-2 text-sm font-medium text-gray-900">Klien</label>
                    <select name="klien_id" id="klien_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @foreach($klients as $klien)
                            <option value="{{ $klien->id }}">{{ $klien->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Advokat --}}
                <div>
                    <label for="advokat_id" class="block mb-2 text-sm font-medium text-gray-900">Pilih Advokat</label>
                    <select name="advokat_id" id="advokat_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @foreach($advokats as $advokat)
                            <option value="{{ $advokat->id }}">{{ $advokat->nama }} - {{ $advokat->spesialis }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Tanggal --}}
            <div>
                <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            {{-- Jenis Kasus --}}
            <div>
                <label for="jenis_kasus" class="block mb-2 text-sm font-medium text-gray-900">Jenis Kasus</label>
                <input type="text" name="jenis_kasus" id="jenis_kasus"
                    placeholder="Contoh: Perdata"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            {{-- Ringkasan --}}
            <div>
                <label for="ringkasan" class="block mb-2 text-sm font-medium text-gray-900">Ringkasan</label>
                <textarea name="ringkasan" id="ringkasan" rows="4"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
            </div>

            {{-- Upload Dokumen --}}
            <div>
                <label for="dokumen" class="block mb-2 text-sm font-medium text-gray-900">Upload Dokumen Pendukung (opsional)</label>
                <input type="file" name="dokumen" id="dokumen"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none">
            </div>

            {{-- Tombol Submit --}}
            <div class="pt-2">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Ajukan Konsultasi
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
