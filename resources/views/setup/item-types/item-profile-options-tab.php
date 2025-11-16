<div class="card-header pb-0 d-flex justify-content-between align-items-center">
    <h6>Item Profile Options</h6>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemProfileOptionModal">
        Add Item Profile Option
    </button>
</div>
<div class="card-body px-0 pt-0 pb-2">
    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Action</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Title</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Option Type</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Base Title</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        List Type</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Show User</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Entry Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($itemProfileOptionsList)): ?>
                    <?php foreach ($itemProfileOptionsList as $option): ?>
                    <tr>
                        <td class="align-middle text-center">
                            <div class="dropdown">
                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                        type="button" id="actionDropdown<?php echo htmlspecialchars($option['itemprofileoptionid'] ?? '', ENT_QUOTES); ?>"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo htmlspecialchars($option['itemprofileoptionid'] ?? '', ENT_QUOTES); ?>">
                                    <li>
                                        <a class="dropdown-item view-details" href="javascript:;"
                                        data-id="<?php echo htmlspecialchars($option['itemprofileoptionid'] ?? '', ENT_QUOTES); ?>">
                                            View Details
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item edit-item-profile-option" href="javascript:;"
                                        data-id="<?php echo htmlspecialchars($option['itemprofileoptionid'] ?? '', ENT_QUOTES); ?>"
                                        data-title="<?php echo htmlspecialchars($option['title'] ?? '', ENT_QUOTES); ?>"
                                        data-optiontype="<?php echo htmlspecialchars($option['optiontype'] ?? '', ENT_QUOTES); ?>"
                                        data-basetitle="<?php echo htmlspecialchars($option['basetitle'] ?? '', ENT_QUOTES); ?>"
                                        data-listtype="<?php echo htmlspecialchars($option['listtype'] ?? '', ENT_QUOTES); ?>"
                                        data-listmenu="<?php echo htmlspecialchars($option['listmenu'] ?? '', ENT_QUOTES); ?>"
                                        data-itemtypeid="<?php echo htmlspecialchars($option['itemtypeid'] ?? '', ENT_QUOTES); ?>">
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item delete-item-profile-option text-danger" href="javascript:;"
                                        data-id="<?php echo htmlspecialchars($option['itemprofileoptionid'] ?? '', ENT_QUOTES); ?>">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($option['title'] ?? '', ENT_QUOTES); ?></h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($option['optiontype'] ?? '', ENT_QUOTES); ?></h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($option['basetitle'] ?? '', ENT_QUOTES); ?></h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($option['listtype'] ?? '', ENT_QUOTES); ?></h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars(!empty($option['showuser']) ? 'Yes' : 'No', ENT_QUOTES); ?></h6>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">
                                <?php echo !empty($option['entrydate']) ? date('d/m/y', strtotime($option['entrydate'])) : ''; ?>
                            </span>
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="text-sm text-secondary mb-0">No Item Profile Options found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Item Profile Option Modal -->
<div class="modal fade" id="addItemProfileOptionModal" tabindex="-1" aria-labelledby="addItemProfileOptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemProfileOptionModalLabel">Add Item Profile Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addItemProfileOptionForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="option_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="option_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="basetitle" class="form-label">Base Title</label>
                        <input type="text" class="form-control" id="basetitle" name="basetitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="listtype" class="form-label">List Type</label>
                        <input type="text" class="form-control" id="listtype" name="listtype" required>
                    </div>
                    <div class="mb-3">
                        <label for="listmenu" class="form-label">List Menu</label>
                        <textarea class="form-control" id="listmenu" name="listmenu" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="profile_itemtypeid" class="form-label">Item Type</label>
                        <select class="form-select" id="profile_itemtypeid" name="itemtypeid" required>
                            <option value="">Select Item Type</option>
                            <?php foreach($itemTypes as $itemtype): ?>
                                <option value="<?php echo htmlspecialchars($itemtype['itemtypeid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($itemtype['title'] ?? '', ENT_QUOTES); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Item Profile Option Modal -->
<div class="modal fade" id="editItemProfileOptionModal" tabindex="-1" aria-labelledby="editItemProfileOptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemProfileOptionModalLabel">Edit Item Profile Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editItemProfileOptionForm" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_itemprofileoptionid" name="itemprofileoptionid">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_option_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_option_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_basetitle" class="form-label">Base Title</label>
                        <input type="text" class="form-control" id="edit_basetitle" name="basetitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_listtype" class="form-label">List Type</label>
                        <input type="text" class="form-control" id="edit_listtype" name="listtype" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_listmenu" class="form-label">List Menu</label>
                        <textarea class="form-control" id="edit_listmenu" name="listmenu" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_profile_itemtypeid" class="form-label">Item Type</label>
                        <select class="form-select" id="edit_profile_itemtypeid" name="itemtypeid" required>
                            <option value="">Select Item Type</option>
                            <?php foreach($itemTypes as $itemtype): ?>
                                <option value="<?php echo htmlspecialchars($itemtype['itemtypeid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($itemtype['title'] ?? '', ENT_QUOTES); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailsModalLabel">Item Profile Option Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                <!-- Details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>