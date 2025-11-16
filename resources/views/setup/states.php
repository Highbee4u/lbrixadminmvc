<?php $pageTitle = 'States'; ?>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>List of States</h6>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStateModal">
                            Add State
                        </button>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Country</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            State</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Entry Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($states)): ?>
                                    <?php foreach ($states as $state): ?>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                            type="button" id="actionDropdown<?php echo htmlspecialchars($state['stateid'] ?? '', ENT_QUOTES); ?>"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo htmlspecialchars($state['stateid'] ?? '', ENT_QUOTES); ?>">
                                                        <li>
                                                            <a class="dropdown-item edit-state" href="javascript:;"
                                                            data-id="<?php echo htmlspecialchars($state['stateid'] ?? '', ENT_QUOTES); ?>"
                                                            data-state="<?php echo htmlspecialchars($state['state'] ?? '', ENT_QUOTES); ?>"
                                                            data-countryid="<?php echo htmlspecialchars($state['countryid'] ?? '', ENT_QUOTES); ?>">
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item delete-state text-danger" href="javascript:;"
                                                            data-id="<?php echo htmlspecialchars($state['stateid'] ?? '', ENT_QUOTES); ?>">
                                                                Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($state['country'] ?? '', ENT_QUOTES); ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($state['state'] ?? '', ENT_QUOTES); ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo !empty($state['entrydate']) ? date('d/m/y', strtotime($state['entrydate'])) : ''; ?>
                                                </span>
                                            </td>
                                            
                                        </tr>
                                        <?php endforeach; ?>
                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <p class="text-sm text-secondary mb-0">No States found</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            <?php if (!empty($pagination)): echo $pagination; endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>
    <!-- Add State Modal -->
    <div class="modal fade" id="addStateModal" tabindex="-1" aria-labelledby="addStateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStateModalLabel">Add State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addStateForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="countryid" class="form-label">Country</label>
                            <select class="form-select" id="countryid" name="countryid" required>
                                <option value="">Select Country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo htmlspecialchars($country['countryid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($country['country'] ?? '', ENT_QUOTES); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" required>
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

    <!-- Edit State Modal -->
    <div class="modal fade" id="editStateModal" tabindex="-1" aria-labelledby="editStateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStateModalLabel">Edit State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStateForm" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edit_stateid" name="stateid">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_countryid" class="form-label">Country</label>
                            <select class="form-select" id="edit_countryid" name="countryid" required>
                                <option value="">Select Country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo $country['countryid']; ?>"><?php echo $country['country']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_state" class="form-label">State</label>
                            <input type="text" class="form-control" id="edit_state" name="state" required>
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
    // Reset form when modal is closed
    $('#addStateModal, #editStateModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add State
    $('#addStateForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo "/setup/states"; ?>",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('State added successfully');
                    $('#addStateModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
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
                    toastr.error('Error adding state');
                }
            }
        });
    });

    // Edit State - Load Data
    $(document).on('click', '.edit-state', function() {
        let id = $(this).data('id');
        let state = $(this).data('state');
        let countryid = $(this).data('countryid');

        $('#edit_stateid').val(id);
        $('#edit_state').val(state);
        $('#edit_countryid').val(countryid);

        $('#editStateModal').modal('show');
    });

    // Update State
    $('#editStateForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_stateid').val();
        $.ajax({
            url: "<?php echo "/setup/states"; ?>/" + id,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('State updated successfully');
                    $('#editStateModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
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
                    toastr.error('Error updating state');
                }
            }
        });
    });

    // Delete State
    $(document).on('click', '.delete-state', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this state?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo "/setup/states"; ?>/" + id,
                    method: 'DELETE',
                    success: function(response) {
                        if(response.success) {
                            toastr.success('State deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting state');
                    }
                });
            }
        });
    });
});
</script>


