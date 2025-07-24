<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Informasi Klien') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update nomor telepon dan alamat Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.klien') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Telepon -->
        <div>
            <label for="telepon" class="block mb-2 text-sm font-medium text-gray-900">
                {{ __('Telepon') }}
            </label>
            <input
                id="telepon"
                name="telepon"
                type="text"
                value="{{ old('telepon', $klien?->telepon) }}"
                required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            />
            @if ($errors->has('telepon'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('telepon') }}</p>
            @endif
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">
                {{ __('Alamat') }}
            </label>
            <input
                id="alamat"
                name="alamat"
                type="text"
                value="{{ old('alamat', $klien?->alamat) }}"
                required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            />
            @if ($errors->has('alamat'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('alamat') }}</p>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
            >
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'klien-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
