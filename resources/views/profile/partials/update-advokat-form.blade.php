<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Informasi Advokat') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update spesialisasi atau data lainnya untuk advokat.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.advokat') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Spesialis -->
        <div>
            <label for="spesialis" class="block mb-2 text-sm font-medium text-gray-900">
                {{ __('Spesialis') }}
            </label>
            <input
                id="spesialis"
                name="spesialis"
                type="text"
                value="{{ old('spesialis', $advokat?->spesialis) }}"
                required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            />
            @if ($errors->has('spesialis'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('spesialis') }}</p>
            @endif
        </div>

        <!-- Telepon -->
        <div>
            <label for="telepon" class="block mb-2 text-sm font-medium text-gray-900">
                {{ __('Telepon') }}
            </label>
            <input
                id="telepon"
                name="telepon"
                type="text"
                value="{{ old('telepon', $advokat?->telepon) }}"
                required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            />
            @if ($errors->has('telepon'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('telepon') }}</p>
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

            @if (session('status') === 'advokat-updated')
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
