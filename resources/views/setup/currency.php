<?php $pageTitle = 'Currencies'; ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Currencies</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCurrencyModal">
                        Add Currency
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
                                        Currency</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Currency Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Currency Symbol</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Currency Rate</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($currencies) && count($currencies) > 0): ?>
                                    <?php foreach ($currencies as $currency): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" id="actionDropdown<?php echo $currency['currencyid']; ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo $currency['currencyid']; ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-currency" href="javascript:;"
                                                        data-id="<?php echo $currency['currencyid']; ?>"
                                                        data-currency="<?php echo htmlspecialchars($currency['currency'] ?? ''); ?>"
                                                        data-currencycode="<?php echo htmlspecialchars($currency['currencycode'] ?? ''); ?>"
                                                        data-currencysymbol="<?php echo htmlspecialchars($currency['currencysymbol'] ?? ''); ?>"
                                                        data-exchangerate="<?php echo htmlspecialchars($currency['exchangerate'] ?? ''); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-currency text-danger" href="javascript:;"
                                                        data-id="<?php echo $currency['currencyid']; ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($currency['currency'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($currency['currencycode'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($currency['currencysymbol'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($currency['exchangerate'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($currency['entrydate']) ? date('d/m/y', strtotime($currency['entrydate'])) : ''; ?>
                                            </span>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Currencies found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        <?php 
                        // Pagination will be handled by your pagination helper
                        // Example: echo $pagination; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<!-- Add Currency Modal -->
<div class="modal fade" id="addCurrencyModal" tabindex="-1" aria-labelledby="addCurrencyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCurrencyModalLabel">Add Currency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCurrencyForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="currency" class="form-label">Currency</label>
                        <input type="text" class="form-control" id="currency" name="currency" required>
                    </div>
                    <div class="mb-3">
                        <label for="currencycode" class="form-label">Currency Code</label>
                        <input type="text" class="form-control" id="currencycode" name="currencycode" required>
                    </div>
                    <div class="mb-3">
                        <label for="currencysymbol" class="form-label">Currency Symbol</label>
                        <input type="text" class="form-control" id="currencysymbol" name="currencysymbol" required>
                    </div>
                    <div class="mb-3">
                        <label for="exchangerate" class="form-label">Currency Rate</label>
                        <input type="number" step="0.01" class="form-control" id="exchangerate" name="exchangerate" required>
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

<!-- Edit Currency Modal -->
<div class="modal fade" id="editCurrencyModal" tabindex="-1" aria-labelledby="editCurrencyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCurrencyModalLabel">Edit Currency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCurrencyForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_currencyid" name="currencyid">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_currency" class="form-label">Currency</label>
                        <input type="text" class="form-control" id="edit_currency" name="currency" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_currencycode" class="form-label">Currency Code</label>
                        <input type="text" class="form-control" id="edit_currencycode" name="currencycode" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_currencysymbol" class="form-label">Currency Symbol</label>
                        <input type="text" class="form-control" id="edit_currencysymbol" name="currencysymbol" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_exchangerate" class="form-label">Currency Rate</label>
                        <input type="number" step="0.01" class="form-control" id="edit_exchangerate" name="exchangerate" required>
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
    $('#addCurrencyModal, #editCurrencyModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Currency
    $('#addCurrencyForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo url('setup/currency'); ?>",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Currency added successfully');
                    $('#addCurrencyModal').modal('hide');
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
                    toastr.error('Error adding currency');
                }
            }
        });
    });

    // Edit Currency - Load Data
    $(document).on('click', '.edit-currency', function() {
        let id = $(this).data('id');
        let currency = $(this).data('currency');
        let currencycode = $(this).data('currencycode');
        let currencysymbol = $(this).data('currencysymbol');
        let exchangerate = $(this).data('exchangerate');

        $('#edit_currencyid').val(id);
        $('#edit_currency').val(currency);
        $('#edit_currencycode').val(currencycode);
        $('#edit_currencysymbol').val(currencysymbol);
        $('#edit_exchangerate').val(exchangerate);

        $('#editCurrencyModal').modal('show');
    });

    // Update Currency
    $('#editCurrencyForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_currencyid').val();
        $.ajax({
            url: "<?php echo url('setup/currency'); ?>/" + id,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Currency updated successfully');
                    $('#editCurrencyModal').modal('hide');
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
                    toastr.error('Error updating currency');
                }
            }
        });
    });

    // Delete Currency
    $(document).on('click', '.delete-currency', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this currency?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo url('setup/currency'); ?>/" + id,
                    method: 'DELETE',
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Currency deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting currency');
                    }
                });
            }
        });
    });
});
</script>
