@extends('layouts.auth')

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 mx-auto">
                <div class="card">
                    <div class="card-body p-0 bg-black auth-header-box rounded-top">
                        <div class="text-center p-3">
                            <a href="{{ url('/') }}" class="logo logo-admin">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"
                                    class="auth-logo">
                            </a>
                            <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Log in to your account</h4>
                            <p class="text-muted fw-medium mb-0">Enter your email and password below.</p>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form class="my-4" method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

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

                            <div class="text-end mb-3">
                                <a href="{{ route('password.request') }}" class="text-muted small">
                                    Forgot your password?
                                </a>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-primary" type="submit">Log In <i
                                        class="fas fa-sign-in-alt ms-1"></i></button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p class="text-muted">Don't have an account? <a href="{{ route('register') }}"
                                    class="text-primary ms-1">Register</a></p>
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
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(function(el) {
                el.addEventListener('click', function() {
                    const target = document.querySelector(el.getAttribute('toggle'));
                    const type = target.getAttribute('type') === 'password' ? 'text' : 'password';
                    target.setAttribute('type', type);
                    el.classList.toggle('fa-eye');
                    el.classList.toggle('fa-eye-slash');
                });
            });

            // Show validation errors or warning alerts
            @if ($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '{{ $error }}<br>';
                @endforeach
                Swal.fire({
                    icon: 'warning',
                    title: 'Login failed',
                    html: errorMessages,
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Login failed',
                    text: '{{ session('error') }}',
                });
            @endif
        </script>
    @endpush
@endsection
