<div class="card">
    <div class="card-body">
        <form
            action="{{ isset($project['project_detail_id'])
                ? route('project-details.update', $project['project_detail_id'])
                : route('project-details.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($project['project_detail_id']))
                @method('PUT')
            @endif
            <input type="hidden" name="project_id" value="{{ $project['id'] }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="project_type" class="form-label">Project Type</label>
                    <select name="project_type" id="project_type" class="form-select">
                        <option value="">-- Select Type --</option>
                        @foreach (['web', 'desktop', 'mobile', 'embedded'] as $type)
                            <option value="{{ $type }}"
                                {{ old('project_type', $project['project_type'] ?? '') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">-- Select Status --</option>
                        @foreach (['draft', 'in_progress', 'completed', 'on_hold', 'cancelled'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $project['status'] ?? '') === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ old('start_date', $project['start_date'] ?? '') }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ old('end_date', $project['end_date'] ?? '') }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="deployment_status" class="form-label">Deployment</label>
                    <select name="deployment_status" id="deployment_status" class="form-select">
                        @foreach (['none', 'uat', 'live'] as $deploy)
                            <option value="{{ $deploy }}"
                                {{ old('deployment_status', $project['deployment_status'] ?? '') === $deploy ? 'selected' : '' }}>
                                {{ strtoupper($deploy) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="uat_link" class="form-label">UAT Link</label>
                    <input type="url" name="uat_link" id="uat_link" class="form-control"
                        value="{{ old('uat_link', $project['uat_link'] ?? '') }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="live_link" class="form-label">Live Link</label>
                    <input type="url" name="live_link" id="live_link" class="form-control"
                        value="{{ old('live_link', $project['live_link'] ?? '') }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="checkout_link" class="form-label">Checkout Link</label>
                    <input type="url" name="checkout_link" id="checkout_link" class="form-control"
                        value="{{ old('checkout_link', $project['checkout_link'] ?? '') }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="image" class="form-label">Image (optional)</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*"
                        onchange="previewImage(this)">

                    {{-- Preview image --}}
                    <div class="mt-2">
                        <img id="imagePreview"
                            src="{{ isset($project['has_image']) ? asset($project['image_path']) : '#' }}"
                            alt="Preview"
                            style="max-width: 100%; max-height: 150px; {{ isset($project['has_image']) ? '' : 'display: none;' }}">
                    </div>

                    @if (isset($project['has_image']))
                        <small class="text-muted">Current: {{ $project['image_path'] }}</small>
                    @endif
                </div>
            </div>
            <!-- Submit Button -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const file = input.files && input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
