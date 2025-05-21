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
                            <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Verify Your Email Address</h4>
                            <p class="text-muted fw-medium mb-0">
                                Before proceeding, please check your email for a verification link.
                            </p>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <form method="POST" action="{{ route('verification.send') }}" class="my-4">
                            @csrf
                            <div class="form-group mb-3 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Resend Verification Email
                                    <i class="fas fa-envelope ms-1"></i>
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="form-group mb-0 row">
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-danger">
                                        Logout
                                        <i class="fas fa-sign-out-alt ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted mb-1">Didn't receive the email?</p>
                            <p class="text-muted mb-0">Check your spam folder or try resending.</p>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end card-body-->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('message'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('message') }}',
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
