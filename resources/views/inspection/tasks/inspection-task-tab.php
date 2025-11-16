<!-- Inspection Task Tab Content -->
<div class="card mb-4">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h6>List of Inspection Tasks</h6>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addInspectionTaskModal">
                Add Inspection Task
            </button>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 table-hover">
                <thead>
                    <tr>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 150px;">
                            Action</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 150px;">
                            Task Description</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                            Lead</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 100px;">
                            Start Date</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 80px;">
                            Status</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                            Supervisor Note</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 100px;">
                            Item</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 80px;">
                            Doc</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 100px;">
                            Entry Date</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tasksList['data'])): ?>
                    <?php foreach ($tasksList['data'] as $task): ?>
                        <tr>
                            <td class="align-middle text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo htmlspecialchars($task['inspectiontaskid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo htmlspecialchars($task['inspectiontaskid'] ?? '', ENT_QUOTES); ?>">
                                        <li>
                                            <a class="dropdown-item edit-inspection-task" href="javascript:;"
                                               data-id="<?php echo htmlspecialchars($task['inspectiontaskid'] ?? '', ENT_QUOTES); ?>"
                                               data-note="<?php echo htmlspecialchars($task['note'] ?? '', ENT_QUOTES); ?>"
                                               data-inspectionlead="<?php echo htmlspecialchars($task['inspectionlead'] ?? '', ENT_QUOTES); ?>"
                                               data-startdate="<?php echo htmlspecialchars($task['startdate'] ?? '', ENT_QUOTES); ?>"
                                               data-status="<?php echo htmlspecialchars($task['status'] ?? '', ENT_QUOTES); ?>"
                                               data-supervisornote="<?php echo htmlspecialchars($task['supervisornote'] ?? '', ENT_QUOTES); ?>"
                                               data-itemid="<?php echo htmlspecialchars($task['itemid'] ?? '', ENT_QUOTES); ?>"
                                               data-docurl="<?php echo htmlspecialchars($task['docurl'] ?? '', ENT_QUOTES); ?>">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item manage-team" href="javascript:;"
                                               data-id="<?php echo htmlspecialchars($task['inspectiontaskid'] ?? '', ENT_QUOTES); ?>">
                                                <i class="fas fa-users me-2"></i>Manage Team
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item assign-task" href="javascript:;"
                                               data-id="<?php echo htmlspecialchars($task['inspectiontaskid'] ?? '', ENT_QUOTES); ?>">
                                                <i class="fas fa-tasks me-2"></i>Assign Task
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item delete-inspection-task text-danger" href="javascript:;"
                                               data-id="<?php echo htmlspecialchars($task['inspectiontaskid'] ?? '', ENT_QUOTES); ?>">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-wrap" style="max-width: 150px;">
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                            <?php $noteText = $task['note'] ?? '';
                                            echo htmlspecialchars((strlen($noteText) > 100 ? substr($noteText, 0, 100) . '...' : $noteText), ENT_QUOTES); 
                                            ?>
                                            <?php if (strlen($task['note'] ?? '') > 100): ?>
                                                <span class="text-primary" style="cursor: pointer;" onclick='showFullText("<?php echo htmlspecialchars(addslashes($task["note"] ?? ""), ENT_QUOTES); ?>", "Task Description")'>...more</span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-wrap" style="max-width: 120px;">
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="text-sm font-weight-normal">
                                            <?php echo htmlspecialchars(!empty($task['inspectionLead']) ? trim(($task['inspectionLead']['lead_firstname'] ?? '') . ' ' . ($task['inspectionLead']['lead_lastname'] ?? '')) : 'N/A', ENT_QUOTES); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-nowrap">
                                <span class="text-secondary text-xs font-weight-bold">
                                    <?php echo !empty($task['startdate']) ? date('d/m/y', strtotime($task['startdate'])) : 'N/A'; ?>
                                </span>
                            </td>
                            <td class="align-middle">
                                <span class="badge badge-sm <?php echo $task['inspection_status_name'] ? 'bg-info' : 'bg-secondary'; ?>">
                                    <?php echo htmlspecialchars(!empty($task['inspection_status_name']) ? (strlen($task['inspection_status_name']) > 15 ? substr($task['inspection_status_name'], 0, 15) . '...' : $task['inspection_status_name']) : 'N/A', ENT_QUOTES); ?>
                                </span>
                            </td>
                            <td class="text-wrap" style="max-width: 120px;">
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                            <?php echo htmlspecialchars(!empty($task['supervisornote']) ? (strlen($task['supervisornote']) > 50 ? substr($task['supervisornote'], 0, 50) . '...' : $task['supervisornote']) : 'N/A', ENT_QUOTES); ?>
                                            <?php if ($task['supervisornote'] && strlen($task['supervisornote'] ?? '') > 50): ?>
                                                <span class="text-primary" style="cursor: pointer;" onclick='showFullText("<?php echo htmlspecialchars(addslashes($task["supervisornote"] ?? ""), ENT_QUOTES); ?>", "Supervisor Note")'>...more</span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-wrap" style="max-width: 100px;">
                                <span class="text-secondary text-xs font-weight-bold" style="word-wrap: break-word;">
                                    <?php echo htmlspecialchars(!empty($task['item_title']) ? (strlen($task['item_title']) > 30 ? substr($task['item_title'], 0, 30) . '...' : $task['item_title']) : 'N/A', ENT_QUOTES); ?>
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <?php if ($task['docurl'] ?? false): ?>
                                    <button type="button" class="btn btn-link text-primary btn-sm p-0" onclick="previewDocument('<?php echo htmlspecialchars($task['docurl'] ?? '', ENT_QUOTES); ?>')" title="View Document">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="text-secondary text-xs">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle text-nowrap">
                                <span class="text-secondary text-xs font-weight-bold">
                                    <?php echo !empty($task['entrydate']) ? date('d/m/y', strtotime($task['entrydate'])) : ''; ?>
                                </span>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <p class="text-sm text-secondary mb-0">No Inspection Tasks found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Inspection Task Modal -->
<div class="modal fade" id="addInspectionTaskModal" tabindex="-1" aria-labelledby="addInspectionTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInspectionTaskModalLabel">Add Inspection Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addInspectionTaskForm" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="itemid" class="form-label">Item</label>
                                <select class="form-select" id="itemid" name="itemid" required>
                                    <option value="">Select Item</option>
                                    <?php foreach ($items as $item): ?>
                                        <option value="<?php echo htmlspecialchars($item['itemid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspectionlead" class="form-label">Inspection Lead</label>
                                <select class="form-select" id="inspectionlead" name="inspectionlead" required>
                                    <option value="">Select Inspection Lead</option>
                                    <?php foreach ($inspectionLead as $lead): ?>
                                        <option value="<?php echo htmlspecialchars($lead['userid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars(trim(($lead['surname'] ?? '') . ' ' . ($lead['firstname'] ?? '') . ' ' . ($lead['middlename'] ?? '')), ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startdate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startdate" name="startdate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <?php foreach ($inspectionStatuses as $status): ?>
                                        <option value="<?php echo htmlspecialchars($status['inspectionstatusid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($status['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supervisornote" class="form-label">Supervisor Note</label>
                                <textarea class="form-control" id="supervisornote" name="supervisornote" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="note" class="form-label">Note (Description)</label>
                                <textarea class="form-control" id="note" name="note" rows="3" required></textarea>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="docurl" class="form-label">Document Upload</label>
                                <input type="file" class="form-control" id="docurl" name="docurl" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Inspection Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Inspection Task Modal -->
<div class="modal fade" id="editInspectionTaskModal" tabindex="-1" aria-labelledby="editInspectionTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInspectionTaskModalLabel">Edit Inspection Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editInspectionTaskForm" enctype="multipart/form-data" method="PUT">
                <input type="hidden" id="edit_inspectiontaskid" name="inspectiontaskid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="edit_itemid" class="form-label">Item</label>
                                <select class="form-select" id="edit_itemid" name="itemid" required>
                                    <option value="">Select Item</option>
                                    <?php foreach ($items as $item): ?>
                                        <option value="<?php echo htmlspecialchars($item['itemid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_inspectionlead" class="form-label">Inspection Lead</label>
                                <select class="form-select" id="edit_inspectionlead" name="inspectionlead" required>
                                    <option value="">Select Inspection Lead</option>
                                    <?php foreach ($inspectionLead as $lead): ?>
                                        <option value="<?php echo htmlspecialchars($lead['userid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars(trim(($lead['surname'] ?? '') . ' ' . ($lead['firstname'] ?? '') . ' ' . ($lead['middlename'] ?? '')), ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_startdate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="edit_startdate" name="startdate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="">Select Status</option>
                                    <?php foreach ($inspectionStatuses as $status): ?>
                                        <option value="<?php echo htmlspecialchars($status['inspectionstatusid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($status['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_supervisornote" class="form-label">Supervisor Note</label>
                                <textarea class="form-control" id="edit_supervisornote" name="supervisornote" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="edit_note" class="form-label">Note (Description)</label>
                                <textarea class="form-control" id="edit_note" name="note" rows="3" required></textarea>
                            </div>
                          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_docurl" class="form-label">Document Upload (Leave empty to keep current)</label>
                                <input type="file" class="form-control" id="edit_docurl" name="docurl" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Inspection Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Manage Team Modal -->
<div class="modal fade" id="manageTeamModal" tabindex="-1" aria-labelledby="manageTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-right">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageTeamModalLabel">Manage Inspection Team</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Stack: Form on top, Team Members list below -->
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h6 class="mb-0">Add Team Member</h6>
                            </div>
                            <div class="card-body">
                                <form id="addTeamMemberForm">
                                    <input type="hidden" id="team_inspectiontaskid" name="inspectiontaskid">

                                    <div class="mb-3">
                                        <label for="teammember" class="form-label">Select User</label>
                                        <select class="form-select" id="teammember" name="userid" required>
                                            <option value="">Select Team Member</option>
                                            <?php foreach ($inspectionLead as $user): ?>
                                                <option value="<?php echo htmlspecialchars($user['userid'] ?? '', ENT_QUOTES); ?>"><?php echo trim($user['surname'] . ' ' . $user['firstname'] . ' ' . $user['middlename']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Comment</label>
                                        <textarea class="form-control" name="comment" id="comment" rows="5" placeholder="Enter any relevant comments..."></textarea>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add Member
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h6 class="mb-0">Current Team Members</h6>
                            </div>
                            <div class="card-body">
                                <div id="teamMembersList">
                                    <!-- Team members will be loaded here -->
                                    <div class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="text-sm text-secondary mt-2">Loading team members...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Assign Task Modal -->
<div class="modal fade" id="assignTaskModal" tabindex="-1" aria-labelledby="assignTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignTaskModalLabel">Assign Inspection Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignTaskForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>">
                <input type="hidden" id="assign_inspectiontaskid" name="inspectiontaskid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assign_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="assign_title" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assign_itemid" class="form-label">Item ID</label>
                                <input type="text" class="form-control" id="assign_itemid" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assign_description" class="form-label">Description</label>
                                <textarea class="form-control" id="assign_description" rows="3" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assign_address" class="form-label">Address</label>
                                <textarea class="form-control" id="assign_address" rows="3" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assign_price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="assign_price" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assign_itemstatusid" class="form-label">Current Item Status</label>
                                <input type="text" class="form-control" id="assign_itemstatusid" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="assign_itemstatus" class="form-label">Item Status</label>
                                <select class="form-select" id="assign_itemstatus" name="itemstatusid" required>
                                    <option value="">Select Item Status</option>
                                    <?php foreach ($itemStatuses as $status): ?>
                                        <option value="<?php echo htmlspecialchars($status['itemstatusid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($status['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="<?php echo asset('css/inspection-task-tab.css'); ?>" rel="stylesheet">

<script>
    // Define URLs for JavaScript
    window.inspectionUrls = {
        store: "<?php echo url('inspection/tasks/store'); ?>",
        team: "<?php echo url('inspection/tasks/team'); ?>",
        teamStore: "<?php echo url('inspection/tasks/team/store'); ?>",
        assign: "<?php echo url('inspection/tasks/assign'); ?>"
    };
    // Expose CSRF token for AJAX requests
    window.csrfToken = "<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>";
</script>
<script src="<?php echo asset('js/inspection-task-tab.js'); ?>"></script>
