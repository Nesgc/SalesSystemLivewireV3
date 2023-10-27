<x-guest-layout>
    <div class="container mt-5">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required
                    autofocus autocomplete="name">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="form-group mt-4">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}"
                    required autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="form-group mt-4">
                <label for="password">{{ __('Password') }}</label>
                <input type="password" id="password" class="form-control" name="password" required
                    autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="form-group mt-4">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a class="btn btn-link" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <button type="submit" class="btn btn-primary ml-4">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
