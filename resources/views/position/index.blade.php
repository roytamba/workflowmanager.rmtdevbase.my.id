@extends('layouts.dashboard')

@push('styles')
    <link href="{{ asset('assets/libs/simple-datatables/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/tablehighlight.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Table Position</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#addPosition">
                                <i class="fas fa-plus me-1"></i> Add Position
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Position Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($positions as $position)
                                    <tr style="cursor: pointer;" data-bs-toggle="modal"
                                        data-bs-target="#editPositionModal{{ $position->id }}">
                                        <td><strong>{{ $position->name }}</strong></td>
                                        <td>{{ $position->description ?? '-' }}</td>
                                        <td>
                                            <span class="badge rounded text-success bg-success-subtle">
                                                {{ $position->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('position.components.add-modal')
    @include('position.components.edit-modal')
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
                confirmButtonColor: '#3085d6',
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
            });
        @endif
    </script>
@endpush
