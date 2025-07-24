<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Advokat</h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto bg-white shadow rounded">
        <form method="POST" action="{{ route('advokats.update', $advokat) }}">
            @csrf @method('PUT')

            <x-input-label for="nama" value="Nama" />
            <x-text-input name="nama" class="w-full mb-2" value="{{ old('nama', $advokat->nama) }}" required />

            <x-input-label for="spesialis" value="Spesialis" />
            <x-text-input name="spesialis" class="w-full mb-2" value="{{ old('spesialis', $advokat->spesialis) }}" />

            <x-input-label for="email" value="Email" />
            <x-text-input type="email" name="email" class="w-full mb-2" value="{{ old('email', $advokat->email) }}" required />

            <x-input-label for="telepon" value="Telepon" />
            <x-text-input name="telepon" class="w-full mb-4" value="{{ old('telepon', $advokat->telepon) }}" />

            <x-primary-button>Update</x-primary-button>
            <a href="{{ route('advokats.index') }}" class="ml-2 text-sm text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>
