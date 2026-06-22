<form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('put')

    <div style="margin-bottom: 1rem;">
        <label for="update_password_current_password" style="display:block; font-weight: bold; margin-bottom: 0.5rem;">Password Saat Ini</label>
        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" style="width:100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ccc;">
        <x-input-error :messages="$errors->updatePassword->get('current_password')" style="color: red; font-size: 0.9rem;" />
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="update_password_password" style="display:block; font-weight: bold; margin-bottom: 0.5rem;">Password Baru</label>
        <input id="update_password_password" name="password" type="password" autocomplete="new-password" style="width:100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ccc;">
        <x-input-error :messages="$errors->updatePassword->get('password')" style="color: red; font-size: 0.9rem;" />
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="update_password_password_confirmation" style="display:block; font-weight: bold; margin-bottom: 0.5rem;">Konfirmasi Password</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" style="width:100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ccc;">
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" style="color: red; font-size: 0.9rem;" />
    </div>

    <div style="display: flex; align-items: center; gap: 1rem;">
        <button type="submit" style="padding: 0.8rem 1.5rem; background: #333; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Update Password</button>

        @if (session('status') === 'password-updated')
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
