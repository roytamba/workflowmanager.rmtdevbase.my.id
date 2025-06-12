@foreach ($tasks as $task)
    <div class="modal fade" id="editTaskModal{{ $task['id'] }}" tabindex="-1"
        aria-labelledby="editTaskLabel{{ $task['id'] }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('tasks.update', $task['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Task - {{ $task['title'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" value="{{ $task['title'] }}" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Module</label>
                                <input type="text" name="module" value="{{ $task['module'] }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Project</label>
                                <select name="project_id" class="form-select">
                                    <option value="">-- Select Project --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ $task['project_id'] == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Assigned To</label>
                                <select name="assigned_to" class="form-select">
                                    <option value="">-- Select User --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $task['assigned_user'] == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Parent Task</label>
                                <select name="parent_task_id" class="form-select">
                                    <option value="">-- None --</option>
                                    @if ($task['parent_task'] != $task['id'])
                                        <option value="{{ $task['parent_task'] }}"
                                            {{ $task['parent_task'] == $task['parent_task'] ? 'selected' : '' }}>
                                            {{ $task['title'] }}
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="2" class="form-control">{{ $task['description'] }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" value="{{ $task['start_date'] }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" value="{{ $task['due_date'] }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Completed At</label>
                                <input type="date" name="completed_at" value="{{ $task['completed_at'] }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    @foreach (['not_started', 'in_progress', 'completed', 'on_hold', 'cancelled'] as $status)
                                        <option value="{{ $status }}"
                                            {{ $task['status'] === $status ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    @foreach (['low', 'medium', 'high', 'urgent'] as $priority)
                                        <option value="{{ $priority }}"
                                            {{ $task['priority'] === $priority ? 'selected' : '' }}>
                                            {{ ucfirst($priority) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Approval</label>
                                <select name="is_approved" class="form-select">
                                    <option value="0" {{ $task['is_approved'] == 0 ? 'selected' : '' }}>Not
                                        Approved
                                    </option>
                                    <option value="1" {{ $task['is_approved'] == 1 ? 'selected' : '' }}>Approved
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Tags</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($tagIcons as $tag => $icon)
                                        <input type="checkbox" class="btn-check" name="tags[]"
                                            value="{{ $tag }}"
                                            id="edit-tag-{{ $tag }}-{{ $task['id'] ?? 'new' }}"
                                            {{ in_array($tag, $task['selected_tags'] ?? []) ? 'checked' : '' }}>

                                        <label class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1"
                                            for="edit-tag-{{ $tag }}-{{ $task['id'] ?? 'new' }}">
                                            <i class="fas {{ $icon }}"></i>
                                            {{ ucwords(str_replace('_', ' ', $tag)) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>


                            <div class="col-md-12">
                                <label class="form-label">Attachments</label>
                                <input type="file" name="attachments[]" id="attachmentInputEdit"
                                    class="form-control" multiple>

                                {{-- Tampilkan lampiran yang sudah ada --}}
                                @if (!empty($task['attachments']) && is_array($task['attachments']))
                                    <div class="mt-3">
                                        <label class="form-label">Existing Attachments:</label>
                                        <ul class="list-group mb-3">
                                            @foreach ($task['attachments'] as $attachment)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ asset('storage/' . $attachment['path']) }}"
                                                        target="_blank">
                                                        {{ $attachment['name'] }}
                                                    </a>
                                                    <span
                                                        class="badge bg-secondary">{{ $attachment['size'] ?? 'N/A' }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Preview file baru yang dipilih --}}
                                <div class="mt-3">
                                    <table class="table table-sm table-bordered align-middle" id="attachmentTableEdit"
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
                                <textarea name="notes" rows="2" class="form-control">{{ $task['notes'] }}</textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-1"></i> Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
