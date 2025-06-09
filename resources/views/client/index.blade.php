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
                            <h4 class="card-title">Client Management</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#addClient">
                                <i class="fas fa-plus me-1"></i> Add Client
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Client Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr style="cursor: pointer;" data-bs-toggle="modal"
                                        data-bs-target="#editClientModal{{ $client->id }}">
                                        <td><strong>{{ $client->name }}</strong></td>
                                        <td>{{ $client->company_name ?? '-' }}</td>
                                        <td>{{ $client->email ?? '-' }}</td>
                                        <td>{{ $client->phone ?? '-' }}</td>
                                        <td>
                                            @if ($client->status === 'active')
                                                <span class="badge rounded text-success bg-success-subtle">Active</span>
                                            @else
                                                <span class="badge rounded text-danger bg-danger-subtle">Inactive</span>
                                            @endif
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

    @include('client.components.add-modal')
    @include('client.components.edit-modal')
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
