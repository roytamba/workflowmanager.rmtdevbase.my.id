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
                        <div class="position-absolute end-0 me-3">
                            <span
                                class="badge rounded text-success bg-transparent border border-primary">{{ $project->status }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3 pb-2 border-dashed-bottom">
                            <div class="flex-shrink-0">
                                <img src="{{ $project->logo ?? 'assets/images/logos/default-logo.png' }}" alt=""
                                    height="50" class="rounded-circle d-inline-block">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate">
                                <h5 class="fw-bold mb-1 fs-15">{{ $project->name }}</h5>
                                <p class="text-dark mb-0 fs-13 fw-semibold"><span class="text-muted">Client :
                                    </span>{{ $project->client_name }}</p>
                            </div><!--end media-body-->
                        </div>
                        <div class="d-flex justify-content-between fw-semibold align-items-center my-3">
                            <div class="img-group d-flex justify-content-center">
                                @foreach ($project->project_managers as $member)
                                    <a class="user-avatar position-relative d-inline-block {{ $loop->first ? '' : 'ms-n2' }}"
                                        href="#" title="{{ $member->user_name }}">
                                        <img src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                            alt="{{ $member->user_name }}" class="thumb-md shadow-sm rounded-circle">
                                    </a>
                                @endforeach

                                @foreach ($project->developers as $member)
                                    <a class="user-avatar position-relative d-inline-block ms-n2" href="#"
                                        title="{{ $member->user_name }}">
                                        <img src="{{ asset('assets/images/users/avatar-2.jpg') }}"
                                            alt="{{ $member->user_name }}" class="thumb-md shadow-sm rounded-circle">
                                    </a>
                                @endforeach

                                @foreach ($project->consultants as $member)
                                    <a class="user-avatar position-relative d-inline-block ms-n2" href="#"
                                        title="{{ $member->user_name }}">
                                        <img src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                            alt="{{ $member->user_name }}" class="thumb-md shadow-sm rounded-circle">
                                    </a>
                                @endforeach

                                @foreach ($project->admins as $member)
                                    <a class="user-avatar position-relative d-inline-block ms-n2" href="#"
                                        title="{{ $member->user_name }}">
                                        <img src="{{ asset('assets/images/users/avatar-4.jpg') }}"
                                            alt="{{ $member->user_name }}" class="thumb-md shadow-sm rounded-circle">
                                    </a>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-primary btn-sm px-3">Details</button>
                        </div>
                        <div class="">
                            <div class="d-flex justify-content-between fw-semibold align-items-center">
                                <p class="mb-1 d-inline-flex align-items-center"><i
                                        class="iconoir-task-list fs-18 text-muted me-1"></i>{{ $project->total_tasks }}
                                    Tasks</p>
                                <small
                                    class="text-end text-body-emphasis d-block ms-auto">{{ $project->progress }}%</small>
                            </div>
                            <div class="progress bg-secondary-subtle" style="height:5px;">
                                <div class="progress-bar bg-secondary rounded-pill" role="progressbar"
                                    style="margin-right:2px; width: {{ $project->progress }}%"
                                    aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="row mt-3 align-items-center">
                                <div class="col-auto col-md-5">
                                    <div class="text-start">
                                        <h5 class="fs-16 fw-semibold mb-0">${{ number_format($project->budget, 0) }}</h5>
                                        <p class="mb-0 text-muted">Total Budget</p>
                                    </div>
                                </div>
                                <div class="col col-md-7 text-end align-self-center">
                                    <h6 class="fw-normal text-muted fs-12 mb-1">Start : <span
                                            class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</span>
                                    </h6>
                                    <h6 class="fw-normal text-muted mb-0 fs-12">Deadline : <span
                                            class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($project->deadline)->format('d M Y') }}</span>
                                    </h6>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div>
        @endforeach
    </div>

    <!-- Modal Add Project -->
    @include('project.components.add-modal')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const logoInput = document.getElementById('project_logo');
        logoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Please upload an image file (jpg, png, gif, webp)',
                    });
                    logoInput.value = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: 'File size must not exceed 2 MB.',
                    });
                    logoInput.value = '';
                    return;
                }

                // Preview (opsional, tampilkan di bawah input)
                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview = document.getElementById('logoPreview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = 'logoPreview';
                        preview.classList.add('mt-2', 'rounded');
                        preview.style.maxHeight = '100px';
                        logoInput.parentElement.appendChild(preview);
                    }
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Function to update selected team members display
        function updateTeamMembersDisplay() {
            // Update Project Managers
            const pmsSelect = document.getElementById('project_managers');
            const selectedPMs = document.getElementById('selectedPMs');
            const selectedPMOptions = Array.from(pmsSelect.selectedOptions);
            if (selectedPMOptions.length > 0) {
                selectedPMs.innerHTML = selectedPMOptions.map(option =>
                    `<span class="badge bg-primary me-1 mb-1">${option.text}</span>`
                ).join('');
            } else {
                selectedPMs.innerHTML = '<span class="text-muted">None selected</span>';
            }

            // Update Developers
            const developersSelect = document.getElementById('developers');
            const selectedDevelopers = document.getElementById('selectedDevelopers');
            const selectedDeveloperOptions = Array.from(developersSelect.selectedOptions);
            if (selectedDeveloperOptions.length > 0) {
                selectedDevelopers.innerHTML = selectedDeveloperOptions.map(option =>
                    `<span class="badge bg-success me-1 mb-1">${option.text}</span>`
                ).join('');
            } else {
                selectedDevelopers.innerHTML = '<span class="text-muted">None selected</span>';
            }

            // Update Admins
            const adminsSelect = document.getElementById('admins');
            const selectedAdmins = document.getElementById('selectedAdmins');
            const selectedAdminOptions = Array.from(adminsSelect.selectedOptions);
            if (selectedAdminOptions.length > 0) {
                selectedAdmins.innerHTML = selectedAdminOptions.map(option =>
                    `<span class="badge bg-info me-1 mb-1">${option.text}</span>`
                ).join('');
            } else {
                selectedAdmins.innerHTML = '<span class="text-muted">None selected</span>';
            }
        }

        // Add event listeners for team selection updates
        document.getElementById('project_managers').addEventListener('change', updateTeamMembersDisplay);
        document.getElementById('developers').addEventListener('change', updateTeamMembersDisplay);
        document.getElementById('admins').addEventListener('change', updateTeamMembersDisplay);

        // Reset form saat modal dibuka
        document.getElementById('addProjectModal').addEventListener('show.bs.modal', function(event) {
            document.querySelector('#addProjectModal form').reset();
            const preview = document.getElementById('logoPreview');
            if (preview) preview.remove();
            updateTeamMembersDisplay();
        });

        // Form validation before submit
        document.querySelector('#addProjectModal form').addEventListener('submit', function(e) {
            const pmsSelected = document.getElementById('project_managers').selectedOptions.length;
            const developersSelected = document.getElementById('developers').selectedOptions.length;

            if (pmsSelected === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Project Manager Required',
                    text: 'Please select at least one project manager for this project.',
                });
                return;
            }

            if (developersSelected === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Developers Required',
                    text: 'Please select at least one developer for this project.',
                });
                return;
            }
        });
    </script>
@endpush
