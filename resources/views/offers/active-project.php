<?php $pageTitle = 'Active Project Offers'; ?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Active Project Offers
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_transaction_type" class="form-label fw-bold">Transaction Type</label>
                            <select class="form-select" id="filter_transaction_type" name="transaction_type">
                                <option value="">All Types</option>
                                <?php foreach ($bidTypes as $bidType): ?>
                                    <option value="<?php echo htmlspecialchars($bidType['bidtypeid'] ?? '', ENT_QUOTES); ?>" <?php echo ($filters['transaction_type'] ?? '') == $bidType['bidtypeid'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($bidType['options'] ?? '', ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_email" class="form-label fw-bold">Email</label>
                            <input type="text" class="form-control" id="filter_email" name="email" value="<?php echo htmlspecialchars($filters['email'] ?? '', ENT_QUOTES); ?>" placeholder="Search by email">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_phone" class="form-label fw-bold">Phone</label>
                            <input type="text" class="form-control" id="filter_phone" name="phone" value="<?php echo htmlspecialchars($filters['phone'] ?? '', ENT_QUOTES); ?>" placeholder="Search by phone">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_status" class="form-label fw-bold">Status</label>
                            <select class="form-select" id="filter_status" name="status">
                                <option value="">All Status</option>
                                <option value="1" <?php echo ($filters['status'] ?? '') == '1' ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo ($filters['status'] ?? '') == '0' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_offerdate" class="form-label fw-bold">Offer Date</label>
                            <input type="date" class="form-control" id="filter_offerdate" name="offerdate" value="<?php echo htmlspecialchars($filters['offerdate'] ?? '', ENT_QUOTES); ?>">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label for="filter_attorney" class="form-label fw-bold">Attorney</label>
                            <select class="form-select" id="filter_attorney" name="attorney">
                                <option value="">All Attorneys</option>
                                <?php foreach ($attorneys as $attorney): ?>
                                    <option value="<?php echo htmlspecialchars($attorney['userid'] ?? '', ENT_QUOTES); ?>" <?php echo ($filters['attorney'] ?? '') == $attorney['userid'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(trim(($attorney['surname'] ?? '') . ' ' . ($attorney['firstname'] ?? '')), ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex gap-2 align-items-center justify-content-end">
                                <button type="button" class="btn btn-primary" id="applyFilters">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                    <i class="fas fa-times me-2"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty(array_filter($filters))): ?>
                        <span class="badge bg-info text-white ms-2">
                            <i class="fas fa-filter me-1"></i><?php echo count(array_filter($filters)); ?> active filter(s)
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Main Content Section -->
    <div class="row  mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Active Project Offers</h6>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 100px;">
                                        Action</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 150px;">
                                        Item Title</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 80px;">
                                        Item ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                                        Transaction Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                                        Bidder Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                                        Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 100px;">
                                        Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                                        Proposed Amount</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                                        Note</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 80px;">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 100px;">
                                        Offer Period</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                                        Payment Terms</th>
                                    
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 120px;">
                                        Attorney</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="min-width: 100px;">
                                        Offer Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($activeProjects)): ?>
                                <?php foreach ($activeProjects as $bid): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo htmlspecialchars(url('offers/property-detail/' . $bid['itembidid']), ENT_QUOTES); ?>"
                                                   class="btn btn-link text-primary btn-sm"
                                                   title="View Property Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 150px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars(!empty($bid['item']) ? (strlen($bid['item']['title']) > 50 ? substr($bid['item']['title'], 0, 50) . '...' : $bid['item']['title']) : 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 80px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars($bid['itemid'] ?? 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 120px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars(!empty($bid['item']) && !empty($bid['item']['bidType']) ? $bid['item']['bidType']['options'] : 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 120px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars($bid['biddername'] ?? 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 120px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars($bid['bidderemail'] ?? 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 100px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars($bid['bidderphone'] ?? 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 120px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php if (!empty($bid['proposedamount']) && !empty($bid['item']) && !empty($bid['item']['currency'])): ?>
                                                            <?php echo htmlspecialchars($bid['item']['currency']['symbol'] ?? '', ENT_QUOTES); ?><?php echo number_format($bid['proposedamount'] ?? 0, 2); ?>
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 120px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal" style="word-wrap: break-word; white-space: normal;">
                                                        <?php echo htmlspecialchars(!empty($bid['note']) ? (strlen($bid['note']) > 50 ? substr($bid['note'], 0, 50) . '...' : $bid['note']) : 'N/A', ENT_QUOTES); ?>
                                                        <?php if (!empty($bid['note']) && strlen($bid['note']) > 50): ?>
                                                            <span class="text-primary" style="cursor: pointer;" onclick='showFullText("<?php echo htmlspecialchars(addslashes($bid["note"] ?? ""), ENT_QUOTES); ?>", "Note")'>...more</span>
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-sm <?php echo $bid['status'] == 1 ? 'bg-success' : 'bg-secondary'; ?>">
                                                <?php echo htmlspecialchars(!empty($bid['item']) && !empty($bid['item']['itemStatus']) ? $bid['item']['itemStatus']['title'] : 'N/A', ENT_QUOTES); ?>
                                            </span>
                                        </td>
                                        <td class="text-wrap" style="max-width: 100px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars($bid['serviceduration'] ?? 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 120px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars($bid['paymentterms'] ?? 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap" style="max-width: 120px;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm font-weight-normal">
                                                        <?php echo htmlspecialchars(!empty($bid['attorney']) ? trim(($bid['attorney']['firstname'] ?? '') . ' ' . ($bid['attorney']['lastname'] ?? '')) : 'N/A', ENT_QUOTES); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-nowrap">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php echo !empty($bid['entrydate']) ? date('d/m/y', strtotime($bid['entrydate'])) : 'N/A'; ?>
                                            </span>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                    <?php else: ?>
                                    <tr>
                                        <td colspan="17" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No Active Project Offers found</p>
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
                <?php if (!empty($pagination)): echo $pagination; endif; ?>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<script>
$(document).ready(function() {
    // Apply Filters
    $('#applyFilters').on('click', function() {
        const filters = {
            transaction_type: $('#filter_transaction_type').val(),
            email: $('#filter_email').val().trim(),
            phone: $('#filter_phone').val().trim(),
            status: $('#filter_status').val(),
            offerdate: $('#filter_offerdate').val(),
            attorney: $('#filter_attorney').val(),
        };

        // Start with current URL and preserve existing parameters
        const currentUrl = new URL(window.location.href);
        const params = new URLSearchParams(currentUrl.search);

        // Add filter parameters
        Object.keys(filters).forEach(key => {
            if (filters[key]) {
                params.set(key, filters[key]);
            } else {
                params.delete(key); // Remove empty filter values
            }
        });

        // Preserve existing page parameter for better UX
        const currentPage = currentUrl.searchParams.get('page');
        if (currentPage) {
            params.set('page', currentPage);
        }

        // Navigate with all preserved parameters
        const url = currentUrl.origin + currentUrl.pathname + (params.toString() ? '?' + params.toString() : '');
        window.location.href = url;
    });

    // Reset Filters
    $('#resetFilters').on('click', function() {
        // Clear all filter inputs
        $('#filter_transaction_type').val('');
        $('#filter_email').val('');
        $('#filter_phone').val('');
        $('#filter_status').val('');
        $('#filter_offerdate').val('');
        $('#filter_attorney').val('');

        // Keep only essential routing parameters, remove filters
        const currentUrl = new URL(window.location.href);
        const params = new URLSearchParams();
        
        // Preserve action parameter for routing
        const action = currentUrl.searchParams.get('action');
        if (action) {
            params.set('action', action);
        }

        // Navigate to cleaned URL
        const url = currentUrl.origin + currentUrl.pathname + (params.toString() ? '?' + params.toString() : '');
        window.location.href = url;
    });

    // Optional: Auto-apply filters on Enter key press in text inputs
    $('#filter_email, #filter_phone').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            $('#applyFilters').click();
        }
    });

    // Real-time filtering for better UX (optional enhancement)
    let filterTimeout;
    $('#filter_email, #filter_phone').on('input', function() {
        clearTimeout(filterTimeout);
        const input = $(this);
        filterTimeout = setTimeout(function() {
            const emailVal = $('#filter_email').val().trim();
            const phoneVal = $('#filter_phone').val().trim();
            
            // Only auto-apply if both text inputs are empty or have meaningful values
            if ((emailVal.length === 0 || emailVal.length >= 3) &&
                (phoneVal.length === 0 || phoneVal.length >= 3)) {
                $('#applyFilters').click();
            }
        }, 1000); // 1 second delay
    });
});
</script>