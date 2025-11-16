<?php $pageTitle = 'Inspection Task'; ?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Inspection Tasks
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_startdate" class="form-label fw-bold">Start Date</label>
                            <input type="date" class="form-control" id="filter_startdate" name="startdate" value="<?php echo htmlspecialchars($_GET['startdate'] ?? '', ENT_QUOTES); ?>">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_status" class="form-label fw-bold">Status</label>
                            <select class="form-select" id="filter_status" name="status">
                                <option value="">All Status</option>
                                <?php foreach (($inspectionStatuses ?? []) as $status): ?>
                                    <?php 
                                        $statusId = $status['inspectionstatusid'] ?? '';
                                        $isSelected = isset($_GET['status']) && (string)$_GET['status'] === (string)$statusId ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo htmlspecialchars($statusId, ENT_QUOTES); ?>" <?php echo $isSelected; ?>>
                                        <?php echo htmlspecialchars($status['title'] ?? '', ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label for="filter_item" class="form-label fw-bold">Item</label>
                            <select class="form-select" id="filter_item" name="itemid">
                                <option value="">All Items</option>
                                <?php foreach (($items ?? []) as $item): ?>
                                    <?php 
                                        $itemId = $item['itemid'] ?? '';
                                        $isSelected = isset($_GET['itemid']) && (string)$_GET['itemid'] === (string)$itemId ? 'selected' : '';
                                        $title = $item['title'] ?? '';
                                        $shortTitle = (mb_strlen($title) > 30) ? (mb_substr($title, 0, 30) . '...') : $title;
                                    ?>
                                    <option value="<?php echo htmlspecialchars($itemId, ENT_QUOTES); ?>" <?php echo $isSelected; ?>>
                                        <?php echo htmlspecialchars($shortTitle, ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_entrydate" class="form-label fw-bold">Entry Date</label>
                            <input type="date" class="form-control" id="filter_entrydate" name="entrydate" value="<?php echo htmlspecialchars($_GET['entrydate'] ?? '', ENT_QUOTES); ?>">
                        </div>
                        <div class="col-lg-3 col-md-12">
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
                        $filterKeys = ['startdate', 'status', 'itemid', 'entrydate'];
                        $activeCount = 0;
                        foreach ($filterKeys as $key) {
                            if (isset($_GET[$key]) && $_GET[$key] !== '') { $activeCount++; }
                        }
                    ?>
                    <?php if ($activeCount > 0): ?>
                        <span class="badge bg-info text-white ms-2">
                            <i class="fas fa-filter me-1"></i><?php echo (int)$activeCount; ?> active filter(s)
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="row">
        <div class="col-12">
            <!-- Tab content -->
            <div class="mt-4" id="inspectionTabsContent">
                <div id="inspection-task">
                    <?php include __DIR__ . '/tasks/inspection-task-tab.php'; ?>
                </div>
            </div>
        </div>
    </div>
     <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <?php if (!empty($tasksList) && $tasksList['last_page'] > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <!-- Previous Button -->
                            <?php if ($tasksList['current_page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=inspection/tasks&page=<?php echo $tasksList['current_page'] - 1; ?>" aria-label="Previous">
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
                            $start = max(1, $tasksList['current_page'] - 2);
                            $end = min($tasksList['last_page'], $tasksList['current_page'] + 2);

                            // Show first page if not in range
                            if ($start > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=inspection/tasks&page=1">1</a>
                                </li>
                                <?php if ($start > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Page numbers in range -->
                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?php echo ($i == $tasksList['current_page']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?action=inspection/tasks&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Show last page if not in range -->
                            <?php if ($end < $tasksList['last_page']): ?>
                                <?php if ($end < $tasksList['last_page'] - 1): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=inspection/tasks&page=<?php echo $tasksList['last_page']; ?>"><?php echo $tasksList['last_page']; ?></a>
                                </li>
                            <?php endif; ?>

                            <!-- Next Button -->
                            <?php if ($tasksList['current_page'] < $tasksList['last_page']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?action=inspection/tasks&page=<?php echo $tasksList['current_page'] + 1; ?>" aria-label="Next">
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

<script>
$(document).ready(function() {
    // Ensure modals are properly initialized
    $('.modal').modal({
        backdrop: 'static',
        keyboard: false
    });

    // Tab functionality will be handled in individual tab files

    // Apply Filters
    $('#applyFilters').on('click', function() {
        const filters = {
            startdate: $('#filter_startdate').val(),
            status: $('#filter_status').val(),
            itemid: $('#filter_item').val(),
            entrydate: $('#filter_entrydate').val(),
        };

        // Build query string
        const params = new URLSearchParams();
        Object.keys(filters).forEach(key => {
            if (filters[key]) {
                params.append(key, filters[key]);
            }
        });

        // Reload page with filters (preserve action parameter)
        const currentUrl = new URL(window.location.href);
        const action = currentUrl.searchParams.get('action');
        if (action) {
            params.set('action', action);
        }
        const url = window.location.pathname + '?' + params.toString();
        window.location.href = url;
    });

    // Reset Filters
    $('#resetFilters').on('click', function() {
        // Clear all filter inputs
        $('#filter_startdate').val('');
        $('#filter_status').val('');
        $('#filter_item').val('');
        $('#filter_entrydate').val('');

        // Reload page without filter parameters but keep action
        const currentUrl = new URL(window.location.href);
        const action = currentUrl.searchParams.get('action');
        const url = action ? window.location.pathname + '?action=' + action : window.location.pathname;
        window.location.href = url;
    });

    // Optional: Auto-apply filters on Enter key press in filter inputs
    $('#filter_startdate, #filter_entrydate').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            $('#applyFilters').click();
        }
    });

    // Optional: Auto-apply when dropdowns change
    // $('#filter_status, #filter_item').on('change', function() {
    //     $('#applyFilters').click();
    // });
});
</script>
