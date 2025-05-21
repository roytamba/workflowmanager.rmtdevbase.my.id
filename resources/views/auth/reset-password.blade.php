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
                            <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Reset Your Password</h4>
                            <p class="text-muted fw-medium mb-0">
                                Enter your email, new password, and confirmation.
                            </p>
                        </div>
                    </div>

                    <div class="card-body pt-3">
                        <form method="POST" action="{{ route('password.update') }}" class="my-4">
                            @csrf

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email', $request->email) }}" required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input id="password_confirmation" type="password"
                                       class="form-control"
                                       name="password_confirmation" required>
                            </div>

                            <div class="form-group mb-0 row">
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        Reset Password
                                        <i class="fas fa-sync-alt ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end card-body-->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('status') }}',
                timer: 3500,
                timerProgressBar: true,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
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
