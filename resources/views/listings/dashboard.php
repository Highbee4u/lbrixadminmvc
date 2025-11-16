<?php $pageTitle = 'Listings Dashboard'; ?>

<style>
.card-hover {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    cursor: pointer;
}
.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
}
a.text-decoration-none:hover {
    text-decoration: none !important;
}
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h6>Listings Dashboard</h6>
            <a class="btn btn-sm btn-outline-primary" href="<?php echo url('listings/new-properties'); ?>">New Properties</a>
        </div>
    </div>

        <div class="row">
        <?php
            $cards = [
                'New Properties' => ['data' => $stats['pendingProperties'] ?? ['totalnumber' => 0, 'totalamount' => 0], 'url' => 'listings/new-properties'],
                'Awaiting Inspections' => ['data' => $stats['awaitingProperties'] ?? ['totalnumber' => 0, 'totalamount' => 0], 'url' => 'listings/awaiting-inspection'],
                'Concluded Inspections' => ['data' => $stats['concludedProperties'] ?? ['totalnumber' => 0, 'totalamount' => 0], 'url' => 'listings/inspection-concluded'],
                'Rejected Properties' => ['data' => $stats['rejectedProperties'] ?? ['totalnumber' => 0, 'totalamount' => 0], 'url' => 'listings/inspection-rejected'],
                'Approved Properties' => ['data' => $stats['approvedProperties'] ?? ['totalnumber' => 0, 'totalamount' => 0], 'url' => 'listings/inspection-approved'],
                'Awaiting Listing' => ['data' => $stats['awaitingListingProperties'] ?? ['totalnumber' => 0, 'totalamount' => 0], 'url' => 'listings/awaiting-listing'],
                'Listed Properties' => ['data' => $stats['listedProperties'] ?? ['totalnumber' => 0, 'totalamount' => 0], 'url' => 'listings/listed'],
                'Closed Properties' => ['data' => $stats['closedProperties'] ?? ['totalnumber' => 0, 'totalamount' => 0], 'url' => 'listings/closed'],
            ];
            foreach ($cards as $label => $card): 
                $data = $card['data'];
                $url = url($card['url']);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="<?php echo htmlspecialchars($url, ENT_QUOTES); ?>" class="text-decoration-none">
                    <div class="card shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs text-primary text-uppercase mb-1"><?php echo htmlspecialchars($label, ENT_QUOTES); ?></div>
                                    <div class="h5 mb-0 text-gray-800"><?php echo (int)($data['totalnumber'] ?? 0); ?></div>
                                    <div class="h6 mb-0 text-gray-600">₦<?php echo number_format((float)($data['totalamount'] ?? 0), 2, '.', ','); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4">
        <h6>Active Offers</h6>
        <div class="row">
            <?php foreach (($offers ?? []) as $offer): ?>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?php echo url('listings/property-detail/' . ($offer['itemid'] ?? '')); ?>" class="text-decoration-none">
                        <div class="card dashboard-card card-hover">
                            <img src="<?php echo htmlspecialchars(Helpers::imageUrl($offer['picurl'] ?? 'img/default-property.jpg'), ENT_QUOTES); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($offer['title'] ?? 'Property', ENT_QUOTES); ?>">
                            <div class="card-body">
                                <p class="card-text text-dark">
                                    <strong>List Type:</strong> <?php echo htmlspecialchars($offer['bidtype'] ?? 'N/A', ENT_QUOTES); ?><br>
                                    <strong>Title:</strong> <?php echo htmlspecialchars($offer['title'] ?? 'N/A', ENT_QUOTES); ?><br>
                                    <strong>No. of Offers:</strong> <?php echo (int)($offer['bidcount'] ?? 0); ?><br>
                                    <strong>Average:</strong> ₦<?php echo number_format((float)($offer['averageoffer'] ?? 0), 2, '.', ','); ?><br>
                                    <strong>List Amount:</strong> ₦<?php echo number_format((float)($offer['price'] ?? 0), 2, '.', ','); ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="mt-4">
        <h6>Pending Properties</h6>
        <div class="row">
            <?php foreach (($recentPending ?? []) as $property): ?>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?php echo url('listings/property-detail/' . ($property['itemid'] ?? '')); ?>" class="text-decoration-none">
                        <div class="card dashboard-card card-hover">
                            <img src="<?php echo htmlspecialchars(Helpers::imageUrl($property['picurl'] ?? 'img/default-property.jpg'), ENT_QUOTES); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title'] ?? 'Property', ENT_QUOTES); ?>">
                            <div class="card-body">
                                <p class="card-text text-dark">
                                    <strong>List Type:</strong> <?php echo htmlspecialchars($property['bidtype'] ?? 'N/A', ENT_QUOTES); ?><br>
                                    <strong>Title:</strong> <?php echo htmlspecialchars($property['title'] ?? 'N/A', ENT_QUOTES); ?><br>
                                    <strong>Amount:</strong> ₦<?php echo number_format((float)($property['price'] ?? 0), 2, '.', ','); ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="mt-4">
        <h6>Awaiting Inspection</h6>
        <div class="row">
            <?php foreach (($recentAwaiting ?? []) as $property): ?>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?php echo url('listings/property-detail/' . ($property['itemid'] ?? '')); ?>" class="text-decoration-none">
                        <div class="card dashboard-card card-hover">
                            <img src="<?php echo htmlspecialchars(Helpers::imageUrl($property['picurl'] ?? 'img/default-property.jpg'), ENT_QUOTES); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title'] ?? 'Property', ENT_QUOTES); ?>">
                            <div class="card-body">
                                <p class="card-text text-dark">
                                    <strong>List Type:</strong> <?php echo htmlspecialchars($property['bidtype'] ?? 'N/A', ENT_QUOTES); ?><br>
                                    <strong>Title:</strong> <?php echo htmlspecialchars($property['title'] ?? 'N/A', ENT_QUOTES); ?><br>
                                    <strong>Inspection Lead:</strong> <?php echo htmlspecialchars($property['inspectionlead'] ?? 'N/A', ENT_QUOTES); ?><br>
                                    <strong>Insp Log Date:</strong> <?php echo !empty($property['inspectionstartdate']) ? date('d/m/Y', strtotime($property['inspectionstartdate'])) : 'N/A'; ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>
