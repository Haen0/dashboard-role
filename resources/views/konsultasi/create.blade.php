{{-- <form method="POST" action="{{ route('konsultasi.store') }}" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <label>Klien</label>
    <select name="klien_id" class="w-full border rounded mb-2">
        @foreach($klients as $klien)
            <option value="{{ $klien->id }}" @selected(old('klien_id', $konsultasi->klien_id ?? '') == $klien->id)>{{ $klien->nama }}</option>
        @endforeach
    </select>

    <label>Advokat</label>
    <select name="advokat_id" class="w-full border rounded mb-2">
        @foreach($advokats as $advokat)
            <option value="{{ $advokat->id }}" @selected(old('advokat_id', $konsultasi->advokat_id ?? '') == $advokat->id)>{{ $advokat->nama }}</option>
        @endforeach
    </select>

    <input type="date" name="tanggal" value="{{ old('tanggal', $konsultasi->tanggal ?? '') }}" class="w-full border mb-2">

    <input type="text" name="jenis_kasus" value="{{ old('jenis_kasus', $konsultasi->jenis_kasus ?? '') }}" class="w-full border mb-2" placeholder="Jenis Kasus">

    <textarea name="ringkasan" class="w-full border mb-2" placeholder="Ringkasan">{{ old('ringkasan', $konsultasi->ringkasan ?? '') }}</textarea>

    <select name="status" class="w-full border mb-2">
        @foreach(['pending', 'diproses', 'selesai'] as $status)
            <option value="{{ $status }}" @selected(old('status', $konsultasi->status ?? '') == $status)>{{ ucfirst($status) }}</option>
        @endforeach
    </select>

    <input type="file" name="dokumen" class="mb-4">

    <button class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
</form> --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Ajukan Konsultasi</h2>
    </x-slot>

    <div class="p-4 bg-white shadow rounded">
        <form action="{{ route('konsultasis.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Klien (hanya tampil jika role = admin) --}}
            @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                <div class="mb-4">
                    <label for="klien_id" class="block text-sm font-medium text-gray-700">Klien</label>
                    <select name="klien_id" id="klien_id" class="mt-1 block w-full border-gray-300 rounded">
                        @foreach($klients as $klien)
                            <option value="{{ $klien->id }}">{{ $klien->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Advokat --}}
                <div class="mb-4">
                    <label for="advokat_id" class="block text-sm font-medium text-gray-700">Pilih Advokat</label>
                    <select name="advokat_id" id="advokat_id" class="mt-1 block w-full border-gray-300 rounded">
                        @foreach($advokats as $advokat)
                        <option value="{{ $advokat->id }}">{{ $advokat->nama }} - {{ $advokat->spesialis }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Tanggal --}}
            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full border-gray-300 rounded">
            </div>

            {{-- Jenis Kasus --}}
            <div class="mb-4">
                <label for="jenis_kasus" class="block text-sm font-medium text-gray-700">Jenis Kasus</label>
                <input type="text" name="jenis_kasus" id="jenis_kasus" class="mt-1 block w-full border-gray-300 rounded" placeholder="Contoh: Perdata">
            </div>

            {{-- Ringkasan --}}
            <div class="mb-4">
                <label for="ringkasan" class="block text-sm font-medium text-gray-700">Ringkasan</label>
                <textarea name="ringkasan" id="ringkasan" rows="4" class="mt-1 block w-full border-gray-300 rounded"></textarea>
            </div>

            {{-- Upload Dokumen --}}
            <div class="mb-4">
                <label for="dokumen" class="block text-sm font-medium text-gray-700">Upload Dokumen Pendukung (opsional)</label>
                <input type="file" name="dokumen" id="dokumen" class="mt-1 block w-full">
            </div>

            {{-- Tombol Submit --}}
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Ajukan Konsultasi
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
