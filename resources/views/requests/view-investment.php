<?php $pageTitle = 'Investment Request Detail'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Investment Request Detail</h3>
                        </div>
                        <div class="col-4 text-end">
                            <button type="button"
                                    class="btn btn-sm btn-info text-white close-request-btn me-2 <?php echo (!empty($investment['itemid']) && $investment['requeststatus'] == 0) ? '' : 'disabled'; ?>"
                                    data-itemrequestid="<?php echo htmlspecialchars($investment['itemrequestid'], ENT_QUOTES); ?>">
                                Close Request
                            </button>
                            <button type="button" onclick="window.history.back()" class="btn btn-sm btn-primary">Go Back</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Accordion for Investment Info and Matching Properties -->
                    <div class="accordion" id="investmentAccordion">
                        
                        <!-- Investment Profile -->
                        <div class="card">
                            <div class="card-header" id="investmentInfo">
                                <h5 class="mb-0">
                                    <button class="btn w-100 text-left" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInvestmentInfo" aria-expanded="true" aria-controls="collapseInvestmentInfo">
                                        Profile
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseInvestmentInfo" class="collapse show" aria-labelledby="investmentInfo" data-bs-parent="#investmentAccordion">
                                <div class="card-body">
                                    <h6 class="text-muted mb-4">Property Information</h6>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-control-label fw-bold">List Type</label>
                                                <p><?php echo htmlspecialchars($investment['bidtype_title'] ?? 'N/A', ENT_QUOTES); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-control-label fw-bold">Description</label>
                                                <p><?php echo htmlspecialchars($investment['description'] ?? 'N/A', ENT_QUOTES); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-control-label fw-bold">Price</label>
                                                <p><?php echo isset($investment['price']) ? number_format((float)$investment['price'], 2, '.', ',') : 'N/A'; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Matching Properties Listings -->
                        <div class="card">
                            <div class="card-header" id="matchingInvestments">
                                <h5 class="mb-0">
                                    <button class="btn w-100 text-left" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMatchingInvestments" aria-expanded="false" aria-controls="collapseMatchingInvestments">
                                        Matching Properties Listings
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseMatchingInvestments" class="collapse" aria-labelledby="matchingInvestments" data-bs-parent="#investmentAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (!empty($matchingItems['data']) && count($matchingItems['data']) > 0): ?>
                                            <?php foreach ($matchingItems['data'] as $item): ?>
                                                <div class="col-lg-3 mb-3">
                                                    <a href="/investments/view-project?id=<?php echo htmlspecialchars($item['itemid'], ENT_QUOTES); ?>" class="w-100">
                                                        <div class="p-1">
                                                            <img src="/<?php echo htmlspecialchars($item['picurl'], ENT_QUOTES); ?>" class="w-100" style="height: 150px; object-fit: cover;">
                                                            <div class="mt-2 fw-bold"><?php echo htmlspecialchars($item['title'], ENT_QUOTES); ?></div>
                                                        </div>
                                                    </a>
                                                    <div class="d-flex gap-2 mt-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-success match-btn <?php echo (empty($investment['itemid']) && $investment['requeststatus'] == 0) ? '' : 'disabled'; ?>" 
                                                                data-itemrequestid="<?php echo htmlspecialchars($investment['itemrequestid'], ENT_QUOTES); ?>"
                                                                data-itemid="<?php echo htmlspecialchars($item['itemid'], ENT_QUOTES); ?>"
                                                                data-title="<?php echo htmlspecialchars($item['title'], ENT_QUOTES); ?>">
                                                            Match
                                                        </button>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger unmatch-btn <?php echo (($investment['requeststatus'] == 0) && !empty($investment['itemid']) && ($item['itemid'] == $investment['itemid'])) ? '' : 'disabled'; ?>" 
                                                                data-itemrequestid="<?php echo htmlspecialchars($investment['itemrequestid'], ENT_QUOTES); ?>"
                                                                data-itemid="<?php echo htmlspecialchars($item['itemid'], ENT_QUOTES); ?>"
                                                                data-title="<?php echo htmlspecialchars($item['title'], ENT_QUOTES); ?>">
                                                            Un-match
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-12">
                                                <p class="text-muted">No matching investments found</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Pagination for matching items -->
                                    <?php if ($matchingItems['last_page'] > 1): ?>
                                        <div class="d-flex justify-content-center mt-4">
                                            <nav aria-label="Matching items pagination">
                                                <ul class="pagination">
                                                    <!-- Previous button -->
                                                    <?php if ($matchingItems['current_page'] > 1): ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="<?php echo url('requests/investments/' . $investment['itemrequestid'] . '?page=' . ($matchingItems['current_page'] - 1)); ?>#collapseMatchingInvestments">
                                                                <i class="fas fa-chevron-left"></i>
                                                            </a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="page-item disabled">
                                                            <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <!-- Page numbers -->
                                                    <?php
                                                    $start = max(1, $matchingItems['current_page'] - 2);
                                                    $end = min($matchingItems['last_page'], $matchingItems['current_page'] + 2);

                                                    for ($i = $start; $i <= $end; $i++):
                                                    ?>
                                                        <li class="page-item <?php echo $i == $matchingItems['current_page'] ? 'active' : ''; ?>">
                                                            <a class="page-link" href="<?php echo url('requests/investments/' . $investment['itemrequestid'] . '?page=' . $i); ?>#collapseMatchingInvestments">
                                                                <?php echo $i; ?>
                                                            </a>
                                                        </li>
                                                    <?php endfor; ?>

                                                    <!-- Next button -->
                                                    <?php if ($matchingItems['current_page'] < $matchingItems['last_page']): ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="<?php echo url('requests/investments/' . $investment['itemrequestid'] . '?page=' . ($matchingItems['current_page'] + 1)); ?>#collapseMatchingInvestments">
                                                                <i class="fas fa-chevron-right"></i>
                                                            </a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="page-item disabled">
                                                            <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="text-center mt-2">
                                            <small class="text-muted">
                                                Showing <?php echo count($matchingItems['data']); ?> of <?php echo $matchingItems['total']; ?> matching items
                                                (Page <?php echo $matchingItems['current_page']; ?> of <?php echo $matchingItems['last_page']; ?>)
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<script>
$(document).ready(function() {
    // Display session messages
    <?php if (isset($_SESSION['success_message'])): ?>
        toastr.success('<?php echo addslashes($_SESSION['success_message']); ?>');
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        toastr.error('<?php echo addslashes($_SESSION['error_message']); ?>');
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    // Handle Match button
    $('.match-btn').on('click', function() {
        if ($(this).hasClass('disabled')) return;
        
        const itemrequestid = $(this).data('itemrequestid');
        const itemid = $(this).data('itemid');
        const title = $(this).data('title');

        Swal.fire({
            title: 'Match Investment?',
            text: `Are you sure you want to match this request to "${title}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, match it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?php echo url('requests/investments/'); ?>${itemrequestid}?confirmitem=${itemid}`;
            }
        });
    });

    // Handle Un-match button
    $('.unmatch-btn').on('click', function() {
        if ($(this).hasClass('disabled')) return;
        
        const itemrequestid = $(this).data('itemrequestid');
        const itemid = $(this).data('itemid');
        const title = $(this).data('title');

        Swal.fire({
            title: 'Un-match Investment?',
            text: `Are you sure you want to un-match this request from "${title}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, un-match it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?php echo url('requests/investments/'); ?>${itemrequestid}?cancelitem=${itemid}`;
            }
        });
    });

    // Handle Close Request button
    $('.close-request-btn').on('click', function() {
        if ($(this).hasClass('disabled')) return;
        
        const itemrequestid = $(this).data('itemrequestid');

        Swal.fire({
            title: 'Close Request?',
            text: 'Are you sure you want to close this investment request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, close it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?php echo url('requests/investments/'); ?>${itemrequestid}?requeststatus=1`;
            }
        });
    });
});
</script>
