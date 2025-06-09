@foreach ($users as $user)
    <!-- Modal Edit -->
    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
        aria-labelledby="editUserLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.update', encrypt($user->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserLabel{{ $user->id }}">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center">
                                <img id="imagePreviewEdit{{ $user->id }}"
                                    src="{{ $user->image ? asset($user->image) : asset('assets/images/users/default.png') }}"
                                    alt="Image Preview" class="me-2 border border-dashed rounded-circle" width="80"
                                    height="80" style="object-fit: cover;">

                                <div class="flex-grow-1 text-truncate">
                                    <label class="btn btn-sm btn-primary text-light">
                                        Change Image
                                        <input type="file" name="image" hidden accept="image/*"
                                            onchange="previewImage(this, 'imagePreviewEdit{{ $user->id }}')">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="name">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-user"></i></span>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                                    required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                    required>
                            </div>
                        </div>

                        <!-- Tambahan Status -->
                        <div class="mb-2">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <!-- Tambahkan status lain jika ada -->
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
