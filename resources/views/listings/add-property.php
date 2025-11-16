<?php
$pageTitle = 'Add Pending Property';
include __DIR__ . '/../partials/topnav.php';

$itemTypes = $itemTypes ?? [];
$inspectionStatuses = $inspectionStatuses ?? [];
$ownershipTypes = $ownershipTypes ?? [];
$users = $users ?? [];
$attorneys = $attorneys ?? [];
$itemStatuses = $itemStatuses ?? [];
$profileOptions = $profileOptions ?? [];
$itemDocTypes = $itemDocTypes ?? [];

?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6>Add New Pending Property</h6>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="propertyTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="item-info-tab" data-bs-toggle="tab" data-bs-target="#item-info" type="button" role="tab" aria-controls="item-info" aria-selected="true">
                                <i class="fas fa-info-circle me-2"></i>Item Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="item-profile-tab" data-bs-toggle="tab" data-bs-target="#item-profile" type="button" role="tab" aria-controls="item-profile" aria-selected="false">
                                <i class="fas fa-list me-2"></i>Item Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="item-docs-tab" data-bs-toggle="tab" data-bs-target="#item-docs" type="button" role="tab" aria-controls="item-docs" aria-selected="false">
                                <i class="fas fa-file-alt me-2"></i>Item Documents
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="item-pics-tab" data-bs-toggle="tab" data-bs-target="#item-pics" type="button" role="tab" aria-controls="item-pics" aria-selected="false">
                                <i class="fas fa-images me-2"></i>Item Pictures
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="property-layout-tab" data-bs-toggle="tab" data-bs-target="#property-layout" type="button" role="tab" aria-controls="property-layout" aria-selected="false">
                                <i class="fas fa-building me-2"></i>Property Layout
                            </button>
                        </li>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content mt-4" id="propertyTabsContent">
                        <!-- Item Information Tab -->
                        <div class="tab-pane fade show active" id="item-info" role="tabpanel" aria-labelledby="item-info-tab">
                            <form id="itemInfoForm">
                                <input type="hidden" id="itemid" name="itemid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title *</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="itemtypeid" class="form-label">Property Type *</label>
                                            <select class="form-select" id="itemtypeid" name="itemtypeid" required>
                                                <option value="">Select Property Type</option>
                                                <?php foreach ($itemTypes as $type): ?>
                                                    <option value="<?php echo htmlspecialchars($type['itemtypeid']); ?>"><?php echo htmlspecialchars($type['title']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address *</label>
                                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inspectionstatusid" class="form-label">Inspection Status</label>
                                            <select class="form-select" id="inspectionstatusid" name="inspectionstatusid">
                                                <option value="">Select Status</option>
                                                <?php foreach ($inspectionStatuses as $status): ?>
                                                    <option value="<?php echo htmlspecialchars($status['inspectionstatusid']); ?>"><?php echo htmlspecialchars($status['title']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ownershiptypeid" class="form-label">Ownership Type</label>
                                            <select class="form-select" id="ownershiptypeid" name="ownershiptypeid">
                                                <option value="">Select Ownership Type</option>
                                                <?php foreach ($ownershipTypes as $type): ?>
                                                    <option value="<?php echo htmlspecialchars($type['ownershiptypeid']); ?>"><?php echo htmlspecialchars($type['title']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ownershiptypetitle" class="form-label">Ownership Title</label>
                                            <input type="text" class="form-control" id="ownershiptypetitle" name="ownershiptypetitle">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control" id="price" name="price" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="priceunit" class="form-label">Price Unit</label>
                                            <input type="text" class="form-control" id="priceunit" name="priceunit">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sellerid" class="form-label">Seller</label>
                                            <select class="form-select" id="sellerid" name="sellerid">
                                                <option value="">Select Seller</option>
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?php echo htmlspecialchars($user['userid']); ?>"><?php echo htmlspecialchars(trim(($user['surname'] ?? '') . ' ' . ($user['firstname'] ?? '') . ' ' . ($user['middlename'] ?? ''))); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="attorneyid" class="form-label">Attorney</label>
                                            <select class="form-select" id="attorneyid" name="attorneyid">
                                                <option value="">Select Attorney</option>
                                                <?php foreach ($attorneys as $attorney): ?>
                                                    <?php if (is_array($attorney) && isset($attorney['userid'])): ?>
                                                        <option value="<?php echo htmlspecialchars($attorney['userid'] ?? '', ENT_QUOTES); ?>">
                                                            <?php echo htmlspecialchars(trim(($attorney['surname'] ?? '') . ' ' . ($attorney['firstname'] ?? '') . ' ' . ($attorney['middlename'] ?? '')), ENT_QUOTES); ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="itemstatusid" class="form-label">Item Status</label>
                                            <select class="form-select" id="itemstatusid" name="itemstatusid">
                                                <option value="">Select Status</option>
                                                <?php foreach ($itemStatuses as $status): ?>
                                                    <option value="<?php echo htmlspecialchars($status['itemstatusid']); ?>"><?php echo htmlspecialchars($status['title']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" onclick="saveItemInfo()">Save & Continue</button>
                                </div>
                            </form>
                        </div>

                        <!-- Item Profile Tab -->
                        <div class="tab-pane fade" id="item-profile" role="tabpanel" aria-labelledby="item-profile-tab">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addProfileRow()">
                                    <i class="fas fa-plus me-2"></i>Add Profile Option
                                </button>
                            </div>
                            <form id="itemProfileForm">
                                <input type="hidden" id="profile_itemid" name="itemid">
                                <div id="profileRows"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" onclick="saveItemProfiles()">Save Profiles</button>
                                </div>
                            </form>
                        </div>

                        <!-- Item Documents Tab -->
                        <div class="tab-pane fade" id="item-docs" role="tabpanel" aria-labelledby="item-docs-tab">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addDocRow()">
                                    <i class="fas fa-plus me-2"></i>Add Document
                                </button>
                            </div>
                            <form id="itemDocsForm" enctype="multipart/form-data">
                                <input type="hidden" id="docs_itemid" name="itemid">
                                <div id="docRows"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" onclick="saveItemDocs()">Save Documents</button>
                                </div>
                            </form>
                        </div>

                        <!-- Item Pictures Tab -->
                        <div class="tab-pane fade" id="item-pics" role="tabpanel" aria-labelledby="item-pics-tab">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addPicRow()">
                                    <i class="fas fa-plus me-2"></i>Add Picture
                                </button>
                            </div>
                            <form id="itemPicsForm" enctype="multipart/form-data">
                                <input type="hidden" id="pics_itemid" name="itemid">
                                <div id="picRows"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" onclick="saveItemPics()">Save Pictures</button>
                                </div>
                            </form>
                        </div>

                        <!-- Property Layout Tab -->
                        <div class="tab-pane fade" id="property-layout" role="tabpanel" aria-labelledby="property-layout-tab">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addLayoutRow()">
                                    <i class="fas fa-plus me-2"></i>Add Floor Layout
                                </button>
                            </div>
                            <form id="propertyLayoutForm">
                                <input type="hidden" id="layout_itemid" name="itemid">
                                <div id="layoutRows"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" onclick="savePropertyLayout()">Save Layout</button>
                                </div>
                            </form>
                        </div>
                            </form>
                        </div>
                        <!-- JS for tab logic and AJAX actions -->
<script>
let currentItemId = null;

// Handle ownership type change
document.getElementById('ownershiptypeid').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const titleInput = document.getElementById('ownershiptypetitle');

    if (this.value) {
        titleInput.value = selectedOption.text;
        titleInput.readOnly = true;
    } else {
        titleInput.value = '';
        titleInput.readOnly = false;
    }
});
function saveItemInfo() {
    const formData = new FormData(document.getElementById('itemInfoForm'));
    fetch('/listings/add-property', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentItemId = data.itemid || null;
            document.getElementById('profile_itemid').value = currentItemId;
            document.getElementById('docs_itemid').value = currentItemId;
            document.getElementById('pics_itemid').value = currentItemId;
            document.getElementById('layout_itemid').value = currentItemId;
            // Switch to next tab
            const profileTab = new bootstrap.Tab(document.getElementById('item-profile-tab'));
            profileTab.show();
            alert('Item information saved successfully');
        } else {
            alert(data.message || 'Failed to save item information');
        }
    })
    .catch(error => {
        alert('An error occurred while saving item information');
    });
}
function addProfileRow() {
    const container = document.getElementById('profileRows');
    const rowCount = container.children.length;
    let html = `<div class="row mb-3 profile-row">
        <div class="col-md-4">
            <select class="form-select" name="profiles[${rowCount}][profileoptionid]" required>
                <option value="">Select Profile Option</option>
                <?php foreach ($profileOptions as $option): ?>
                    <option value="<?php echo htmlspecialchars($option['itemprofileoptionid']); ?>"><?php echo htmlspecialchars($option['title']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="profiles[${rowCount}][profilevalue]" placeholder="Value" required>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="profiles[${rowCount}][basevalue]" placeholder="Base Value">
        </div>
        <div class="col-md-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="profiles[${rowCount}][showuser]" value="1">
                <label class="form-check-label">Show User</label>
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
function saveItemProfiles() {
    const formData = new FormData(document.getElementById('itemProfileForm'));
    fetch('/listings/properties/profiles', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Item profiles saved successfully');
        } else {
            alert('Failed to save item profiles');
        }
    })
    .catch(error => {
        alert('An error occurred while saving item profiles');
    });
}
function addDocRow() {
    const container = document.getElementById('docRows');
    const rowCount = container.children.length;
    let html = `<div class="row mb-3 doc-row">
        <div class="col-md-4">
            <select class="form-select" name="docs[${rowCount}][itemdoctypeid]" required>
                <option value="">Select Document Type</option>
                <?php foreach ($itemDocTypes as $type): ?>
                    <option value="<?php echo htmlspecialchars($type['itemdoctypeid']); ?>"><?php echo htmlspecialchars($type['title']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-select" name="docs[${rowCount}][docstatus]">
                <option value="1">Visible to users</option>
                <option value="0">Hidden from users</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="file" class="form-control" name="docs[${rowCount}][docurl]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
function saveItemDocs() {
    const formData = new FormData(document.getElementById('itemDocsForm'));
    fetch('/listings/properties/docs', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Item documents saved successfully');
        } else {
            alert('Failed to save item documents');
        }
    })
    .catch(error => {
        alert('An error occurred while saving item documents');
    });
}
function addPicRow() {
    const container = document.getElementById('picRows');
    const rowCount = container.children.length;
    let html = `<div class="row mb-3 pic-row">
        <div class="col-md-5">
            <input type="text" class="form-control" name="pics[${rowCount}][pictitle]" placeholder="Picture Title" required>
        </div>
        <div class="col-md-3">
            <select class="form-select" name="pics[${rowCount}][picstatus]">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="file" class="form-control" name="pics[${rowCount}][picurl]" accept=".jpg,.jpeg,.png" required>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
function saveItemPics() {
    const formData = new FormData(document.getElementById('itemPicsForm'));
    fetch('/listings/properties/pics', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Item pictures saved successfully');
        } else {
            alert('Failed to save item pictures');
        }
    })
    .catch(error => {
        alert('An error occurred while saving item pictures');
    });
}
function addLayoutRow() {
    const container = document.getElementById('layoutRows');
    const rowCount = container.children.length;
    let html = `<div class="row mb-3 layout-row">
        <div class="col-md-3">
            <input type="text" class="form-control" name="layouts[${rowCount}][floortitle]" placeholder="Floor Title" required>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control" name="layouts[${rowCount}][roomcount]" placeholder="Room Count" required>
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="layouts[${rowCount}][roomlabels]" placeholder="Room Labels">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="layouts[${rowCount}][roomsizes]" placeholder="Room Sizes">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="layouts[${rowCount}][roomprices]" placeholder="Room Prices">
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
function savePropertyLayout() {
    const formData = new FormData(document.getElementById('propertyLayoutForm'));
    fetch('/listings/properties/layout', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Property layout saved successfully');
            window.location.href = '/listings/new-properties';
        } else {
            alert('Failed to save property layout');
        }
    })
    .catch(error => {
        alert('An error occurred while saving property layout');
    });
}
</script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>
