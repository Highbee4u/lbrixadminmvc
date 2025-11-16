<?php $pageTitle = 'Inspection Doc Types'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Inspection Doc Types</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addInspectionDocTypeModal">
                        Add Inspection Doc Type
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
                                        Title</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($inspectiondoctypes) && count($inspectiondoctypes) > 0): ?>
                                    <?php foreach ($inspectiondoctypes as $inspectiondoctype): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item edit-inspectiondoctype" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($inspectiondoctype['itemdoctypeid'] ?? ''); ?>"
                                                        data-title="<?php echo htmlspecialchars($inspectiondoctype['title'] ?? ''); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-inspectiondoctype text-danger" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($inspectiondoctype['itemdoctypeid'] ?? ''); ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($inspectiondoctype['title'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($inspectiondoctype['entrydate']) ? date('d/m/y', strtotime($inspectiondoctype['entrydate'])) : ''; ?>
                                            </span>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Inspection Doc Types found</p>
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

    <!-- Add InspectionDocType Modal -->
    <div class="modal fade" id="addInspectionDocTypeModal" tabindex="-1" aria-labelledby="addInspectionDocTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInspectionDocTypeModalLabel">Add Inspection Doc Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addInspectionDocTypeForm">
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

    <!-- Edit Inspection Doc Type Modal -->
    <div class="modal fade" id="editInspectionDocTypeModal" tabindex="-1" aria-labelledby="editInspectionDocTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInspectionDocTypeModalLabel">Edit Inspection Doc Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editInspectionDocTypeForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edit_itemdoctypeid" name="itemdoctypeid">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
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
    $('#addInspectionDocTypeModal, #editInspectionDocTypeModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Inspection Doc Type
    $('#addInspectionDocTypeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo htmlspecialchars(url('/setup/inspection-doc-types'), ENT_QUOTES); ?>",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Inspection doc type added successfully');
                    $('#addInspectionDocTypeModal').modal('hide');
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
                    toastr.error('Error adding inspection doc type');
                }
            }
        });
    });

    // Edit Inspection Doc Type - Load Data
    $(document).on('click', '.edit-inspectiondoctype', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');

        $('#edit_itemdoctypeid').val(id);
        $('#edit_title').val(title);

        $('#editInspectionDocTypeModal').modal('show');
    });

    // Update Inspection Doc Type
    $('#editInspectionDocTypeForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_itemdoctypeid').val();
        $.ajax({
            url: "<?php echo url('setup/inspection-doc-types'); ?>/" + encodeURIComponent(id),
            method: 'POST',
            data: $(this).serialize() + '&_method=PUT',
                        success: function(response) {
                if(response.success) {
                    toastr.success('Inspection doc type updated successfully');
                    $('#editInspectionDocTypeModal').modal('hide');
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
                    toastr.error('Error updating inspection doc type');
                }
            }
        });
    });

    // Delete Inspection Doc Type
    $(document).on('click', '.delete-inspectiondoctype', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this inspection doc type?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo url('setup/inspection-doc-types'); ?>/" + encodeURIComponent(id),
                    method: 'POST',
                    data: { _method: 'DELETE' },
                                        success: function(response) {
                        if(response.success) {
                            toastr.success('Inspection doc type deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting inspection doc type');
                    }
                });
            }
        });
    });
});
</script>


