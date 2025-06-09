<div class="modal fade" id="addClient" tabindex="-1" aria-labelledby="addClientLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientLabel">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Name -->
                    <div class="mb-2">
                        <label for="name">Client Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="name" placeholder="Enter client name"
                                required>
                        </div>
                    </div>

                    <!-- Company Name -->
                    <div class="mb-2">
                        <label for="company_name">Company Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input type="text" class="form-control" name="company_name" placeholder="Optional">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-2">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="example@company.com">
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="mb-2">
                        <label for="phone">Phone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" class="form-control" name="phone" placeholder="Optional">
                        </div>
                    </div>

                    <!-- Website -->
                    <div class="mb-2">
                        <label for="website">Website</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                            <input type="url" class="form-control" name="website" placeholder="https://example.com">
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-2">
                        <label for="address">Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <textarea class="form-control" name="address" rows="2" placeholder="Optional"></textarea>
                        </div>
                    </div>

                    <!-- Status -->
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
                    <button type="submit" class="btn btn-primary w-100">Save Client</button>
                </div>
            </form>
        </div>
    </div>
</div>
