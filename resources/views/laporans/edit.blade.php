<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Isi Catatan Manajer</h2>
    </x-slot>

    <div class="p-4 bg-white rounded shadow">
        <form action="{{ route('laporans.update', $laporan->id) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Catatan Manajer</label>
                <textarea name="catatan_manajer" rows="5" class="w-full border rounded p-2"
                          required>{{ old('catatan_manajer', $laporan->catatan_manajer) }}</textarea>
            </div>

            <div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan Catatan
                </button>
                <a href="{{ route('laporans.index') }}"
                   class="ml-2 text-gray-600 hover:underline">Kembali</a>
            </div>
        </form>
    </div>
</x-app-layout>
