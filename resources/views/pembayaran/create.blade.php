<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Tagihan</h2>
    </x-slot>

    <div class="p-4 mx-auto bg-white rounded-lg shadow-md border border-gray-200">
        <form method="POST" action="{{ route('pembayaran.store') }}" class="space-y-4">
            @csrf

            {{-- Konsultasi --}}
            <div>
                <label for="konsultasi_id" class="block text-sm font-medium text-gray-900">Konsultasi</label>
                <select name="konsultasi_id" id="konsultasi_id" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Pilih Konsultasi --</option>
                    @foreach ($konsultasis as $k)
                        <option value="{{ $k->id }}">
                            {{ $k->klien->nama ?? '-' }} - {{ $k->advokat->nama ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('konsultasi_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-900">Jumlah (Rp)</label>
                <input type="number" name="jumlah" id="jumlah" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @error('jumlah')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-900">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @error('tanggal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Metode --}}
            <div>
                <label for="metode" class="block text-sm font-medium text-gray-900">Metode Pembayaran</label>
                <select name="metode" id="metode" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Pilih Metode --</option>
                    <option value="transfer">Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="qris">QRIS</option>
                </select>
                @error('metode')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex gap-2 pt-2">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none 
                    focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Simpan
                </button>
                <a href="{{ route('pembayaran.index') }}"
                    class="text-gray-600 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none 
                    focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
