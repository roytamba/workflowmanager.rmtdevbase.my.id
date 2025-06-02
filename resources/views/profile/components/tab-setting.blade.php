<div class="tab-pane p-3 active" id="settings" role="tabpanel">
    <!-- Update Profile -->
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title">Update Profile</h4>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('user-profile-information.update') }}">
                @csrf
                @method('PUT')

                {{-- Full Name --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="name">Full Name</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text"
                            name="name" value="{{ old('name', $user->name) }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="email">Email</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                            name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Address --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="address">Address</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="address" class="form-control" type="text" name="address"
                            value="{{ old('address', optional($userDetail)->address) }}">
                    </div>
                </div>

                {{-- Website --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="website">Website</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="website" class="form-control" type="text" name="website"
                            value="{{ old('website', optional($userDetail)->website) }}">
                    </div>
                </div>

                {{-- Facebook --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="facebook">Facebook</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="facebook" class="form-control" type="text" name="facebook"
                            value="{{ old('facebook', optional($userDetail)->facebook) }}">
                    </div>
                </div>

                {{-- X (Twitter) --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="x">X (Twitter)</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="x" class="form-control" type="text" name="x"
                            value="{{ old('x', optional($userDetail)->x) }}">
                    </div>
                </div>

                {{-- Instagram --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="instagram">Instagram</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="instagram" class="form-control" type="text" name="instagram"
                            value="{{ old('instagram', optional($userDetail)->instagram) }}">
                    </div>
                </div>

                {{-- Phone --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="phone">Phone</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="phone" class="form-control" type="text" name="phone"
                            value="{{ old('phone', optional($userDetail)->phone) }}">
                    </div>
                </div>

                {{-- Bio / Quotes --}}
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="bio">Bio / About</label>
                    <div class="col-lg-9 col-xl-8">
                        <textarea id="bio" class="form-control" name="bio" rows="3">{{ old('bio', optional($userDetail)->bio) }}</textarea>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="form-group row">
                    <div class="col-lg-9 col-xl-8 offset-lg-3">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title">Update Password</h4>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('user-password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="update_current_password">Current
                        Password</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="update_current_password"
                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                            type="password" name="current_password" required autocomplete="current-password">

                        @error('current_password', 'updatePassword')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="update_password">New Password</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="update_password"
                            class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                            type="password" name="password" required autocomplete="new-password">

                        @error('password', 'updatePassword')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="update_password_confirmation">Confirm
                        Password</label>
                    <div class="col-lg-9 col-xl-8">
                        <input id="update_password_confirmation" class="form-control" type="password"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-9 col-xl-8 offset-lg-3">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Delete Account (Updated) -->
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title text-danger">Delete Account</h4>
        </div>
        <div class="card-body pt-0">
            <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <p class="text-muted mb-3">
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                    Please enter your password to confirm.
                </p>

                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end form-label" for="password">Password</label>
                    <div class="col-lg-9 col-xl-8">
                        <!-- Changed field name from delete_password to password -->
                        <input id="password" class="form-control @error('password') is-invalid @enderror"
                            type="password" name="password" required>

                        @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-9 col-xl-8 offset-lg-3">
                        <button type="button" class="btn btn-danger" id="delete-btn">Delete Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initFormValidations();
        });

        function initFormValidations() {
            handleDeleteAccountValidation();
            handleProfileUpdateValidation();
            handlePasswordUpdateValidation();
        }

        function handleDeleteAccountValidation() {
            const form = document.getElementById('delete-account-form');
            const btn = document.getElementById('delete-btn');
            const password = document.getElementById('password');

            btn.addEventListener('click', () => {
                if (!password.value.trim()) {
                    showFieldError(password, 'The password field is required.');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete my account'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }

        function handleProfileUpdateValidation() {
            const form = document.querySelector('form[action*="user-profile-information.update"]');
            if (!form) return;

            const name = form.querySelector('#name');
            const email = form.querySelector('#email');

            form.addEventListener('submit', function(e) {
                let hasError = false;

                if (!name.value.trim()) {
                    showFieldError(name, 'Name is required.');
                    hasError = true;
                }

                if (!email.value.trim()) {
                    showFieldError(email, 'Email is required.');
                    hasError = true;
                }

                if (hasError) e.preventDefault();
            });
        }

        function handlePasswordUpdateValidation() {
            const form = document.querySelector('form[action*="user-password.update"]');
            if (!form) return;

            const current = form.querySelector('#update_current_password');
            const password = form.querySelector('#update_password');
            const confirm = form.querySelector('#update_password_confirmation');

            form.addEventListener('submit', function(e) {
                let hasError = false;

                if (!current.value.trim()) {
                    showFieldError(current, 'Current password is required.');
                    hasError = true;
                }

                if (!password.value.trim()) {
                    showFieldError(password, 'New password is required.');
                    hasError = true;
                }

                if (confirm.value !== password.value) {
                    showFieldError(confirm, 'Passwords do not match.');
                    hasError = true;
                }

                if (hasError) e.preventDefault();
            });
        }

        function showFieldError(field, message) {
            field.classList.add('is-invalid');
            let error = field.nextElementSibling;
            if (!error || !error.classList.contains('invalid-feedback')) {
                error = document.createElement('span');
                error.classList.add('invalid-feedback');
                error.setAttribute('role', 'alert');
                field.parentNode.appendChild(error);
            }
            error.textContent = message;
            error.style.display = 'block';
        }

        function removeFieldError(field) {
            field.classList.remove('is-invalid');
            const error = field.nextElementSibling;
            if (error && error.classList.contains('invalid-feedback')) {
                error.style.display = 'none';
            }
        }

        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('status') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Something went wrong!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
            });
        @endif
    </script>
@endpush
