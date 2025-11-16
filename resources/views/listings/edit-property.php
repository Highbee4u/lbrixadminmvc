<?php $pageTitle = 'Edit Pending Property'; ?>

<?php $backUrl = $_SERVER['HTTP_REFERER'] ?? '/listings/new-properties'; ?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Edit Property: <?php echo htmlspecialchars($item['title'] ?? ''); ?></h6>
          <a href="<?php echo htmlspecialchars($backUrl); ?>" class="btn btn-sm btn-primary" onclick="event.preventDefault(); if (document.referrer) { history.back(); } else { window.location.href='<?php echo htmlspecialchars($backUrl); ?>'; }">Back</a>
        </div>
        <div class="card-body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" id="editPropertyTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="edit-item-info-tab" data-bs-toggle="tab" data-bs-target="#edit-item-info" type="button" role="tab" aria-controls="edit-item-info" aria-selected="true">
                <i class="fas fa-info-circle me-2"></i>Item Information
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="edit-item-profile-tab" data-bs-toggle="tab" data-bs-target="#edit-item-profile" type="button" role="tab" aria-controls="edit-item-profile" aria-selected="false">
                <i class="fas fa-list me-2"></i>Item Profile
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="edit-item-docs-tab" data-bs-toggle="tab" data-bs-target="#edit-item-docs" type="button" role="tab" aria-controls="edit-item-docs" aria-selected="false">
                <i class="fas fa-file-alt me-2"></i>Item Documents
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="edit-item-pics-tab" data-bs-toggle="tab" data-bs-target="#edit-item-pics" type="button" role="tab" aria-controls="edit-item-pics" aria-selected="false">
                <i class="fas fa-images me-2"></i>Item Pictures
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="edit-property-layout-tab" data-bs-toggle="tab" data-bs-target="#edit-property-layout" type="button" role="tab" aria-controls="edit-property-layout" aria-selected="false">
                <i class="fas fa-building me-2"></i>Property Layout
              </button>
            </li>
          </ul>

          <!-- Tab content -->
          <div class="tab-content mt-4" id="editPropertyTabsContent">
            <!-- Item Information Tab -->
            <div class="tab-pane fade show active" id="edit-item-info" role="tabpanel" aria-labelledby="edit-item-info-tab">
              <form id="editItemInfoForm">
                <input type="hidden" id="edit_itemid" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_title" class="form-label">Title *</label>
                      <input type="text" class="form-control" id="edit_title" name="title" value="<?php echo htmlspecialchars($item['title'] ?? ''); ?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_itemtypeid" class="form-label">Property Type *</label>
                      <select class="form-select" id="edit_itemtypeid" name="itemtypeid" required>
                        <option value="">Select Property Type</option>
                        <?php foreach(($itemTypes ?? []) as $type): ?>
                          <option value="<?php echo htmlspecialchars($type['itemtypeid']); ?>" <?php echo (($item['itemtypeid'] ?? '') == $type['itemtypeid']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($type['title']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_description" class="form-label">Description</label>
                      <textarea class="form-control" id="edit_description" name="description" rows="3"><?php echo htmlspecialchars($item['description'] ?? ''); ?></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_address" class="form-label">Address *</label>
                      <textarea class="form-control" id="edit_address" name="address" rows="3" required><?php echo htmlspecialchars($item['address'] ?? ''); ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_inspectionstatusid" class="form-label">Inspection Status</label>
                      <select class="form-select" id="edit_inspectionstatusid" name="inspectionstatusid">
                        <option value="">Select Status</option>
                        <?php foreach(($inspectionStatuses ?? []) as $status): ?>
                          <option value="<?php echo htmlspecialchars($status['inspectionstatusid']); ?>" <?php echo (($item['inspectionstatusid'] ?? '') == $status['inspectionstatusid']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($status['title']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_ownershiptypeid" class="form-label">Ownership Type</label>
                      <select class="form-select" id="edit_ownershiptypeid" name="ownershiptypeid">
                        <option value="">Select Ownership Type</option>
                        <?php foreach(($ownershipTypes ?? []) as $type): ?>
                          <option value="<?php echo htmlspecialchars($type['ownershiptypeid']); ?>" <?php echo (($item['ownershiptypeid'] ?? '') == $type['ownershiptypeid']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($type['title']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_ownershiptypetitle" class="form-label">Ownership Title</label>
                      <input type="text" class="form-control" id="edit_ownershiptypetitle" name="ownershiptypetitle" value="<?php echo htmlspecialchars($item['ownershiptypetitle'] ?? ''); ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_price" class="form-label">Price</label>
                      <input type="number" class="form-control" id="edit_price" name="price" step="0.01" value="<?php echo htmlspecialchars($item['price'] ?? ''); ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_priceunit" class="form-label">Price Unit</label>
                      <input type="text" class="form-control" id="edit_priceunit" name="priceunit" value="<?php echo htmlspecialchars($item['priceunit'] ?? ''); ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_sellerid" class="form-label">Seller</label>
                      <select class="form-select" id="edit_sellerid" name="sellerid">
                        <option value="">Select Seller</option>
                        <?php foreach(($users ?? []) as $user): ?>
                          <option value="<?php echo htmlspecialchars($user['userid']); ?>" <?php echo (($item['sellerid'] ?? '') == $user['userid']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars(trim(($user['surname'] ?? '') . ' ' . ($user['firstname'] ?? '') . ' ' . ($user['middlename'] ?? ''))); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_attorneyid" class="form-label">Attorney</label>
                      <select class="form-select" id="edit_attorneyid" name="attorneyid">
                        <option value="">Select Attorney</option>
                        <?php foreach(($attorneys ?? []) as $att): ?>
                          <option value="<?php echo htmlspecialchars($att['userid']); ?>" <?php echo (($item['attorneyid'] ?? '') == $att['userid']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars(trim(($att['surname'] ?? '') . ' ' . ($att['firstname'] ?? '') . ' ' . ($att['middlename'] ?? ''))); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="edit_itemstatusid" class="form-label">Item Status</label>
                      <select class="form-select" id="edit_itemstatusid" name="itemstatusid">
                        <option value="">Select Status</option>
                        <?php foreach(($itemStatuses ?? []) as $st): ?>
                          <option value="<?php echo htmlspecialchars($st['itemstatusid']); ?>" <?php echo (($item['itemstatusid'] ?? '') == $st['itemstatusid']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($st['title']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">Update Information</button>
                </div>
              </form>
            </div>

            <!-- Item Profile Tab -->
            <div class="tab-pane fade" id="edit-item-profile" role="tabpanel" aria-labelledby="edit-item-profile-tab">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6>Item Profiles</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                  <i class="fas fa-plus me-2"></i>Add Profile Option
                </button>
              </div>
              <div class="card">
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-hover">
                      <thead>
                        <tr>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 80px;">Action</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Profile Option</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Value</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Base Value</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Show User</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Entry Date</th>
                        </tr>
                      </thead>
                      <tbody id="profileTableBody">
                        <?php if (!empty($itemProfiles)): 
                          $activeProfiles = array_filter($itemProfiles, function($profile) {
                            return !isset($profile['isdeleted']) || $profile['isdeleted'] != -1;
                          });
                          if (!empty($activeProfiles)): 
                            foreach ($activeProfiles as $profile): ?>
                          <tr>
                            <td class="align-middle text-center">
                              <div class="btn-group" role="group">
                                <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="profileActionDropdown<?php echo htmlspecialchars($profile['itemprofileid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileActionDropdown<?php echo htmlspecialchars($profile['itemprofileid'] ?? '', ENT_QUOTES); ?>">
                                  <li>
                                    <a class="dropdown-item edit-profile" href="javascript:;"
                                       data-id="<?php echo htmlspecialchars($profile['itemprofileid'] ?? '', ENT_QUOTES); ?>"
                                       data-profileoptionid="<?php echo htmlspecialchars($profile['profileoptionid'] ?? '', ENT_QUOTES); ?>"
                                       data-profilevalue="<?php echo htmlspecialchars($profile['profilevalue'] ?? '', ENT_QUOTES); ?>"
                                       data-basevalue="<?php echo htmlspecialchars($profile['basevalue'] ?? '', ENT_QUOTES); ?>"
                                       data-showuser="<?php echo htmlspecialchars($profile['showuser'] ?? '0', ENT_QUOTES); ?>">
                                      <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                  </li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li>
                                    <a class="dropdown-item delete-profile text-danger" href="javascript:;"
                                       data-id="<?php echo htmlspecialchars($profile['itemprofileid'] ?? '', ENT_QUOTES); ?>">
                                      <i class="fas fa-trash me-2"></i>Delete
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($profile['profileoptiontitle'] ?? 'N/A'); ?></span></td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($profile['profilevalue'] ?? ''); ?></span></td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($profile['basevalue'] ?? '0'); ?></span></td>
                            <td class="align-middle"><span class="badge badge-sm <?php echo !empty($profile['showuser']) ? 'bg-success' : 'bg-secondary'; ?>"><?php echo !empty($profile['showuser']) ? 'Yes' : 'No'; ?></span></td>
                            <td class="align-middle text-nowrap"><span class="text-secondary text-xs font-weight-bold"><?php echo !empty($profile['entrydate']) ? date('d/m/y', strtotime($profile['entrydate'])) : 'N/A'; ?></span></td>
                          </tr>
                        <?php endforeach; else: ?>
                          <tr><td colspan="6" class="text-center py-4"><p class="text-sm text-secondary mb-0">No profiles found</p></td></tr>
                        <?php endif; else: ?>
                          <tr><td colspan="6" class="text-center py-4"><p class="text-sm text-secondary mb-0">No profiles found</p></td></tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item Documents Tab -->
            <div class="tab-pane fade" id="edit-item-docs" role="tabpanel" aria-labelledby="edit-item-docs-tab">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6>Item Documents</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDocModal">
                  <i class="fas fa-plus me-2"></i>Add Document
                </button>
              </div>
              <div class="card">
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-hover">
                      <thead>
                        <tr>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 80px;">Action</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Document Type</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Entry Date</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Document</th>
                        </tr>
                      </thead>
                      <tbody id="docTableBody">
                        <?php if (!empty($itemDocs)): foreach ($itemDocs as $doc): ?>
                          <tr>
                            <td class="align-middle text-center">
                              <div class="btn-group" role="group">
                                <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="docActionDropdown<?php echo htmlspecialchars($doc['itemdocid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="docActionDropdown<?php echo htmlspecialchars($doc['itemdocid'] ?? '', ENT_QUOTES); ?>">
                                  <li>
                                    <a class="dropdown-item edit-doc" href="javascript:;"
                                       data-id="<?php echo htmlspecialchars($doc['itemdocid'] ?? '', ENT_QUOTES); ?>"
                                       data-itemdoctypeid="<?php echo htmlspecialchars($doc['itemdoctypeid'] ?? '', ENT_QUOTES); ?>"
                                       data-docstatus="<?php echo htmlspecialchars($doc['docstatus'] ?? '1', ENT_QUOTES); ?>">
                                      <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                  </li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li>
                                    <a class="dropdown-item delete-doc text-danger" href="javascript:;"
                                       data-id="<?php echo htmlspecialchars($doc['itemdocid'] ?? '', ENT_QUOTES); ?>">
                                      <i class="fas fa-trash me-2"></i>Delete
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($doc['itemdoctitle'] ?? 'N/A'); ?></span></td>
                            <td class="align-middle"><span class="badge badge-sm <?php echo !empty($doc['docstatus']) ? 'bg-success' : 'bg-secondary'; ?>"><?php echo !empty($doc['docstatus']) ? 'Visible' : 'Hidden'; ?></span></td>
                            <td class="align-middle text-nowrap"><span class="text-secondary text-xs font-weight-bold"><?php echo !empty($doc['entrydate']) ? date('d/m/y', strtotime($doc['entrydate'])) : 'N/A'; ?></span></td>
                            <td class="align-middle">
                              <?php if (!empty($doc['docurl'])): ?>
                                <a class="btn btn-link text-primary btn-sm p-0" href="<?php echo htmlspecialchars($doc['docurl']); ?>" target="_blank"><i class="fas fa-eye me-1"></i>View Document</a>
                              <?php else: ?>
                                <span class="text-secondary text-xs">-</span>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach; else: ?>
                          <tr><td colspan="5" class="text-center py-4"><p class="text-sm text-secondary mb-0">No documents found</p></td></tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item Pictures Tab -->
            <div class="tab-pane fade" id="edit-item-pics" role="tabpanel" aria-labelledby="edit-item-pics-tab">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6>Item Pictures</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPicModal">
                  <i class="fas fa-plus me-2"></i>Add Picture
                </button>
              </div>
              <div class="card">
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-hover">
                      <thead>
                        <tr>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 80px;">Action</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Picture Title</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Entry Date</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                        </tr>
                      </thead>
                      <tbody id="picTableBody">
                        <?php if (!empty($itemPics)): foreach ($itemPics as $pic): ?>
                          <tr>
                            <td class="align-middle text-center">
                              <div class="btn-group" role="group">
                                <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="picActionDropdown<?php echo htmlspecialchars($pic['itempicid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="picActionDropdown<?php echo htmlspecialchars($pic['itempicid'] ?? '', ENT_QUOTES); ?>">
                                  <li>
                                    <a class="dropdown-item edit-pic" href="javascript:;"
                                       data-id="<?php echo htmlspecialchars($pic['itempicid'] ?? '', ENT_QUOTES); ?>"
                                       data-pictitle="<?php echo htmlspecialchars($pic['pictitle'] ?? '', ENT_QUOTES); ?>"
                                       data-picstatus="<?php echo htmlspecialchars($pic['picstatus'] ?? '1', ENT_QUOTES); ?>">
                                      <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                  </li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li>
                                    <a class="dropdown-item delete-pic text-danger" href="javascript:;"
                                       data-id="<?php echo htmlspecialchars($pic['itempicid'] ?? '', ENT_QUOTES); ?>">
                                      <i class="fas fa-trash me-2"></i>Delete
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($pic['pictitle'] ?? ''); ?></span></td>
                            <td class="align-middle"><span class="badge badge-sm <?php echo !empty($pic['picstatus']) ? 'bg-success' : 'bg-secondary'; ?>"><?php echo !empty($pic['picstatus']) ? 'Active' : 'Inactive'; ?></span></td>
                            <td class="align-middle text-nowrap"><span class="text-secondary text-xs font-weight-bold"><?php echo !empty($pic['entrydate']) ? date('d/m/y', strtotime($pic['entrydate'])) : 'N/A'; ?></span></td>
                            <td class="align-middle">
                              <?php if (!empty($pic['picurl'])): ?>
                                <a class="btn btn-link text-primary btn-sm p-0" href="<?php echo htmlspecialchars($pic['picurl']); ?>" target="_blank"><i class="fas fa-eye me-1"></i>View Image</a>
                              <?php else: ?>
                                <span class="text-secondary text-xs">-</span>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach; else: ?>
                          <tr><td colspan="5" class="text-center py-4"><p class="text-sm text-secondary mb-0">No pictures found</p></td></tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Property Layout Tab -->
            <div class="tab-pane fade" id="edit-property-layout" role="tabpanel" aria-labelledby="edit-property-layout-tab">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6>Property Layout</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLayoutModal">
                  <i class="fas fa-plus me-2"></i>Add Floor Layout
                </button>
              </div>
              <div class="card">
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-hover">
                      <thead>
                        <tr>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 80px;">Action</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Floor Title</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Room Count</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Room Labels</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Room Sizes</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Room Prices</th>
                        </tr>
                      </thead>
                      <tbody id="layoutTableBody">
                        <?php if (!empty($subItems)): foreach ($subItems as $layout): ?>
                          <tr>
                            <td class="align-middle text-center">
                              <div class="btn-group" role="group">
                                <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="layoutActionDropdown<?php echo htmlspecialchars($layout['subitemid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="layoutActionDropdown<?php echo htmlspecialchars($layout['subitemid'] ?? '', ENT_QUOTES); ?>">
                                  <li>
                                    <a class="dropdown-item edit-layout" href="javascript:;"
                                       data-id="<?php echo htmlspecialchars($layout['subitemid'] ?? '', ENT_QUOTES); ?>"
                                       data-floortitle="<?php echo htmlspecialchars($layout['floortitle'] ?? '', ENT_QUOTES); ?>"
                                       data-roomcount="<?php echo htmlspecialchars($layout['roomcount'] ?? '', ENT_QUOTES); ?>"
                                       data-roomlabels="<?php echo htmlspecialchars($layout['roomlabels'] ?? '', ENT_QUOTES); ?>"
                                       data-roomsizes="<?php echo htmlspecialchars($layout['roomsizes'] ?? '', ENT_QUOTES); ?>"
                                       data-roomprices="<?php echo htmlspecialchars($layout['roomprices'] ?? '', ENT_QUOTES); ?>">
                                      <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                  </li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li>
                                    <a class="dropdown-item delete-layout text-danger" href="javascript:;"
                                       data-id="<?php echo htmlspecialchars($layout['subitemid'] ?? '', ENT_QUOTES); ?>">
                                      <i class="fas fa-trash me-2"></i>Delete
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($layout['floortitle'] ?? ''); ?></span></td>
                            <td class="align-middle text-center"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($layout['roomcount'] ?? '0'); ?></span></td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($layout['roomlabels'] ?? 'N/A'); ?></span></td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($layout['roomsizes'] ?? 'N/A'); ?></span></td>
                            <td class="text-wrap"><span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($layout['roomprices'] ?? 'N/A'); ?></span></td>
                          </tr>
                        <?php endforeach; else: ?>
                          <tr><td colspan="6" class="text-center py-4"><p class="text-sm text-secondary mb-0">No layout information found</p></td></tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Profile Modal -->
<div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProfileModalLabel">Add Profile Option</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addProfileForm">
        <input type="hidden" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_profile_option" class="form-label">Profile Option *</label>
                <select class="form-select" id="add_profile_option" name="profiles[0][profileoptionid]" required>
                  <option value="">Select Profile Option</option>
                  <?php 
                  // Get list of already used profile option IDs
                  $usedProfileOptionIds = [];
                  if (!empty($itemProfiles)) {
                    foreach ($itemProfiles as $profile) {
                      if (!isset($profile['isdeleted']) || $profile['isdeleted'] != -1) {
                        $usedProfileOptionIds[] = $profile['profileoptionid'];
                      }
                    }
                  }
                  
                  // Display only unused profile options
                  foreach(($profileOptions ?? []) as $opt): 
                    if (!in_array($opt['itemprofileoptionid'], $usedProfileOptionIds)):
                  ?>
                    <option value="<?php echo htmlspecialchars($opt['itemprofileoptionid']); ?>"><?php echo htmlspecialchars($opt['title']); ?></option>
                  <?php 
                    endif;
                  endforeach; 
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_profile_value" class="form-label">Value *</label>
                <input type="text" class="form-control" id="add_profile_value" name="profiles[0][profilevalue]" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_profile_basevalue" class="form-label">Base Value</label>
                <input type="text" class="form-control" id="add_profile_basevalue" name="profiles[0][basevalue]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="add_profile_showuser" name="profiles[0][showuser]" value="1">
                  <label class="form-check-label" for="add_profile_showuser">Show to User</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Profile</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Option</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editProfileForm">
        <input type="hidden" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
        <input type="hidden" id="edit_profile_id" name="itemprofileid">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_profile_option" class="form-label">Profile Option *</label>
                <select class="form-select" id="edit_profile_option" name="profileoptionid" required>
                  <option value="">Select Profile Option</option>
                  <?php foreach(($profileOptions ?? []) as $opt): ?>
                    <option value="<?php echo htmlspecialchars($opt['itemprofileoptionid']); ?>"><?php echo htmlspecialchars($opt['title']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_profile_value" class="form-label">Value *</label>
                <input type="text" class="form-control" id="edit_profile_value" name="profilevalue" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_profile_basevalue" class="form-label">Base Value</label>
                <input type="text" class="form-control" id="edit_profile_basevalue" name="basevalue">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="edit_profile_showuser" name="showuser" value="1">
                  <label class="form-check-label" for="edit_profile_showuser">Show to User</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Document Modal -->
<div class="modal fade" id="addDocModal" tabindex="-1" aria-labelledby="addDocModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDocModalLabel">Add Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addDocForm" enctype="multipart/form-data">
        <input type="hidden" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_doc_type" class="form-label">Document Type *</label>
                <select class="form-select" id="add_doc_type" name="docs[0][itemdoctypeid]" required>
                  <option value="">Select Document Type</option>
                  <?php foreach(($itemDocTypes ?? []) as $dt): ?>
                    <option value="<?php echo htmlspecialchars($dt['itemdoctypeid']); ?>"><?php echo htmlspecialchars($dt['title']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_doc_status" class="form-label">Visibility</label>
                <select class="form-select" id="add_doc_status" name="docs[0][docstatus]">
                  <option value="1">Visible to users</option>
                  <option value="0">Hidden from users</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="add_doc_file" class="form-label">Document File *</label>
                <input type="file" class="form-control" id="add_doc_file" name="docs[0][docurl]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Document</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Document Modal -->
<div class="modal fade" id="editDocModal" tabindex="-1" aria-labelledby="editDocModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDocModalLabel">Edit Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editDocForm">
        <input type="hidden" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
        <input type="hidden" id="edit_doc_id" name="itemdocid">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_doc_type" class="form-label">Document Type *</label>
                <select class="form-select" id="edit_doc_type" name="itemdoctypeid" required>
                  <option value="">Select Document Type</option>
                  <?php foreach(($itemDocTypes ?? []) as $dt): ?>
                    <option value="<?php echo htmlspecialchars($dt['itemdoctypeid']); ?>"><?php echo htmlspecialchars($dt['title']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_doc_status" class="form-label">Visibility</label>
                <select class="form-select" id="edit_doc_status" name="docstatus">
                  <option value="1">Visible to users</option>
                  <option value="0">Hidden from users</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>To change the document file, please delete this document and add a new one.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Document</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Picture Modal -->
<div class="modal fade" id="addPicModal" tabindex="-1" aria-labelledby="addPicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPicModalLabel">Add Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addPicForm" enctype="multipart/form-data">
        <input type="hidden" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_pic_title" class="form-label">Picture Title *</label>
                <input type="text" class="form-control" id="add_pic_title" name="pics[0][pictitle]" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_pic_status" class="form-label">Status</label>
                <select class="form-select" id="add_pic_status" name="pics[0][picstatus]">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="add_pic_file" class="form-label">Picture File *</label>
                <input type="file" class="form-control" id="add_pic_file" name="pics[0][picurl]" accept=".jpg,.jpeg,.png,.webp" required>
                <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG, WEBP</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Picture</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Picture Modal -->
<div class="modal fade" id="editPicModal" tabindex="-1" aria-labelledby="editPicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPicModalLabel">Edit Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editPicForm">
        <input type="hidden" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
        <input type="hidden" id="edit_pic_id" name="itempicid">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_pic_title" class="form-label">Picture Title *</label>
                <input type="text" class="form-control" id="edit_pic_title" name="pictitle" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_pic_status" class="form-label">Status</label>
                <select class="form-select" id="edit_pic_status" name="picstatus">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>To change the picture file, please delete this picture and add a new one.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Picture</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Layout Modal -->
<div class="modal fade" id="addLayoutModal" tabindex="-1" aria-labelledby="addLayoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLayoutModalLabel">Add Floor Layout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addLayoutForm">
        <input type="hidden" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_layout_title" class="form-label">Floor Title *</label>
                <input type="text" class="form-control" id="add_layout_title" name="layouts[0][floortitle]" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_layout_count" class="form-label">Room Count *</label>
                <input type="number" class="form-control" id="add_layout_count" name="layouts[0][roomcount]" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_layout_labels" class="form-label">Room Labels</label>
                <input type="text" class="form-control" id="add_layout_labels" name="layouts[0][roomlabels]" placeholder="e.g., Room A, Room B, Room C">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="add_layout_sizes" class="form-label">Room Sizes</label>
                <input type="text" class="form-control" id="add_layout_sizes" name="layouts[0][roomsizes]" placeholder="e.g., 100sqm, 80sqm, 120sqm">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="add_layout_prices" class="form-label">Room Prices</label>
                <input type="text" class="form-control" id="add_layout_prices" name="layouts[0][roomprices]" placeholder="e.g., 50000, 45000, 60000">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Layout</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Layout Modal -->
<div class="modal fade" id="editLayoutModal" tabindex="-1" aria-labelledby="editLayoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLayoutModalLabel">Edit Floor Layout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editLayoutForm">
        <input type="hidden" name="itemid" value="<?php echo htmlspecialchars($item['itemid'] ?? ''); ?>">
        <input type="hidden" id="edit_layout_id" name="subitemid">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_layout_title" class="form-label">Floor Title *</label>
                <input type="text" class="form-control" id="edit_layout_title" name="floortitle" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_layout_count" class="form-label">Room Count *</label>
                <input type="number" class="form-control" id="edit_layout_count" name="roomcount" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_layout_labels" class="form-label">Room Labels</label>
                <input type="text" class="form-control" id="edit_layout_labels" name="roomlabels" placeholder="e.g., Room A, Room B, Room C">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_layout_sizes" class="form-label">Room Sizes</label>
                <input type="text" class="form-control" id="edit_layout_sizes" name="roomsizes" placeholder="e.g., 100sqm, 80sqm, 120sqm">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="edit_layout_prices" class="form-label">Room Prices</label>
                <input type="text" class="form-control" id="edit_layout_prices" name="roomprices" placeholder="e.g., 50000, 45000, 60000">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Layout</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
let currentEditItemId = <?php echo json_encode($item['itemid'] ?? null); ?>;

// Tab retention functionality
document.addEventListener('DOMContentLoaded', function() {
  // Check if there's a stored active tab
  const activeTab = localStorage.getItem('editPropertyActiveTab');
  if (activeTab) {
    const tabTrigger = document.querySelector(`button[data-bs-target="${activeTab}"]`);
    if (tabTrigger) {
      const tab = new bootstrap.Tab(tabTrigger);
      tab.show();
    }
    // Clear the stored tab after restoring
    localStorage.removeItem('editPropertyActiveTab');
  }

  // Store active tab before page reload
  const tabButtons = document.querySelectorAll('#editPropertyTabs button[data-bs-toggle="tab"]');
  tabButtons.forEach(button => {
    button.addEventListener('shown.bs.tab', function(event) {
      const targetTab = event.target.getAttribute('data-bs-target');
      localStorage.setItem('currentEditPropertyTab', targetTab);
    });
  });
});

// Update Item Info
document.getElementById('editItemInfoForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  // Additional client-side validation
  const title = document.getElementById('edit_title').value.trim();
  const itemtypeid = document.getElementById('edit_itemtypeid').value;
  const address = document.getElementById('edit_address').value.trim();
  
  if (!title) {
    toastr.error('Title is required');
    return;
  }
  if (!itemtypeid) {
    toastr.error('Property Type is required');
    return;
  }
  if (!address) {
    toastr.error('Address is required');
    return;
  }
  
  const formData = new FormData(this);
  fetch(window.location.pathname, { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        toastr.success(data.message || 'Item information updated successfully');
      } else {
        toastr.error(data.message || 'Failed to update item information');
      }
    })
    .catch(() => toastr.error('An error occurred while updating item information'));
});

// Add Profile
document.getElementById('addProfileForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData(this);
  
  // Store current tab before reload
  localStorage.setItem('editPropertyActiveTab', '#edit-item-profile');
  
  fetch('/listings/properties/profiles', { method: 'POST', body: formData })
    .then(r=>r.json()).then(d=>{
      if (d.success) {
        bootstrap.Modal.getInstance(document.getElementById('addProfileModal')).hide();
        toastr.success('Profile added successfully');
        setTimeout(() => location.reload(), 1000);
      } else { 
        toastr.error(d.message || 'Failed to add profile'); 
      }
    }).catch(()=>toastr.error('Error while adding profile'));
});

// Edit Profile - Load Data
document.addEventListener('click', function(e) {
  if (e.target.closest('.edit-profile')) {
    const btn = e.target.closest('.edit-profile');
    const id = btn.getAttribute('data-id');
    const profileoptionid = btn.getAttribute('data-profileoptionid');
    const profilevalue = btn.getAttribute('data-profilevalue');
    const basevalue = btn.getAttribute('data-basevalue');
    const showuser = btn.getAttribute('data-showuser');

    document.getElementById('edit_profile_id').value = id;
    document.getElementById('edit_profile_option').value = profileoptionid;
    document.getElementById('edit_profile_value').value = profilevalue;
    document.getElementById('edit_profile_basevalue').value = basevalue;
    document.getElementById('edit_profile_showuser').checked = (showuser == '1');

    new bootstrap.Modal(document.getElementById('editProfileModal')).show();
  }
});

// Update Profile
document.getElementById('editProfileForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData();
  
  // Build the proper data structure for update (same as add, but with itemprofileid)
  formData.append('itemid', currentEditItemId);
  formData.append('profiles[0][itemprofileid]', document.getElementById('edit_profile_id').value);
  formData.append('profiles[0][profileoptionid]', document.getElementById('edit_profile_option').value);
  formData.append('profiles[0][profilevalue]', document.getElementById('edit_profile_value').value);
  formData.append('profiles[0][basevalue]', document.getElementById('edit_profile_basevalue').value);
  formData.append('profiles[0][showuser]', document.getElementById('edit_profile_showuser').checked ? '1' : '0');
  
  // Store current tab before reload
  localStorage.setItem('editPropertyActiveTab', '#edit-item-profile');
  
  fetch('/listings/properties/profiles', { method: 'POST', body: formData })
    .then(r=>r.json()).then(d=>{
      if (d.success) {
        bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
        toastr.success('Profile updated successfully');
        setTimeout(() => location.reload(), 1000);
      } else { 
        toastr.error(d.message || 'Failed to update profile'); 
      }
    }).catch(()=>toastr.error('Error while updating profile'));
});

// Delete Profile
document.addEventListener('click', function(e) {
  if (e.target.closest('.delete-profile')) {
    const btn = e.target.closest('.delete-profile');
    const id = btn.getAttribute('data-id');
    
    Swal.fire({
      title: 'Are you sure?',
      text: 'You want to delete this profile option?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Store current tab before reload
        localStorage.setItem('editPropertyActiveTab', '#edit-item-profile');
        
        const formData = new FormData();
        formData.append('itemid', currentEditItemId);
        formData.append('profiles[0][itemprofileid]', id);
        formData.append('profiles[0][isdeleted]', '-1');
        
        fetch('/listings/properties/profiles', { method: 'POST', body: formData })
          .then(r=>r.json()).then(d=>{
            if (d.success) {
              toastr.success('Profile deleted successfully');
              setTimeout(() => location.reload(), 1000);
            } else { 
              toastr.error(d.message || 'Failed to delete profile'); 
            }
          }).catch(()=>toastr.error('Error while deleting profile'));
      }
    });
  }
});

// Add Document
document.getElementById('addDocForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData(this);
  
  // Store current tab before reload
  localStorage.setItem('editPropertyActiveTab', '#edit-item-docs');
  
  fetch('/listings/properties/docs', { method: 'POST', body: formData })
    .then(r=>r.json()).then(d=>{
      if (d.success) {
        bootstrap.Modal.getInstance(document.getElementById('addDocModal')).hide();
        toastr.success('Document added successfully');
        setTimeout(() => location.reload(), 1000);
      } else { 
        toastr.error(d.message || 'Failed to add document'); 
      }
    }).catch(()=>toastr.error('Error while adding document'));
});

// Edit Document - Load Data
document.addEventListener('click', function(e) {
  if (e.target.closest('.edit-doc')) {
    const btn = e.target.closest('.edit-doc');
    const id = btn.getAttribute('data-id');
    const itemdoctypeid = btn.getAttribute('data-itemdoctypeid');
    const docstatus = btn.getAttribute('data-docstatus');

    document.getElementById('edit_doc_id').value = id;
    document.getElementById('edit_doc_type').value = itemdoctypeid;
    document.getElementById('edit_doc_status').value = docstatus;

    new bootstrap.Modal(document.getElementById('editDocModal')).show();
  }
});

// Update Document
document.getElementById('editDocForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData();
  
  formData.append('itemid', currentEditItemId);
  formData.append('docs[0][itemdocid]', document.getElementById('edit_doc_id').value);
  formData.append('docs[0][itemdoctypeid]', document.getElementById('edit_doc_type').value);
  formData.append('docs[0][docstatus]', document.getElementById('edit_doc_status').value);
  
  // Store current tab before reload
  localStorage.setItem('editPropertyActiveTab', '#edit-item-docs');
  
  fetch('/listings/properties/docs', { method: 'POST', body: formData })
    .then(r=>r.json()).then(d=>{
      if (d.success) {
        bootstrap.Modal.getInstance(document.getElementById('editDocModal')).hide();
        toastr.success('Document updated successfully');
        setTimeout(() => location.reload(), 1000);
      } else { 
        toastr.error(d.message || 'Failed to update document'); 
      }
    }).catch(()=>toastr.error('Error while updating document'));
});

// Delete Document
document.addEventListener('click', function(e) {
  if (e.target.closest('.delete-doc')) {
    const btn = e.target.closest('.delete-doc');
    const id = btn.getAttribute('data-id');
    
    Swal.fire({
      title: 'Are you sure?',
      text: 'You want to delete this document?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Store current tab before reload
        localStorage.setItem('editPropertyActiveTab', '#edit-item-docs');
        
        const formData = new FormData();
        formData.append('itemid', currentEditItemId);
        formData.append('docs[0][itemdocid]', id);
        formData.append('docs[0][isdeleted]', '-1');
        
        fetch('/listings/properties/docs', { method: 'POST', body: formData })
          .then(r=>r.json()).then(d=>{
            if (d.success) {
              toastr.success('Document deleted successfully');
              setTimeout(() => location.reload(), 1000);
            } else { 
              toastr.error(d.message || 'Failed to delete document'); 
            }
          }).catch(()=>toastr.error('Error while deleting document'));
      }
    });
  }
});

// Add Picture
document.getElementById('addPicForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData(this);
  
  // Store current tab before reload
  localStorage.setItem('editPropertyActiveTab', '#edit-item-pics');
  
  fetch('/listings/properties/pics', { method: 'POST', body: formData })
    .then(r=>r.json()).then(d=>{
      if (d.success) {
        bootstrap.Modal.getInstance(document.getElementById('addPicModal')).hide();
        toastr.success('Picture added successfully');
        setTimeout(() => location.reload(), 1000);
      } else { 
        toastr.error(d.message || 'Failed to add picture'); 
      }
    }).catch(()=>toastr.error('Error while adding picture'));
});

// Edit Picture - Load Data
document.addEventListener('click', function(e) {
  if (e.target.closest('.edit-pic')) {
    const btn = e.target.closest('.edit-pic');
    const id = btn.getAttribute('data-id');
    const pictitle = btn.getAttribute('data-pictitle');
    const picstatus = btn.getAttribute('data-picstatus');

    document.getElementById('edit_pic_id').value = id;
    document.getElementById('edit_pic_title').value = pictitle;
    document.getElementById('edit_pic_status').value = picstatus;

    new bootstrap.Modal(document.getElementById('editPicModal')).show();
  }
});

// Update Picture
document.getElementById('editPicForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData();
  
  formData.append('itemid', currentEditItemId);
  formData.append('pics[0][itempicid]', document.getElementById('edit_pic_id').value);
  formData.append('pics[0][pictitle]', document.getElementById('edit_pic_title').value);
  formData.append('pics[0][picstatus]', document.getElementById('edit_pic_status').value);
  
  // Store current tab before reload
  localStorage.setItem('editPropertyActiveTab', '#edit-item-pics');
  
  fetch('/listings/properties/pics', { method: 'POST', body: formData })
    .then(r=>r.json()).then(d=>{
      if (d.success) {
        bootstrap.Modal.getInstance(document.getElementById('editPicModal')).hide();
        toastr.success('Picture updated successfully');
        setTimeout(() => location.reload(), 1000);
      } else { 
        toastr.error(d.message || 'Failed to update picture'); 
      }
    }).catch(()=>toastr.error('Error while updating picture'));
});

// Delete Picture
document.addEventListener('click', function(e) {
  if (e.target.closest('.delete-pic')) {
    const btn = e.target.closest('.delete-pic');
    const id = btn.getAttribute('data-id');
    
    Swal.fire({
      title: 'Are you sure?',
      text: 'You want to delete this picture?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Store current tab before reload
        localStorage.setItem('editPropertyActiveTab', '#edit-item-pics');
        
        const formData = new FormData();
        formData.append('itemid', currentEditItemId);
        formData.append('pics[0][itempicid]', id);
        formData.append('pics[0][isdeleted]', '-1');
        
        fetch('/listings/properties/pics', { method: 'POST', body: formData })
          .then(r=>r.json()).then(d=>{
            if (d.success) {
              toastr.success('Picture deleted successfully');
              setTimeout(() => location.reload(), 1000);
            } else { 
              toastr.error(d.message || 'Failed to delete picture'); 
            }
          }).catch(()=>toastr.error('Error while deleting picture'));
      }
    });
  }
});

// Add Layout
document.getElementById('addLayoutForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData(this);
  
  // Store current tab before reload
  localStorage.setItem('editPropertyActiveTab', '#edit-property-layout');
  
  fetch('/listings/properties/layout', { method: 'POST', body: formData })
    .then(r=>r.json()).then(d=>{
      if (d.success) {
        bootstrap.Modal.getInstance(document.getElementById('addLayoutModal')).hide();
        toastr.success('Layout added successfully');
        setTimeout(() => location.reload(), 1000);
      } else { 
        toastr.error(d.message || 'Failed to add layout'); 
      }
    }).catch(()=>toastr.error('Error while adding layout'));
});

// Edit Layout - Load Data
document.addEventListener('click', function(e) {
  if (e.target.closest('.edit-layout')) {
    const btn = e.target.closest('.edit-layout');
    const id = btn.getAttribute('data-id');
    const floortitle = btn.getAttribute('data-floortitle');
    const roomcount = btn.getAttribute('data-roomcount');
    const roomlabels = btn.getAttribute('data-roomlabels');
    const roomsizes = btn.getAttribute('data-roomsizes');
    const roomprices = btn.getAttribute('data-roomprices');

    document.getElementById('edit_layout_id').value = id;
    document.getElementById('edit_layout_title').value = floortitle;
    document.getElementById('edit_layout_count').value = roomcount;
    document.getElementById('edit_layout_labels').value = roomlabels;
    document.getElementById('edit_layout_sizes').value = roomsizes;
    document.getElementById('edit_layout_prices').value = roomprices;

    new bootstrap.Modal(document.getElementById('editLayoutModal')).show();
  }
});

// Update Layout
document.getElementById('editLayoutForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData();
  
  formData.append('itemid', currentEditItemId);
  formData.append('layouts[0][subitemid]', document.getElementById('edit_layout_id').value);
  formData.append('layouts[0][floortitle]', document.getElementById('edit_layout_title').value);
  formData.append('layouts[0][roomcount]', document.getElementById('edit_layout_count').value);
  formData.append('layouts[0][roomlabels]', document.getElementById('edit_layout_labels').value);
  formData.append('layouts[0][roomsizes]', document.getElementById('edit_layout_sizes').value);
  formData.append('layouts[0][roomprices]', document.getElementById('edit_layout_prices').value);
  
  // Store current tab before reload
  localStorage.setItem('editPropertyActiveTab', '#edit-property-layout');
  
  fetch('/listings/properties/layout', { method: 'POST', body: formData })
    .then(r=>r.json()).then(d=>{
      if (d.success) {
        bootstrap.Modal.getInstance(document.getElementById('editLayoutModal')).hide();
        toastr.success('Layout updated successfully');
        setTimeout(() => location.reload(), 1000);
      } else { 
        toastr.error(d.message || 'Failed to update layout'); 
      }
    }).catch(()=>toastr.error('Error while updating layout'));
});

// Delete Layout
document.addEventListener('click', function(e) {
  if (e.target.closest('.delete-layout')) {
    const btn = e.target.closest('.delete-layout');
    const id = btn.getAttribute('data-id');
    
    Swal.fire({
      title: 'Are you sure?',
      text: 'You want to delete this floor layout?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Store current tab before reload
        localStorage.setItem('editPropertyActiveTab', '#edit-property-layout');
        
        const formData = new FormData();
        formData.append('itemid', currentEditItemId);
        formData.append('layouts[0][subitemid]', id);
        formData.append('layouts[0][isdeleted]', '-1');
        
        fetch('/listings/properties/layout', { method: 'POST', body: formData })
          .then(r=>r.json()).then(d=>{
            if (d.success) {
              toastr.success('Layout deleted successfully');
              setTimeout(() => location.reload(), 1000);
            } else { 
              toastr.error(d.message || 'Failed to delete layout'); 
            }
          }).catch(()=>toastr.error('Error while deleting layout'));
      }
    });
  }
});
</script>
