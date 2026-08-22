<x-dashboard-layout>
    <h2 class="h4 mb-4">Profile Settings</h2>

    <div class="dash-panel mb-3">
        <h6 class="mb-3">Profile Information</h6>
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="dash-panel mb-3">
        <h6 class="mb-3">Update Password</h6>
        @include('profile.partials.update-password-form')
    </div>

    <div class="dash-panel border-danger">
        <h6 class="mb-3 text-danger">Delete Account</h6>
        @include('profile.partials.delete-user-form')
    </div>
</x-dashboard-layout>