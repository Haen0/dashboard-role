<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Klien</h2>
    </x-slot>

    <div class="p-4 mx-auto bg-white rounded-lg shadow-md border border-gray-200">
        <form method="POST" action="{{ route('klients.update', $klient->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                <input type="text" name="nama" id="nama"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required value="{{ old('nama', $klient->nama) }}">
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required value="{{ old('email', $klient->email) }}">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telepon --}}
            <div>
                <label for="telepon" class="block mb-2 text-sm font-medium text-gray-900">Telepon</label>
                <input type="text" name="telepon" id="telepon"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required value="{{ old('telepon', $klient->telepon) }}">
                @error('telepon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>{{ old('alamat', $klient->alamat) }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-2 pt-2">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none 
                    focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Update
                </button>
                <a href="{{ route('klients.index') }}"
                    class="text-gray-600 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none 
                    focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
