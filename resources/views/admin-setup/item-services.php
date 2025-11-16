<?php $pageTitle = 'Item Services'; ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Item Services</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemServiceModal">
                        Add Item Service
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
                                        Services</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Item Types</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($itemServiceList) && count($itemServiceList) > 0): ?>
                                    <?php foreach($itemServiceList as $itemService): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle" 
                                                        type="button" id="actionDropdown<?php echo $itemService['itemserviceid']; ?>" 
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo $itemService['itemserviceid']; ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-item-service" href="javascript:;" 
                                                        data-id="<?php echo $itemService['itemserviceid']; ?>"
                                                        data-serviceid="<?php echo $itemService['serviceid']; ?>"
                                                        data-itemtypeid="<?php echo $itemService['itemtypeid']; ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-item-service text-danger" href="javascript:;" 
                                                        data-id="<?php echo $itemService['itemserviceid']; ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        <?php echo htmlspecialchars($itemService['service_name'] ?? 'N/A'); ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <?php echo htmlspecialchars($itemService['itemtype_name'] ?? 'N/A'); ?>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo date('d/m/y', strtotime($itemService['entrydate'])); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No item services found</p>
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

<!-- Add Item Service Modal -->
<div class="modal fade" id="addItemServiceModal" tabindex="-1" aria-labelledby="addItemServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemServiceModalLabel">Add Item Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addItemServiceForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="serviceid" class="form-label">Service</label>
                        <select class="form-select" id="serviceid" name="serviceid" required>
                            <option value="">Select Service</option>
                            <?php foreach($servicelist as $service): ?>
                                <option value="<?php echo $service['serviceid']; ?>">
                                    <?php echo htmlspecialchars($service['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="itemtypeid" class="form-label">Item Type</label>
                        <select class="form-select" id="itemtypeid" name="itemtypeid" required>
                            <option value="">Select Item Type</option>
                            <?php foreach($itemTypelist as $itemType): ?>
                                <option value="<?php echo $itemType['itemtypeid']; ?>">
                                    <?php echo htmlspecialchars($itemType['title']); ?>
                                </option>
                            <?php endforeach; ?>
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

<!-- Edit Item Service Modal -->
<div class="modal fade" id="editItemServiceModal" tabindex="-1" aria-labelledby="editItemServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemServiceModalLabel">Edit Item Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editItemServiceForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_itemserviceid" name="itemserviceid">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_serviceid" class="form-label">Service</label>
                        <select class="form-select" id="edit_serviceid" name="serviceid" required>
                            <option value="">Select Service</option>
                            <?php foreach($servicelist as $service): ?>
                                <option value="<?php echo $service['serviceid']; ?>">
                                    <?php echo htmlspecialchars($service['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_itemtypeid" class="form-label">Item Type</label>
                        <select class="form-select" id="edit_itemtypeid" name="itemtypeid" required>
                            <option value="">Select Item Type</option>
                            <?php foreach($itemTypelist as $itemType): ?>
                                <option value="<?php echo $itemType['itemtypeid']; ?>">
                                    <?php echo htmlspecialchars($itemType['title']); ?>
                                </option>
                            <?php endforeach; ?>
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
        // Reset form when modal is closed
        $('#addItemServiceModal, #editItemServiceModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
        });

        // Add Item Service
        $('#addItemServiceForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo url('admin/item-services/store'); ?>",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        toastr.success('Item service added successfully');
                        $('#addItemServiceModal').modal('hide');
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
                        toastr.error('Error adding item service');
                    }
                }
            });
        });

        // Edit Item Service - Load Data
        $(document).on('click', '.edit-item-service', function() {
            let id = $(this).data('id');
            let serviceId = $(this).attr('data-serviceid');
            let itemTypeId = $(this).attr('data-itemtypeid');

            $('#edit_itemserviceid').val(id);
            $('#edit_serviceid').val(serviceId);
            $('#edit_itemtypeid').val(itemTypeId);

            $('#editItemServiceModal').modal('show');
        });

        // Update Item Service
        $('#editItemServiceForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#edit_itemserviceid').val();
            let serviceId = $('#edit_serviceid').val();
            let itemTypeId = $('#edit_itemtypeid').val();
            let csrfToken = $('input[name="csrf_token"]').val();

            $.ajax({
                url: "<?php echo url('admin/item-services'); ?>/" + id,
                method: 'PUT',
                data: {
                    itemserviceid: id,
                    serviceid: serviceId,
                    itemtypeid: itemTypeId,
                    csrf_token: csrfToken,
                    _method: 'PUT'
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success('Item service updated successfully');
                        $('#editItemServiceModal').modal('hide');
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
                        toastr.error('Error updating item service');
                    }
                }
            });
        });

        // Delete Item Service
        $(document).on('click', '.delete-item-service', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this item service?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo url('admin/item-services'); ?>/" + id,
                        method: 'DELETE',
                        data: {
                            csrf_token: "<?php echo $_SESSION['csrf_token'] ?? ''; ?>"
                        },
                        success: function(response) {
                            if(response.success) {
                                toastr.success('Item service deleted successfully');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Error deleting item service');
                        }
                    });
                }
            });
        });
    });
</script>