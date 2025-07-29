<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Laporan</h2>
    </x-slot>

    <div class="p-4 bg-white rounded shadow">
        <form action="{{ route('laporans.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Tipe Laporan</label>
                <select name="tipe" required
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5">
                    <option value="">Pilih Tipe</option>
                    <option value="harian">Harian</option>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" required
                       class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5" />
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Jumlah Kasus</label>
                <input type="number" value="{{ $jumlah_kasus }}" disabled
                       class="bg-gray-100 border border-gray-300 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" />
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Jumlah Konsultasi</label>
                <input type="number" value="{{ $jumlah_konsultasi }}" disabled
                       class="bg-gray-100 border border-gray-300 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" />
            </div>

            <div>
                <button type="submit"
                        class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
