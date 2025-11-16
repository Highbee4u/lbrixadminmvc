<?php $pageTitle = 'Investments'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Investments</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addInvestmentModal">
                        Add Investment
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
                                        Joint Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Start Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($investments) && count($investments) > 0): ?>
                                    <?php foreach($investments as $investment): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" id="actionDropdown<?php echo $investment['investmentid']; ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo $investment['investmentid']; ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-investment" href="javascript:;"
                                                        data-id="<?php echo $investment['investmentid']; ?>"
                                                        data-title="<?php echo htmlspecialchars($investment['title']); ?>"
                                                        data-jointstatus="<?php echo $investment['jointstatus']; ?>"
                                                        data-status="<?php echo $investment['status']; ?>"
                                                        data-amount="<?php echo htmlspecialchars($investment['amount'] ?? ''); ?>"
                                                        data-startdate="<?php echo $investment['startdate'] ?? ''; ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-investment text-danger" href="javascript:;"
                                                        data-id="<?php echo $investment['investmentid']; ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($investment['title']); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo $investment['jointstatus'] == 1 ? 'Yes' : 'No'; ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php 
                                                    $statusText = 'N/A';
                                                    foreach($optionLists as $option) {
                                                        if($option['optionlistid'] == $investment['status']) {
                                                            $statusText = htmlspecialchars($option['options']);
                                                            break;
                                                        }
                                                    }
                                                    echo $statusText;
                                                ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($investment['startdate']) ? date('d/m/y', strtotime($investment['startdate'])) : '-'; ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo date('d/m/y', strtotime($investment['entrydate'])); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Investments found</p>
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

<!-- Add Investment Modal -->
<div class="modal fade" id="addInvestmentModal" tabindex="-1" aria-labelledby="addInvestmentModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addInvestmentModalLabel">Add Investment</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="addInvestmentForm">
                 <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="title" class="form-label">Title</label>
                         <input type="text" class="form-control" id="title" name="title" required>
                     </div>
                     <div class="mb-3">
                         <label for="amount" class="form-label">Amount</label>
                         <input type="text" class="form-control" id="amount" name="amount" required>
                     </div>
                     <div class="mb-3">
                         <label for="jointstatus" class="form-label">Joint Status</label>
                         <select class="form-select" id="jointstatus" name="jointstatus" required>
                             <option value="">Select Joint Status</option>
                             <?php foreach($inspectionStatusList as $status): ?>
                                 <option value="<?php echo $status['inspectionstatusid']; ?>">
                                     <?php echo htmlspecialchars($status['title']); ?>
                                 </option>
                             <?php endforeach; ?>
                         </select>
                     </div>
                     <div class="mb-3">
                         <label for="status" class="form-label">Status</label>
                         <select class="form-select" id="status" name="status" required>
                             <option value="">Select Status</option>
                             <?php foreach($optionLists as $option): ?>
                                 <option value="<?php echo $option['optionlistid']; ?>">
                                     <?php echo htmlspecialchars($option['options']); ?>
                                 </option>
                             <?php endforeach; ?>
                         </select>
                     </div>
                     <div class="mb-3">
                         <label for="startdate" class="form-label">Start Date</label>
                         <input type="date" class="form-control" id="startdate" name="startdate">
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

<!-- Edit Investment Modal -->
<div class="modal fade" id="editInvestmentModal" tabindex="-1" aria-labelledby="editInvestmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInvestmentModalLabel">Edit Investment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editInvestmentForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_investmentid" name="investmentid">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                         <label for="edit_amount" class="form-label">Amount</label>
                         <input type="text" class="form-control" id="edit_amount" name="amount" required>
                     </div>
                    <div class="mb-3">
                        <label for="edit_jointstatus" class="form-label">Joint Status</label>
                        <select class="form-select" id="edit_jointstatus" name="jointstatus" required>
                            <option value="">Select Joint Status</option>
                            <?php foreach($inspectionStatusList as $status): ?>
                                <option value="<?php echo $status['inspectionstatusid']; ?>">
                                    <?php echo htmlspecialchars($status['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="">Select Status</option>
                            <?php foreach($optionLists as $option): ?>
                                <option value="<?php echo $option['optionlistid']; ?>">
                                    <?php echo htmlspecialchars($option['options']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_startdate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="edit_startdate" name="startdate">
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
    $('#addInvestmentModal, #editInvestmentModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Investment
    $('#addInvestmentForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "/admin/investments",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Investment added successfully');
                    $('#addInvestmentModal').modal('hide');
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
                    toastr.error('Error adding investment');
                }
            }
        });
    });

    // Edit Investment - Load Data
    $(document).on('click', '.edit-investment', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');
        let jointstatus = $(this).data('jointstatus');
        let status = $(this).data('status');
        let startdate = $(this).data('startdate');
        let amount = $(this).data('amount');

        $('#edit_investmentid').val(id);
        $('#edit_title').val(title);
        $('#edit_jointstatus').val(jointstatus);
        $('#edit_status').val(status);
        $('#edit_startdate').val(startdate);
        $('#edit_amount').val(amount);

        $('#editInvestmentModal').modal('show');
    });

    // Update Investment
    $('#editInvestmentForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_investmentid').val();
        $.ajax({
            url: "/admin/investments/" + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Investment updated successfully');
                    $('#editInvestmentModal').modal('hide');
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
                    toastr.error('Error updating investment');
                }
            }
        });
    });

    // Delete Investment
    $(document).on('click', '.delete-investment', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this investment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/investments/" + id,
                    method: 'DELETE',
                    data: {
                        csrf_token: "<?php echo $_SESSION['csrf_token'] ?? ''; ?>"
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Investment deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting investment');
                    }
                });
            }
        });
    });
});
</script>