<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control"
            value="{{ old('title', $task->title ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Project</label>
        <select name="project_id" class="form-select">
            <option value="">-- Select Project --</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}" 
                    {{ (old('project_id', $task->project_id ?? '') == $project->id) ? 'selected' : '' }}>
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
                    {{ (old('assigned_to', $task->assigned_to ?? '') == $user->id) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Parent Task</label>
        <select name="parent_task_id" class="form-select">
            <option value="">-- None --</option>
            @foreach ($tasks as $t)
                @if (!isset($task) || $t->id != $task->id)
                    <option value="{{ $t->id }}"
                        {{ (old('parent_task_id', $task->parent_task_id ?? '') == $t->id) ? 'selected' : '' }}>
                        {{ $t->title }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="2" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control"
            value="{{ old('start_date', $task->start_date ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Due Date</label>
        <input type="date" name="due_date" class="form-control"
            value="{{ old('due_date', $task->due_date ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Completed At</label>
        <input type="date" name="completed_at" class="form-control"
            value="{{ old('completed_at', $task->completed_at ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach (['not_started', 'in_progress', 'completed', 'on_hold', 'cancelled'] as $status)
                <option value="{{ $status }}"
                    {{ (old('status', $task->status ?? 'not_started') == $status) ? 'selected' : '' }}>
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
                    {{ (old('priority', $task->priority ?? 'medium') == $priority) ? 'selected' : '' }}>
                    {{ ucfirst($priority) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Progress (%)</label>
        <input type="number" name="progress" class="form-control" min="0" max="100"
            value="{{ old('progress', $task->progress ?? 0) }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Attachment</label>
        <input type="file" name="attachment" class="form-control">
        @if (!empty($task->attachment))
            <div class="mt-2">
                <small>Current: <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank">View file</a></small>
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label">Approval</label>
        <select name="is_approved" class="form-select">
            <option value="0" {{ (old('is_approved', $task->is_approved ?? false) == false) ? 'selected' : '' }}>Not Approved</option>
            <option value="1" {{ (old('is_approved', $task->is_approved ?? false) == true) ? 'selected' : '' }}>Approved</option>
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" rows="2" class="form-control">{{ old('notes', $task->notes ?? '') }}</textarea>
    </div>
</div>
