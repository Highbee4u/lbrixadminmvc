<?php
$pageTitle = 'Awaiting Listing Projects';
?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Awaiting Listing Projects
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-6">
                            <label for="filter_ownership_type" class="form-label fw-bold">Ownership Type</label>
                            <select class="form-select" id="filter_ownership_type" name="ownership_type">
                                <option value="">All Types</option>
                                <?php if (isset($ownershipTypes) && !empty($ownershipTypes)): ?>
                                    <?php foreach ($ownershipTypes as $type): ?>
                                        <option value="<?php echo htmlspecialchars($type['ownershiptypeid'], ENT_QUOTES); ?>" <?php echo (isset($_GET['ownership_type']) && $_GET['ownership_type'] == $type['ownershiptypeid']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($type['title'], ENT_QUOTES); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="filter_entry_date" class="form-label fw-bold">Entry Date</label>
                            <input type="date" class="form-control" id="filter_entry_date" name="entry_date" value="<?php echo isset($_GET['entry_date']) ? htmlspecialchars($_GET['entry_date'], ENT_QUOTES) : ''; ?>">
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
                    $activeFilters = array_filter($_GET ?? [], function($value, $key) {
                        return in_array($key, ['ownership_type', 'entry_date']) && !empty($value);
                    }, ARRAY_FILTER_USE_BOTH);
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
                        <h6>Awaiting Listing Projects</h6>
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
                                <?php if (isset($awaitingInspectionList['data']) && !empty($awaitingInspectionList['data'])): ?>
                                    <?php foreach ($awaitingInspectionList['data'] as $project): ?>
                                        <tr>
                                                                                        <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo $project['itemid']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo $project['itemid']; ?>">
                                                        <li>
                                                            <a class="dropdown-item" href="/investments/view-project?id=<?php echo htmlspecialchars($project['itemid'], ENT_QUOTES); ?>">
                                                                <i class="fas fa-eye me-2"></i>View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item list-project" href="javascript:;" 
                                                               data-itemid="<?php echo htmlspecialchars($project['itemid'], ENT_QUOTES); ?>"
                                                               data-title="<?php echo htmlspecialchars($project['title'] ?? '', ENT_QUOTES); ?>">
                                                                <i class="fas fa-list me-2"></i>List Property
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
                                                            echo htmlspecialchars(strlen($title) > 50 ? substr($title, 0, 50) : $title, ENT_QUOTES); 
                                                            ?>
                                                            <?php if (strlen($title) > 50): ?>
                                                                <span class="text-primary" style="cursor: pointer;" onclick="showFullText('<?php echo htmlspecialchars($title, ENT_QUOTES); ?>', 'Project Title')">...more</span>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                                            <?php 
                                                            $description = $project['description'] ?? '';
                                                            echo htmlspecialchars(strlen($description) > 50 ? substr($description, 0, 50) : $description, ENT_QUOTES); 
                                                            ?>
                                                            <?php if (strlen($description) > 50): ?>
                                                                <span class="text-primary" style="cursor: pointer;" onclick="showFullText('<?php echo htmlspecialchars($description, ENT_QUOTES); ?>', 'Description')">...more</span>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px;">
                                                <span class="text-secondary text-xs font-weight-bold" style="word-wrap: break-word;">
                                                    <?php 
                                                    $address = $project['address'] ?? '';
                                                    echo htmlspecialchars(strlen($address) > 50 ? substr($address, 0, 50) : $address, ENT_QUOTES); 
                                                    ?>
                                                    <?php if (strlen($address) > 50): ?>
                                                        <span class="text-primary" style="cursor: pointer;" onclick="showFullText('<?php echo htmlspecialchars($address, ENT_QUOTES); ?>', 'Address')">...more</span>
                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-sm <?php echo isset($project['inspectionStatus']) ? 'bg-info' : 'bg-secondary'; ?>">
                                                    <?php echo isset($project['inspectionStatus']) ? htmlspecialchars($project['inspectionStatus']['title'], ENT_QUOTES) : 'Not Set'; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo isset($project['price']) ? number_format($project['price'], 2) : 'N/A'; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php 
                                                    if (isset($project['seller'])) {
                                                        echo htmlspecialchars(trim(($project['seller']['surname'] ?? '') . ' ' . ($project['seller']['firstname'] ?? '') . ' ' . ($project['seller']['middlename'] ?? '')), ENT_QUOTES);
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($project['ownershiptypetitle'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($project['projecttypetitle'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo isset($project['entrydate']) ? date('d/m/y', strtotime($project['entrydate'])) : 'N/A'; ?>
                                                </span>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Awaiting Listing projects found</p>
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
    <?php if (isset($awaitingInspectionList['data']) && !empty($awaitingInspectionList['data'])): ?>
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <?php
                    $pagination = $awaitingInspectionList;
                    $currentPage = $pagination['current_page'];
                    $lastPage = $pagination['last_page'];
                    $queryParams = $_GET;
                    ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <!-- Previous Page -->
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <?php $queryParams['page'] = $currentPage - 1; ?>
                                    <a class="page-link" href="?<?php echo http_build_query($queryParams); ?>">Previous</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php for ($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++): ?>
                                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                    <?php $queryParams['page'] = $i; ?>
                                    <a class="page-link" href="?<?php echo http_build_query($queryParams); ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Page -->
                            <?php if ($currentPage < $lastPage): ?>
                                <li class="page-item">
                                    <?php $queryParams['page'] = $currentPage + 1; ?>
                                    <a class="page-link" href="?<?php echo http_build_query($queryParams); ?>">Next</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    <?php endif; ?>
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
document.addEventListener('DOMContentLoaded', function() {
    // Apply Filters
    document.getElementById('applyFilters').addEventListener('click', function() {
        const filters = {
            ownership_type: document.getElementById('filter_ownership_type').value,
            entry_date: document.getElementById('filter_entry_date').value,
        };

        // Build query string
        const params = new URLSearchParams();
        Object.keys(filters).forEach(key => {
            if (filters[key]) {
                params.append(key, filters[key]);
            }
        });

        // Reload page with filters
        const url = (() => {
                const baseUrl = '<?php echo url("investments/awaiting-listing"); ?>';
                const queryString = params.toString();
                return baseUrl + (queryString ? '&' + queryString : '');
            })();
        window.location.href = url;
    });

    // Reset Filters
    document.getElementById('resetFilters').addEventListener('click', function() {
        // Clear all filter inputs
        document.getElementById('filter_ownership_type').value = '';
        document.getElementById('filter_entry_date').value = '';

        // Reload page without any query parameters
        window.location.href = '<?php echo url("investments/awaiting-listing"); ?>';
    });

    // Optional: Auto-apply filters on Enter key press in filter inputs
    document.getElementById('filter_entry_date').addEventListener('keypress', function(e) {
        if (e.which === 13) { // Enter key
            document.getElementById('applyFilters').click();
        }
    });
});

function showFullText(text, title) {
    document.getElementById('fullTextModalLabel').textContent = title;
    document.getElementById('fullTextContent').textContent = text;
    new bootstrap.Modal(document.getElementById('fullTextModal')).show();
}

// Handle list property
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('list-project') || e.target.closest('.list-project')) {
        e.preventDefault();
        const element = e.target.closest('.list-project');
        const itemid = element.dataset.itemid;
        const title = element.dataset.title;

        if (!itemid) {
            toastr.error('Project ID is required');
            return;
        }

        Swal.fire({
            title: 'List Project?',
            text: `Are you sure you want to list "${title}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, list it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('itemstatusid', '10');
                
                fetch(`/investments/projects/update/${itemid}`, {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json().then(data => ({ok: r.ok, data})))
                .then(({ok, data}) => {
                    if (ok && data.success) {
                        toastr.success('Project listed successfully');
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        toastr.error(data.message || 'Failed to list project');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while listing the project');
                });
            }
        });
    }
});
</script>

<?php
// Include footer
include __DIR__ . '/../partials/footer.php';
?>
