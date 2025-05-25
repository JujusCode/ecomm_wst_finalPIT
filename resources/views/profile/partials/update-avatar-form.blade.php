<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your account profile avatar.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        
        <!-- Hidden field to indicate this is an avatar update -->
        <input type="hidden" name="update_type" value="avatar">

        <div>
            <div class="flex items-center mb-4">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-20 h-20 object-cover rounded-full mr-4" alt="User Avatar">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                        <span class="text-gray-500 text-2xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                @endif
                <div>
                    <h3 class="text-md font-medium">Current Avatar</h3>
                    <p class="text-sm text-gray-500">JPG, PNG or JPEG (max. 2MB)</p>
                </div>
            </div>

            <input
                id="avatar"
                name="avatar"
                type="file"
                class="mt-1 block w-full"
                accept="image/png, image/jpeg, image/jpg"
            />

            @error('avatar')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Save Avatar') }}
            </button>

            @if (session('status') === 'avatar-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Avatar saved.') }}</p>
            @endif
        </div>
    </form>
</section>