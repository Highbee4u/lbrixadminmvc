<?php $pageTitle = 'Inspection Requests'; ?>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>List of Inspection Requests</h6>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createInspectionRequestModal">
                            Create Inspection Request
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:80px;">Action</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:60px;">Item ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:100px;">Item Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:100px;">Requester Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:90px;">Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:120px;">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:120px;">Note</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:80px;">Attorney</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width:90px;">Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($inspectionRequests['data'])): ?>
                                <?php foreach ($inspectionRequests['data'] as $request): ?>
                                    <tr>
                                         <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo htmlspecialchars($request['inspectionrequestid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo htmlspecialchars($request['inspectionrequestid'] ?? '', ENT_QUOTES); ?>">
                                                    <li>
                                                        <a class="dropdown-item view-request" href="javascript:;"
                                                           data-id="<?php echo htmlspecialchars($request['inspectionrequestid'] ?? '', ENT_QUOTES); ?>"
                                                           data-itemid="<?php echo htmlspecialchars($request['itemid'] ?? '', ENT_QUOTES); ?>">
                                                            <i class="fas fa-eye me-2"></i>View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item edit-request" href="javascript:;"
                                                           data-id="<?php echo htmlspecialchars($request['inspectionrequestid'] ?? '', ENT_QUOTES); ?>">
                                                            <i class="fas fa-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item create-inspection-task" href="javascript:;"
                                                           data-itemid="<?php echo htmlspecialchars($request['itemid'] ?? '', ENT_QUOTES); ?>"
                                                           data-itemtitle="<?php echo htmlspecialchars($request['item_title'] ?? 'N/A', ENT_QUOTES); ?>"
                                                           data-inspecteename="<?php echo htmlspecialchars($request['inspecteename'] ?? 'N/A', ENT_QUOTES); ?>"
                                                           data-inspecteephone="<?php echo htmlspecialchars($request['inspecteephone'] ?? 'N/A', ENT_QUOTES); ?>"
                                                           data-inspecteeemail="<?php echo htmlspecialchars($request['inspecteeemail'] ?? 'N/A', ENT_QUOTES); ?>"
                                                           data-attorneyname="<?php echo htmlspecialchars(!empty($request['attorney_firstname']) ? trim(($request['attorney_surname'] ?? '') . ' ' . ($request['attorney_firstname'] ?? '') . ' ' . ($request['attorney_middlename'] ?? '')) : 'N/A', ENT_QUOTES); ?>"
                                                           data-proposeddate="<?php echo htmlspecialchars(!empty($request['proposeddate']) ? date('Y-m-d', strtotime($request['proposeddate'])) : '', ENT_QUOTES); ?>"
                                                           data-note="<?php echo htmlspecialchars($request['note'] ?? '', ENT_QUOTES); ?>">
                                                            <i class="fas fa-tasks me-2"></i>Create Inspection Task
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item delete-request text-danger" href="javascript:;"
                                                           data-id="<?php echo htmlspecialchars($request['inspectionrequestid'] ?? '', ENT_QUOTES); ?>">
                                                            <i class="fas fa-trash me-2"></i>Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-wrap">       
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($request['itemid'] ?? '', ENT_QUOTES); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal"><?php echo htmlspecialchars(!empty($request['item_title']) ? $request['item_title'] : 'N/A', ENT_QUOTES); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                          <td class="text-wrap">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($request['inspecteename'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($request['inspecteephone'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($request['inspecteeemail'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 150px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                                        <?php 
                                                        $noteText = $request['note'] ?? '';
                                                        echo htmlspecialchars((strlen($noteText) > 100 ? substr($noteText, 0, 100) . '...' : $noteText), ENT_QUOTES);
                                                        if (strlen($noteText) > 100): 
                                                        ?>
                                                            <span class="text-primary" style="cursor: pointer;" onclick='showFullText("<?php echo htmlspecialchars(addslashes($noteText), ENT_QUOTES); ?>", "Request Name")'>...more</span>
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars(
                                                            !empty($request['attorney_firstname'])
                                                                ? trim(($request['attorney_surname'] ?? '') . ' ' . ($request['attorney_firstname'] ?? '') . ' ' . ($request['attorney_middlename'] ?? ''))
                                                                : 'N/A',
                                                            ENT_QUOTES
                                                        ); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal"><?php echo !empty($request['proposeddate']) ? date('d/m/y', strtotime($request['proposeddate'])) : 'N/A'; ?></span>
                                                </div>
                                            </div>
                                        </td>
                                      
                                       
                                       
                                    </tr>
                                <?php endforeach; ?>
                    <?php else: ?>
                                    <tr>
                                        <td colspan="19" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Inspection Requests found</p>
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

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <?php if (!empty($inspectionRequests) && $inspectionRequests['last_page'] > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <!-- Previous Button -->
                            <?php if ($inspectionRequests['current_page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=inspection/requests&page=<?php echo $inspectionRequests['current_page'] - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </span>
                                </li>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php
                            $start = max(1, $inspectionRequests['current_page'] - 2);
                            $end = min($inspectionRequests['last_page'], $inspectionRequests['current_page'] + 2);

                            // Show first page if not in range
                            if ($start > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=inspection/requests&page=1">1</a>
                                </li>
                                <?php if ($start > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Page numbers in range -->
                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?php echo ($i == $inspectionRequests['current_page']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?action=inspection/requests&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Show last page if not in range -->
                            <?php if ($end < $inspectionRequests['last_page']): ?>
                                <?php if ($end < $inspectionRequests['last_page'] - 1): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=inspection/requests&page=<?php echo $inspectionRequests['last_page']; ?>"><?php echo $inspectionRequests['last_page']; ?></a>
                                </li>
                            <?php endif; ?>

                            <!-- Next Button -->
                            <?php if ($inspectionRequests['current_page'] < $inspectionRequests['last_page']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=inspection/requests&page=<?php echo $inspectionRequests['current_page'] + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<!-- Create Inspection Request Modal -->
<div class="modal fade" id="createInspectionRequestModal" tabindex="-1" aria-labelledby="createInspectionRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createInspectionRequestModalLabel">Create Inspection Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createInspectionRequestForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bidtypeid" class="form-label">Transaction Type</label>
                                <select class="form-select" id="bidtypeid" name="bidtypeid" required>
                                    <option value="">Select Transaction Type</option>
                                    <?php foreach ($bidTypes ?? [] as $bidType): ?>
                                        <option value="<?php echo htmlspecialchars($bidType['bidtypeid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($bidType['options'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspecteeid" class="form-label">Inspectee</label>
                                <select class="form-select" id="inspecteeid" name="inspecteeid" required>
                                    <option value="">Select Inspectee</option>
                                    <?php foreach ($users ?? [] as $user): ?>
                                        <option value="<?php echo htmlspecialchars($user['userid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($user['username'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspecteename" class="form-label">Requester Name</label>
                                <input type="text" class="form-control" id="inspecteename" name="inspecteename" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspecteephone" class="form-label">Requester Phone</label>
                                <input type="text" class="form-control" id="inspecteephone" name="inspecteephone" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspecteeemail" class="form-label">Requester Email</label>
                                <input type="email" class="form-control" id="inspecteeemail" name="inspecteeemail" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="attorneyid" class="form-label">Attorney</label>
                                <select class="form-select" id="attorneyid" name="attorneyid">
                                    <option value="">Select Attorney</option>
                                    <?php foreach ($users ?? [] as $user): ?>
                                        <option value="<?php echo htmlspecialchars($user['userid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars(trim(($user['surname'] ?? '') . ' ' . ($user['firstname'] ?? '') . ' ' . ($user['middlename'] ?? '')), ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="note" class="form-label">Requester Note</label>
                                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="proposeddate" class="form-label">Proposed Date</label>
                                <input type="date" class="form-control" id="proposeddate" name="proposeddate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="itemid" class="form-label">Item</label>
                                <select class="form-select" id="itemid" name="itemid" required>
                                    <option value="">Select Item</option>
                                    <?php foreach ($items ?? [] as $item): ?>
                                        <option value="<?php echo htmlspecialchars($item['itemid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Inspection Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Inspection Request Modal -->
<div class="modal fade" id="editInspectionRequestModal" tabindex="-1" aria-labelledby="editInspectionRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInspectionRequestModalLabel">Edit Inspection Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editInspectionRequestForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_inspectionrequestid" name="inspectionrequestid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_bidtypeid" class="form-label">Transaction Type</label>
                                <select class="form-select" id="edit_bidtypeid" name="bidtypeid" required>
                                    <option value="">Select Transaction Type</option>
                                    <?php foreach ($bidTypes ?? [] as $bidType): ?>
                                        <option value="<?php echo htmlspecialchars($bidType['bidtypeid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($bidType['options'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_inspecteeid" class="form-label">Inspectee</label>
                                <select class="form-select" id="edit_inspecteeid" name="inspecteeid" required>
                                    <option value="">Select Inspectee</option>
                                    <?php foreach ($users ?? [] as $user): ?>
                                        <option value="<?php echo htmlspecialchars($user['userid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($user['username'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_inspecteename" class="form-label">Requester Name</label>
                                <input type="text" class="form-control" id="edit_inspecteename" name="inspecteename" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_inspecteephone" class="form-label">Requester Phone</label>
                                <input type="text" class="form-control" id="edit_inspecteephone" name="inspecteephone" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_inspecteeemail" class="form-label">Requester Email</label>
                                <input type="email" class="form-control" id="edit_inspecteeemail" name="inspecteeemail" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_attorneyid" class="form-label">Attorney</label>
                                <select class="form-select" id="edit_attorneyid" name="attorneyid">
                                    <option value="">Select Attorney</option>
                                    <?php foreach ($users ?? [] as $user): ?>
                                        <option value="<?php echo htmlspecialchars($user['userid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars(trim(($user['surname'] ?? '') . ' ' . ($user['firstname'] ?? '') . ' ' . ($user['middlename'] ?? '')), ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_note" class="form-label">Note</label>
                                <textarea class="form-control" id="edit_note" name="note" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_proposeddate" class="form-label">Proposed Date</label>
                                <input type="date" class="form-control" id="edit_proposeddate" name="proposeddate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_itemid" class="form-label">Item</label>
                                <select class="form-select" id="edit_itemid" name="itemid" required>
                                    <option value="">Select Item</option>
                                    <?php foreach ($items ?? [] as $item): ?>
                                        <option value="<?php echo htmlspecialchars($item['itemid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Inspection Request</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Define URLs for JavaScript
    window.inspectionUrls = {
        ...window.inspectionUrls,
        requests: {
            store: "<?php echo url('inspection/requests/store'); ?>",
            update: "<?php echo url('inspection/requests/:id'); ?>",
            show: "<?php echo url('inspection/requests/:id'); ?>",
            destroy: "<?php echo url('inspection/requests/:id'); ?>"
        },
        tasks: {
            store: "<?php echo url('inspection/tasks/store'); ?>"
        }
    };
</script>
<script src="<?php echo asset('js/inspection-requests.js'); ?>"></script>
 
<!-- Add Inspection Task Modal -->
<div class="modal fade" id="addInspectionTaskModal" tabindex="-1" aria-labelledby="addInspectionTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInspectionTaskModalLabel">Create Inspection Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addInspectionTaskForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES); ?>">
                <!-- Hidden field to submit itemid while keeping the select disabled -->
                <input type="hidden" id="task_itemid_hidden" name="itemid" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="task_itemid" class="form-label">Item</label>
                                <select class="form-select" id="task_itemid" required>
                                    <option value="">Select Item</option>
                                    <?php foreach ($items ?? [] as $item): ?>
                                        <option value="<?php echo htmlspecialchars($item['itemid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspectionlead" class="form-label">Inspection Lead</label>
                                <select class="form-select" id="inspectionlead" name="inspectionlead" required>
                                    <option value="">Select Lead</option>
                                    <?php foreach ($inspectionLead ?? [] as $lead): ?>
                                        <option value="<?php echo htmlspecialchars($lead['userid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars(trim(($lead['surname'] ?? '') . ' ' . ($lead['firstname'] ?? '') . ' ' . ($lead['middlename'] ?? '')), ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="task_status" class="form-label">Status</label>
                                <select class="form-select" id="task_status" name="status" required>
                                    <option value="">Select Status</option>
                                    <?php foreach ($inspectionStatuses ?? [] as $status): ?>
                                        <option value="<?php echo htmlspecialchars($status['inspectionstatusid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($status['title'] ?? '', ENT_QUOTES); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="task_startdate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="task_startdate" name="startdate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="task_note" class="form-label">Note</label>
                                <textarea class="form-control" id="task_note" name="note" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="task_supervisornote" class="form-label">Supervisor Note</label>
                                <textarea class="form-control" id="task_supervisornote" name="supervisornote" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
 </div>
