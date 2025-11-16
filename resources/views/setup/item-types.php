<?php $pageTitle = 'Item Types'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="itemTypesTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="item-types-tab" data-bs-toggle="tab" href="#item-types" role="tab" aria-controls="item-types" aria-selected="true">
                                    <i class="fas fa-cube"></i>
                                    <span class="d-none d-md-block">&nbsp;Item Types</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="item-service-types-tab" data-bs-toggle="tab" href="#item-service-types" role="tab" aria-controls="item-service-types" aria-selected="false">
                                    <i class="fas fa-tools"></i>
                                    <span class="d-none d-md-block">&nbsp;Item Services</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="item-profile-options-tab" data-bs-toggle="tab" href="#item-profile-options" role="tab" aria-controls="item-profile-options" aria-selected="false">
                                    <i class="fas fa-user-cog"></i>
                                    <span class="d-none d-md-block">&nbsp;Profile Options</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <!-- Tab panes -->
                <div class="tab-content" id="itemTypesTabContent">
                    <div class="tab-pane fade show active" id="item-types" role="tabpanel" aria-labelledby="item-types-tab">
                        <?php include __DIR__.'/item-types/item-types-tab.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="item-service-types" role="tabpanel" aria-labelledby="item-service-types-tab">
                        <?php include __DIR__.'/item-types/item-service-types-tab.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="item-profile-options" role="tabpanel" aria-labelledby="item-profile-options-tab">
                        <?php include __DIR__.'/item-types/item-profile-options-tab.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>


<script>
$(document).ready(function() {
    // Tab retention - restore active tab after page reload
    let activeTab = localStorage.getItem('itemTypesActiveTab');
    if (activeTab) {
        $('#itemTypesTab a[href="' + activeTab + '"]').tab('show');
    }

    // Initialize active tab styling on page load
    function initializeActiveTab() {
        $('#itemTypesTab .nav-link.active').addClass('bg-primary text-white').find('i').addClass('text-white');
    }

    // Initialize on page load
    initializeActiveTab();

    // Handle tab switching to update active state styling and save to localStorage
    $('#itemTypesTab a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        // Save active tab to localStorage
        localStorage.setItem('itemTypesActiveTab', $(e.target).attr('href'));
        
        // Remove active styling from all tabs
        $('#itemTypesTab .nav-link').removeClass('bg-primary text-white').find('i').removeClass('text-white');
        $('#itemTypesTab .badge').remove();

        // Add active styling to current tab
        $(e.target).addClass('bg-primary text-white').find('i').addClass('text-white');
    });

    // Reset form when modal is closed
    $('#addItemTypeModal, #editItemTypeModal, #addItemServiceTypeModal, #editItemServiceTypeModal, #addItemProfileOptionModal, #editItemProfileOptionModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Add Item Type
    $('#addItemTypeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo htmlspecialchars(url('/setup/item-types'), ENT_QUOTES); ?>",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item type added successfully');
                    $('#addItemTypeModal').modal('hide');
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
                    toastr.error('Error adding item type');
                }
            }
        });
    });

    // Edit Item Type - Load Data
    $(document).on('click', '.edit-itemtype', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');

        $('#edit_itemtypeid').val(id);
        $('#edit_title').val(title);

        $('#editItemTypeModal').modal('show');
    });

    // Update Item Type
    $('#editItemTypeForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_itemtypeid').val();
        if (!id) {
            toastr.error('Missing id for update');
            return;
        }
        let data = $(this).serializeArray();
        data.push({ name: '_method', value: 'PUT' });

        $.ajax({
            url: "/setup/item-types/" + encodeURIComponent(id),
            method: 'POST',
            data: $.param(data),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item type updated successfully');
                    $('#editItemTypeModal').modal('hide');
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
                    toastr.error('Error updating item type');
                }
            }
        });
    });

    // Delete Item Type
    $(document).on('click', '.delete-itemtype', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this item type?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                if (!id) {
                    toastr.error('Missing id for delete');
                    return;
                }
                $.ajax({
                    url: "/setup/item-types/" + encodeURIComponent(id),
                    method: 'POST',
                    data: { _method: 'DELETE' },
                                        success: function(response) {
                        if(response.success) {
                            toastr.success('Item type deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting item type');
                    }
                });
            }
        });
    });

    // Item Service Types
    // Add Item Service Type
    $('#addItemServiceTypeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo htmlspecialchars(url('/setup/item-service-types'), ENT_QUOTES); ?>",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item service type added successfully');
                    $('#addItemServiceTypeModal').modal('hide');
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
                    toastr.error('Error adding item service type');
                }
            }
        });
    });

    // Edit Item Service Type - Load Data
    $(document).on('click', '.edit-item-service-type', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let title = $(this).data('title');

        $('#edit_itemserviceid').val(id);
        $('#edit_service_title').val(title);

        $('#editItemServiceTypeModal').modal('show');
    });

    // Update Item Service Type
    $('#editItemServiceTypeForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_itemserviceid').val();
        $.ajax({
            url: "/setup/item-service-types/" + encodeURIComponent(id),
            method: 'POST',
            data: $(this).serialize() + '&_method=PUT',
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item service type updated successfully');
                    $('#editItemServiceTypeModal').modal('hide');
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
                    toastr.error('Error updating item service type');
                }
            }
        });
    });

    // Delete Item Service Type
    $(document).on('click', '.delete-item-service-type', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this item service type?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/setup/item-service-types/" + encodeURIComponent(id),
                    method: 'DELETE',
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Item service type deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting item service type');
                    }
                });
            }
        });
    });

    // Item Profile Options
    // Add Item Profile Option
    $('#addItemProfileOptionForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo htmlspecialchars(url('/setup/item-profile-options'), ENT_QUOTES); ?>",
            method: 'POST',
            data: $(this).serialize(),
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item profile option added successfully');
                    $('#addItemProfileOptionModal').modal('hide');
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
                    toastr.error('Error adding item profile option');
                }
            }
        });
    });

    // View Details
    $(document).on('click', '.view-details', function() {
        let id = $(this).data('id');
        
        // Show loading state
        $('#detailsContent').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading details...</p>
            </div>
        `);
        
        $('#viewDetailsModal').modal('show');
        
        // Fetch actual data
        $.ajax({
            url: '/api/item-profile-options/' + encodeURIComponent(id),
            method: 'GET',
            success: function(response) {
                if(response.success && response.data) {
                    let data = response.data;
                    $('#detailsContent').html(`
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID:</strong> ${data.itemprofileoptionid || 'N/A'}</p>
                                <p><strong>Item Type:</strong> ${data.itemtype_name || 'N/A'}</p>
                                <p><strong>Option Type:</strong> ${data.optiontype || 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Title:</strong> ${data.title || 'N/A'}</p>
                                <p><strong>Base Title:</strong> ${data.basetitle || 'N/A'}</p>
                                <p><strong>List Type:</strong> ${data.listtype || 'N/A'}</p>
                                <p><strong>Show User:</strong> ${data.showuser || 'N/A'}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <p><strong>List Menu:</strong></p>
                                <pre class="bg-light p-3 rounded">${data.listmenu || 'N/A'}</pre>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>Entry Date:</strong> ${data.entrydate ? new Date(data.entrydate).toLocaleString() : 'N/A'}</p>
                                <p><strong>Entry By:</strong> ${data.entryby || 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Modify Date:</strong> ${data.modifydate ? new Date(data.modifydate).toLocaleString() : 'N/A'}</p>
                                <p><strong>Modify By:</strong> ${data.modifyby || 'N/A'}</p>
                            </div>
                        </div>
                    `);
                } else {
                    $('#detailsContent').html(`
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> No details found.
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                $('#detailsContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> Error loading details. Please try again.
                    </div>
                `);
                toastr.error('Error loading details');
            }
        });
    });

    // Edit Item Profile Option - Load Data
    $(document).on('click', '.edit-item-profile-option', function() {
        let id = $(this).data('id');
        let title = $(this).data('title');
        let optiontype = $(this).data('optiontype');
        let basetitle = $(this).data('basetitle');
        let listtype = $(this).data('listtype');
        let listmenu = $(this).data('listmenu');
        let itemtypeid = $(this).data('itemtypeid');

        $('#edit_itemprofileoptionid').val(id);
        $('#edit_option_title').val(title);
        $('#edit_basetitle').val(basetitle);
        $('#edit_listtype').val(listtype);
        $('#edit_listmenu').val(listmenu);
        $('#edit_profile_itemtypeid').val(itemtypeid);

        $('#editItemProfileOptionModal').modal('show');
    });

    // Update Item Profile Option
    $('#editItemProfileOptionForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_itemprofileoptionid').val();
        $.ajax({
            url: "/setup/item-profile-options/" + encodeURIComponent(id),
            method: 'POST',
            data: $(this).serialize() + '&_method=PUT',
                        success: function(response) {
                if(response.success) {
                    toastr.success('Item profile option updated successfully');
                    $('#editItemProfileOptionModal').modal('hide');
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
                    toastr.error('Error updating item profile option');
                }
            }
        });
    });

    // Delete Item Profile Option
    $(document).on('click', '.delete-item-profile-option', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this item profile option?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/setup/item-profile-options/" + encodeURIComponent(id),
                    method: 'DELETE',
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Item profile option deleted successfully');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting item profile option');
                    }
                });
            }
        });
    });
});
</script>


