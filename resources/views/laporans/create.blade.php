<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Laporan</h2>
    </x-slot>

    <div class="p-4 bg-white rounded shadow">
        <form action="{{ route('laporans.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Periode Tanggal --}}
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Periode Laporan</label>
                <div class="flex space-x-2">
                    <input type="date" name="tanggal_dari" required
                           class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5"
                           value="{{ old('tanggal_dari') }}" />
                    <span class="self-center">s/d</span>
                    <input type="date" name="tanggal_ke" required
                           class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5"
                           value="{{ old('tanggal_ke') }}" />
                </div>
                @error('tanggal_dari') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('tanggal_ke') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jumlah Kasus --}}
            {{-- <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Jumlah Kasus</label>
                <input type="number" value="{{ $jumlah_kasus }}" disabled
                       class="bg-gray-100 border border-gray-300 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" />
            </div> --}}

            {{-- Jumlah Konsultasi --}}
            {{-- <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Jumlah Konsultasi</label>
                <input type="number" value="{{ $jumlah_konsultasi }}" disabled
                       class="bg-gray-100 border border-gray-300 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" />
            </div> --}}

            {{-- Jumlah Kasus --}}
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Jumlah Kasus</label>
                <input type="number" id="jumlah_kasus" value="0" disabled
                    class="bg-gray-100 border border-gray-300 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" />
            </div>

            {{-- Jumlah Konsultasi --}}
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Jumlah Konsultasi</label>
                <input type="number" id="jumlah_konsultasi" value="0" disabled
                    class="bg-gray-100 border border-gray-300 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" />
            </div>

            {{-- Tombol Submit --}}
            <div>
                <button type="submit"
                        class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dari = document.querySelector('input[name="tanggal_dari"]');
            const ke   = document.querySelector('input[name="tanggal_ke"]');
            const jumlahKasus = document.getElementById('jumlah_kasus');
            const jumlahKonsultasi = document.getElementById('jumlah_konsultasi');

            function updateJumlah() {
                if (dari.value && ke.value) {
                    fetch(`{{ route('laporans.hitung') }}?tanggal_dari=${dari.value}&tanggal_ke=${ke.value}`)
                        .then(res => res.json())
                        .then(data => {
                            jumlahKasus.value = data.jumlah_kasus;
                            jumlahKonsultasi.value = data.jumlah_konsultasi;
                        });
                }
            }

            dari.addEventListener('change', updateJumlah);
            ke.addEventListener('change', updateJumlah);
        });
    </script>

</x-app-layout>
