<?php $pageTitle = 'Payment Terms'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Payment Terms</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentTermModal">
                        Add Payment Term
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
                                        Payment title</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($paymentterms) && count($paymentterms) > 0): ?>
                                    <?php foreach ($paymentterms as $paymentterm): ?>
                                    <tr>
                                         <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item edit-paymentterm" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($paymentterm['paytermid'] ?? ''); ?>"
                                                        data-title="<?php echo htmlspecialchars($paymentterm['title'] ?? ''); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-paymentterm text-danger" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($paymentterm['paytermid'] ?? ''); ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($paymentterm['title'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($paymentterm['entrydate']) ? date('d/m/y', strtotime($paymentterm['entrydate'])) : ''; ?> 
                                            </span>
                                        </td>
                                       
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Payment Terms found</p>
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
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>
    <!-- Add Payment Term Modal -->
    <div class="modal fade" id="addPaymentTermModal" tabindex="-1" aria-labelledby="addPaymentTermModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentTermModalLabel">Add Payment Term</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPaymentTermForm">
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

    <!-- Edit Payment Term Modal -->
    <div class="modal fade" id="editPaymentTermModal" tabindex="-1" aria-labelledby="editPaymentTermModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentTermModalLabel">Edit Payment Term</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPaymentTermForm" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edit_paytermid" name="paytermid">
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

   


<script>
$(document).ready(function() {
    // Reset form when modal is closed
    $('#addPaymentTermModal, #editPaymentTermModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Payment Term
    $('#addPaymentTermForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo htmlspecialchars(url('/setup/payment-terms'), ENT_QUOTES); ?>",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Payment term added successfully');
                    $('#addPaymentTermModal').modal('hide');
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
                    toastr.error('Error adding payment term');
                }
            }
        });
    });

    // Edit Payment Term - Load Data
    $(document).on('click', '.edit-paymentterm', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');

        $('#edit_paytermid').val(id);
        $('#edit_title').val(title);

        $('#editPaymentTermModal').modal('show');
    });

    // Update Payment Term
    $('#editPaymentTermForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_paytermid').val();
        $.ajax({
            url: "/setup/payment-terms/" + encodeURIComponent(id),
            method: 'POST',
            data: $(this).serialize() + '&_method=PUT',
                        success: function(response) {
                if(response.success) {
                    toastr.success('Payment term updated successfully');
                    $('#editPaymentTermModal').modal('hide');
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
                    toastr.error('Error updating payment term');
                }
            }
        });
    });

    // Delete Payment Term
    $(document).on('click', '.delete-paymentterm', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this payment term?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/setup/payment-terms/" + encodeURIComponent(id),
                    method: 'DELETE',
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Payment term deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting payment term');
                    }
                });
            }
        });
    });
});
</script>


