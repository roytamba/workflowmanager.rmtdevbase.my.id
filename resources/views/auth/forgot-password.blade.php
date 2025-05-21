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
                            <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Forgot Your Password?</h4>
                            <p class="text-muted fw-medium mb-0">We'll email you instructions to reset your password.</p>
                        </div>
                    </div>

                    <div class="card-body pt-3">
                        <form method="POST" action="{{ route('password.email') }}" class="my-4">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" id="email" class="form-control" required
                                    value="{{ old('email') }}" placeholder="Enter your email">
                            </div>

                            <div class="form-group mb-0 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Send Reset Link <i class="fas fa-paper-plane ms-1"></i>
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted">Remember your password? <a href="{{ route('login') }}"
                                    class="text-primary">Login here</a></p>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- end card-body -->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('status') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
@endpush
