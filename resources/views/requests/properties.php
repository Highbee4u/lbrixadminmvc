<?php $pageTitle = 'Property Requests'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Properties Request</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <?php if (!empty($properties['data']) && count($properties['data']) > 0): ?>
                            <?php foreach ($properties['data'] as $property): ?>
                                <!-- Property Request Card -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <a href="<?php echo url('requests/properties/' . htmlspecialchars($property['itemrequestid'] ?? '', ENT_QUOTES)); ?>" class="text-decoration-none">
                                        <div class="card h-180 w-100 py-2 mb-3" style="background: url('/img/question.png'); height: 240px; background-size: cover; background-position: center;">
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
                                                Title: <?php echo htmlspecialchars($property['item_title'] ?? $property['title'] ?? 'N/A', ENT_QUOTES); ?>
                                            </div>
                                            <div class="h6 mt-0 font-weight-bold text-dark">
                                                List Amount: <?php echo number_format((float)($property['price'] ?? 0), 2, '.', ','); ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-home fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No property requests available</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($properties['last_page']) && $properties['last_page'] > 1): ?>
                        <div class="row">
                            <div class="col-12">
                                <?php $paginationData = $properties; include __DIR__ . '/../partials/pagination.php'; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>
