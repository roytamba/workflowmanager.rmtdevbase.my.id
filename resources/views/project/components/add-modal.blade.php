<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <!-- Nama Project -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Project Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>

                    <!-- Client -->
                    <div class="mb-3">
                        <label for="client_id" class="form-label">Client</label>
                        <select name="client_id" class="form-select" id="client_id" required>
                            <option value="">-- Select Client --</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }} @if ($client->company_name)
                                        ({{ $client->company_name }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Project Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3" placeholder="Optional..."></textarea>
                    </div>

                    <!-- Deployment -->
                    <div class="mb-3">
                        <label for="deployment_status" class="form-label">Deployment Status</label>
                        <select name="deployment_status" class="form-select" id="deployment_status">
                            <option value="none" selected>None</option>
                            <option value="uat">UAT</option>
                            <option value="live">Live</option>
                        </select>
                    </div>

                    <!-- Link -->
                    <div class="mb-3">
                        <label for="uat_link" class="form-label">UAT Link</label>
                        <input type="url" name="uat_link" class="form-control" id="uat_link"
                            placeholder="https://uat.example.com">
                    </div>

                    <div class="mb-3">
                        <label for="live_link" class="form-label">Live Link</label>
                        <input type="url" name="live_link" class="form-control" id="live_link"
                            placeholder="https://www.example.com">
                    </div>

                    <div class="mb-3">
                        <label for="checkout_link" class="form-label">Checkout Link</label>
                        <input type="url" name="checkout_link" class="form-control" id="checkout_link"
                            placeholder="https://checkout.example.com">
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Project Status</label>
                        <select name="status" class="form-select" id="status">
                            <option value="in_progress" selected>In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="on_hold">On Hold</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- Gambar & Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Project Image</label>
                        <input type="file" name="image" class="form-control" id="image" accept="image/*"
                            onchange="previewProjectImage(event)">
                    </div>

                    <div class="mb-4 text-center">
                        <img id="projectImagePreview"
                            src="https://via.placeholder.com/300x180?text=Project+Image+Preview" alt="Image Preview"
                            class="img-fluid rounded shadow-sm border" style="max-height: 200px;">
                    </div>

                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Preview Gambar -->
    <script>
        function previewProjectImage(event) {
            const input = event.target;
            const preview = document.getElementById('projectImagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = "https://via.placeholder.com/300x180?text=Project+Image+Preview";
            }
        }
    </script>
</div>
