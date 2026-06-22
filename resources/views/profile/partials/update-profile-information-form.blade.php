<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div style="margin-bottom: 1rem;">
        <label for="name" style="display:block; font-weight: bold; margin-bottom: 0.5rem;">Nama</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" style="width:100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ccc;">
        <x-input-error class="mt-2" :messages="$errors->get('name')" style="color: red; font-size: 0.9rem;" />
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="email" style="display:block; font-weight: bold; margin-bottom: 0.5rem;">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" style="width:100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ccc;">
        <x-input-error class="mt-2" :messages="$errors->get('email')" style="color: red; font-size: 0.9rem;" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="phone" style="display:block; font-weight: bold; margin-bottom: 0.5rem;">Nomor HP</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" style="width:100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ccc;">
        <x-input-error class="mt-2" :messages="$errors->get('phone')" style="color: red; font-size: 0.9rem;" />
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="avatar" style="display:block; font-weight: bold; margin-bottom: 0.5rem;">Foto Profil</label>
        <input id="avatar" name="avatar" type="file" accept="image/*" style="width:100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ccc;">
        <x-input-error class="mt-2" :messages="$errors->get('avatar')" style="color: red; font-size: 0.9rem;" />
    </div>

    <div style="display: flex; align-items: center; gap: 1rem;">
        <button type="submit" style="padding: 0.8rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Simpan Perubahan</button>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                style="color: #28a745; font-weight: bold; margin: 0;"
            >Tersimpan.</p>
        @endif
    </div>
</form>
