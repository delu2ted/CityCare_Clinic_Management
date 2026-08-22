<x-guest-layout>
    <p class="text-muted small mb-3">Forgot your password? No problem. Enter your email and we'll send you a password reset link.</p>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Email Password Reset Link</button>
        </div>
    </form>
</x-guest-layout>