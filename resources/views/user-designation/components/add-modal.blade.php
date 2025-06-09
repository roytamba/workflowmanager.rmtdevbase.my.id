<div class="modal fade" id="addUserDesignation" tabindex="-1" aria-labelledby="addUserDesignationLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user-designations.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserDesignationLabel">Add User Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- User --}}
                    <div class="mb-2">
                        <label for="user_id">User</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select class="form-select" name="user_id" required>
                                <option value="" disabled selected>Select user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="mb-2">
                        <label for="role_id">Role</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            <select class="form-select" name="role_id" required>
                                <option value="" disabled selected>Select role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Position --}}
                    <div class="mb-2">
                        <label for="position_id">Position</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                            <select class="form-select" name="position_id" required>
                                <option value="" disabled selected>Select position</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-2">
                        <label for="status">Status</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                            <select class="form-select" name="status" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Save Designation</button>
                </div>
            </form>
        </div>
    </div>
</div>
