@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('assets/libs/simple-datatables/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/tablehighlight.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link fw-medium active" data-bs-toggle="tab" href="#overview" role="tab"
                aria-selected="true">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-medium" data-bs-toggle="tab" href="#project" role="tab"
                aria-selected="false">Detail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-medium" data-bs-toggle="tab" href="#gallery" role="tab" aria-selected="false">Task</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-medium " data-bs-toggle="tab" href="#settings" role="tab"
                aria-selected="false">Team</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="overview" role="tabpanel">
            <div class="row">
                @include('project.components.task-timeline-chart')
                @include('project.components.project-completion-chart')
                @include('project.components.task-history-table')
                @include('project.components.small-team-table')
            </div>
        </div>
        <div class="tab-pane" id="project" role="tabpanel">
            {{-- Project --}}
            @include('project.components.project-card')
            {{-- Project  Details --}}
            @include('project.components.project-detail-card')
        </div>

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/libs/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatable2.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatable3.init.js') }}"></script>
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
