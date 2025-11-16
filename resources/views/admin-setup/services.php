<?php $pageTitle = 'Services'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Services</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="fas fa-plus"></i> Add New Service
                    </button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary opacity-7">Action</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Service Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Service Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Is Admin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Is Participant</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($services)): ?>
                                    <?php foreach ($services as $service): ?>
                                        <tr>
                                           <td class="align-middle">
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                            type="button" id="actionDropdown<?php echo $service['serviceid']; ?>"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo $service['serviceid']; ?>">
                                                        <li>
                                                            <a class="dropdown-item edit-service" href="javascript:;"
                                                            data-id="<?php echo $service['serviceid']; ?>"
                                                            data-code="<?php echo htmlspecialchars($service['code'] ?? ''); ?>"
                                                            data-title="<?php echo htmlspecialchars($service['title']); ?>"
                                                            data-isadmin="<?php echo $service['isadmin']; ?>"
                                                            data-isparticipant="<?php echo $service['isparticipant']; ?>">
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item delete-service text-danger" href="javascript:;"
                                                            data-id="<?php echo $service['serviceid']; ?>"
                                                            data-title="<?php echo htmlspecialchars($service['title']); ?>">
                                                                Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-3 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($service['code'] ?? 'N/A'); ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-3 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($service['title'] ?? 'N/A'); ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0"><?php echo htmlspecialchars($service['isadmin'] ? 'Yes' : 'No'); ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0"><?php echo htmlspecialchars($service['isparticipant'] ? 'Yes' : 'No'); ?></p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo isset($service['entrydate']) ? date('d M Y', strtotime($service['entrydate'])) : 'N/A'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No services found</p>
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

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addServiceForm" method="POST" action="<?php echo url('admin/services/create'); ?>">
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="code" class="form-label">Service Code</label>
                         <input type="text" class="form-control" id="code" name="code" required>
                     </div>
                     <div class="mb-3">
                         <label for="title" class="form-label">Service Title</label>
                         <input type="text" class="form-control" id="title" name="title" required>
                     </div>
                     <div class="mb-3">
                         <label for="isadmin" class="form-label">Is Admin</label>
                         <select class="form-select" id="isadmin" name="isadmin" required>
                             <option value="">Select</option>
                             <option value="1">Yes</option>
                             <option value="0">No</option>
                         </select>
                     </div>
                     <div class="mb-3">
                         <label for="isparticipant" class="form-label">Is Participant</label>
                         <select class="form-select" id="isparticipant" name="isparticipant" required>
                             <option value="">Select</option>
                             <option value="1">Yes</option>
                             <option value="0">No</option>
                         </select>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Save</button>
                 </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editServiceForm" method="POST">
                <input type="hidden" id="edit_serviceid" name="serviceid">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_code" class="form-label">Service Code</label>
                        <input type="text" class="form-control" id="edit_code" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Service Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_isadmin" class="form-label">Is Admin</label>
                        <select class="form-select" id="edit_isadmin" name="isadmin" required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_isparticipant" class="form-label">Is Participant</label>
                        <select class="form-select" id="edit_isparticipant" name="isparticipant" required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Reset form when add modal is closed
    $('#addServiceModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Reset form when edit modal is closed
    $('#editServiceModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Edit Service - Load Data into Modal
    $(document).on('click', '.edit-service', function() {
        let id = $(this).data('id');
        let code = $(this).data('code');
        let title = $(this).data('title');
        let isadmin = $(this).data('isadmin');
        let isparticipant = $(this).data('isparticipant');

        $('#edit_serviceid').val(id);
        $('#edit_code').val(code);
        $('#edit_title').val(title);
        $('#edit_isadmin').val(isadmin);
        $('#edit_isparticipant').val(isparticipant);


        // Show the edit modal
        $('#editServiceModal').modal('show');
    });

    // Update Service
    $('#editServiceForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_serviceid').val();

        $.ajax({
            url: '<?php echo url('admin/services/update'); ?>/' + id,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Service updated successfully');
                    $('#editServiceModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || 'Failed to update service');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        toastr.error(errors[key][0]);
                        $(`#edit_${key}`).addClass('is-invalid');
                    });
                } else {
                    toastr.error('Error updating service');
                }
            }
        });
    });

    // Delete Service with Confirmation
    $(document).on('click', '.delete-service', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let title = $(this).data('title');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete "' + title + '"? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo url('admin/services/delete'); ?>/' + id,
                    method: 'POST',
                    data: {
                        csrf_token: '<?php echo $_SESSION['csrf_token'] ?? ''; ?>'
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Service deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response.message || 'Failed to delete service');
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting service');
                    }
                });
            }
        });
    });

    // Add Service Form Submission
    $('#addServiceForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Service added successfully');
                    $('#addServiceModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || 'Failed to add service');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        toastr.error(errors[key][0]);
                        $(`#${key}`).addClass('is-invalid');
                    });
                } else {
                    toastr.error('Error adding service');
                }
            }
        });
    });
});
</script>