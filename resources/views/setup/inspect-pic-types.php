<?php $pageTitle = 'Inspect Pic Types'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Inspection Pic Types</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addInspectionPicTypeModal">
                        Add Inspection Pic Type
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
                                        Inspection title</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($inspectionpictypelist) && count($inspectionpictypelist) > 0): ?>
                                    <?php foreach ($inspectionpictypelist as $inspectionpictype): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item edit-inspectionpictype" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($inspectionpictype['itempictypeid'] ?? ''); ?>"
                                                        data-title="<?php echo htmlspecialchars($inspectionpictype['title'] ?? ''); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-inspectionpictype text-danger" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($inspectionpictype['itempictypeid'] ?? ''); ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($inspectionpictype['title'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($inspectionpictype['entrydate']) ? date('d/m/y', strtotime($inspectionpictype['entrydate'])) : ''; ?>
                                            </span>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Inspection Pic Types found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        <?php /* Pagination */ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add inspectionpictype Modal -->
    <div class="modal fade" id="addInspectionPicTypeModal" tabindex="-1" aria-labelledby="addInspectionPicTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInspectionPicTypeModalLabel">Add Inspection Pic Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addInspectionPicTypeForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
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

    <!-- Edit Inspection Pic Type Modal -->
    <div class="modal fade" id="editInspectionPicTypeModal" tabindex="-1" aria-labelledby="editInspectionPicTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInspectionPicTypeModalLabel">Edit Inspection Pic Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editInspectionPicTypeForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edit_itempictypeid" name="itempictypeid">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_itempictype" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_itempictype" name="title" required>
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

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>


<script>
$(document).ready(function() {
    // Reset form when modal is closed
    $('#addInspectionPicTypeModal, #editInspectionPicTypeModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Inspection Pic Type
    $('#addInspectionPicTypeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo htmlspecialchars(url('/setup/inspect-pic-types'), ENT_QUOTES); ?>",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Inspection picture type added successfully');
                    $('#addInspectionPicTypeModal').modal('hide');
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
                    toastr.error('Error adding inspection picture type');
                }
            }
        });
    });

    // Edit Inspection Pic Type - Load Data
    $(document).on('click', '.edit-inspectionpictype', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');

        $('#edit_itempictypeid').val(id);
        $('#edit_itempictype').val(title);

        $('#editInspectionPicTypeModal').modal('show');
    });

    // Update Inspection Pic Type
    $('#editInspectionPicTypeForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_itempictypeid').val();
        $.ajax({
            url: "/setup/inspect-pic-types/" + encodeURIComponent(id),
            method: 'POST',
            data: $(this).serialize() + '&_method=PUT',
                        success: function(response) {
                if(response.success) {
                    toastr.success('Inspection picture type updated successfully');
                    $('#editInspectionPicTypeModal').modal('hide');
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
                    toastr.error('Error updating inspection picture type');
                }
            }
        });
    });

    // Delete Inspection Pic Type
    $(document).on('click', '.delete-inspectionpictype', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this inspection picture type?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/setup/inspect-pic-types/" + encodeURIComponent(id),
                    method: 'POST',
                    data: { _method: 'DELETE' },
                                        success: function(response) {
                        if(response.success) {
                            toastr.success('Inspection picture type deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting inspection picture type');
                    }
                });
            }
        });
    });
});
</script>


