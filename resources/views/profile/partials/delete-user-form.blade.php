<section class="space-y-6">
    <header>
        <p class="mt-1 text-sm" style="color: #666; margin-bottom: 1rem;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        style="padding: 0.8rem 1.5rem; background: #dc3545; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6" style="padding: 2rem;">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900" style="margin-bottom: 1rem; color: #dc3545;">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600" style="margin-bottom: 1.5rem; color: #666;">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6" style="margin-bottom: 1.5rem;">
                <label for="password" class="sr-only" style="display:block; font-weight: bold; margin-bottom: 0.5rem;">{{ __('Password') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    style="width:100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ccc;"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" style="color: red; font-size: 0.9rem;" />
            </div>

            <div class="mt-6 flex justify-end" style="display: flex; gap: 1rem; justify-content: flex-end;">
                <x-secondary-button x-on:click="$dispatch('close')" style="padding: 0.8rem 1.5rem; background: #eee; color: #333; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" style="padding: 0.8rem 1.5rem; background: #dc3545; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
