@foreach ($roles as $role)
    <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1"
        aria-labelledby="editRoleLabel{{ $role->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('roles.update', encrypt($role->id)) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleLabel{{ $role->id }}">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="name">Role Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" class="form-control" name="name" value="{{ $role->name }}"
                                    required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="description">Description</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea class="form-control" name="description" rows="2">{{ $role->description }}</textarea>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="status">Status</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                <select class="form-select" name="status" required>
                                    <option value="active" {{ $role->status == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $role->status == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success w-100">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
