<x-guest-layout>
    <h4 class="mb-4 text-center">Welcome Back</h4>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label small" for="remember_me">Remember me</label>
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary">Log In</button>
        </div>

        <div class="d-flex justify-content-between small">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a>
            @endif
            <a href="{{ route('register') }}" class="text-decoration-none">Create an account</a>
        </div>
    </form>
</x-guest-layout>