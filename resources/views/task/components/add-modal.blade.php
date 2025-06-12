<div class="modal fade" id="addTask" tabindex="-1" aria-labelledby="addTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Module</label>
                            <input type="text" name="module" class="form-control"
                                placeholder="e.g. Sales, Inventory">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-select">
                                <option value="">-- Select Project --</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Assigned To</label>
                            <select name="assigned_to" class="form-select">
                                <option value="">-- Select User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Parent Task</label>
                            <select name="parent_task_id" class="form-select">
                                <option value="">-- None --</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task['id'] }}">{{ $task['title'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Completed At</label>
                            <input type="date" name="completed_at" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                @foreach (['not_started', 'in_progress', 'completed', 'on_hold', 'cancelled'] as $status)
                                    <option value="{{ $status }}">{{ ucwords(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select">
                                @foreach (['low', 'medium', 'high', 'urgent'] as $priority)
                                    <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Approval</label>
                            <select name="is_approved" class="form-select">
                                <option value="0">Not Approved</option>
                                <option value="1">Approved</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Tags</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($tagIcons as $tag => $icon)
                                    <input type="checkbox" class="btn-check" name="tags[]" value="{{ $tag }}" id="tag-{{ $tag }}">
                                    <label class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1" for="tag-{{ $tag }}">
                                        <i class="fas {{ $icon }}"></i> {{ ucwords(str_replace('_', ' ', $tag)) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Attachments</label>
                            <input type="file" name="attachments[]" id="attachmentInput" class="form-control"
                                multiple>
                            <div class="mt-3">
                                <table class="table table-sm table-bordered align-middle" id="attachmentTable"
                                    style="display:none;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>File Name</th>
                                            <th>Size</th>
                                            <th>Type</th>
                                            <th style="width: 40px;">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" rows="2" class="form-control"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i> Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initFileUploader({
            inputId: 'attachmentInput',
            tableId: 'attachmentTable'
        });
    });

    function initFileUploader({
        inputId,
        tableId
    }) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        const tbody = table.querySelector('tbody');
        let fileList = [];

        input.addEventListener('change', () => {
            const newFiles = Array.from(input.files);
            fileList = fileList.concat(newFiles);
            updateTable();
        });

        tbody.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-remove')) {
                const index = parseInt(e.target.dataset.index, 10);
                fileList.splice(index, 1);
                updateTable();
            }
        });

        function updateTable() {
            tbody.innerHTML = '';

            if (fileList.length === 0) {
                table.style.display = 'none';
                input.value = '';
                return;
            }

            fileList.forEach((file, index) => {
                const row = document.createElement('tr');
                const fileSize = (file.size / 1024).toFixed(1) + ' KB';
                const fileType = file.type || 'Unknown';

                row.innerHTML = `
                    <td>${file.name}</td>
                    <td>${fileSize}</td>
                    <td>${fileType}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-remove" data-index="${index}">&times;</button>
                    </td>
                `;

                tbody.appendChild(row);
            });

            table.style.display = '';
            refreshInputFiles();
        }

        function refreshInputFiles() {
            const dataTransfer = new DataTransfer();
            fileList.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }
    }
</script>
