<?php $pageTitle = 'New Properties'; ?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Pending Properties
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-4">
                            <label for="filter_itemtype" class="form-label fw-bold">Property Type</label>
                            <select class="form-select" id="filter_itemtype" name="itemtype">
                                <option value="">All Types</option>
                                <?php foreach (($itemTypes ?? []) as $type): ?>
                                    <option value="<?php echo htmlspecialchars($type['itemtypeid'] ?? '', ENT_QUOTES); ?>" <?php echo (($_GET['itemtype'] ?? '') == ($type['itemtypeid'] ?? '')) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($type['title'] ?? '', ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <label for="filter_entry_date" class="form-label fw-bold">Entry Date</label>
                            <input type="date" class="form-control" id="filter_entry_date" name="entry_date" value="<?php echo htmlspecialchars($_GET['entry_date'] ?? '', ENT_QUOTES); ?>">
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
                    <?php 
                        $activeFilters = array_filter(['itemtype' => $_GET['itemtype'] ?? null,'entry_date' => $_GET['entry_date'] ?? null]);
                        if (!empty($activeFilters)):
                    ?>
                        <span class="badge bg-info text-white ms-2">
                            <i class="fas fa-filter me-1"></i><?php echo count($activeFilters); ?> active filter(s)
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Pending Properties</h6>
                        <a href="<?php echo url('listings/add-property'); ?>" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Add Property
                        </a>
                    </div>
<!-- Add Property Modal -->
<div class="modal fade" id="addPropertyModal" tabindex="-1" aria-labelledby="addPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPropertyModalLabel">Add Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPropertyForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="property_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="property_title" name="title" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="property_type" class="form-label">Property Type</label>
                            <select class="form-select" id="property_type" name="itemtypeid" required>
                                <option value="">Select Type</option>
                                <?php foreach (($itemTypes ?? []) as $type): ?>
                                    <option value="<?php echo htmlspecialchars($type['itemtypeid'] ?? '', ENT_QUOTES); ?>">
                                        <?php echo htmlspecialchars($type['title'] ?? '', ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="property_description" class="form-label">Description</label>
                            <textarea class="form-control" id="property_description" name="description" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="property_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="property_address" name="address" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="property_price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="property_price" name="price" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="property_priceunit" class="form-label">Price Unit</label>
                            <input type="text" class="form-control" id="property_priceunit" name="priceunit">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="property_entrydate" class="form-label">Entry Date</label>
                            <input type="date" class="form-control" id="property_entrydate" name="entrydate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="property_doc" class="form-label">Document Upload</label>
                            <input type="file" class="form-control" id="property_doc" name="docurl" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Accepted: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Property</button>
                </div>
            </form>
        </div>
    </div>
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
                                <?php if (!empty($pendingProperties['data'])): ?>
                                    <?php foreach ($pendingProperties['data'] as $property): ?>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES); ?>">
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo url('listings/property-detail/' . htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES)); ?>">
                                                                <i class="fas fa-eye me-2"></i>View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo url('listings/edit-property/' . htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES)); ?>">
                                                                <i class="fas fa-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item create-inspection" href="javascript:;" data-itemid="<?php echo htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES); ?>" data-title="<?php echo htmlspecialchars($property['title'] ?? '', ENT_QUOTES); ?>">
                                                                <i class="fas fa-tasks me-2"></i>Create Inspection Task
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger delete-property" href="javascript:;" data-itemid="<?php echo htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES); ?>">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-warning reject-property" href="javascript:;" data-itemid="<?php echo htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES); ?>">
                                                                <i class="fas fa-ban me-2"></i>Reject
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                                            <?php $title = $property['title'] ?? ''; echo htmlspecialchars(mb_strlen($title) > 50 ? mb_substr($title,0,50).'...' : $title, ENT_QUOTES); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                                            <?php $desc = $property['description'] ?? ''; echo htmlspecialchars(mb_strlen($desc) > 50 ? mb_substr($desc,0,50).'...' : $desc, ENT_QUOTES); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <span class="text-secondary text-xs font-weight-bold" style="word-wrap: break-word;">
                                                    <?php $addr = $property['address'] ?? ''; echo htmlspecialchars(mb_strlen($addr) > 50 ? mb_substr($addr,0,50).'...' : $addr, ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-sm bg-info">
                                                    <?php echo htmlspecialchars($property['inspectionstatusid'] ?? 'Not Set', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo isset($property['price']) ? number_format((float)$property['price'], 2) : 'N/A'; ?>
                                                    <?php echo !empty($property['priceunit']) ? ' ' . htmlspecialchars($property['priceunit'], ENT_QUOTES) : ''; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($property['itemtypeid'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">N/A</span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo !empty($property['entrydate']) ? date('d/m/y', strtotime($property['entrydate'])) : 'N/A'; ?>
                                                </span>
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No pending properties found</p>
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

    <?php include __DIR__ . '/../partials/pagination.php'; // Common pagination snippet ?>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<script>
(function(){
    const applyBtn = document.getElementById('applyFilters');
    if (applyBtn) {
        applyBtn.addEventListener('click', function(){
            const params = new URLSearchParams();
            const it = document.getElementById('filter_itemtype').value;
            const ed = document.getElementById('filter_entry_date').value;
            if (it) params.append('itemtype', it);
            if (ed) params.append('entry_date', ed);
            window.location.href = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        });
    }
    const resetBtn = document.getElementById('resetFilters');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(){
            window.location.href = window.location.pathname;
        });
    }
})();

// Add Property Modal logic (guard if modal trigger exists)
const addPropertyBtn = document.getElementById('addPropertyBtn');
if (addPropertyBtn) {
    addPropertyBtn.addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('addPropertyModal'));
            const f = document.getElementById('addPropertyForm');
            if (f) f.reset();
            clearAddPropertyAlert();
            modal.show();
    });
}

// AJAX form submit (guard if modal exists)
const addPropertyForm = document.getElementById('addPropertyForm');
if (addPropertyForm) {
    addPropertyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            fetch('<?php echo url('listings/add-property'); ?>', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                    if (data.success) {
                            toastr.success(data.message || 'Property added successfully.');
                            setTimeout(() => { window.location.reload(); }, 1000);
                    } else {
                            toastr.error(data.message || 'Failed to add property.');
                    }
            })
            .catch(() => {
                    toastr.error('An error occurred. Please try again.');
            });
    });
}

// Delete and Reject handlers (event delegation)
document.addEventListener('click', function(e){
    const del = e.target.closest('.delete-property');
    if (del) {
        const id = del.getAttribute('data-itemid');
        if (!id) return;
        Swal.fire({
            title: 'Delete Property?',
            text: 'This will perform a soft delete. The property can be restored later.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`<?php echo url('listings/properties/'); ?>${id}`, { method: 'DELETE' })
                    .then(r => r.json()).then(d => {
                        if (d.success) {
                            toastr.success(d.message || 'Property deleted successfully');
                            setTimeout(() => { window.location.reload(); }, 1000);
                        } else {
                            toastr.error(d.message || 'Delete failed');
                        }
                    }).catch(() => toastr.error('Error while deleting property'));
            }
        });
    }
    const rej = e.target.closest('.reject-property');
    if (rej) {
        const id = rej.getAttribute('data-itemid');
        if (!id) return;
        Swal.fire({
            title: 'Reject Property?',
            text: 'Are you sure you want to reject this property?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, reject it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`<?php echo url('listings/properties/reject/'); ?>${id}`, { method: 'POST' })
                    .then(r => r.json()).then(d => {
                        if (d.success) {
                            toastr.success(d.message || 'Property rejected successfully');
                            setTimeout(() => { window.location.reload(); }, 1000);
                        } else {
                            toastr.error(d.message || 'Reject failed');
                        }
                    }).catch(() => toastr.error('Error while rejecting property'));
            }
        });
    }
});

    // Create Inspection Task modal handling
    document.addEventListener('click', function(e){
        const c = e.target.closest('.create-inspection');
        if (!c) return;
        e.preventDefault();
        const itemid = c.getAttribute('data-itemid');
        const title = c.getAttribute('data-title') || '';
        const inputTitle = document.getElementById('inspection_itemid');
        const inputHidden = document.getElementById('inspection_itemid_hidden');
        if (inputTitle) inputTitle.value = title;
        if (inputHidden) inputHidden.value = itemid;
        const m = new bootstrap.Modal(document.getElementById('createInspectionModal'));
        m.show();
    });

    const createInspectionForm = document.getElementById('createInspectionForm');
    if (createInspectionForm) {
        createInspectionForm.addEventListener('submit', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            fetch('<?php echo url('inspection/tasks/store'); ?>', { method:'POST', body: fd })
                .then(r=>r.json()).then(d=>{
                    if (d.success) {
                        bootstrap.Modal.getInstance(document.getElementById('createInspectionModal')).hide();
                        toastr.success(d.message || 'Inspection task created successfully');
                        setTimeout(() => { location.reload(); }, 1000);
                    } else {
                        toastr.error(d.message || 'Failed to create inspection task');
                    }
                }).catch(()=>toastr.error('Error while creating inspection task'));
        });
    }
</script>

    <!-- Create Inspection Task Modal -->
    <div class="modal fade" id="createInspectionModal" tabindex="-1" aria-labelledby="createInspectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createInspectionModalLabel">Create Inspection Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createInspectionForm" enctype="multipart/form-data">
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
                                        <?php foreach(($inspectionLeads ?? []) as $lead): ?>
                                            <option value="<?php echo htmlspecialchars($lead['userid']); ?>"><?php echo htmlspecialchars(trim(($lead['surname'] ?? '') . ' ' . ($lead['firstname'] ?? '') . ' ' . ($lead['middlename'] ?? ''))); ?></option>
                                        <?php endforeach; ?>
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
                                        <?php foreach(($inspectionStatuses ?? []) as $status): ?>
                                            <option value="<?php echo htmlspecialchars($status['inspectionstatusid']); ?>"><?php echo htmlspecialchars($status['title']); ?></option>
                                        <?php endforeach; ?>
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
