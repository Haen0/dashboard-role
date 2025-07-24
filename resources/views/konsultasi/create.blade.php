<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
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
</form>
