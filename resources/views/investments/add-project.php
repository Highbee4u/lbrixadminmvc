<?php $pageTitle = isset($project) ? 'Edit Project' : 'Add New Project'; ?>


<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6><?php echo isset($project) ? 'Edit Investment Project' : 'Add New Investment Project'; ?></h6>
                        <a href="/investments/new-projects" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Projects
                        </a>
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
                        <!-- Project Profile tab removed -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo isset($project) ? '' : 'disabled'; ?>" id="project-documents-tab" data-bs-toggle="pill" data-bs-target="#project-documents" type="button" role="tab" aria-controls="project-documents" aria-selected="false">
                                <i class="fas fa-file-alt me-2"></i>Project Documents
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo isset($project) ? '' : 'disabled'; ?>" id="project-images-tab" data-bs-toggle="pill" data-bs-target="#project-images" type="button" role="tab" aria-controls="project-images" aria-selected="false">
                                <i class="fas fa-images me-2"></i>Project Images
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo isset($project) ? '' : 'disabled'; ?>" id="project-layout-tab" data-bs-toggle="pill" data-bs-target="#project-layout" type="button" role="tab" aria-controls="project-layout" aria-selected="false">
                                <i class="fas fa-building me-2"></i>Project Layout
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="projectTabsContent">
                        <!-- Project Information Tab -->
                        <div class="tab-pane fade show active" id="project-info" role="tabpanel" aria-labelledby="project-info-tab">
                            <form id="projectInfoForm">
                                <input type="hidden" name="servicetypeid" value="4">
                                <input type="hidden" name="inspectiontaskid" value="">
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
                            <form id="projectDocumentsForm">
                                <input type="hidden" id="documents_itemid" name="itemid" value="<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">

                                <?php if (isset($project) && !empty($project['itemDocs'])): ?>
                                    <div class="mb-4">
                                        <h6 class="text-muted">Existing Documents</h6>
                                        <?php foreach ($project['itemDocs'] as $doc): ?>
                                            <div class="card mb-2">
                                                <div class="card-body py-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <strong><?php echo htmlspecialchars($doc['itemDocTypeTitle'] ?? 'Document', ENT_QUOTES); ?></strong>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span class="badge <?php echo !empty($doc['docstatus']) ? 'bg-success' : 'bg-secondary'; ?>">
                                                                <?php echo !empty($doc['docstatus']) ? 'Visible' : 'Hidden'; ?>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3 text-end">
                                                            <?php if (!empty($doc['docurl'])): ?>
                                                                <a href="/storage/<?php echo htmlspecialchars($doc['docurl'], ENT_QUOTES); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="itemdoctypeid" class="form-label fw-bold">Document Type *</label>
                                            <select class="form-select" id="itemdoctypeid" name="itemdoctypeid" required>
                                                <option value="">Select Document Type</option>
                                                <?php foreach (($itemDocTypes ?? []) as $type): ?>
                                                    <option value="<?php echo htmlspecialchars($type['itemdoctypeid'] ?? '', ENT_QUOTES); ?>">
                                                        <?php echo htmlspecialchars($type['title'] ?? '', ENT_QUOTES); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="docstatus" class="form-label fw-bold">Visible to Users</label>
                                            <select class="form-select" id="docstatus" name="docstatus">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="docurl" class="form-label fw-bold">Document File *</label>
                                            <input type="file" class="form-control" id="docurl" name="docurl" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 400KB)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="switchTab('project-info')">
                                        <i class="fas fa-arrow-left me-2"></i>Previous
                                    </button>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary me-2" id="addAnotherDocument">
                                            <i class="fas fa-plus me-2"></i>Add Another
                                        </button>
                                        <button type="button" class="btn btn-primary" id="saveProjectDocument">
                                            <i class="fas fa-save me-2"></i>Save & Continue
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Project Images Tab -->
                        <div class="tab-pane fade" id="project-images" role="tabpanel" aria-labelledby="project-images-tab">
                            <form id="projectImagesForm">
                                <input type="hidden" id="images_itemid" name="itemid" value="<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">

                                <?php if (isset($project) && !empty($project['itemPics'])): ?>
                                    <div class="mb-4">
                                        <h6 class="text-muted">Existing Images</h6>
                                        <div class="row">
                                            <?php foreach ($project['itemPics'] as $pic): ?>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <div class="card-body text-center">
                                                            <?php if (!empty($pic['picurl'])): ?>
                                                                <img src="<?php echo htmlspecialchars(Helpers::imageUrl($pic['picurl']), ENT_QUOTES); ?>" class="img-fluid mb-2" style="max-height: 150px;" alt="Project Image">
                                                            <?php endif; ?>
                                                            <h6 class="card-title"><?php echo htmlspecialchars($pic['pictitle'] ?? 'Image', ENT_QUOTES); ?></h6>
                                                            <span class="badge <?php echo !empty($pic['picstatus']) ? 'bg-success' : 'bg-secondary'; ?>">
                                                                <?php echo !empty($pic['picstatus']) ? 'Visible' : 'Hidden'; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="pictitle" class="form-label fw-bold">Image Title</label>
                                            <input type="text" class="form-control" id="pictitle" name="pictitle">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="picstatus" class="form-label fw-bold">Visible to Users</label>
                                            <select class="form-select" id="picstatus" name="picstatus">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="picurl" class="form-label fw-bold">Image File *</label>
                                            <input type="file" class="form-control" id="picurl" name="picurl" accept=".jpg,.jpeg,.png" required>
                                            <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG (Max: 400KB)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="switchTab('project-documents')">
                                        <i class="fas fa-arrow-left me-2"></i>Previous
                                    </button>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary me-2" id="addAnotherImage">
                                            <i class="fas fa-plus me-2"></i>Add Another
                                        </button>
                                        <button type="button" class="btn btn-primary" id="saveProjectImage">
                                            <i class="fas fa-save me-2"></i>Save & Continue
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Project Layout Tab -->
                        <div class="tab-pane fade" id="project-layout" role="tabpanel" aria-labelledby="project-layout-tab">
                            <form id="projectLayoutForm">
                                <input type="hidden" id="layout_itemid" name="itemid" value="<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">

                                <?php if (isset($project) && !empty($project['subItems'])): ?>
                                    <div class="mb-4">
                                        <h6 class="text-muted">Existing Layout</h6>
                                        <?php foreach ($project['subItems'] as $layout): ?>
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h6 class="mb-0"><?php echo htmlspecialchars($layout['floortitle'] ?? 'Floor', ENT_QUOTES); ?></h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <strong>Rooms/Offices:</strong> <?php echo htmlspecialchars($layout['roomcount'] ?? 0, ENT_QUOTES); ?>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <strong>Labels:</strong> <?php echo htmlspecialchars($layout['roomlabels'] ?? 'N/A', ENT_QUOTES); ?>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <strong>Sizes:</strong> <?php echo htmlspecialchars($layout['roomsizes'] ?? 'N/A', ENT_QUOTES); ?>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <strong>Prices:</strong> <?php echo htmlspecialchars($layout['roomprices'] ?? 'N/A', ENT_QUOTES); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="floortitle" class="form-label fw-bold">Floor Title *</label>
                                            <input type="text" class="form-control" id="floortitle" name="floortitle" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="roomcount" class="form-label fw-bold">Number of Rooms/Offices *</label>
                                            <input type="number" class="form-control" id="roomcount" name="roomcount" min="1" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="roomlabels" class="form-label fw-bold">Room/Office Labels</label>
                                            <textarea class="form-control" id="roomlabels" name="roomlabels" rows="3" placeholder="Enter room/office labels separated by commas"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="roomsizes" class="form-label fw-bold">Room/Office Sizes</label>
                                            <textarea class="form-control" id="roomsizes" name="roomsizes" rows="3" placeholder="Enter room/office sizes separated by commas"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="roomprices" class="form-label fw-bold">Room/Office Prices</label>
                                            <textarea class="form-control" id="roomprices" name="roomprices" rows="3" placeholder="Enter room/office prices separated by commas"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="switchTab('project-images')">
                                        <i class="fas fa-arrow-left me-2"></i>Previous
                                    </button>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary me-2" id="addAnotherFloor">
                                            <i class="fas fa-plus me-2"></i>Add Another Floor
                                        </button>
                                        <button type="button" class="btn btn-success" id="completeProject">
                                            <i class="fas fa-check me-2"></i>Complete Project
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<script>


let currentItemId = null;

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

    // Safe event binding for document tab buttons
    var saveDocBtn = document.getElementById('saveProjectDocument');
    var addAnotherDocBtn = document.getElementById('addAnotherDocument');
    if (saveDocBtn) {
        saveDocBtn.addEventListener('click', function() {
            const form = document.getElementById('projectDocumentsForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }
            // Ensure itemid is set before submitting
            if (!form.itemid.value && currentItemId) {
                form.itemid.value = currentItemId;
            }
            const formData = new FormData(form);
            fetch('/investments/projects/docs', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(response => {
                if (response.success) {
                    enableNextTab('project-documents', 'project-images');
                    switchTab('project-images');
                    alert('Document uploaded successfully!');
                } else {
                    alert(response.message || 'Failed to upload document');
                }
            })
            .catch(() => alert('An error occurred while uploading document'));
        });
    }
    if (addAnotherDocBtn) {
        addAnotherDocBtn.addEventListener('click', function() {
            const form = document.getElementById('projectDocumentsForm');
            form.reset();
            form.classList.remove('was-validated');
            // Ensure itemid is preserved after reset
            if (currentItemId) {
                form.itemid.value = currentItemId;
            }
        });
    }
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
    
    console.log('Creating new project:', {
        title: formData.get('title'),
        description: formData.get('description')
    });

    fetch('/investments/projects/store', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            currentItemId = response.itemid;
            // Set itemid for all subsequent forms
            if (document.getElementById('documents_itemid')) {
                document.getElementById('documents_itemid').value = currentItemId;
            }
            if (document.getElementById('images_itemid')) {
                document.getElementById('images_itemid').value = currentItemId;
            }
            if (document.getElementById('layout_itemid')) {
                document.getElementById('layout_itemid').value = currentItemId;
            }

            enableNextTab('project-info', 'project-documents');
            switchTab('project-documents');
            toastr.success(response.message || 'Project created successfully!');
        } else {
            toastr.error(response.message || 'Failed to save project information');
        }
    })
    .catch(error => {
        console.error('Error saving project:', error);
        toastr.error('An error occurred while saving project information');
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
    .catch(() => alert('Failed to load profile options'));
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

document.getElementById('saveProjectProfile').addEventListener('click', function() {
    enableNextTab('project-profile', 'project-documents');
    switchTab('project-documents');
    alert('Project profile saved successfully!');
});

document.getElementById('saveProjectDocument').addEventListener('click', function() {
    const form = document.getElementById('projectDocumentsForm');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // Ensure itemid is set before submitting
    if (!form.itemid.value && currentItemId) {
        form.itemid.value = currentItemId;
    }

    const formData = new FormData(form);

    fetch('/investments/projects/docs', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            enableNextTab('project-documents', 'project-images');
            switchTab('project-images');
            alert('Document uploaded successfully!');
        } else {
            alert(response.message || 'Failed to upload document');
        }
    })
    .catch(() => alert('An error occurred while uploading document'));
});

document.getElementById('addAnotherDocument').addEventListener('click', function() {
    const form = document.getElementById('projectDocumentsForm');
    form.reset();
    form.classList.remove('was-validated');
    // Ensure itemid is preserved after reset
    if (currentItemId) {
        form.itemid.value = currentItemId;
    }
});

document.getElementById('saveProjectImage').addEventListener('click', function() {
    const form = document.getElementById('projectImagesForm');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // Ensure itemid is set before submitting
    if (!form.itemid.value && currentItemId) {
        form.itemid.value = currentItemId;
    }

    const formData = new FormData(form);

    fetch('/investments/projects/pics', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            enableNextTab('project-images', 'project-layout');
            switchTab('project-layout');
            alert('Image uploaded successfully!');
        } else {
            alert(response.message || 'Failed to upload image');
        }
    })
    .catch(() => alert('An error occurred while uploading image'));
});

document.getElementById('addAnotherImage').addEventListener('click', function() {
    const form = document.getElementById('projectImagesForm');
    form.reset();
    form.classList.remove('was-validated');
    // Ensure itemid is preserved after reset
    if (currentItemId) {
        form.itemid.value = currentItemId;
    }
});

document.getElementById('completeProject').addEventListener('click', function() {
    const form = document.getElementById('projectLayoutForm');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // Ensure itemid is set before submitting
    if (!form.itemid.value && currentItemId) {
        form.itemid.value = currentItemId;
    }

    const formData = new FormData(form);

    fetch('/investments/projects/layout', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            alert('Project completed successfully!');
            setTimeout(() => {
                window.location.href = '/investments/new-projects';
            }, 2000);
        } else {
            alert(response.message || 'Failed to complete project');
        }
    })
    .catch(() => alert('An error occurred while completing project'));
});

document.getElementById('addAnotherFloor').addEventListener('click', function() {
    const form = document.getElementById('projectLayoutForm');
    form.reset();
    form.classList.remove('was-validated');
    // Ensure itemid is preserved after reset
    if (currentItemId) {
        form.itemid.value = currentItemId;
    }
});
</script>
