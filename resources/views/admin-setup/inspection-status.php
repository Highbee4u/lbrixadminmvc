<?php $pageTitle = 'Inspection Status'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Inspection Status</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addInspectionStatusModal">
                        Add Inspection Status
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
                                        Inspection Title</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($inpectionStatusList) && count($inpectionStatusList) > 0): ?>
                                    <?php foreach($inpectionStatusList as $inpectionStatus): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" id="actionDropdown<?php echo $inpectionStatus['inspectionstatusid']; ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo $inpectionStatus['inspectionstatusid']; ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-inspection-status" href="javascript:;"
                                                        data-id="<?php echo $inpectionStatus['inspectionstatusid']; ?>"
                                                        data-title="<?php echo htmlspecialchars($inpectionStatus['title']); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-inspection-status text-danger" href="javascript:;"
                                                        data-id="<?php echo $inpectionStatus['inspectionstatusid']; ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($inpectionStatus['title']); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo date('d/m/y', strtotime($inpectionStatus['entrydate'])); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Inspection Status found</p>
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

<!-- Add Inspection Status Modal -->
<div class="modal fade" id="addInspectionStatusModal" tabindex="-1" aria-labelledby="addInspectionStatusModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addInspectionStatusModalLabel">Add Inspection Status</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="addInspectionStatusForm">
                 <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="title" class="form-label">Inspection Title</label>
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

<!-- Edit Inspection Status Modal -->
<div class="modal fade" id="editInspectionStatusModal" tabindex="-1" aria-labelledby="editInspectionStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="editInspectionStatusModalLabel">Edit Inspection Status</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="editInspectionStatusForm">
                 <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                 <input type="hidden" name="_method" value="PUT">
                 <input type="hidden" id="edit_inspectionstatusid" name="inspectionstatusid">
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="edit_title" class="form-label">Inspection Title</label>
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

<script>
    $(document).ready(function() {
        // Reset form when modal is closed
        $('#addInspectionStatusModal, #editInspectionStatusModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
        });

        // Add Inspection Status
        $('#addInspectionStatusForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo url('admin/inspection-status/store'); ?>",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        toastr.success('Inspection Status added successfully');
                        $('#addInspectionStatusModal').modal('hide');
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
                        toastr.error('Error adding Inspection Status');
                    }
                }
            });
        });

        // Edit Inspection Status - Load Data
        $(document).on('click', '.edit-inspection-status', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');

            $('#edit_inspectionstatusid').val(id);
            $('#edit_title').val(title);

            $('#editInspectionStatusModal').modal('show');
        });

        // Update Inspection Status
        $('#editInspectionStatusForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#edit_inspectionstatusid').val();
            $.ajax({
                url: "<?php echo url('admin/inspection-status'); ?>/" + id,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        toastr.success('Inspection Status updated successfully');
                        $('#editInspectionStatusModal').modal('hide');
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
                        toastr.error('Error updating Inspection Status');
                    }
                }
            });
        });

        // Delete Inspection Status
        $(document).on('click', '.delete-inspection-status', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this Inspection Status?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo url('admin/inspection-status'); ?>/" + id,
                        method: 'DELETE',
                        data: {
                            csrf_token: "<?php echo $_SESSION['csrf_token'] ?? ''; ?>"
                        },
                        success: function(response) {
                            if(response.success) {
                                toastr.success('Inspection Status deleted successfully');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Error deleting Inspection Status');
                        }
                    });
                }
            });
        });
    });
</script>