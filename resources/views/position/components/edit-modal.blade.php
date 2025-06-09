@foreach ($positions as $position)
    <div class="modal fade" id="editPositionModal{{ $position->id }}" tabindex="-1"
        aria-labelledby="editPositionLabel{{ $position->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('positions.update', encrypt($position->id)) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPositionLabel{{ $position->id }}">Edit Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="name">Position Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                <input type="text" class="form-control" name="name" value="{{ $position->name }}"
                                    required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="description">Description</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea class="form-control" name="description" rows="2">{{ $position->description }}</textarea>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="status">Status</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                <select class="form-select" name="status" required>
                                    <option value="active" {{ $position->status == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $position->status == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success w-100">Update Position</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
