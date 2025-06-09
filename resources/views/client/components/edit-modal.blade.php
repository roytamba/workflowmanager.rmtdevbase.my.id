@foreach ($clients as $client)
    <div class="modal fade" id="editClientModal{{ $client->id }}" tabindex="-1"
        aria-labelledby="editClientModalLabel{{ $client->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editClientModalLabel{{ $client->id }}">Edit Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-2">
                            <label for="name">Client Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ $client->name }}"
                                    required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="company_name">Company Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ $client->company_name }}">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ $client->email }}">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="phone">Phone</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" name="phone" class="form-control" value="{{ $client->phone }}">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="status">Status</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $client->status === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $client->status === 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Update Client</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
