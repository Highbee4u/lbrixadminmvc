<?php $pageTitle = 'Investment Requests'; ?>
<?php include __DIR__ . '/../partials/topnav.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Investment Requests</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <?php if (!empty($investments['data']) && count($investments['data']) > 0): ?>
                            <?php foreach ($investments['data'] as $investment): ?>
                                <!-- Investment Request Card -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <a href="/requests/investment/view?id=<?php echo htmlspecialchars($investment['itemrequestid'] ?? '', ENT_QUOTES); ?>" class="text-decoration-none">
                                        <div class="card h-180 w-100 py-2 mb-3" style="background: url('/img/No_image.png'); height: 240px; background-size: cover; background-position: center;">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col mr-2">
                                            <div class="h6 mt-0 font-weight-bold text-dark">
                                                Title: <?php echo htmlspecialchars($investment['item_title'] ?? $investment['title'] ?? 'N/A', ENT_QUOTES); ?>
                                            </div>
                                            <div class="h6 mt-0 font-weight-bold text-dark">
                                                List Amount: <?php echo number_format((float)($investment['price'] ?? 0), 2, '.', ','); ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No investment requests available</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($investments['last_page']) && $investments['last_page'] > 1): ?>
                        <div class="row">
                            <div class="col-12">
                                <?php $paginationData = $investments; include __DIR__ . '/../partials/pagination.php'; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>
