<?php $pageTitle = 'Item Doc Types'; ?>


<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Item Document Type</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemDocTypeModal">
                        Add ItemDocType
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
                                        Item Title</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($itemdoctypes) && count($itemdoctypes) > 0): ?>
                                    <?php foreach ($itemdoctypes as $itemdoctype): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" id="actionDropdown<?php echo htmlspecialchars($itemdoctype['itemdoctypeid'] ?? ''); ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo htmlspecialchars($itemdoctype['itemdoctypeid'] ?? ''); ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-itemdoctype" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($itemdoctype['itemdoctypeid'] ?? ''); ?>"
                                                        data-title="<?php echo htmlspecialchars($itemdoctype['title'] ?? ''); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-itemdoctype text-danger" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($itemdoctype['itemdoctypeid'] ?? ''); ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($itemdoctype['title'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($itemdoctype['entrydate']) ? date('d/m/y', strtotime($itemdoctype['entrydate'])) : ''; ?>
                                            </span>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Item Document Type found</p>
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

    <!-- Add ItemDocType Modal -->
    <div class="modal fade" id="addItemDocTypeModal" tabindex="-1" aria-labelledby="addItemDocTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemDocTypeModalLabel">Add ItemDocType</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addItemDocTypeForm">
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

    <!-- Edit ItemDocType Modal -->
    <div class="modal fade" id="editItemDocTypeModal" tabindex="-1" aria-labelledby="editItemDocTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemDocTypeModalLabel">Edit ItemDocType</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editItemDocTypeForm">
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
    $('#addItemDocTypeModal, #editItemDocTypeModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Item Doc Type
    $('#addItemDocTypeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo htmlspecialchars(url('/setup/item-doc-types'), ENT_QUOTES); ?>",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item document type added successfully');
                    $('#addItemDocTypeModal').modal('hide');
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
                    toastr.error('Error adding item document type');
                }
            }
        });
    });

    // Edit Item Doc Type - Load Data
    $(document).on('click', '.edit-itemdoctype', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');

        $('#edit_itemdoctypeid').val(id);
        $('#edit_title').val(title);

        $('#editItemDocTypeModal').modal('show');
    });

    // Update Item Doc Type
    $('#editItemDocTypeForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_itemdoctypeid').val();
        let formData = new FormData(this);
        formData.append('_method', 'PUT');

            $.ajax({
                url: "<?php echo htmlspecialchars(url('/setup/item-doc-types/'), ENT_QUOTES); ?>" + id,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item document type updated successfully');
                    $('#editItemDocTypeModal').modal('hide');
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
                    toastr.error('Error updating item document type');
                }
            }
        });
    });

    // Delete Item Doc Type
    $(document).on('click', '.delete-itemdoctype', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this item document type?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                        url: "<?php echo htmlspecialchars(url('/setup/item-doc-types/'), ENT_QUOTES); ?>" + id,
                    method: 'DELETE',
                                        success: function(response) {
                        if(response.success) {
                            toastr.success('Item document type deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting item document type');
                    }
                });
            }
        });
    });
});
</script>


