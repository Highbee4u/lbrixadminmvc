<?php $pageTitle = 'Admin Roles'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Admin Roles</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="fas fa-plus"></i> Add New Role
                    </button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role Title</th>
                                   <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Admin Rank</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Entry Date</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roles)): ?>
                                    <?php foreach($roles as $role): ?>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                            type="button" id="actionDropdown<?php echo htmlspecialchars($role['adminroleid'] ?? ''); ?>"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo htmlspecialchars($role['adminroleid'] ?? ''); ?>">
                                                        <li>
                                                            <a class="dropdown-item edit-role" href="javascript:;"
                                                               data-id="<?php echo htmlspecialchars($role['adminroleid'] ?? ''); ?>"
                                                               data-title="<?php echo htmlspecialchars($role['title'] ?? ''); ?>"
                                                               data-rank="<?php echo htmlspecialchars($role['adminrank'] ?? ''); ?>"
                                                               data-status="<?php echo htmlspecialchars($role['status'] ?? ''); ?>">
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item delete-role text-danger" href="javascript:;"
                                                               data-id="<?php echo htmlspecialchars($role['adminroleid'] ?? ''); ?>">
                                                                Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($role['title'] ?? 'N/A'); ?></h6>
                                                        <p class="text-xs text-secondary mb-0">ID: <?php echo htmlspecialchars($role['adminroleid'] ?? 'N/A'); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($role['adminrank'] ?? 'N/A'); ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php if(isset($role['status']) && $role['status'] == 1): ?>
                                                    <span class="badge badge-sm bg-gradient-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo isset($role['entrydate']) && $role['entrydate'] ? date('d/m/y', strtotime($role['entrydate'])) : 'N/A'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No admin roles found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addRoleForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin_title" class="form-label">Admin Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="admin_title" name="title" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="admin_rank" class="form-label">Admin Rank <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="admin_rank" name="adminrank" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="admin_status" class="form-label">Admin Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="admin_status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitAddRole">
                        <span class="btn-text">Submit</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm">
                    <input type="hidden" id="edit_role_id" name="id">
                    <div class="mb-3">
                        <label for="edit_admin_title" class="form-label">Admin Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_admin_title" name="title" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_admin_rank" class="form-label">Admin Rank <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_admin_rank" name="adminrank" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_admin_status" class="form-label">Admin Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_admin_status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitEditRole">
                    <span class="btn-text">Update</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
            // Configure jQuery AJAX to use method override for PUT/DELETE
            $.ajaxSetup({
                beforeSend: function(xhr, settings) {
                    if (settings.type === 'PUT' || settings.type === 'DELETE' || settings.type === 'PATCH') {
                        xhr.setRequestHeader('X-HTTP-Method-Override', settings.type);
                        settings.type = 'POST';
                    }
                }
            });

            // Helper function to show loading state
            function setLoadingState(button, isLoading) {
                const btnText = button.find('.btn-text');
                const spinner = button.find('.spinner-border');

                if (isLoading) {
                    button.prop('disabled', true);
                    btnText.addClass('d-none');
                    spinner.removeClass('d-none');
                } else {
                    button.prop('disabled', false);
                    btnText.removeClass('d-none');
                    spinner.addClass('d-none');
                }
            }

            // Helper function to clear form errors
            function clearFormErrors(form) {
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');
            }

            // Helper function to show form errors
            function showFormErrors(form, errors) {
                clearFormErrors(form);

                $.each(errors, function(field, messages) {
                    const input = form.find('[name="' + field + '"]');
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').text(messages[0]);
                });
            }

            // Add Role
            $('#submitAddRole').on('click', function() {
                const button = $(this);
                const form = $('#addRoleForm');
                const formData = form.serialize();

                clearFormErrors(form);
                setLoadingState(button, true);

                $.ajax({
                    url: '/admin/roles/store',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#addRoleModal').modal('hide');
                            form[0].reset();
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors || {};
                            showFormErrors(form, errors);

                            if (xhr.responseJSON.message) {
                                alert(xhr.responseJSON.message);
                            }
                        } else {
                            alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                        }
                    },
                    complete: function() {
                        setLoadingState(button, false);
                    }
                });
            });

            // Edit Role - Open Modal and Populate
            $('.edit-role').on('click', function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const rank = $(this).data('rank');
                const status = $(this).data('status');

                const form = $('#editRoleForm');
                clearFormErrors(form);

                $('#edit_role_id').val(id);
                $('#edit_admin_title').val(title);
                $('#edit_admin_rank').val(rank);
                $('#edit_admin_status').val(status);

                $('#editRoleModal').modal('show');
            });

            // Update Role
            $('#submitEditRole').on('click', function() {
                const button = $(this);
                const form = $('#editRoleForm');
                const formData = form.serialize();
                const roleId = $('#edit_role_id').val();

                clearFormErrors(form);
                setLoadingState(button, true);

                $.ajax({
                    url: '/admin/roles/update/' + roleId,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#editRoleModal').modal('hide');
                            form[0].reset();

                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors || {};
                            showFormErrors(form, errors);

                            if (xhr.responseJSON.message) {
                                alert(xhr.responseJSON.message);
                            }
                        } else {
                            alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                        }
                    },
                    complete: function() {
                        setLoadingState(button, false);
                    }
                });
            });

            // Delete Role
            $('.delete-role').on('click', function() {
                const roleId = $(this).data('id');

                if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
                    $.ajax({
                        url: '/admin/roles/destroy/' + roleId,
                        type: 'DELETE',
                        data: {
                            _token: '<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                        }
                    });
                }
            });

            // Clear form when modal is closed
            $('#addRoleModal').on('hidden.bs.modal', function() {
                clearFormErrors($('#addRoleForm'));
                $('#addRoleForm')[0].reset();
            });

            $('#editRoleModal').on('hidden.bs.modal', function() {
                clearFormErrors($('#editRoleForm'));
                $('#editRoleForm')[0].reset();
            });
        });
    </script>
