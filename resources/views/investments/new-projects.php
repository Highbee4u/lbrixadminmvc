<?php $pageTitle = 'Pending Projects'; ?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Pending Projects
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-6">
                            <label for="filter_ownership_type" class="form-label fw-bold">Ownership Type</label>
                            <select class="form-select" id="filter_ownership_type" name="ownership_type">
                                <option value="">All Types</option>
                                <?php foreach (($ownershipTypes ?? []) as $type): ?>
                                    <option value="<?php echo htmlspecialchars($type['ownershiptypeid'] ?? '', ENT_QUOTES); ?>" <?php echo (($_GET['ownership_type'] ?? '') == ($type['ownershiptypeid'] ?? '')) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($type['title'] ?? '', ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="filter_entry_date" class="form-label fw-bold">Entry Date</label>
                            <input type="date" class="form-control" id="filter_entry_date" name="entry_date" value="<?php echo htmlspecialchars($_GET['entry_date'] ?? '', ENT_QUOTES); ?>">
                        </div>
                        <div class="col-lg-4 col-md-6">
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
                        $activeFilters = array_filter(['ownership_type' => $_GET['ownership_type'] ?? null,'entry_date' => $_GET['entry_date'] ?? null]);
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

    <!-- Main Content Section -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Pending Projects</h6>
                        <a href="<?php echo url('investments/add-project'); ?>" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Add Project
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Title</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inspection Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Project Amount</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Financee</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ownership Title</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Entry Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($investmentList['data'])): ?>
                                    <?php foreach ($investmentList['data'] as $project): ?>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo url("investments/project-detail/" . htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES)); ?>">
                                                                <i class="fas fa-eye me-2"></i>View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo url("investments/edit-project/" . htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES)); ?>">
                                                                <i class="fas fa-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item create-inspection" href="javascript:;" data-itemid="<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>" data-title="<?php echo htmlspecialchars($project['title'] ?? '', ENT_QUOTES); ?>">
                                                                <i class="fas fa-tasks me-2"></i>Create Inspection Task
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger delete-project" href="javascript:;" data-itemid="<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-warning reject-project" href="javascript:;" data-itemid="<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">
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
                                                            <?php 
                                                            $title = $project['title'] ?? '';
                                                            echo htmlspecialchars(mb_strlen($title) > 50 ? mb_substr($title,0,50).'...' : $title, ENT_QUOTES);
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                                            <?php 
                                                            $desc = $project['description'] ?? '';
                                                            echo htmlspecialchars(mb_strlen($desc) > 50 ? mb_substr($desc,0,50).'...' : $desc, ENT_QUOTES);
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <span class="text-secondary text-xs font-weight-bold" style="word-wrap: break-word;">
                                                    <?php 
                                                    $addr = $project['address'] ?? '';
                                                    echo htmlspecialchars(mb_strlen($addr) > 50 ? mb_substr($addr,0,50).'...' : $addr, ENT_QUOTES);
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-sm <?php echo !empty($project['inspectionstatus']) ? 'bg-info' : 'bg-secondary'; ?>">
                                                    <?php echo htmlspecialchars($project['inspectionstatus'] ?? 'Not Set', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo isset($project['price']) ? number_format((float)$project['price'], 2) : 'N/A'; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($project['financee'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($project['ownershiptypetitle'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($project['itemtypetitle'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo !empty($project['entrydate']) ? date('d/m/y', strtotime($project['entrydate'])) : 'N/A'; ?>
                                                </span>
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No pending projects found</p>
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

    <?php $paginationData = $investmentList; include __DIR__ . '/../partials/pagination.php'; ?>
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
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inspection_itemid" class="form-label">Project</label>
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

<script>
(function(){
    const applyBtn = document.getElementById('applyFilters');
    if (applyBtn) {
        applyBtn.addEventListener('click', function(){
            const params = new URLSearchParams();
            const ot = document.getElementById('filter_ownership_type').value;
            const ed = document.getElementById('filter_entry_date').value;
            if (ot) params.append('ownership_type', ot);
            if (ed) params.append('entry_date', ed);
            window.location.href = (() => {
                const baseUrl = '<?php echo url("investments/new-projects"); ?>';
                const queryString = params.toString();
                return baseUrl + (queryString ? '&' + queryString : '');
            })();
        });
    }
    const resetBtn = document.getElementById('resetFilters');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(){
            window.location.href = '<?php echo url("investments/new-projects"); ?>';
        });
    }
})();

function showFullText(text, title) {
    document.getElementById('fullTextModalLabel').textContent = title;
    document.getElementById('fullTextContent').textContent = text;
    new bootstrap.Modal(document.getElementById('fullTextModal')).show();
}

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

// Delete and Reject handlers
document.addEventListener('click', function(e){
    const del = e.target.closest('.delete-project');
    if (del) {
        const id = del.getAttribute('data-itemid');
        if (!id) {
            toastr.error('Project ID is required');
            return;
        }
        
        Swal.fire({
            title: 'Delete Project?',
            text: 'This is a soft delete. The project can be restored later.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`<?php echo url("investments/projects/delete") ?>/${id}`, { method: 'POST' })
                    .then(r => r.json().then(data => ({ok: r.ok, data})))
                    .then(({ok, data}) => {
                        if (ok && data.success) {
                            toastr.success(data.message || 'Project deleted successfully');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            toastr.error(data.message || 'Failed to delete project');
                        }
                    })
                    .catch(() => toastr.error('Error occurred while deleting project'));
            }
        });
    }
    
    const rej = e.target.closest('.reject-project');
    if (rej) {
        const id = rej.getAttribute('data-itemid');
        if (!id) {
            toastr.error('Project ID is required');
            return;
        }
        
        Swal.fire({
            title: 'Reject Project?',
            text: 'This action will mark the project as rejected.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f39c12',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`<?php echo url("investments/projects/reject") ?>/${id}`, { method: 'POST' })
                    .then(r => r.json().then(data => ({ok: r.ok, data})))
                    .then(({ok, data}) => {
                        if (ok && data.success) {
                            toastr.success(data.message || 'Project rejected successfully');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            toastr.error(data.message || 'Failed to reject project');
                        }
                    })
                    .catch(() => toastr.error('Error occurred while rejecting project'));
            }
        });
    }
});

const createInspectionForm = document.getElementById('createInspectionForm');
if (createInspectionForm) {
    createInspectionForm.addEventListener('submit', function(e){
        e.preventDefault();
        
        // Validate form
        if (!this.checkValidity()) {
            this.classList.add('was-validated');
            toastr.warning('Please fill in all required fields');
            return;
        }
        
        const fd = new FormData(this);
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
        
        fetch('<?php echo url("inspection/tasks/store") ?>', { method:'POST', body: fd })
            .then(r => r.json().then(data => ({ok: r.ok, data})))
            .then(({ok, data}) => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                
                if (ok && data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createInspectionModal'));
                    if (modal) modal.hide();
                    
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Inspection task created successfully',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    toastr.error(data.message || 'Failed to create inspection task');
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                toastr.error('Error occurred while creating inspection task');
            });
    });
}
</script>
