<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Bayar Tagihan</h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto bg-white rounded-lg shadow-md border border-gray-200">
        <h3 class="text-lg font-semibold mb-4">
            Tagihan Konsultasi (Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }})
        </h3>
        <p class="mb-4 text-sm text-gray-600">
            Silakan pilih metode pembayaran dan upload bukti transfer.
        </p>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-300" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pembayaran.upload', $pembayaran->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            {{-- Metode Pembayaran --}}
            <div>
                <label for="metode" class="block mb-2 text-sm font-medium text-gray-900">Metode Pembayaran</label>
                <select name="metode" id="metode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="transfer">Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="qris">QRIS</option>
                </select>
                @error('metode')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload Bukti Pembayaran --}}
            <div>
                <label for="bukti_pembayaran" class="block mb-2 text-sm font-medium text-gray-900">Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                @error('bukti_pembayaran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="text-right">
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Kirim Bukti
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
