<?php $pageTitle = 'Bid Types'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Bid Types</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBidTypeModal">
                        Add Bid Type
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
                                <?php if (!empty($bidTypes) && count($bidTypes) > 0): ?>
                                    <?php foreach($bidTypes as $bidType): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" id="actionDropdown<?php echo $bidType['bidtypeid']; ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo $bidType['bidtypeid']; ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-bid-type" href="javascript:;"
                                                        data-id="<?php echo $bidType['bidtypeid']; ?>"
                                                        data-options="<?php echo htmlspecialchars($bidType['options']); ?>"
                                                        data-serviceid="<?php echo $bidType['serviceid']; ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-bid-type text-danger" href="javascript:;"
                                                        data-id="<?php echo $bidType['bidtypeid']; ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($bidType['options']); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo date('d/m/y', strtotime($bidType['entrydate'])); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Bid Types found</p>
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


<!-- Add Bid Type Modal -->
<div class="modal fade" id="addBidTypeModal" tabindex="-1" aria-labelledby="addBidTypeModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addBidTypeModalLabel">Add Bid Type</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="addBidTypeForm">
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="serviceid" class="form-label">Service</label>
                         <select class="form-select" id="serviceid" name="serviceid" required>
                             <option value="">Select Service</option>
                             <?php foreach($services as $service): ?>
                                 <option value="<?php echo $service['serviceid']; ?>"><?php echo htmlspecialchars($service['title']); ?></option>
                             <?php endforeach; ?>
                         </select>
                     </div>
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

<!-- Edit Bid Type Modal -->
<div class="modal fade" id="editBidTypeModal" tabindex="-1" aria-labelledby="editBidTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editBidTypeModalLabel">Edit Bid Type</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="editBidTypeForm">
                  <input type="hidden" id="edit_bidtypeid" name="bidtypeid">
                  <div class="modal-body">
                      <div class="mb-3">
                          <label for="edit_serviceid" class="form-label">Service</label>
                          <select class="form-select" id="edit_serviceid" name="serviceid" required>
                              <option value="">Select Service</option>
                              <?php foreach($services as $service): ?>
                                  <option value="<?php echo $service['serviceid']; ?>"><?php echo htmlspecialchars($service['title']); ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
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
    $('#addBidTypeModal, #editBidTypeModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Bid Type
    $('#addBidTypeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "/admin/bid-types",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Bid type added successfully');
                    $('#addBidTypeModal').modal('hide');
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
                    toastr.error('Error adding bid type');
                }
            }
        });
    });

    // Edit Bid Type - Load Data
    $(document).on('click', '.edit-bid-type', function() {
        let id = $(this).data('id');
        let options = $(this).data('options');
        let serviceid = $(this).data('serviceid');

        $('#edit_bidtypeid').val(id);
        $('#edit_title').val(options);
        $('#edit_serviceid').val(serviceid);

        $('#editBidTypeModal').modal('show');
    });

    // Update Bid Type
    $('#editBidTypeForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_bidtypeid').val();
        $.ajax({
            url: "/admin/bid-types/" + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Bid type updated successfully');
                    $('#editBidTypeModal').modal('hide');
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
                    toastr.error('Error updating bid type');
                }
            }
        });
    });

    // Delete Bid Type
    $(document).on('click', '.delete-bid-type', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this bid type?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/bid-types/" + id,
                    method: 'POST',
                    data: {_method: 'DELETE'},
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Bid type deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting bid type');
                    }
                });
            }
        });
    });
});
</script>