<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Tagihan</h2>
    </x-slot>

    <div class="p-4 max-w-lg mx-auto bg-white rounded shadow">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Klien</label>
                <p class="text-gray-900 font-semibold">{{ $pembayaran->konsultasi->klien->nama ?? '-' }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Advokat</label>
                <p class="text-gray-900 font-semibold">{{ $pembayaran->konsultasi->advokat->nama ?? '-' }}</p>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Tagihan (Rp)</label>
                <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $pembayaran->jumlah) }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Tagihan</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $pembayaran->tanggal) }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('pembayaran.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Kembali
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
