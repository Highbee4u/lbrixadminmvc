<?php $pageTitle = 'Inspection Concluded'; ?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Inspection Concluded Properties
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-6">
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
                        <div class="col-lg-4 col-md-6">
                            <label for="filter_entry_date" class="form-label fw-bold">Entry Date</label>
                            <input type="date" class="form-control" id="filter_entry_date" name="entry_date" value="<?php echo isset($_GET['entry_date']) ? htmlspecialchars($_GET['entry_date']) : ''; ?>">
                        </div>
                        <div class="col-lg-4 col-md-12">
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
                        <h6>Inspection Concluded Properties</h6>
                        <a href="<?php echo url('listings/add-property'); ?>" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Add Property
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
                                <?php if (!empty($inspectionConcluded['data']) && count($inspectionConcluded['data']) > 0): ?>
                                    <?php foreach ($inspectionConcluded['data'] as $property): ?>
                                        <tr>
                                                                                        <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo $property['itemid']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo $property['itemid']; ?>">
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo url('listings/property-detail/' . $property['itemid']); ?>">
                                                                <i class="fas fa-eye me-2"></i>View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo url('listings/edit-property/' . $property['itemid']); ?>">
                                                                <i class="fas fa-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item create-inspection" href="javascript:;" data-itemid="<?php echo $property['itemid']; ?>" data-title="<?php echo htmlspecialchars($property['title']); ?>">
                                                                <i class="fas fa-tasks me-2"></i>Create Inspection Task
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger delete-property" href="javascript:;" data-itemid="<?php echo $property['itemid']; ?>" data-title="<?php echo htmlspecialchars($property['title']); ?>">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-warning reject-property" href="javascript:;" data-itemid="<?php echo $property['itemid']; ?>" data-title="<?php echo htmlspecialchars($property['title']); ?>">
                                                                <i class="fas fa-times me-2"></i>Reject
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
                                            <p class="text-sm text-secondary mb-0">No Inspection Concluded Properties found</p>
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

    <?php $paginationData = $inspectionConcluded; include __DIR__ . '/../partials/pagination.php'; ?>
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

<!-- Create Inspection Task Modal -->
<div class="modal fade" id="createInspectionModal" tabindex="-1" aria-labelledby="createInspectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createInspectionModalLabel">Create Inspection Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createInspectionForm" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inspection_itemid" class="form-label">Item</label>
                                <input type="text" class="form-control" id="inspection_itemid" readonly>
                                <input type="hidden" id="inspection_itemid_hidden" name="itemid">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspection_lead" class="form-label">Inspection Lead</label>
                                <select class="form-select" id="inspection_lead" name="inspectionlead" required>
                                    <option value="">Select Inspection Lead</option>
                                    <?php if (!empty($inspectionLeads)): ?>
                                        <?php foreach ($inspectionLeads as $lead): ?>
                                            <option value="<?php echo $lead['userid']; ?>"><?php echo htmlspecialchars(trim($lead['surname'] . ' ' . $lead['firstname'] . ' ' . $lead['middlename'])); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspection_startdate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="inspection_startdate" name="startdate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspection_status" class="form-label">Status</label>
                                <select class="form-select" id="inspection_status" name="status" required>
                                    <option value="">Select Status</option>
                                    <?php if (!empty($inspectionStatuses)): ?>
                                        <?php foreach ($inspectionStatuses as $status): ?>
                                            <option value="<?php echo $status['inspectionstatusid']; ?>"><?php echo htmlspecialchars($status['title']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspection_supervisornote" class="form-label">Supervisor Note</label>
                                <textarea class="form-control" id="inspection_supervisornote" name="supervisornote" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inspection_note" class="form-label">Note (Description)</label>
                                <textarea class="form-control" id="inspection_note" name="note" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inspection_docurl" class="form-label">Document Upload</label>
                                <input type="file" class="form-control" id="inspection_docurl" name="docurl" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Inspection Task</button>
                </div>
            </form>
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

    // Create Inspection Task
    $(document).on('click', '.create-inspection', function() {
        const itemid = $(this).data('itemid');
        const title = $(this).data('title');
        $('#inspection_itemid').val(title);
        $('#inspection_itemid_hidden').val(itemid);
        new bootstrap.Modal(document.getElementById('createInspectionModal')).show();
    });
});

function showFullText(text, title) {
    document.getElementById('fullTextModalLabel').textContent = title;
    document.getElementById('fullTextContent').textContent = text;
    new bootstrap.Modal(document.getElementById('fullTextModal')).show();
}
</script>
