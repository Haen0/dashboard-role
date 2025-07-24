<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Atur Advokat & Jadwal Konsultasi</h2>
    </x-slot>

    <div class="p-4 bg-white shadow rounded">
        <form action="{{ route('konsultasis.update', $konsultasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Info Klien --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Klien</label>
                <input type="text" value="{{ $konsultasi->klien->nama ?? '-' }}" disabled
                    class="mt-1 block w-full border-gray-300 rounded bg-gray-100">
            </div>

            {{-- Advokat --}}
            <div class="mb-4">
                <label for="advokat_id" class="block text-sm font-medium text-gray-700">Pilih Advokat</label>
                <select name="advokat_id" id="advokat_id"
                        class="mt-1 block w-full border-gray-300 rounded">
                    <option value="">-- Pilih Advokat --</option>
                    @foreach($advokats as $advokat)
                        <option value="{{ $advokat->id }}" @selected($konsultasi->advokat_id == $advokat->id)>
                            {{ $advokat->nama }} - {{ $advokat->spesialis }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Konsultasi</label>
                <input type="date" name="tanggal" id="tanggal"
                    value="{{ $konsultasi->tanggal }}"
                    class="mt-1 block w-full border-gray-300 rounded">
            </div>

            {{-- Waktu --}}
            <div class="mb-4">
                <label for="waktu" class="block text-sm font-medium text-gray-700">Waktu Konsultasi</label>
                <input type="time" name="waktu" id="waktu"
                    value="{{ $konsultasi->jadwal->waktu ?? '' }}"
                    class="mt-1 block w-full border-gray-300 rounded">
            </div>

            {{-- Lokasi --}}
            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Konsultasi</label>
                <input type="text" name="lokasi" id="lokasi"
                    value="{{ $konsultasi->jadwal->lokasi ?? '' }}"
                    placeholder="Contoh: Kantor Advokat / Zoom"
                    class="mt-1 block w-full border-gray-300 rounded">
            </div>

            {{-- Tombol Submit --}}
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
