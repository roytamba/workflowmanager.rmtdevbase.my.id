@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <!-- Button Add Project -->
        <div class="col-12 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                <i class="iconoir-plus me-2"></i>Add New Project
            </button>
        </div>

        <!-- Loop untuk menampilkan project cards -->
        @foreach ($projects as $project)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="position-absolute  end-0 me-3">
                            <span
                                class="badge rounded text-success bg-transparent border border-primary">{{ $project->status }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3 pb-2 border-dashed-bottom">
                            <div class="flex-shrink-0">
                                <img src="{{ $project->image ? asset($project->image) : asset('assets/images/logo-sm.png') }}"
                                    alt="" height="50" class="d-inline-block">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate">
                                <h5 class="fw-bold mb-1 fs-15">{{ $project->name }}</h5>
                                <p class="text-dark mb-0 fs-13 fw-semibold">
                                    <span class="text-muted">Client :
                                    </span>{{ $project->client ? $project->client : 'Not Set' }}
                                </p>
                            </div><!--end media-body-->
                        </div>
                        <div class="d-flex justify-content-between fw-semibold align-items-center  my-3">
                            <div class="img-group d-flex justify-content-center">
                                <a class="user-avatar position-relative d-inline-block" href="#">
                                    <img src="assets/images/users/avatar-1.jpg" alt="avatar"
                                        class="thumb-md shadow-sm rounded-circle">
                                </a>
                                <a class="user-avatar position-relative d-inline-block ms-n2" href="#">
                                    <img src="assets/images/users/avatar-4.jpg" alt="avatar"
                                        class="thumb-md shadow-sm rounded-circle">
                                </a>
                                <a class="user-avatar position-relative d-inline-block ms-n2" href="#">
                                    <img src="assets/images/users/avatar-6.jpg" alt="avatar"
                                        class="thumb-md shadow-sm rounded-circle">
                                </a>
                                <a href="" class="user-avatar position-relative d-inline-block ms-1">
                                    <span
                                        class="thumb-md shadow-sm justify-content-center d-flex align-items-center bg-info-subtle rounded-circle fw-semibold fs-6">+6</span>
                                </a>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm px-3">Details</button>
                        </div>
                        <div class="">
                            <div class="d-flex justify-content-between fw-semibold align-items-center">
                                <p class="mb-1 d-inline-flex align-items-center"><i
                                        class="iconoir-task-list fs-18 text-muted me-1"></i>Task: {{ $project->task ? $project->task : 'Not Set' }}</p>
                                <small
                                    class="text-end text-body-emphasis d-block ms-auto">{{ $project->progress ? $project->progress : 0 }}%</small>
                            </div>
                            <div class="progress bg-secondary-subtle" style="height:5px;">
                                <div class="progress-bar bg-secondary rounded-pill" role="progressbar"
                                    style="margin-right:2px; width: {{ $project->progress ? $project->progress : 0 }}% "
                                    aria-valuenow="{{ $project->progress ? $project->progress : 0 }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                            <div class="row mt-3 align-items-center">
                                <div class="col-auto col-md-5">
                                    <div class="text-start">
                                        <h5 class="fs-16 fw-semibold mb-0">
                                            {{ $project->budget ? $project->budget : 'Not Set' }}</h5>
                                        <p class="mb-0  text-muted">Total Budget</p>
                                    </div>
                                </div>
                                <div class="col col-md-7 text-end align-self-center">
                                    <h6 class="fw-normal text-muted fs-12 mb-1">Start : <span class="text-dark fw-semibold">
                                            {{ $project->end_date ? $project->start_date : 'Not Set' }}</span></h6>
                                    <h6 class="fw-normal text-muted mb-0 fs-12">Deadline : <span
                                            class="text-dark fw-semibold">
                                            {{ $project->end_date ? $project->end_date : 'Not Set' }}</span></h6>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div>
                    </div><!--end card-body-->
                </div>
            </div>
        @endforeach

    </div>

    <!-- Modal Add Project -->
    @include('project.components.add-modal')
@endsection

@push('scripts')
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
