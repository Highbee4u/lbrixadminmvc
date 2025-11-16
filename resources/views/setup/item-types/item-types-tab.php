<div class="card-header pb-0 d-flex justify-content-between align-items-center">
    <h6>Item Types</h6>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemTypeModal">
        Add Item Type
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
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Entry Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($itemTypes)): ?>
                    <?php foreach ($itemTypes as $itemtype): ?>
                    <tr>
                                                <td class="align-middle text-center">
                            <div class="dropdown">
                                <button class="btn btn-link text-secondary font-weight-bold text-xs dropdown-toggle"
                                        type="button" id="actionDropdown<?php echo htmlspecialchars($itemtype['itemtypeid'] ?? '', ENT_QUOTES); ?>"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo htmlspecialchars($itemtype['itemtypeid'] ?? '', ENT_QUOTES); ?>">
                                    <li>
                                        <a class="dropdown-item edit-itemtype" href="javascript:;"
                                        data-id="<?php echo htmlspecialchars($itemtype['itemtypeid'] ?? '', ENT_QUOTES); ?>"
                                        data-title="<?php echo htmlspecialchars($itemtype['title'] ?? '', ENT_QUOTES); ?>">
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item delete-itemtype text-danger" href="javascript:;"
                                        data-id="<?php echo htmlspecialchars($itemtype['itemtypeid'] ?? '', ENT_QUOTES); ?>">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($itemtype['title'] ?? '', ENT_QUOTES); ?></h6>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">
                                <?php echo !empty($itemtype['entrydate']) ? date('d/m/y', strtotime($itemtype['entrydate'])) : ''; ?>
                            </span>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <p class="text-sm text-secondary mb-0">No Item Types found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $itemTypes->links() }}
    </div>
</div>

<!-- Add Item Type Modal -->
<div class="modal fade" id="addItemTypeModal" tabindex="-1" aria-labelledby="addItemTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemTypeModalLabel">Add Item Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addItemTypeForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
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

<!-- Edit Item Type Modal -->
<div class="modal fade" id="editItemTypeModal" tabindex="-1" aria-labelledby="editItemTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemTypeModalLabel">Edit Item Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editItemTypeForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_itemtypeid" name="itemtypeid">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
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
