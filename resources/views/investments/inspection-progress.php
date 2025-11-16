<?php $pageTitle = 'Inspection Inprogress'; ?>
<?php include __DIR__ . '/../partials/topnav.php'; ?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Inspection In Progress Projects
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
                        <h6>Inspection In Progress Projects</h6>
                        <a href="/investments/add-project" class="btn btn-success">
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
                                <?php if (!empty($inspectionInprogessList['data'])): ?>
                                    <?php foreach ($inspectionInprogessList['data'] as $project): ?>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">
                                                        <li>
                                                            <a class="dropdown-item" href="/investments/view-project?id=<?php echo htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES); ?>">
                                                                <i class="fas fa-eye me-2"></i>View
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
                                            <p class="text-sm text-secondary mb-0">No Inspection In Progress projects found</p>
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

    <?php $paginationData = $inspectionInprogessList; include __DIR__ . '/../partials/pagination.php'; ?>
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

function showFullText(text, title) {
    document.getElementById('fullTextModalLabel').textContent = title;
    document.getElementById('fullTextContent').textContent = text;
    new bootstrap.Modal(document.getElementById('fullTextModal')).show();
}
</script>
