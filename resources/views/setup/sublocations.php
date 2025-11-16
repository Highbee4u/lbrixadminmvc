<?php $pageTitle = 'Sublocations'; ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>List of Sublocations</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSublocationModal">
                        Add Sublocation
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
                                        Country</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        State</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sublocation</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Entry Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sublocations) && count($sublocations) > 0): ?>
                                    <?php foreach ($sublocations as $sublocation): ?>
                                    <tr>
                                                                                <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                                        type="button" id="actionDropdown<?php echo htmlspecialchars($sublocation['sublocationid'] ?? ''); ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo htmlspecialchars($sublocation['sublocationid'] ?? ''); ?>">
                                                    <li>
                                                        <a class="dropdown-item edit-sublocation" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($sublocation['sublocationid'] ?? ''); ?>"
                                                        data-sublocation="<?php echo htmlspecialchars($sublocation['sublocation'] ?? ''); ?>"
                                                        data-countryid="<?php echo htmlspecialchars($sublocation['countryid'] ?? ''); ?>"
                                                        data-stateid="<?php echo htmlspecialchars($sublocation['stateid'] ?? ''); ?>">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-sublocation text-danger" href="javascript:;"
                                                        data-id="<?php echo htmlspecialchars($sublocation['sublocationid'] ?? ''); ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo $sublocation['country_name']; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo $sublocation['state_name']; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo $sublocation['sublocation']; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($sublocation['entrydate']) ? date('d/m/y', strtotime($sublocation['entrydate'])) : ''; ?>
                                            </span>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Sublocations found</p>
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

    <!-- Add Sublocation Modal -->
    <div class="modal fade" id="addSublocationModal" tabindex="-1" aria-labelledby="addSublocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSublocationModalLabel">Add Sublocation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addSublocationForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="countryid" class="form-label">Country</label>
                            <select class="form-select" id="countryid" name="countryid" required>
                                <option value="">Select Country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo htmlspecialchars($country['countryid'] ?? ''); ?>"><?php echo htmlspecialchars($country['country'] ?? ''); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stateid" class="form-label">State</label>
                            <select class="form-select" id="stateid" name="stateid" required>
                                <option value="">Select State</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?php echo htmlspecialchars($state['stateid'] ?? ''); ?>"><?php echo htmlspecialchars($state['state'] ?? ''); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sublocation" class="form-label">Sublocation</label>
                            <input type="text" class="form-control" id="sublocation" name="sublocation" required>
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

    <!-- Edit Sublocation Modal -->
    <div class="modal fade" id="editSublocationModal" tabindex="-1" aria-labelledby="editSublocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSublocationModalLabel">Edit Sublocation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSublocationForm">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edit_sublocationid" name="sublocationid">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_countryid" class="form-label">Country</label>
                            <select class="form-select" id="edit_countryid" name="countryid" required>
                                <option value="">Select Country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo htmlspecialchars($country['countryid'] ?? ''); ?>"><?php echo htmlspecialchars($country['country'] ?? ''); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_stateid" class="form-label">State</label>
                            <select class="form-select" id="edit_stateid" name="stateid" required>
                                <option value="">Select State</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?php echo htmlspecialchars($state['stateid'] ?? ''); ?>"><?php echo htmlspecialchars($state['state'] ?? ''); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_sublocation" class="form-label">Sublocation</label>
                            <input type="text" class="form-control" id="edit_sublocation" name="sublocation" required>
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
    $('#addSublocationModal, #editSublocationModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Load states based on country selection in Add modal
    $('#countryid').on('change', function() {
        let countryid = $(this).val();
        let stateSelect = $('#stateid');
        
        // Clear and disable state select
        stateSelect.html('<option value="">Loading...</option>').prop('disabled', true);
        
        if(countryid) {
            $.ajax({
                url: '/api/states/country/' + countryid,
                method: 'GET',
                success: function(response) {
                    if(response.success && response.states) {
                        stateSelect.html('<option value="">Select State</option>');
                        response.states.forEach(function(state) {
                            stateSelect.append(
                                $('<option></option>').val(state.stateid).text(state.state)
                            );
                        });
                        stateSelect.prop('disabled', false);
                    }
                },
                error: function() {
                    toastr.error('Error loading states');
                    stateSelect.html('<option value="">Select State</option>').prop('disabled', false);
                }
            });
        } else {
            stateSelect.html('<option value="">Select State</option>').prop('disabled', false);
        }
    });

    // Load states based on country selection in Edit modal
    $('#edit_countryid').on('change', function() {
        let countryid = $(this).val();
        let stateSelect = $('#edit_stateid');
        
        // Clear and disable state select
        stateSelect.html('<option value="">Loading...</option>').prop('disabled', true);
        
        if(countryid) {
            $.ajax({
                url: '/api/states/country/' + countryid,
                method: 'GET',
                success: function(response) {
                    if(response.success && response.states) {
                        stateSelect.html('<option value="">Select State</option>');
                        response.states.forEach(function(state) {
                            stateSelect.append(
                                $('<option></option>').val(state.stateid).text(state.state)
                            );
                        });
                        stateSelect.prop('disabled', false);
                    }
                },
                error: function() {
                    toastr.error('Error loading states');
                    stateSelect.html('<option value="">Select State</option>').prop('disabled', false);
                }
            });
        } else {
            stateSelect.html('<option value="">Select State</option>').prop('disabled', false);
        }
    });

    // Add Sublocation
    $('#addSublocationForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "/setup/sublocations",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Sublocation added successfully');
                    $('#addSublocationModal').modal('hide');
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
                    toastr.error('Error adding sublocation');
                }
            }
        });
    });

    // Edit Sublocation - Load Data
    $(document).on('click', '.edit-sublocation', function() {
        let id = $(this).data('id');
        let sublocation = $(this).data('sublocation');
        let countryid = $(this).data('countryid');
        let stateid = $(this).data('stateid');

        $('#edit_sublocationid').val(id);
        $('#edit_sublocation').val(sublocation);
        $('#edit_countryid').val(countryid);

        // Load states for the selected country, then set the state value
        if(countryid) {
            $.ajax({
                url: '/api/states/country/' + countryid,
                method: 'GET',
                success: function(response) {
                    if(response.success && response.states) {
                        let stateSelect = $('#edit_stateid');
                        stateSelect.html('<option value="">Select State</option>');
                        response.states.forEach(function(state) {
                            stateSelect.append(
                                $('<option></option>').val(state.stateid).text(state.state)
                            );
                        });
                        // Set the selected state after loading
                        stateSelect.val(stateid);
                    }
                },
                error: function() {
                    toastr.error('Error loading states');
                }
            });
        } else {
            $('#edit_stateid').val(stateid);
        }

        $('#editSublocationModal').modal('show');
    });

    // Update Sublocation
    $('#editSublocationForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_sublocationid').val();
        $.ajax({
            url: "/setup/sublocations/" + id,
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Sublocation updated successfully');
                    $('#editSublocationModal').modal('hide');
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
                    toastr.error('Error updating sublocation');
                }
            }
        });
    });

    // Delete Sublocation
    $(document).on('click', '.delete-sublocation', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this sublocation?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/setup/sublocations/" + id,
                    method: 'DELETE',
                                        success: function(response) {
                        if(response.success) {
                            toastr.success('Sublocation deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting sublocation');
                    }
                });
            }
        });
    });
});
</script>


