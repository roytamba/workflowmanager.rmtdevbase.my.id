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
                            <h4 class="card-title">Table User</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <button class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#addUser"><i
                                    class="fas fa-plus me-1"></i> Add User</button>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registered On</th>
                                    <th>Status</th>
                                    {{-- Hilangkan kolom Action --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr style="cursor: pointer;" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal{{ $user->id }}">
                                        <td class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($user->image) }}"
                                                    class="me-2 thumb-md align-self-center rounded" alt="User Image">

                                                <div class="flex-grow-1 text-truncate">
                                                    <h6 class="m-0">{{ $user->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#"
                                                class="text-body text-decoration-underline">{{ $user->email }}</a>
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <span
                                                class="badge rounded text-success bg-success-subtle">{{ $user->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    @include('user.components.add-modal')
    @include('user.components.edit-modal')
@endsection
@push('scripts')
    <script src="{{ asset('assets/libs/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        function previewImage(inputFile, previewId) {
            const file = inputFile.files[0];
            const preview = document.getElementById(previewId);

            if (file && preview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
