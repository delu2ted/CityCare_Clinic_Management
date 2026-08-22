<!DOCTYPE html>
<html>
<head>
    <title>Access Denied</title>
    @vite(['resources/css/app.css'])
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height:100vh;background:#f8f9fa;">
    <div class="text-center">
        <h1 class="display-4 fw-bold" style="color:#b08dc0;">403</h1>
        <p class="text-muted mb-4">{{ $exception->getMessage() ?: 'You do not have permission to access this page.' }}</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>