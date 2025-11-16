$(document).ready(function() {
    // Reset form when modal is closed
    $('#addInspectionTaskModal, #editInspectionTaskModal, #assignTaskModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Clean up any leftover backdrops when modals close (prevents stacking issues)
    $('.modal').on('hidden.bs.modal', function () {
        // Remove any extra backdrops
        if ($('.modal:visible').length === 0) {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        }
    });


    // Add Inspection Task
    $('#addInspectionTaskForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: window.inspectionUrls.store,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': (window.csrfToken || '')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success('Inspection task added successfully');
                    $('#addInspectionTaskModal').modal('hide');
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
                    toastr.error('Error adding inspection task');
                }
            }
        });
    });

    // Edit Inspection Task - Load Data
    $(document).on('click', '.edit-inspection-task', function() {
        // Close any open modals first to prevent backdrop stacking
        $('.modal').modal('hide');
        
        let id = $(this).data('id');
        let note = $(this).data('note');
        let inspectionlead = $(this).data('inspectionlead');
        let startdate = $(this).data('startdate');
        let status = $(this).data('status');
        let supervisornote = $(this).data('supervisornote');
        let itemid = $(this).data('itemid');

        $('#edit_inspectiontaskid').val(id);
        $('#edit_note').val(note);
        $('#edit_inspectionlead').val(inspectionlead);
        $('#edit_startdate').val(startdate);
        $('#edit_status').val(status);
        $('#edit_supervisornote').val(supervisornote);
        $('#edit_itemid').val(itemid);

        // Small delay to ensure previous modal is fully closed
        setTimeout(function() {
            $('#editInspectionTaskModal').modal('show');
        }, 300);
    });

    // Update Inspection Task
    $('#editInspectionTaskForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let id = $('#edit_inspectiontaskid').val();
        
        // Add PUT method spoofing for Laravel-style routing
        formData.append('_method', 'PUT');

        $.ajax({
            url: window.inspectionUrls.store.replace('/store', '/' + encodeURIComponent(id)),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': (window.csrfToken || '')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success('Inspection task updated successfully');
                    $('#editInspectionTaskModal').modal('hide');
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
                    toastr.error('Error updating inspection task');
                }
            }
        });
    });

    // Assign Task Form
    $('#assignTaskForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: window.inspectionUrls.assign,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    toastr.success('Task assigned successfully');
                    $('#assignTaskModal').modal('hide');
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
                        $(`#assign_${key}`).addClass('is-invalid');
                    });
                } else {
                    toastr.error('Error assigning task');
                }
            }
        });
    });

    // Delete Inspection Task
    $(document).on('click', '.delete-inspection-task', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this inspection task?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: window.inspectionUrls.store.replace('/store', '/' + encodeURIComponent(id)),
                    method: 'POST',
                    data: { _method: 'DELETE' },
                    headers: {
                        'X-CSRF-TOKEN': (window.csrfToken || '')
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Inspection task deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting inspection task');
                    }
                });
            }
        });
    });

    // Manage Team
    $(document).on('click', '.manage-team', function() {
        let inspectionTaskId = $(this).data('id');
        $('#team_inspectiontaskid').val(inspectionTaskId);
        loadTeamMembers(inspectionTaskId);
        $('#manageTeamModal').modal('show');
    });

    // Assign Inspection Task
    $(document).on('click', '.assign-task', function() {
        let inspectionTaskId = $(this).data('id');

        // Load task data and populate modal
        $.ajax({
            url: window.inspectionUrls.store.replace('/store', '/' + inspectionTaskId),
            method: 'GET',
            success: function(response) {
                // Assuming response contains task data with item relationship
                let task = response.task || response;

                $('#assign_inspectiontaskid').val(task.inspectiontaskid);
                $('#assign_title').val(task.item_title || '');
                $('#assign_itemid').val(task.itemid);
                $('#assign_description').val(task.note || '');
                $('#assign_address').val(task.item_address || '');
                $('#assign_price').val(task.item_price || '');
                $('#assign_itemstatusid').val(task.item_status_title || '');

                $('#assignTaskModal').modal('show');
            },
            error: function(xhr) {
                toastr.error('Error loading task data');
            }
        });
    });
});

// Function to preview document
function previewDocument(docUrl) {
    if (docUrl) {
        window.open(docUrl, '_blank');
    }
}

// Function to load team members
function loadTeamMembers(inspectionTaskId) {
    $.ajax({
        url: window.inspectionUrls.team + "/" + inspectionTaskId,
        method: 'GET',
        success: function(response) {
            console.log('Team members loaded:', response);
            $('#teamMembersList').html(response);
        },
        error: function(xhr) {
            $('#teamMembersList').html('<p class="text-danger">Error loading team members</p>');
        }
    });
}

// Add Team Member
$('#addTeamMemberForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: window.inspectionUrls.teamStore,
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if(response.success) {
                toastr.success('Team member added successfully');
                $('#addTeamMemberForm')[0].reset();
                let inspectionTaskId = $('#team_inspectiontaskid').val();
                loadTeamMembers(inspectionTaskId);
                // Modal stays open - user can continue adding more members
            }
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(function(key) {
                    toastr.error(errors[key][0]);
                });
            } else {
                toastr.error('Error adding team member');
            }
        }
    });
});

// Remove Team Member
function removeTeamMember(teamMemberId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to remove this team member?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: window.inspectionUrls.team + "/" + encodeURIComponent(teamMemberId),
                method: 'POST',
                data: { _method: 'DELETE' },
                headers: {
                    'X-CSRF-TOKEN': (window.csrfToken || '')
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success('Team member removed successfully');
                        let inspectionTaskId = $('#team_inspectiontaskid').val();
                        loadTeamMembers(inspectionTaskId);
                        // Modal stays open - user can continue managing team
                    }
                },
                error: function(xhr) {
                    toastr.error('Error removing team member');
                }
            });
        }
    });
}

// Edit Team Member Comment
function editTeamMemberComment(teamMemberId) {
    // Show input field and hide display text
    $('#comment-display-' + teamMemberId).addClass('d-none');
    $('#comment-input-' + teamMemberId).removeClass('d-none');

    // Show save/cancel buttons and hide edit button
    $('#edit-btn-' + teamMemberId).addClass('d-none');
    $('#save-btn-' + teamMemberId).removeClass('d-none');
    $('#cancel-btn-' + teamMemberId).removeClass('d-none');
}

// Save Team Member Comment
function saveTeamMemberComment(teamMemberId) {
    const newComment = $('#comment-input-' + teamMemberId).val();

    $.ajax({
        url: window.inspectionUrls.team + "/" + encodeURIComponent(teamMemberId),
        method: 'POST',
        data: {
            _method: 'PUT',
            comment: newComment
        },
        headers: {
            'X-CSRF-TOKEN': (window.csrfToken || '')
        },
        success: function(response) {
            if(response.success) {
                toastr.success('Team member comment updated successfully');
                // Update display text and hide input
                $('#comment-display-' + teamMemberId).text(newComment || 'No comment').removeClass('d-none');
                $('#comment-input-' + teamMemberId).addClass('d-none');

                // Reset buttons
                $('#edit-btn-' + teamMemberId).removeClass('d-none');
                $('#save-btn-' + teamMemberId).addClass('d-none');
                $('#cancel-btn-' + teamMemberId).addClass('d-none');
            }
        },
        error: function(xhr) {
            toastr.error('Error updating team member comment');
        }
    });
}

// Cancel Edit Comment
function cancelEditComment(teamMemberId) {
    // Reset input value and hide it
    const originalComment = $('#comment-display-' + teamMemberId).text();
    $('#comment-input-' + teamMemberId).val(originalComment === 'No comment' ? '' : originalComment).addClass('d-none');

    // Show display text
    $('#comment-display-' + teamMemberId).removeClass('d-none');

    // Reset buttons
    $('#edit-btn-' + teamMemberId).removeClass('d-none');
    $('#save-btn-' + teamMemberId).addClass('d-none');
    $('#cancel-btn-' + teamMemberId).addClass('d-none');
}

// Show full text in modal
function showFullText(text, title) {
    Swal.fire({
        title: title,
        text: text,
        confirmButtonText: 'Close',
        width: '600px',
        customClass: {
            popup: 'text-start'
        }
    });
}