@extends('layouts.auth')

@section('content')
<div class="card-body">
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <div class="card">
                <div class="card-body p-0 bg-black auth-header-box rounded-top">
                    <div class="text-center p-3">
                        <a href="{{ url('/') }}" class="logo logo-admin">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo" class="auth-logo">
                        </a>
                        <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Create an account</h4>
                        <p class="text-muted fw-medium mb-0">Register with your information below.</p>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form class="my-4" method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                placeholder="Enter full name" value="{{ old('name') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Enter email" value="{{ old('email') }}">
                        </div>

                        <div class="form-group mb-3 position-relative">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Enter password">
                            <span toggle="#password" class="fa fa-fw fa-eye toggle-password"
                                  style="position: absolute; top: 38px; right: 15px; cursor: pointer;"></span>
                        </div>

                        <div class="form-group mb-3 position-relative">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required
                                placeholder="Confirm password">
                            <span toggle="#password_confirmation" class="fa fa-fw fa-eye toggle-password"
                                  style="position: absolute; top: 38px; right: 15px; cursor: pointer;"></span>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-primary" type="submit">Register <i class="fas fa-user-plus ms-1"></i></button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-primary ms-1">Log in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 & JS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Password match check
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;

        if (password !== confirm) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password and Confirm Password do not match!',
            });
        }
    });

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function (el) {
        el.addEventListener('click', function () {
            const target = document.querySelector(el.getAttribute('toggle'));
            const type = target.getAttribute('type') === 'password' ? 'text' : 'password';
            target.setAttribute('type', type);
            el.classList.toggle('fa-eye');
            el.classList.toggle('fa-eye-slash');
        });
    });

    // Show server-side email error if exists
    @if ($errors->has('email'))
        Swal.fire({
            icon: 'error',
            title: 'Email already used',
            text: '{{ $errors->first('email') }}',
        });
    @endif
</script>
@endpush
@endsection
