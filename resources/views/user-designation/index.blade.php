@extends('layouts.dashboard')

@push('styles')
    <link href="{{ asset('assets/libs/simple-datatables/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/tablehighlight.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Table User Designation</h5>
                        <button class="btn bg-primary text-white" data-bs-toggle="modal"
                            data-bs-target="#addUserDesignation">
                            <i class="fas fa-plus me-1"></i> Add User Designation
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0" id="datatable_1">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($designations as $designation)
                                        <tr style="cursor: pointer;" data-bs-toggle="modal"
                                            data-bs-target="#editUserDesignationModal{{ $designation->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $designation->user->name }}</td>
                                            <td>{{ $designation->user->email }}</td>
                                            <td>{{ $designation->role->name }}</td>
                                            <td>{{ $designation->position->name }}</td>
                                            <td>
                                                <span class="badge rounded text-success bg-success-subtle">
                                                    {{ $designation->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($designations->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No designations found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    @include('user-designation.components.add-modal')
    @include('user-designation.components.edit-modal')
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        @endif

        @if (session('validation_errors'))
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', session('validation_errors')) !!}`,
            });
        @endif
    </script>
@endpush