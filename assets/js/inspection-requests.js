$(document).ready(function() {
    // Reset form when modal is closed
    $('#createInspectionRequestModal, #editInspectionRequestModal, #addInspectionTaskModal').on('hidden.bs.modal', function () {
        const $form = $(this).find('form');
        if ($form.length) {
            $form[0].reset();
        }
        $('.is-invalid').removeClass('is-invalid');
        // Re-enable fields after closing Add Task modal
        $('#task_itemid').prop('disabled', false);
        $('#task_note').prop('readonly', false);
        $('#task_itemid_hidden').val('');
    });

    // Create Inspection Request
    $('#createInspectionRequestForm').on('submit', function(e) {
        e.preventDefault();

        console.log('Form submitted');
        console.log('URL:', window.inspectionUrls.requests.store);
        console.log('Form data:', $(this).serialize());

        const $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true);

        $.ajax({
            url: window.inspectionUrls.requests.store,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log('Success response:', response);
                if (response && response.success) {
                    toastr.success(response.message || 'Inspection request created successfully');
                    $('#createInspectionRequestModal').modal('hide');
                    setTimeout(function() { location.reload(); }, 800);
                } else {
                    toastr.error(response && response.message ? response.message : 'Failed to create inspection request');
                }
            },
            error: function(xhr) {
                console.log('Error response:', xhr);
                console.log('Status:', xhr.status);
                console.log('Response:', xhr.responseJSON);

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        toastr.error(errors[key][0]);
                        $(`#${key}`).addClass('is-invalid');
                    });
                } else {
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : xhr.statusText || 'Error creating inspection request';
                    toastr.error(msg);
                }
            },
            complete: function() {
                $submitBtn.prop('disabled', false);
            }
        });
    });

    // Edit Inspection Request - Load Data
    $(document).on('click', '.edit-request', function() {
        let id = $(this).data('id');

        $.ajax({
            url: window.inspectionUrls.requests.show.replace(':id', id),
            method: 'GET',
            success: function(response) {
                let request = response.request;

                $('#edit_inspectionrequestid').val(request.inspectionrequestid);
                $('#edit_bidtypeid').val(request.bidtypeid);
                $('#edit_inspecteeid').val(request.inspecteeid);
                $('#edit_inspecteename').val(request.inspecteename);
                $('#edit_inspecteephone').val(request.inspecteephone);
                $('#edit_inspecteeemail').val(request.inspecteeemail);
                $('#edit_attorneyid').val(request.attorneyid);
                $('#edit_note').val(request.note);
                $('#edit_proposeddate').val(request.proposeddate);
                $('#edit_itemid').val(request.itemid);

                $('#editInspectionRequestModal').modal('show');
            },
            error: function(xhr) {
                toastr.error('Error loading request data');
            }
        });
    });

    // Update Inspection Request
    $('#editInspectionRequestForm').on('submit', function(e) {
        e.preventDefault();

        let id = $('#edit_inspectionrequestid').val();

        $.ajax({
            url: window.inspectionUrls.requests.update.replace(':id', id),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response && response.success) {
                    toastr.success(response.message || 'Inspection request updated successfully');
                    $('#editInspectionRequestModal').modal('hide');
                    setTimeout(function() { location.reload(); }, 800);
                } else {
                    toastr.error(response && response.message ? response.message : 'Failed to update inspection request');
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
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : xhr.statusText || 'Error updating inspection request';
                    toastr.error(msg);
                }
            }
        });
    });

    // Delete Inspection Request
    $(document).on('click', '.delete-request', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this inspection request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: window.inspectionUrls.requests.destroy.replace(':id', id),
                    method: 'POST',
                    data: { _method: 'DELETE' },
                    success: function(response) {
                        if (response && response.success) {
                            toastr.success(response.message || 'Inspection request deleted successfully');
                            setTimeout(function() { location.reload(); }, 800);
                        } else {
                            toastr.error(response && response.message ? response.message : 'Failed to delete inspection request');
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting inspection request');
                    }
                });
            }
        });
    });

    // View Request - Redirect to property detail page
    $(document).on('click', '.view-request', function() {
        let id = $(this).data('id');
        // Redirect to property detail page - adjust URL as needed
        window.location.href = '/listings/dashboard'; // Placeholder - adjust based on your routing
    });

    // Create Inspection Task from Request
    $(document).on('click', '.create-inspection-task', function() {
        const $btn = $(this);
        const itemid = $btn.data('itemid');
        const itemtitle = $btn.data('itemtitle') || '';
        const inspecteename = $btn.data('inspecteename') || '';
        const inspecteephone = $btn.data('inspecteephone') || '';
        const inspecteeemail = $btn.data('inspecteeemail') || '';
        const attorneyname = $btn.data('attorneyname') || '';
        const proposeddate = $btn.data('proposeddate') || '';
        const note = $btn.data('note') || '';

        // Select the item in the task form
        $('#task_itemid').val(itemid);
        // Disable the select but still submit value via hidden field
        $('#task_itemid').prop('disabled', true);
        $('#task_itemid_hidden').val(itemid);

        // Prefill note and make it readonly so it submits but can't be edited
        $('#task_note').val(note).prop('readonly', true);

        // Update modal title to show item info
        $('#addInspectionTaskModalLabel').text('Create Inspection Task for: ' + itemtitle);

        $('#addInspectionTaskModal').modal('show');
    });

    // Submit Add Inspection Task form
    $(document).on('submit', '#addInspectionTaskForm', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $form.find('button[type="submit"]');
        $btn.prop('disabled', true);

        console.log('Submitting Inspection Task:', $form.serialize());

        $.ajax({
            url: window.inspectionUrls.tasks.store,
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                console.log('Task create response:', response);
                if (response && response.success) {
                    toastr.success(response.message || 'Inspection task created successfully');
                    $('#addInspectionTaskModal').modal('hide');
                    setTimeout(function() { location.reload(); }, 800);
                } else {
                    toastr.error(response && response.message ? response.message : 'Failed to create inspection task');
                }
            },
            error: function(xhr) {
                console.log('Task create error:', xhr);
                const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : xhr.statusText || 'Error creating inspection task';
                toastr.error(msg);
            },
            complete: function() { $btn.prop('disabled', false); }
        });
    });
});