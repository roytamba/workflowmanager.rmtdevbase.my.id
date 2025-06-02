<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Project Name -->
                        <div class="col-md-6 mb-3">
                            <label for="project_name" class="form-label">Project Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="project_name" name="name" required>
                        </div>

                        <!-- Client Name -->
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">Client Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="client_name" name="client_name" required>
                        </div>

                        <!-- Project Type -->
                        <div class="col-md-6 mb-3">
                            <label for="project_type" class="form-label">Project Type <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="project_type" name="project_type" required>
                                <option value="">Select Project Type</option>
                                <option value="Java">Java</option>
                                <option value="PHP">PHP</option>
                            </select>
                        </div>

                        <!-- Project Logo -->
                        <div class="col-md-6 mb-3">
                            <label for="project_logo" class="form-label">Project Logo</label>
                            <input type="file" class="form-control" id="project_logo" name="logo"
                                accept="image/*">
                            <small class="text-muted">Upload project logo (optional)</small>
                        </div>

                        <!-- Project Status -->
                        <div class="col-md-6 mb-3">
                            <label for="project_status" class="form-label">Status <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="project_status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <!-- Budget -->
                        <div class="col-md-6 mb-3">
                            <label for="budget" class="form-label">Budget</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="budget" name="budget" min="0"
                                    step="0.01">
                            </div>
                        </div>

                        <!-- Total Tasks -->
                        <div class="col-md-6 mb-3">
                            <label for="total_tasks" class="form-label">Total Tasks</label>
                            <input type="number" class="form-control" id="total_tasks" name="total_tasks"
                                min="0" value="0">
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>

                        <!-- Deadline -->
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>

                        <!-- Progress -->
                        <div class="col-md-6 mb-3">
                            <label for="progress" class="form-label">Progress (%)</label>
                            <input type="number" class="form-control" id="progress" name="progress"
                                min="0" max="100" value="0">
                        </div>

                        <!-- Team Selection Section -->
                        <div class="col-12 mb-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">Team Assignment</h6>
                        </div>

                        <!-- Project Manager -->
                        <div class="col-md-3 mb-3">
                            <label for="project_managers" class="form-label">Project Managers <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="project_managers" name="project_managers[]" multiple
                                required>
                                @foreach ($project_managers as $pm)
                                    <option value="{{ $pm->user_id }}">{{ $pm->user_name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple project managers</small>
                        </div>

                        <!-- Developers -->
                        <div class="col-md-3 mb-3">
                            <label for="developers" class="form-label">Developers <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="developers" name="developers[]" multiple required>
                                @foreach ($software_developers as $sd)
                                    <option value="{{ $sd->user_id }}">{{ $sd->user_name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple developers</small>
                        </div>

                        <!-- Consultants -->
                        <div class="col-md-3 mb-3">
                            <label for="consultants" class="form-label">Consultants</label>
                            <select class="form-select" id="consultants" name="consultants[]" multiple>
                                @foreach ($consultants as $consultant)
                                    <option value="{{ $consultant->user_id }}">{{ $consultant->user_name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple consultants (optional)</small>
                        </div>
                        
                        <!-- Admins -->
                        <div class="col-md-3 mb-3">
                            <label for="admins" class="form-label">Admins</label>
                            <select class="form-select" id="admins" name="admins[]" multiple>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->user_id }}">{{ $admin->user_name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple admins (optional)</small>
                        </div>

                        

                        <!-- Selected Team Members Display -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Selected Team Members</label>
                            <div id="selectedTeamMembers" class="border rounded p-3 bg-light">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6 class="fw-bold text-primary mb-2">Project Managers</h6>
                                        <div id="selectedPMs" class="text-muted">None selected</div>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 class="fw-bold text-success mb-2">Developers</h6>
                                        <div id="selectedDevelopers" class="text-muted">None selected</div>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 class="fw-bold text-info mb-2">Admins</h6>
                                        <div id="selectedAdmins" class="text-muted">None selected</div>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 class="fw-bold text-warning mb-2">Consultants</h6>
                                        <div id="selectedConsultants" class="text-muted">None selected</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                placeholder="Project description (optional)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS to update selected members display -->
<script>
    function updateSelectedOptions(selectId, displayId) {
        const select = document.getElementById(selectId);
        const display = document.getElementById(displayId);
        const selectedOptions = Array.from(select.selectedOptions).map(opt => opt.text);
        display.textContent = selectedOptions.length > 0 ? selectedOptions.join(', ') : 'None selected';
    }

    // Add event listeners to all multiple selects
    ['project_managers', 'developers', 'admins', 'consultants'].forEach(id => {
        document.getElementById(id).addEventListener('change', () => {
            updateSelectedOptions(id, 'selected' + id.charAt(0).toUpperCase() + id.slice(1));
        });
    });

    // Initialize display on modal show or page load
    document.addEventListener('DOMContentLoaded', () => {
        ['project_managers', 'developers', 'admins', 'consultants'].forEach(id => {
            updateSelectedOptions(id, 'selected' + id.charAt(0).toUpperCase() + id.slice(1));
        });
    });
</script>
