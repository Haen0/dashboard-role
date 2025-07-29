<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Atur Advokat & Jadwal Konsultasi</h2>
    </x-slot>

    <div class="p-6 mx-auto bg-white rounded-lg shadow-md border border-gray-200">
        <form action="{{ route('konsultasis.update', $konsultasi->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Info Klien --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Klien</label>
                <input type="text" value="{{ $konsultasi->klien->nama ?? '-' }}" disabled
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed">
            </div>

            {{-- Advokat --}}
            <div>
                <label for="advokat_id" class="block mb-2 text-sm font-medium text-gray-900">Pilih Advokat</label>
                <select name="advokat_id" id="advokat_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Pilih Advokat --</option>
                    @foreach($advokats as $advokat)
                        <option value="{{ $advokat->id }}" @selected($konsultasi->advokat_id == $advokat->id)>
                            {{ $advokat->nama }} - {{ $advokat->spesialis }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Konsultasi</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ $konsultasi->tanggal }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            {{-- Waktu --}}
            <div>
                <label for="waktu" class="block mb-2 text-sm font-medium text-gray-900">Waktu Konsultasi</label>
                <input type="time" name="waktu" id="waktu" value="{{ $konsultasi->jadwal->waktu ?? '' }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            {{-- Lokasi --}}
            <div>
                <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-900">Lokasi Konsultasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ $konsultasi->jadwal->lokasi ?? '' }}"
                    placeholder="Contoh: Kantor Advokat / Zoom"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            {{-- Tombol   Submit --}}
            <div class="pt-2">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
