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
                                <img id="avatarPreviewEdit{{ $user->id }}"
                                    src="{{ $user->detail && $user->detail->image ? asset('storage/' . $user->detail->image) : asset('assets/images/users/default.png') }}"
                                    alt="Avatar Preview" class="me-2 border border-dashed rounded-circle" width="80"
                                    height="80" style="object-fit: cover;">

                                <div class="flex-grow-1 text-truncate">
                                    <label class="btn btn-sm btn-primary text-light">
                                        Change Avatar
                                        <input type="file" name="avatar" hidden accept="image/*"
                                            onchange="previewImage(this, 'avatarPreviewEdit{{ $user->id }}')">
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
