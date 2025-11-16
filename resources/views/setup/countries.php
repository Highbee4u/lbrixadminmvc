<?php $pageTitle = 'Countries'; ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Country</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCountryModal">
                        Add Country
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Country Code</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                </tr>
                            </thead>
                            <tbody id="countriesTableBody">
                                <?php if (!empty($countries) && count($countries) > 0): ?>
                                    <?php foreach ($countries as $country): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" id="actionDropdown<?php echo $country['countryid']; ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo $country['countryid']; ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-country" href="javascript:;"
                                                        data-id="<?php echo $country['countryid']; ?>"
                                                        data-country="<?php echo htmlspecialchars($country['country'] ?? ''); ?>"
                                                        data-countrycode="<?php echo htmlspecialchars($country['countrycode'] ?? ''); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-country text-danger" href="javascript:;"
                                                        data-id="<?php echo $country['countryid']; ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($country['country'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($country['countrycode'] ?? ''); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($country['entrydate']) ? date('d/m/y', strtotime($country['entrydate'])) : ''; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Country found</p>
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


<!-- Add Country Modal -->
<div class="modal fade" id="addCountryModal" tabindex="-1" aria-labelledby="addCountryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCountryModalLabel">Add Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCountryForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="country" class="form-label">Country Name</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>
                    <div class="mb-3">
                        <label for="countrycode" class="form-label">Country Code</label>
                        <input type="text" class="form-control" id="countrycode" name="countrycode">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Country</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Country Modal -->
<div class="modal fade" id="editCountryModal" tabindex="-1" aria-labelledby="editCountryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCountryModalLabel">Edit Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCountryForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_country_id" name="countryid">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_country" class="form-label">Country Name</label>
                        <input type="text" class="form-control" id="edit_country" name="country" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_countrycode" class="form-label">Country Code</label>
                        <input type="text" class="form-control" id="edit_countrycode" name="countrycode">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Country</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Reset form when modal is closed
    $('#addCountryModal, #editCountryModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Country
    $('#addCountryForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo url('setup/countries'); ?>",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Country added successfully');
                    $('#addCountryModal').modal('hide');
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
                    toastr.error('Error adding country');
                }
            }
        });
    });

    // Edit Country - Load Data
    $(document).on('click', '.edit-country', function() {
        let id = $(this).data('id');
        let country = $(this).data('country');
        let countrycode = $(this).data('countrycode');

        $('#edit_country_id').val(id);
        $('#edit_country').val(country);
        $('#edit_countrycode').val(countrycode);

        $('#editCountryModal').modal('show');
    });

    // Update Country
    $('#editCountryForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_country_id').val();
        $.ajax({
            url: "<?php echo url('setup/countries'); ?>/" + id,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Country updated successfully');
                    $('#editCountryModal').modal('hide');
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
                    toastr.error('Error updating country');
                }
            }
        });
    });

    // Delete Country
    $(document).on('click', '.delete-country', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this country?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo url('setup/countries'); ?>/" + id,
                    method: 'DELETE',
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Country deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting country');
                    }
                });
            }
        });
    });
});
</script>
