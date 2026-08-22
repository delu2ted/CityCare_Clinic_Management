<x-guest-layout>
    <p class="text-muted small mb-3">Thanks for signing up! Before continuing, please verify your email by clicking the link we just sent you. Didn't get it? We'll gladly send another.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success small">A new verification link has been sent to your email address.</div>
    @endif

    <div class="d-flex align-items-center justify-content-between mt-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">Resend Verification Email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link btn-sm text-decoration-none">Log Out</button>
        </form>
    </div>
</x-guest-layout>