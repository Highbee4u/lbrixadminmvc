<?php $pageTitle = 'Edit Project'; ?>
<?php include __DIR__ . '/../partials/topnav.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Edit Investment Project</h6>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-pills nav-fill mb-4" id="projectTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="project-info-tab" data-bs-toggle="pill" data-bs-target="#project-info" type="button" role="tab" aria-controls="project-info" aria-selected="true">
                                <i class="fas fa-info-circle me-2"></i>Project Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="project-documents-tab" data-bs-toggle="pill" data-bs-target="#project-documents" type="button" role="tab" aria-controls="project-documents" aria-selected="false">
                                <i class="fas fa-file-alt me-2"></i>Project Documents
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="project-images-tab" data-bs-toggle="pill" data-bs-target="#project-images" type="button" role="tab" aria-controls="project-images" aria-selected="false">
                                <i class="fas fa-images me-2"></i>Project Images
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="project-inspection-tab" data-bs-toggle="pill" data-bs-target="#project-inspection" type="button" role="tab" aria-controls="project-inspection" aria-selected="false">
                                <i class="fas fa-clipboard-check me-2"></i>Project Inspection
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="investors-info-tab" data-bs-toggle="pill" data-bs-target="#investors-info" type="button" role="tab" aria-controls="investors-info" aria-selected="false">
                                <i class="fas fa-users me-2"></i>Investors Information
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="projectTabsContent">
                        <!-- Project Information Tab -->
                        <div class="tab-pane fade show active" id="project-info" role="tabpanel" aria-labelledby="project-info-tab">
                            <form id="projectInfoForm">
                                <input type="hidden" name="servicetypeid" value="4">
                                <input type="hidden" name="inspectiontaskid" value="<?php echo htmlspecialchars($project['inspectiontaskid'] ?? '', ENT_QUOTES); ?>">
                                <input type="hidden" name="itemid" id="itemid" value="<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="title" class="form-label fw-bold">Project Title *</label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($project['title'] ?? '', ENT_QUOTES); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="inspectionstatusid" class="form-label fw-bold">Inspection Status</label>
                                            <select class="form-select" id="inspectionstatusid" name="inspectionstatusid">
                                                <option value="">Select Status</option>
                                                <?php foreach (($inspectionStatuses ?? []) as $status): ?>
                                                    <option value="<?php echo htmlspecialchars($status['inspectionstatusid'] ?? '', ENT_QUOTES); ?>" <?php echo (($project['inspectionstatusid'] ?? '') == ($status['inspectionstatusid'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($status['title'] ?? '', ENT_QUOTES); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="description" class="form-label fw-bold">Description *</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($project['description'] ?? '', ENT_QUOTES); ?></textarea>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="address" class="form-label fw-bold">Address *</label>
                                            <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($project['address'] ?? '', ENT_QUOTES); ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="price" class="form-label fw-bold">Total Project Amount</label>
                                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($project['price'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="ownershiptypeid" class="form-label fw-bold">Ownership Type</label>
                                            <select class="form-select" id="ownershiptypeid" name="ownershiptypeid">
                                                <option value="">Select Ownership Type</option>
                                                <?php foreach (($ownershipTypes ?? []) as $type): ?>
                                                    <option value="<?php echo htmlspecialchars($type['ownershiptypeid'] ?? '', ENT_QUOTES); ?>" <?php echo (($project['ownershiptypeid'] ?? '') == ($type['ownershiptypeid'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($type['title'] ?? '', ENT_QUOTES); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="ownershiptypetitle" class="form-label fw-bold">Ownership Title</label>
                                            <input type="text" class="form-control" id="ownershiptypetitle" name="ownershiptypetitle" value="<?php echo htmlspecialchars($project['ownershiptypetitle'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="minprice" class="form-label fw-bold">Minimum Investment</label>
                                            <input type="number" class="form-control" id="minprice" name="minprice" step="0.01" value="<?php echo htmlspecialchars($project['minprice'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="maxprice" class="form-label fw-bold">Maximum Investment</label>
                                            <input type="number" class="form-control" id="maxprice" name="maxprice" step="0.01" value="<?php echo htmlspecialchars($project['maxprice'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="investunit" class="form-label fw-bold">Unit of Investment</label>
                                            <input type="text" class="form-control" id="investunit" name="investunit" value="<?php echo htmlspecialchars($project['investunit'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="investreturns" class="form-label fw-bold">Investment Returns</label>
                                            <input type="text" class="form-control" id="investreturns" name="investreturns" value="<?php echo htmlspecialchars($project['investreturns'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="tenure" class="form-label fw-bold">Tenure of Investment</label>
                                            <input type="text" class="form-control" id="tenure" name="tenure" value="<?php echo htmlspecialchars($project['tenure'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="investoptionid" class="form-label fw-bold">Investment Type</label>
                                            <select class="form-select" id="investoptionid" name="investoptionid">
                                                <option value="">Select Investment Type</option>
                                                <?php foreach (($investOptions ?? []) as $option): ?>
                                                    <option value="<?php echo htmlspecialchars($option['investoptionid'] ?? '', ENT_QUOTES); ?>" <?php echo (($project['investoptionid'] ?? '') == ($option['investoptionid'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($option['title'] ?? '', ENT_QUOTES); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="investoptiontitle" class="form-label fw-bold">Investment Type Title</label>
                                            <input type="text" class="form-control" id="investoptiontitle" name="investoptiontitle" value="<?php echo htmlspecialchars($project['investoptiontitle'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="sellerid" class="form-label fw-bold">Financee/Seller</label>
                                            <select class="form-select" id="sellerid" name="sellerid">
                                                <option value="">Select Financee/Seller</option>
                                                <?php foreach (($users ?? []) as $user): ?>
                                                    <option value="<?php echo htmlspecialchars($user['userid'] ?? '', ENT_QUOTES); ?>" <?php echo (($project['sellerid'] ?? '') == ($user['userid'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars(trim(($user['surname'] ?? '') . ' ' . ($user['firstname'] ?? '') . ' ' . ($user['middlename'] ?? '')), ENT_QUOTES); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="attorneyid" class="form-label fw-bold">Attorney</label>
                                            <select class="form-select" id="attorneyid" name="attorneyid">
                                                <option value="">Select Attorney</option>
                                                <?php 
                                                // Debug: Check if attorneys array exists and has data
                                                if (empty($attorneys)): ?>
                                                    <!-- No attorneys found. Check database for users with usertypeid=4 -->
                                                <?php endif;
                                                foreach (($attorneys ?? []) as $attorney): ?>
                                                    <option value="<?php echo htmlspecialchars($attorney['userid'] ?? '', ENT_QUOTES); ?>" <?php echo (($project['attorneyid'] ?? '') == ($attorney['userid'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars(trim(($attorney['surname'] ?? '') . ' ' . ($attorney['firstname'] ?? '') . ' ' . ($attorney['middlename'] ?? '')), ENT_QUOTES); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="projecttypeid" class="form-label fw-bold">Project Type</label>
                                            <select class="form-select" id="projecttypeid" name="projecttypeid">
                                                <option value="">Select Project Type</option>
                                                <?php foreach (($projectTypes ?? []) as $type): ?>
                                                    <option value="<?php echo htmlspecialchars($type['projecttypeid'] ?? '', ENT_QUOTES); ?>" <?php echo (($project['projecttypeid'] ?? '') == ($type['projecttypeid'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($type['title'] ?? '', ENT_QUOTES); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="projecttypetitle" class="form-label fw-bold">Project Type Title</label>
                                            <input type="text" class="form-control" id="projecttypetitle" name="projecttypetitle" value="<?php echo htmlspecialchars($project['projecttypetitle'] ?? '', ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="itemstatusid" class="form-label fw-bold">Item Status</label>
                                            <select class="form-select" id="itemstatusid" name="itemstatusid">
                                                <option value="">Select Status</option>
                                                <?php foreach (($itemStatuses ?? []) as $status): ?>
                                                    <option value="<?php echo htmlspecialchars($status['itemstatusid'] ?? '', ENT_QUOTES); ?>" <?php echo (($project['itemstatusid'] ?? '') == ($status['itemstatusid'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($status['title'] ?? '', ENT_QUOTES); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" id="saveProjectInfo">
                                        <i class="fas fa-save me-2"></i>Save & Continue
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Project Profile tab removed -->

                        <!-- Project Documents Tab -->
                        <div class="tab-pane fade" id="project-documents" role="tabpanel" aria-labelledby="project-documents-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Project Documents</h6>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#documentModal" onclick="openDocumentModal()">
                                    <i class="fas fa-plus me-2"></i>Add New Document
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="documentsTable">
                                    <thead>
                                        <tr>
                                            <th>Document Type</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="documentsTableBody">
                                        <?php if (isset($project) && !empty($project['itemDocs'])): ?>
                                            <?php foreach ($project['itemDocs'] as $doc): ?>
                                                <tr data-docid="<?php echo htmlspecialchars($doc['itemdocid'] ?? '', ENT_QUOTES); ?>">
                                                    <td><?php echo htmlspecialchars($doc['itemDocTypeTitle'] ?? 'Document', ENT_QUOTES); ?></td>
                                                    <td>
                                                        <?php if (!empty($doc['docurl'])): ?>
                                                            <a href="/storage/<?php echo htmlspecialchars($doc['docurl'], ENT_QUOTES); ?>" target="_blank">
                                                                <i class="fas fa-file-alt me-1"></i><?php echo basename($doc['docurl']); ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">No file</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge <?php echo !empty($doc['docstatus']) ? 'bg-success' : 'bg-secondary'; ?>">
                                                            <?php echo !empty($doc['docstatus']) ? 'Visible' : 'Hidden'; ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo isset($doc['entrydate']) ? date('M d, Y', strtotime($doc['entrydate'])) : 'N/A'; ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary" onclick="editDocument(<?php echo htmlspecialchars($doc['itemdocid'] ?? '', ENT_QUOTES); ?>)">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteDocument(<?php echo htmlspecialchars($doc['itemdocid'] ?? '', ENT_QUOTES); ?>)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr id="noDocumentsRow">
                                                <td colspan="5" class="text-center text-muted">No documents added yet</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary" onclick="switchTab('project-info')">
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                                <button type="button" class="btn btn-primary" onclick="switchTab('project-images')">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Project Images Tab -->
                        <div class="tab-pane fade" id="project-images" role="tabpanel" aria-labelledby="project-images-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Project Images</h6>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="openImageModal()">
                                    <i class="fas fa-plus me-2"></i>Add Project Image
                                </button>
                            </div>

                            <div class="row" id="imagesGallery">
                                <?php if (isset($project) && !empty($project['itemPics'])): ?>
                                    <?php foreach ($project['itemPics'] as $pic): ?>
                                        <div class="col-md-4 mb-3" data-picid="<?php echo htmlspecialchars($pic['itempicid'] ?? '', ENT_QUOTES); ?>">
                                            <div class="card">
                                                <?php if (!empty($pic['picurl'])): ?>
                                                    <img src="<?php echo htmlspecialchars(Helpers::imageUrl($pic['picurl']), ENT_QUOTES); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Project Image">
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <h6 class="card-title"><?php echo htmlspecialchars($pic['pictitle'] ?? 'Image', ENT_QUOTES); ?></h6>
                                                    <span class="badge <?php echo !empty($pic['picstatus']) ? 'bg-success' : 'bg-secondary'; ?> mb-2">
                                                        <?php echo !empty($pic['picstatus']) ? 'Visible' : 'Hidden'; ?>
                                                    </span>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-sm btn-outline-primary" onclick="editImage(<?php echo htmlspecialchars($pic['itempicid'] ?? '', ENT_QUOTES); ?>)">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteImage(<?php echo htmlspecialchars($pic['itempicid'] ?? '', ENT_QUOTES); ?>)">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12" id="noImagesMessage">
                                        <div class="alert alert-info text-center">No images added yet</div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary" onclick="switchTab('project-documents')">
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                                <button type="button" class="btn btn-primary" onclick="switchTab('project-layout')">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Project Inspection Tab -->
                        <div class="tab-pane fade" id="project-inspection" role="tabpanel" aria-labelledby="project-inspection-tab">
                            <div class="mb-3">
                                <h6 class="text-muted">Inspection Records</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Inspector</th>
                                            <th>Task</th>
                                            <th>Status</th>
                                            <th>Comments</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="inspectionsTableBody">
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                Loading inspections...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-secondary" onclick="switchTab('project-images')">
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                                <button type="button" class="btn btn-primary" onclick="switchTab('investors-info')">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Investors Information Tab -->
                        <div class="tab-pane fade" id="investors-info" role="tabpanel" aria-labelledby="investors-info-tab">
                            <div class="mb-3">
                                <h6 class="text-muted">Investor Bids/Offers</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Investor</th>
                                            <th>Bid Amount</th>
                                            <th>Status</th>
                                            <th>Comments</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="investorsTableBody">
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                Loading investor information...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-secondary" onclick="switchTab('project-inspection')">
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<script>
    // Global variables - declared at top to avoid hoisting issues
    let currentItemId = null;
    let editingDocumentId = null;
    let editingImageId = null;

    // Set CSRF token for AJAX requests
    window.csrfToken = "<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>";

document.addEventListener('DOMContentLoaded', function() {
    initializeValidation();

    // Auto-fill ownership title when ownership type changes
    const ownershipTypeSelect = document.getElementById('ownershiptypeid');
    const ownershipTitleInput = document.getElementById('ownershiptypetitle');
    const syncOwnershipTitle = () => {
        if (!ownershipTypeSelect || !ownershipTitleInput) return;
        const sel = ownershipTypeSelect;
        const txt = sel && sel.options && sel.selectedIndex >= 0 ? (sel.options[sel.selectedIndex].text || '').trim() : '';
        if (txt && txt !== 'Select Ownership Type') {
            ownershipTitleInput.value = txt;
        }
    };
    if (ownershipTypeSelect) {
        ownershipTypeSelect.addEventListener('change', syncOwnershipTitle);
        // Initialize once on load if input is empty
        if (ownershipTitleInput && !ownershipTitleInput.value) {
            syncOwnershipTitle();
        }
    }

    // Auto-fill project type title when project type changes
    const projectTypeSelect = document.getElementById('projecttypeid');
    const projectTypeTitleInput = document.getElementById('projecttypetitle');
    const syncProjectTypeTitle = () => {
        if (!projectTypeSelect || !projectTypeTitleInput) return;
        const sel = projectTypeSelect;
        const txt = sel && sel.options && sel.selectedIndex >= 0 ? (sel.options[sel.selectedIndex].text || '').trim() : '';
        if (txt && txt !== 'Select Project Type') {
            projectTypeTitleInput.value = txt;
        }
    };
    if (projectTypeSelect) {
        projectTypeSelect.addEventListener('change', syncProjectTypeTitle);
        if (projectTypeTitleInput && !projectTypeTitleInput.value) {
            syncProjectTypeTitle();
        }
    }

    // Auto-fill investment type title when investment type changes
    const investOptionSelect = document.getElementById('investoptionid');
    const investOptionTitleInput = document.getElementById('investoptiontitle');
    const syncInvestOptionTitle = () => {
        if (!investOptionSelect || !investOptionTitleInput) return;
        const sel = investOptionSelect;
        const txt = sel && sel.options && sel.selectedIndex >= 0 ? (sel.options[sel.selectedIndex].text || '').trim() : '';
        if (txt && txt !== 'Select Investment Type') {
            investOptionTitleInput.value = txt;
        }
    };
    if (investOptionSelect) {
        investOptionSelect.addEventListener('change', syncInvestOptionTitle);
        if (investOptionTitleInput && !investOptionTitleInput.value) {
            syncInvestOptionTitle();
        }
    }

    // Load data when switching to inspection or investors tabs
    const inspectionTab = document.getElementById('project-inspection-tab');
    const investorsTab = document.getElementById('investors-info-tab');
    
    if (inspectionTab) {
        inspectionTab.addEventListener('shown.bs.tab', function() {
            loadInspections();
        });
        // Also load if the tab is already active on page load
        if (inspectionTab.classList.contains('active')) {
            loadInspections();
        }
    }
    
    if (investorsTab) {
        investorsTab.addEventListener('shown.bs.tab', function() {
            loadInvestors();
        });
        // Also load if the tab is already active on page load
        if (investorsTab.classList.contains('active')) {
            loadInvestors();
        }
    }

    // Documents and images are now handled by modals - no inline form handlers needed
});

function initializeValidation() {
    document.querySelectorAll('form').forEach(function(form) {
        form.classList.add('needs-validation');
        form.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.classList.add('was-validated');
        });
    });
}

function switchTab(tabId) {
    // Remove 'active' from all tab buttons and panes
    document.querySelectorAll('#projectTabs .nav-link').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

    // Add 'active' to the selected tab button and pane
    const tabButton = document.getElementById(tabId + '-tab');
    const tabPane = document.getElementById(tabId);
    if (tabButton) tabButton.classList.add('active');
    if (tabPane) {
        tabPane.classList.add('show', 'active');
    }
}

function enableNextTab(currentTab, nextTab) {
    const nextTabButton = document.getElementById(nextTab + '-tab');
    if (nextTabButton) {
        nextTabButton.classList.remove('disabled');
    }
}

document.getElementById('saveProjectInfo').addEventListener('click', function() {
    const form = document.getElementById('projectInfoForm');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const formData = new FormData(form);
    const itemId = document.getElementById('itemid').value;
    
    console.log('Updating project:', {
        itemid: itemId,
        title: formData.get('title'),
        description: formData.get('description'),
        allFormData: Array.from(formData.entries())
    });

    fetch('/investments/projects/update-info', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            toastr.success(response.message || 'Project updated successfully!');
            // Move to next tab instead of redirecting
            switchTab('project-documents');
        } else {
            toastr.error(response.message || 'Failed to update project information');
        }
    })
    .catch(error => {
        console.error('Error updating project:', error);
        toastr.error('An error occurred while updating project information');
    });
});

function loadProfileOptions() {
    // Prefer itemtypeid from the Project Information tab; fallback to currentItemId
    const itemTypeSelect = document.getElementById('itemtypeid');
    const itemTypeId = itemTypeSelect ? itemTypeSelect.value : '';
    const query = itemTypeId ? ('itemtypeid=' + encodeURIComponent(itemTypeId)) : (currentItemId ? ('itemid=' + encodeURIComponent(currentItemId)) : '');
    if (!query) return;

    fetch('/investments/profile-options?' + query)
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            renderProfileFields(response.profileOptions);
        }
    })
    .catch(() => toastr.error('Failed to load profile options'));
}

function renderProfileFields(profileOptions) {
    const container = document.getElementById('profileFieldsContainer');
    container.innerHTML = '';

    if (profileOptions && profileOptions.length > 0) {
        profileOptions.forEach(option => {
            const fieldHtml = `
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label class="form-label fw-bold">${option.title}</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="profile_${option.itemprofileoptionid}" placeholder="Enter value">
                        <input type="hidden" name="profileoptionid[]" value="${option.itemprofileoptionid}">
                    </div>
                </div>
            `;
            container.innerHTML += fieldHtml;
        });
    } else {
        container.innerHTML = '<div class="text-center py-4"><p class="text-muted">No profile options available for this project type.</p></div>';
    }
}

const saveProfileBtn = document.getElementById('saveProjectProfile');
if (saveProfileBtn) {
    saveProfileBtn.addEventListener('click', function() {
        enableNextTab('project-profile', 'project-documents');
        switchTab('project-documents');
        toastr.success('Project profile saved successfully!');
    });
}

// Documents and Images tabs now handled by modals

// ==================== INSPECTION RECORDS ====================

function loadInspections() {
    if (!currentItemId) return;
    
    fetch(`/investments/projects/${currentItemId}/inspections`)
        .then(r => r.json())
        .then(response => {
            const tbody = document.getElementById('inspectionsTableBody');
            if (response.success && response.inspections && response.inspections.length > 0) {
                tbody.innerHTML = response.inspections.map(inspection => `
                    <tr>
                        <td>${inspection.inspectiondate || 'N/A'}</td>
                        <td>${inspection.inspectorname || 'N/A'}</td>
                        <td>${inspection.tasktitle || 'N/A'}</td>
                        <td><span class="badge bg-${inspection.status === '1' ? 'success' : 'warning'}">${inspection.statustext || 'Pending'}</span></td>
                        <td>${inspection.comments || '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="viewInspection(${inspection.inspectionid})">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No inspection records found</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error loading inspections:', error);
            document.getElementById('inspectionsTableBody').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading inspections</td></tr>';
        });
}

function viewInspection(inspectionId) {
    // View inspection details (to be implemented)
    window.location.href = `/inspections/view?id=${inspectionId}`;
}

// ==================== INVESTORS INFORMATION ====================

function loadInvestors() {
    if (!currentItemId) return;
    
    fetch(`/investments/projects/${currentItemId}/investors`)
        .then(r => r.json())
        .then(response => {
            const tbody = document.getElementById('investorsTableBody');
            if (response.success && response.investors && response.investors.length > 0) {
                tbody.innerHTML = response.investors.map(investor => `
                    <tr>
                        <td>${investor.biddate || 'N/A'}</td>
                        <td>${investor.investorname || 'N/A'}</td>
                        <td>${investor.bidamount ? '$' + parseFloat(investor.bidamount).toLocaleString() : 'N/A'}</td>
                        <td><span class="badge bg-${investor.bidstatus === '1' ? 'success' : 'warning'}">${investor.statustext || 'Pending'}</span></td>
                        <td>${investor.comments || '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="viewBid(${investor.bidid})">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No investor bids found</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error loading investors:', error);
            document.getElementById('investorsTableBody').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading investor information</td></tr>';
        });
}

function viewBid(bidId) {
    // View bid details (to be implemented)
    window.location.href = `/offers/view?id=${bidId}`;
}

// ==================== DOCUMENT MANAGEMENT ====================

function openDocumentModal(docId = null) {
    editingDocumentId = docId;
    const modal = document.getElementById('documentModal');
    const modalTitle = modal.querySelector('.modal-title');
    const form = document.getElementById('documentForm');
    
    form.reset();
    form.classList.remove('was-validated');
    
    if (docId) {
        modalTitle.textContent = 'Edit Document';
        // Load document data via AJAX
        fetch(`/investments/projects/documents/${docId}`)
            .then(r => r.json())
            .then(response => {
                console.log('Document data response:', response);
                if (response.success && response.document) {
                    const doc = response.document;
                    console.log('Setting document values:', doc);
                    document.getElementById('doc_itemdoctypeid').value = doc.itemdoctypeid || '';
                    document.getElementById('doc_docstatus').value = doc.docstatus || '1';
                    // File input cannot be pre-filled for security reasons
                    // Make file input optional for editing
                    document.getElementById('doc_docurl').removeAttribute('required');
                } else {
                    toastr.error(response.message || 'Failed to load document data');
                }
            })
            .catch(error => {
                console.error('Error loading document:', error);
                toastr.error('An error occurred while loading document');
            });
    } else {
        modalTitle.textContent = 'Add New Document';
        // Make file input required for new documents
        document.getElementById('doc_docurl').setAttribute('required', 'required');
    }
}

function saveDocument() {
    const form = document.getElementById('documentForm');

    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const formData = new FormData(form);
    const itemId = document.getElementById('itemid').value;
    formData.append('itemid', itemId);

    const url = editingDocumentId
        ? `/investments/projects/documents/${editingDocumentId}/update`
        : '/investments/projects/documents/store';

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json().then(data => ({ok: r.ok, status: r.status, data})))
    .then(({ok, status, data}) => {
        console.log('Save document response:', data);
        if (ok && data.success) {
            toastr.success(data.message || 'Document saved successfully!');
            bootstrap.Modal.getInstance(document.getElementById('documentModal')).hide();
            // Reload documents table
            loadDocuments();
        } else {
            console.error('Save failed:', data);
            toastr.error(data.message || 'Failed to save document');
        }
    })
    .catch(error => {
        console.error('Error saving document:', error);
        toastr.error('An error occurred while saving document');
    });
}

function editDocument(docId) {
    editingDocumentId = docId;
    const modal = new bootstrap.Modal(document.getElementById('documentModal'));
    modal.show();
    openDocumentModal(docId);
}

function deleteDocument(docId) {
    if (!docId) {
        toastr.error('Document ID is required');
        return;
    }

    Swal.fire({
        title: 'Delete Document?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Deleting document ID:', docId);
            fetch(`/investments/projects/documents/${docId}/delete`, {
                method: 'POST',
                body: JSON.stringify({ _method: 'DELETE' })
            })
            .then(r => r.json().then(data => ({ok: r.ok, status: r.status, data})))
            .then(({ok, status, data}) => {
                console.log('Delete response:', data);
                if (ok && data.success) {
                    toastr.success(data.message || 'Document deleted successfully!');
                    loadDocuments();
                } else {
                    console.error('Delete failed:', data);
                    toastr.error(data.message || 'Failed to delete document');
                }
            })
            .catch(error => {
                console.error('Error deleting document:', error);
                toastr.error('An error occurred while deleting document');
            });
        }
    });
}

function loadDocuments() {
    const itemId = document.getElementById('itemid').value;
    fetch(`/investments/projects/${itemId}/documents`, {
        method: 'GET',
    })
        .then(r => {
            if (!r.ok) {
                throw new Error(`HTTP error! status: ${r.status}`);
            }
            return r.json();
        })
        .then(response => {
            if (response.success) {
                const tbody = document.getElementById('documentsTableBody');
                tbody.innerHTML = '';

                if (response.documents && response.documents.length > 0) {
                    response.documents.forEach(doc => {
                        const row = document.createElement('tr');
                        row.setAttribute('data-docid', doc.itemdocid);
                        row.innerHTML = `
                            <td>${doc.itemDocTypeTitle || 'Document'}</td>
                            <td>
                                ${doc.docurl ? `<a href="/documents/${doc.docurl}" target="_blank"><i class="fas fa-file-alt me-1"></i>${doc.docurl.split('/').pop()}</a>` : '<span class="text-muted">No file</span>'}
                            </td>
                            <td>
                                <span class="badge ${doc.docstatus ? 'bg-success' : 'bg-secondary'}">
                                    ${doc.docstatus ? 'Visible' : 'Hidden'}
                                </span>
                            </td>
                            <td>${doc.entrydate ? new Date(doc.entrydate).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A'}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="editDocument(${doc.itemdocid})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteDocument(${doc.itemdocid})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                } else {
                    tbody.innerHTML = '<tr id="noDocumentsRow"><td colspan="5" class="text-center text-muted">No documents added yet</td></tr>';
                }
            }
        })
        .catch(error => console.error('Error loading documents:', error));
}
</script>

<!-- Document Modal -->
<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentModalLabel">Add New Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm">
                    <div class="form-group mb-3">
                        <label for="doc_itemdoctypeid" class="form-label fw-bold">Document Type *</label>
                        <select class="form-select" id="doc_itemdoctypeid" name="itemdoctypeid" required>
                            <option value="">Select Document Type</option>
                            <?php foreach (($itemDocTypes ?? []) as $type): ?>
                                <option value="<?php echo htmlspecialchars($type['itemdoctypeid'] ?? '', ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($type['title'] ?? '', ENT_QUOTES); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="doc_docstatus" class="form-label fw-bold">Visible to Users</label>
                        <select class="form-select" id="doc_docstatus" name="docstatus">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="doc_docurl" class="form-label fw-bold">Document File *</label>
                        <input type="file" class="form-control" id="doc_docurl" name="docurl" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" required>
                        <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, XLS, XLSX, TXT (Max: 20MB)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveDocument()">Save Document</button>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Add Project Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="imageForm">
                    <div class="form-group mb-3">
                        <label for="img_pictitle" class="form-label fw-bold">Image Title</label>
                        <input type="text" class="form-control" id="img_pictitle" name="pictitle" placeholder="Enter image title">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="img_picstatus" class="form-label fw-bold">Visible to Users</label>
                        <select class="form-select" id="img_picstatus" name="picstatus">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="img_picurl" class="form-label fw-bold">Image File *</label>
                        <input type="file" class="form-control" id="img_picurl" name="picurl" accept=".jpg,.jpeg,.png,.gif" required>
                        <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG, GIF (Max: 5MB)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveImage()">Save Image</button>
            </div>
        </div>
    </div>
</div>

<script>
// ==================== IMAGE MANAGEMENT ====================

function openImageModal(picId = null) {
    editingImageId = picId;
    const modal = document.getElementById('imageModal');
    const modalTitle = modal.querySelector('.modal-title');
    const form = document.getElementById('imageForm');
    
    form.reset();
    form.classList.remove('was-validated');
    
    if (picId) {
        modalTitle.textContent = 'Edit Image';
        // Load image data via AJAX
        fetch(`/investments/projects/images/${picId}`)
            .then(r => r.json())
            .then(response => {
                if (response.success) {
                    const img = response.image;
                    document.getElementById('img_pictitle').value = img.pictitle || '';
                    document.getElementById('img_picstatus').value = img.picstatus || '1';
                }
            })
            .catch(error => console.error('Error loading image:', error));
    } else {
        modalTitle.textContent = 'Add Project Image';
    }
}

function saveImage() {
    const form = document.getElementById('imageForm');

    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const formData = new FormData(form);
    const itemId = document.getElementById('itemid').value;
    formData.append('itemid', itemId);

    const url = editingImageId
        ? `/investments/projects/images/${editingImageId}/update`
        : '/investments/projects/images/store';

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(r => {
        if (!r.ok) {
            throw new Error(`HTTP error! status: ${r.status}`);
        }
        return r.json();
    })
    .then(response => {
        if (response.success) {
            toastr.success(response.message || 'Image saved successfully!');
            bootstrap.Modal.getInstance(document.getElementById('imageModal')).hide();
            // Reload images gallery
            loadImages();
        } else {
            toastr.error(response.message || 'Failed to save image');
        }
    })
    .catch(error => {
        console.error('Error saving image:', error);
        toastr.error('An error occurred while saving image');
    });
}

function editImage(picId) {
    editingImageId = picId;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
    openImageModal(picId);
}

function deleteImage(picId) {
    Swal.fire({
        title: 'Delete Image?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const itemId = document.getElementById('itemid').value;
            fetch(`/investments/projects/images/${picId}/delete`, {
                method: 'POST',
                body: JSON.stringify({
                    itemid: itemId,
                    _method: 'DELETE'
                })
            })
            .then(r => {
                if (!r.ok) {
                    throw new Error(`HTTP error! status: ${r.status}`);
                }
                return r.json();
            })
            .then(response => {
                if (response.success) {
                    toastr.success(response.message || 'Image deleted successfully!');
                    loadImages();
                } else {
                    toastr.error(response.message || 'Failed to delete image');
                }
            })
            .catch(error => {
                console.error('Error deleting image:', error);
                toastr.error('An error occurred while deleting image');
            });
        }
    });
}

function loadImages() {
    const itemId = document.getElementById('itemid').value;
    fetch(`/investments/projects/${itemId}/images`, {
        method: 'GET',
    })
        .then(r => {
            if (!r.ok) {
                throw new Error(`HTTP error! status: ${r.status}`);
            }
            return r.json();
        })
        .then(response => {
            if (response.success) {
                const gallery = document.getElementById('imagesGallery');
                gallery.innerHTML = '';

                if (response.images && response.images.length > 0) {
                    response.images.forEach(img => {
                        const col = document.createElement('div');
                        col.className = 'col-md-4 mb-3';
                        col.setAttribute('data-picid', img.itempicid);
                        col.innerHTML = `
                            <div class="card">
                                ${img.picurl ? `<img src="/${img.picurl}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Project Image">` : ''}
                                <div class="card-body">
                                    <h6 class="card-title">${img.pictitle || 'Image'}</h6>
                                    <span class="badge ${img.picstatus ? 'bg-success' : 'bg-secondary'} mb-2">
                                        ${img.picstatus ? 'Visible' : 'Hidden'}
                                    </span>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editImage(${img.itempicid})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteImage(${img.itempicid})">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        gallery.appendChild(col);
                    });
                } else {
                    gallery.innerHTML = '<div class="col-12" id="noImagesMessage"><div class="alert alert-info text-center">No images added yet</div></div>';
                }
            }
        })
        .catch(error => console.error('Error loading images:', error));
}
</script>

