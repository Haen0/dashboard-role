<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Advokat</h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto bg-white shadow rounded">
        <form method="POST" action="{{ route('advokats.store') }}">
            @csrf

            <x-input-label for="nama" value="Nama" />
            <x-text-input name="nama" class="w-full mb-2" required />

            <x-input-label for="spesialis" value="Spesialis" />
            <x-text-input name="spesialis" class="w-full mb-2" />

            <x-input-label for="email" value="Email" />
            <x-text-input type="email" name="email" class="w-full mb-2" required />

            <x-input-label for="telepon" value="Telepon" />
            <x-text-input name="telepon" class="w-full mb-4" />

            <x-primary-button>Simpan</x-primary-button>
            <a href="{{ route('advokats.index') }}" class="ml-2 text-sm text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>
