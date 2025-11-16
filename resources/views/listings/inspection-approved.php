<?php $pageTitle = 'Inspection Approved'; ?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Inspection Approved Properties
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-4">
                            <label for="filter_itemtype" class="form-label fw-bold">Property Type</label>
                            <select class="form-select" id="filter_itemtype" name="itemtype">
                                <option value="">All Types</option>
                                <?php if (!empty($itemTypes)): ?>
                                    <?php foreach ($itemTypes as $type): ?>
                                        <option value="<?php echo htmlspecialchars($type['itemtypeid']); ?>" <?php echo (isset($_GET['itemtype']) && $_GET['itemtype'] == $type['itemtypeid']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($type['title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <label for="filter_entry_date" class="form-label fw-bold">Entry Date</label>
                            <input type="date" class="form-control" id="filter_entry_date" name="entry_date" value="<?php echo isset($_GET['entry_date']) ? htmlspecialchars($_GET['entry_date']) : ''; ?>">
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="d-flex gap-2 align-items-center justify-content-lg-start justify-content-center">
                                <button type="button" class="btn btn-primary" id="applyFilters">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                    <i class="fas fa-times me-2"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>List of Inspection Approved</h6>
                        <a href="<?php echo url('listings/add-property'); ?>" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Add Inspection Approved
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Title</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inspection Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Property Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Seller</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Entry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($inspectionApproved['data']) && count($inspectionApproved['data']) > 0): ?>
                                    <?php foreach ($inspectionApproved['data'] as $property): ?>
                                        <tr>
                                             <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo $property['itemid']; ?>" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo $property['itemid']; ?>">
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo url('listings/property-detail/' . $property['itemid']); ?>">
                                                                <i class="fas fa-eye me-2"></i>View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-warning reject-approved-property" href="javascript:;" data-itemid="<?php echo $property['itemid']; ?>" data-title="<?php echo htmlspecialchars($property['title']); ?>">
                                                                <i class="fas fa-times me-2"></i>Reject
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-info reinspect-approved-property" href="javascript:;" data-itemid="<?php echo $property['itemid']; ?>" data-title="<?php echo htmlspecialchars($property['title']); ?>">
                                                                <i class="fas fa-search me-2"></i>Re-Inspect
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-success list-approved-property" href="javascript:;" data-itemid="<?php echo $property['itemid']; ?>" data-title="<?php echo htmlspecialchars($property['title']); ?>">
                                                                <i class="fas fa-list me-2"></i>List Properties
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-primary keep-approved-for-listing" href="javascript:;" data-itemid="<?php echo $property['itemid']; ?>" data-title="<?php echo htmlspecialchars($property['title']); ?>">
                                                                <i class="fas fa-bookmark me-2"></i>Keep for Listing
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                                            <?php 
                                                            $title = $property['title'] ?? '';
                                                            echo htmlspecialchars(mb_substr($title, 0, 50)); 
                                                            if (mb_strlen($title) > 50): 
                                                            ?>
                                                                <span class="text-primary" style="cursor: pointer;" onclick="showFullText('<?php echo htmlspecialchars(addslashes($title)); ?>', 'Item Title')">...more</span>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                                            <?php 
                                                            $description = $property['description'] ?? '';
                                                            echo htmlspecialchars(mb_substr($description, 0, 50)); 
                                                            if (mb_strlen($description) > 50): 
                                                            ?>
                                                                <span class="text-primary" style="cursor: pointer;" onclick="showFullText('<?php echo htmlspecialchars(addslashes($description)); ?>', 'Description')">...more</span>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <span class="text-secondary text-xs font-weight-bold" style="word-wrap: break-word;">
                                                    <?php 
                                                    $address = $property['address'] ?? '';
                                                    echo htmlspecialchars(mb_substr($address, 0, 50)); 
                                                    if (mb_strlen($address) > 50): 
                                                    ?>
                                                        <span class="text-primary" style="cursor: pointer;" onclick="showFullText('<?php echo htmlspecialchars(addslashes($address)); ?>', 'Address')">...more</span>
                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-sm <?php echo !empty($property['inspectionstatus']) ? 'bg-info' : 'bg-secondary'; ?>">
                                                    <?php echo htmlspecialchars($property['inspectionstatus'] ?? 'Not Set'); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php 
                                                    if (!empty($property['price'])) {
                                                        echo number_format($property['price'], 2);
                                                        if (!empty($property['priceunit'])) {
                                                            echo ' ' . htmlspecialchars($property['priceunit']);
                                                        }
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($property['itemtype'] ?? 'N/A'); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($property['seller'] ?? 'N/A'); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php 
                                                    if (!empty($property['entrydate'])) {
                                                        echo date('d/m/y', strtotime($property['entrydate']));
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                           
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Inspection Approved properties found</p>
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

    <?php $paginationData = $inspectionApproved; include __DIR__ . '/../partials/pagination.php'; ?>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<!-- Full Text Modal -->
<div class="modal fade" id="fullTextModal" tabindex="-1" aria-labelledby="fullTextModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullTextModalLabel">Full Text</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="fullTextContent"></p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Apply Filters
        $('#applyFilters').on('click', function() {
            const filters = {
                itemtype: $('#filter_itemtype').val(),
                entry_date: $('#filter_entry_date').val(),
            };

            const params = new URLSearchParams();
            Object.keys(filters).forEach(key => {
                if (filters[key]) {
                    params.append(key, filters[key]);
                }
            });

            const url = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.location.href = url;
        });

        // Reset Filters
        $('#resetFilters').on('click', function() {
            $('#filter_itemtype').val('');
            $('#filter_entry_date').val('');
            window.location.href = window.location.pathname;
        });

        $('#filter_entry_date').on('keypress', function(e) {
            if (e.which === 13) {
                $('#applyFilters').click();
            }
        });
    });

    function showFullText(text, title) {
        document.getElementById('fullTextModalLabel').textContent = title;
        document.getElementById('fullTextContent').textContent = text;
        new bootstrap.Modal(document.getElementById('fullTextModal')).show();
    }

    // Handle reject approved property
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('reject-approved-property') || e.target.closest('.reject-approved-property')) {
            e.preventDefault();
            const itemid = e.target.closest('.reject-approved-property').dataset.itemid;
            const title = e.target.closest('.reject-approved-property').dataset.title;

            Swal.fire({
                title: 'Reject Property?',
                html: `Are you sure you want to reject <strong>"${title}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Reject',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?php echo url("listings/properties/reject"); ?>/' + itemid, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message || 'Property rejected successfully');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(data.message || 'Failed to reject property');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while rejecting the property');
                    });
                }
            });
        }
    });

    // Handle reinspect approved property
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('reinspect-approved-property') || e.target.closest('.reinspect-approved-property')) {
            e.preventDefault();
            const itemid = e.target.closest('.reinspect-approved-property').dataset.itemid;
            const title = e.target.closest('.reinspect-approved-property').dataset.title;

            Swal.fire({
                title: 'Send for Reinspection?',
                html: `Are you sure you want to send <strong>"${title}"</strong> for reinspection?`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Reinspect',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?php echo url("listings/properties/reinspect"); ?>/' + itemid, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message || 'Property sent for reinspection successfully');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(data.message || 'Failed to send property for reinspection');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while sending property for reinspection');
                    });
                }
            });
        }
    });

    // Handle list approved property
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('list-approved-property') || e.target.closest('.list-approved-property')) {
            e.preventDefault();
            const itemid = e.target.closest('.list-approved-property').dataset.itemid;
            const title = e.target.closest('.list-approved-property').dataset.title;

            Swal.fire({
                title: 'List Property?',
                html: `Are you sure you want to list <strong>"${title}"</strong>?`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, List It',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?php echo url("listings/properties/list-property"); ?>/' + itemid, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message || 'Property listed successfully');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(data.message || 'Failed to list property');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while listing property');
                    });
                }
            });
        }
    });

    // Handle keep for listing approved property
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('keep-approved-for-listing') || e.target.closest('.keep-approved-for-listing')) {
            e.preventDefault();
            const itemid = e.target.closest('.keep-approved-for-listing').dataset.itemid;
            const title = e.target.closest('.keep-approved-for-listing').dataset.title;

            Swal.fire({
                title: 'Keep for Listing?',
                html: `Are you sure you want to keep <strong>"${title}"</strong> for future listing?`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Keep It',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?php echo url("listings/properties/keep-for-listing"); ?>/' + itemid, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message || 'Property kept for listing successfully');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(data.message || 'Failed to keep property for listing');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while keeping property for listing');
                    });
                }
            });
        }
    });
</script>
