<?php $pageTitle = 'Item Pic Types'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Item Pic Type</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemPicTypeModal">
                        Add ItemPicType
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
                                <?php if (!empty($itempicypes) && count($itempicypes) > 0): ?>
                                    <?php foreach ($itempicypes as $itempicype): ?>
                                    <tr>
                                                                                <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" id="actionDropdown<?php echo htmlspecialchars($itempicype['itempicypeid'] ?? ''); ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo htmlspecialchars($itempicype['itempicypeid'] ?? ''); ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-itempicype" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($itempicype['itempictypeid'] ?? ''); ?>"
                                                        data-title="<?php echo htmlspecialchars($itempicype['title'] ?? ''); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-itempicype text-danger" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($itempicype['itempictypeid'] ?? ''); ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($itempicype['title'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($itempicype['entrydate']) ? date('d/m/y', strtotime($itempicype['entrydate'])) : ''; ?>
                                            </span>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Item Pic Type found</p>
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

    <!-- Add itempicype Modal -->
    <div class="modal fade" id="addItemPicTypeModal" tabindex="-1" aria-labelledby="addItemPicTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemPicTypeModalLabel">Add Item Pic Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addItemPicTypeForm">
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

    <!-- Edit ItemPicType Modal -->
    <div class="modal fade" id="editItemPicTypeModal" tabindex="-1" aria-labelledby="editItemPicTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemPicTypeModalLabel">Edit ItemPicType</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editItemPicTypeForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edit_itempictypeid" name="itempictypeid">
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
    $('#addItemPicTypeModal, #editItemPicTypeModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Item Pic Type
    $('#addItemPicTypeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo htmlspecialchars(url('/setup/item-pic-types'), ENT_QUOTES); ?>",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item picture type added successfully');
                    $('#addItemPicTypeModal').modal('hide');
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
                    toastr.error('Error adding item picture type');
                }
            }
        });
    });

    // Edit Item Pic Type - Load Data
    $(document).on('click', '.edit-itempicype', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');

        $('#edit_itempictypeid').val(id);
        $('#edit_title').val(title);

        $('#editItemPicTypeModal').modal('show');
    });

    // Update Item Pic Type
    $('#editItemPicTypeForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_itempictypeid').val();

        $.ajax({
            url: "/setup/item-pic-types/" + id,
            method: 'PUT',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item picture type updated successfully');
                    $('#editItemPicTypeModal').modal('hide');
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
                    toastr.error('Error updating item picture type');
                }
            }
        });
    });

    // Delete Item Pic Type
    $(document).on('click', '.delete-itempicype', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this item picture type?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/setup/item-pic-types/" + id,
                    method: 'DELETE',
                                        success: function(response) {
                        if(response.success) {
                            toastr.success('Item picture type deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting item picture type');
                    }
                });
            }
        });
    });
});
</script>


