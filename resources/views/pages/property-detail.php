<?php $pageTitle = 'Property Detail'; ?>
<?php include __DIR__ . '/../partials/topnav.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Property Detail</h6>
                        <a href="javascript:history.back()" class="btn btn-sm btn-primary">Go Back</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="accordion" id="accordionPropertyDetail">
                        <!-- Property Profile Section -->
                        <div class="card">
                            <div class="card-header bg-light" id="headingProfile">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text-dark font-weight-bold text-decoration-none w-100 d-flex justify-content-between align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfile" aria-expanded="false" aria-controls="collapseProfile">
                                        <span><i class="fas fa-info-circle me-2"></i>Property Profile</span>
                                        <i class="fas fa-chevron-down transition-all"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseProfile" class="collapse" aria-labelledby="headingProfile" data-bs-parent="#accordionPropertyDetail">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <h5 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">List Type: <?php
                                                $btid = $property['bidType']['bidtypeid'] ?? null;
                                                echo $btid === 1 ? 'Sell' : ($btid === 2 ? 'Let' : ($btid ? 'Lease Out' : 'N/A'));
                                            ?></h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</label>
                                                <p class="text-sm font-weight-normal"><?php echo htmlspecialchars($property['title'] ?? 'N/A', ENT_QUOTES); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</label>
                                                <p class="text-sm font-weight-normal"><?php echo htmlspecialchars($property['address'] ?? 'N/A', ENT_QUOTES); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</label>
                                                <p class="text-sm font-weight-normal"><?php echo !empty($property['price']) ? number_format((float)$property['price'], 2) . ' ' . htmlspecialchars($property['priceunit'] ?? '', ENT_QUOTES) : 'N/A'; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Seller</label>
                                                <p class="text-sm font-weight-normal"><?php echo !empty($property['seller']) ? htmlspecialchars(trim(($property['seller']['surname'] ?? '') . ' ' . ($property['seller']['firstname'] ?? '') . ' ' . ($property['seller']['middlename'] ?? '')), ENT_QUOTES) : 'N/A'; ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Coordinates</label>
                                                <p class="text-sm font-weight-normal"><?php echo (!empty($property['geolatitude']) && !empty($property['geolongitude'])) ? ($property['geolatitude'] . ', ' . $property['geolongitude']) : '0.0, 0.0'; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Seller Phone</label>
                                                <p class="text-sm font-weight-normal"><?php echo htmlspecialchars($property['seller']['phone'] ?? 'N/A', ENT_QUOTES); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Seller Email</label>
                                                <p class="text-sm font-weight-normal"><?php echo htmlspecialchars($property['seller']['email'] ?? 'N/A', ENT_QUOTES); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Attorney Name</label>
                                                <p class="text-sm font-weight-normal"><?php echo !empty($property['attorney']) ? htmlspecialchars(trim(($property['attorney']['surname'] ?? '') . ' ' . ($property['attorney']['firstname'] ?? '') . ' ' . ($property['attorney']['middlename'] ?? '')), ENT_QUOTES) : 'N/A'; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Attorney Phone</label>
                                                <p class="text-sm font-weight-normal"><?php echo htmlspecialchars($property['attorney']['phone'] ?? 'N/A', ENT_QUOTES); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Attorney Email</label>
                                                <p class="text-sm font-weight-normal"><?php echo htmlspecialchars($property['attorney']['email'] ?? 'N/A', ENT_QUOTES); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item Profiles Table -->
                                    <?php if (!empty($property['itemProfiles']) && count($property['itemProfiles']) > 0): ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive p-0">
                                                <table class="table align-items-center mb-0 table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Profile Title</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($property['itemProfiles'] as $profile): ?>
                                                        <tr>
                                                            <td class="text-wrap">
                                                                <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($profile['profileOption']['title'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                            </td>
                                                            <td class="text-wrap">
                                                                <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($profile['profilevalue'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Property Images Section -->
                        <div class="card">
                            <div class="card-header bg-light" id="headingImages">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text-dark font-weight-bold text-decoration-none w-100 d-flex justify-content-between align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImages" aria-expanded="false" aria-controls="collapseImages">
                                        <span><i class="fas fa-images me-2"></i>Property Images</span>
                                        <i class="fas fa-chevron-down transition-all"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseImages" class="collapse" aria-labelledby="headingImages" data-bs-parent="#accordionPropertyDetail">
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (!empty($property['itemPics'])): ?>
                                        <?php foreach ($property['itemPics'] as $pic): ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body p-2 text-center">
                                                    <?php if (!empty($pic['picurl'])): ?>
                                                        <img src="<?php echo htmlspecialchars(Helpers::imageUrl($pic['picurl']), ENT_QUOTES); ?>" class="img-fluid rounded mb-2" style="max-height: 150px;" alt="<?php echo htmlspecialchars($pic['pictitle'] ?? 'Property Image', ENT_QUOTES); ?>">
                                                        <?php if (!empty($pic['pictitle'])): ?>
                                                            <h6 class="text-sm font-weight-normal mb-0"><?php echo htmlspecialchars($pic['pictitle'], ENT_QUOTES); ?></h6>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <div class="text-center py-4">
                                                            <i class="fas fa-image fa-3x text-muted"></i>
                                                            <p class="text-sm text-muted mt-2">No Image</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <div class="col-12">
                                            <div class="text-center py-4">
                                                <i class="fas fa-images fa-3x text-muted"></i>
                                                <p class="text-sm text-secondary mb-0">No images available</p>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Property Documents Section -->
                        <div class="card">
                            <div class="card-header bg-light" id="headingDocuments">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text-dark font-weight-bold text-decoration-none w-100 d-flex justify-content-between align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDocuments" aria-expanded="false" aria-controls="collapseDocuments">
                                        <span><i class="fas fa-file-alt me-2"></i>Property Documents</span>
                                        <i class="fas fa-chevron-down transition-all"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseDocuments" class="collapse" aria-labelledby="headingDocuments" data-bs-parent="#accordionPropertyDetail">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0 table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Doc. Type</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Document</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($property['itemDocs'])): ?>
                                                <?php foreach ($property['itemDocs'] as $doc): ?>
                                                <tr>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($doc['itemDocType']['title'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <?php if (!empty($doc['docurl'])): ?>
                                                            <a href="<?php echo htmlspecialchars(url('/' . ltrim($doc['docurl'], '/')), ENT_QUOTES); ?>" target="_blank" class="btn btn-link text-primary btn-sm p-0">
                                                                <i class="fas fa-eye me-1"></i>View File
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-sm text-secondary">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($doc['docstatus'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center py-4">
                                                        <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                                                        <p class="text-sm text-secondary mb-0">No documents available</p>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Property Inspection Section -->
                        <div class="card">
                            <div class="card-header bg-light" id="headingInspection">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text-dark font-weight-bold text-decoration-none w-100 d-flex justify-content-between align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInspection" aria-expanded="false" aria-controls="collapseInspection">
                                        <span><i class="fas fa-search me-2"></i>Property Inspection</span>
                                        <i class="fas fa-chevron-down transition-all"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseInspection" class="collapse" aria-labelledby="headingInspection" data-bs-parent="#accordionPropertyDetail">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0 table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task ID</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inspect Date</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inspector</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($property['itemInspections'])): ?>
                                                <?php foreach ($property['itemInspections'] as $inspection): ?>
                                                <tr>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($inspection['inspectiontaskid'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo !empty($inspection['inspectiondate']) ? date('d/m/Y', strtotime($inspection['inspectiondate'])) : 'N/A'; ?></span>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <div class="text-sm font-weight-normal">
                                                            <strong>Name:</strong> <?php echo htmlspecialchars(($inspection['inspectby']['firstname'] ?? 'N/A') . ' ' . ($inspection['inspectby']['surname'] ?? ''), ENT_QUOTES); ?><br>
                                                            <strong>Phone:</strong> <?php echo htmlspecialchars($inspection['inspectby']['phone'] ?? 'N/A', ENT_QUOTES); ?><br>
                                                            <strong>Email:</strong> <?php echo htmlspecialchars($inspection['inspectby']['email'] ?? 'N/A', ENT_QUOTES); ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <?php $statusId = $inspection['statusid'] ?? null; $badge = ($statusId == 4 ? 'bg-success' : ($statusId == 5 ? 'bg-danger' : 'bg-warning')); ?>
                                                        <span class="badge badge-sm <?php echo $badge; ?>">
                                                            <?php echo htmlspecialchars($inspection['status'] ?? 'N/A', ENT_QUOTES); ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <div class="text-sm font-weight-normal">
                                                            <strong>Note:</strong> <?php echo htmlspecialchars($inspection['note'] ?? 'N/A', ENT_QUOTES); ?><br>
                                                            <strong>Address:</strong> <?php echo htmlspecialchars($inspection['address'] ?? 'N/A', ENT_QUOTES); ?><br>
                                                            <strong>Landmark:</strong> <?php echo htmlspecialchars($inspection['landmark'] ?? 'N/A', ENT_QUOTES); ?><br>
                                                            <strong>Contact:</strong> <?php echo htmlspecialchars($inspection['contactperson'] ?? 'N/A', ENT_QUOTES); ?><br>
                                                            <strong>Charting:</strong> <?php echo htmlspecialchars($inspection['chartinginfo'] ?? 'N/A', ENT_QUOTES); ?><br>
                                                            <strong>Title Verified:</strong> <?php echo htmlspecialchars($inspection['titleverified'] ?? 'N/A', ENT_QUOTES); ?><br>
                                                            <?php
                                                                $geo = $inspection['geolocation'] ?? '';
                                                                $parts = explode(',', $geo);
                                                                $lat = trim($parts[1] ?? '0');
                                                                $lng = trim($parts[0] ?? '0');
                                                            ?>
                                                            <strong>Geo Location:</strong>
                                                            <?php if (!empty($geo)): ?>
                                                                <a target="_blank" href="https://maps.google.com/?q=<?php echo htmlspecialchars($lat, ENT_QUOTES); ?>,<?php echo htmlspecialchars($lng, ENT_QUOTES); ?>" class="text-primary"><?php echo htmlspecialchars($geo, ENT_QUOTES); ?></a>
                                                            <?php else: ?>
                                                                N/A
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <i class="fas fa-search fa-2x text-muted mb-2"></i>
                                                        <p class="text-sm text-secondary mb-0">No inspections available</p>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <?php $status = $property['itemstatusid'] ?? null; ?>
                                            <?php if ($status == 3 || $status == 5): ?>
                                                <button type="button" class="btn btn-success btn-sm me-2" onclick="approveProperty(<?php echo (int)($property['itemid'] ?? 0); ?>)">
                                                    <i class="fas fa-check me-1"></i>Approve
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($status == 3 || $status == 4): ?>
                                                <button type="button" class="btn btn-danger btn-sm me-2" onclick="rejectProperty(<?php echo (int)($property['itemid'] ?? 0); ?>)">
                                                    <i class="fas fa-times me-1"></i>Reject
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($status == 3 || $status == 4 || $status == 5): ?>
                                                <button type="button" class="btn btn-warning btn-sm" onclick="reinspectProperty(<?php echo (int)($property['itemid'] ?? 0); ?>)">
                                                    <i class="fas fa-redo me-1"></i>Reinspect
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Offers Section -->
                        <div class="card">
                            <div class="card-header bg-light" id="headingOffers">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text-dark font-weight-bold text-decoration-none w-100 d-flex justify-content-between align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOffers" aria-expanded="false" aria-controls="collapseOffers">
                                        <span><i class="fas fa-handshake me-2"></i>Offers</span>
                                        <i class="fas fa-chevron-down transition-all"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOffers" class="collapse" aria-labelledby="headingOffers" data-bs-parent="#accordionPropertyDetail">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0 table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bidder</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Note</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Duration</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terms</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($property['itemBids'])): ?>
                                                <?php foreach ($property['itemBids'] as $bid): ?>
                                                <tr>
                                                    <td class="text-wrap">
                                                        <?php $status = $property['itemstatusid'] ?? null; ?>
                                                        <?php if ($status == 10): ?>
                                                            <?php if (!empty($property['itembidid']) && !empty($bid['itembidid']) && $property['itembidid'] == $bid['itembidid']): ?>
                                                                <span class="badge bg-success">Selected</span>
                                                            <?php else: ?>
                                                                <button type="button" class="btn btn-primary btn-sm me-1" onclick="selectBid(<?php echo (int)($property['itemid'] ?? 0); ?>, <?php echo (int)($bid['itembidid'] ?? 0); ?>)">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="cancelBid(<?php echo (int)($property['itemid'] ?? 0); ?>, <?php echo (int)($bid['itembidid'] ?? 0); ?>)">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo !empty($bid['bidder']) ? htmlspecialchars(trim(($bid['bidder']['surname'] ?? '') . ' ' . ($bid['bidder']['firstname'] ?? '') . ' ' . ($bid['bidder']['middlename'] ?? '')), ENT_QUOTES) : 'N/A'; ?></span>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($bid['note'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo !empty($bid['proposedamount']) ? number_format((float)$bid['proposedamount'], 2) : 'N/A'; ?></span>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($bid['serviceduration'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                    </td>
                                                    <td class="text-wrap">
                                                        <span class="text-sm font-weight-normal"><?php echo htmlspecialchars($bid['paymentterms'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                    </td>
                                                    
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <i class="fas fa-handshake fa-2x text-muted mb-2"></i>
                                                        <p class="text-sm text-secondary mb-0">No offers available</p>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Offer Action Buttons -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <?php
                                                $status = $property['itemstatusid'] ?? null;
                                                $activeBidsCount = 0;
                                                if (!empty($property['itemBids'])) {
                                                    foreach ($property['itemBids'] as $b) { if (($b['status'] ?? null) == 1) { $activeBidsCount++; } }
                                                }
                                            ?>
                                            <?php if ($status == 10 && $activeBidsCount > 0): ?>
                                                <button type="button" class="btn btn-success btn-sm me-2" onclick="confirmOffer(<?php echo (int)($property['itemid'] ?? 0); ?>)">
                                                    <i class="fas fa-check-circle me-1"></i>Confirm Offer
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($status == 4 || $status == 10): ?>
                                                <button type="button" class="btn btn-info btn-sm me-2" onclick="keepForListing(<?php echo (int)($property['itemid'] ?? 0); ?>)">
                                                    <i class="fas fa-list me-1"></i>Keep for Listing
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($status == 4 || $status == 9): ?>
                                                <button type="button" class="btn btn-primary btn-sm me-2" onclick="listProperty(<?php echo (int)($property['itemid'] ?? 0); ?>)">
                                                    <i class="fas fa-upload me-1"></i>List
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($status == 15 && $activeBidsCount > 0): ?>
                                                <button type="button" class="btn btn-danger btn-sm me-2" onclick="closeOffer(<?php echo (int)($property['itemid'] ?? 0); ?>)">
                                                    <i class="fas fa-times-circle me-1"></i>Close Offer
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($status == 15): ?>
                                                <button type="button" class="btn btn-warning btn-sm" onclick="cancelOffer(<?php echo (int)($property['itemid'] ?? 0); ?>)">
                                                    <i class="fas fa-ban me-1"></i>Cancel Offer
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
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

<style>
.accordion-button:focus {
    box-shadow: none;
    border: none;
}

.accordion-button:not(.collapsed) .fa-chevron-down {
    transform: rotate(180deg);
}

.transition-all {
    transition: transform 0.3s ease;
}

.card-header.bg-light {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #dee2e6;
}

.card-header.bg-light .accordion-button {
    background-color: transparent !important;
    border: none !important;
    box-shadow: none !important;
}

.card-header.bg-light .accordion-button:hover {
    background-color: rgba(0, 0, 0, 0.05) !important;
}
</style>

<script>
// NOTE: These endpoints must exist on the backend for full functionality.
// If not yet implemented, these will fail. Adjust URLs if your routes differ.
function approveProperty(itemId) {
    if (confirm('Are you sure you want to approve this property?')) {
        fetch(`<?php echo url('listings/properties/approve'); ?>/` + itemId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to approve property'); }
        }).catch(err => { console.error(err); alert('An error occurred while approving the property'); });
    }
}

function rejectProperty(itemId) {
    if (confirm('Are you sure you want to reject this property?')) {
        fetch(`<?php echo url('listings/properties/reject'); ?>/` + itemId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to reject property'); }
        }).catch(err => { console.error(err); alert('An error occurred while rejecting the property'); });
    }
}

function reinspectProperty(itemId) {
    if (confirm('Are you sure you want to reinspect this property?')) {
        fetch(`<?php echo url('listings/properties/reinspect'); ?>/` + itemId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to send property for reinspection'); }
        }).catch(err => { console.error(err); alert('An error occurred while sending property for reinspection'); });
    }
}

function selectBid(itemId, bidId) {
    if (confirm('Are you sure you want to select this offer?')) {
        fetch(`<?php echo url('listings/properties/select-bid'); ?>/` + itemId + '/' + bidId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to select bid'); }
        }).catch(err => { console.error(err); alert('An error occurred while selecting the bid'); });
    }
}

function cancelBid(itemId, bidId) {
    if (confirm('Are you sure you want to cancel this offer?')) {
        fetch(`<?php echo url('listings/properties/cancel-bid'); ?>/` + itemId + '/' + bidId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to cancel bid'); }
        }).catch(err => { console.error(err); alert('An error occurred while cancelling the bid'); });
    }
}

function confirmOffer(itemId) {
    if (confirm('Are you sure you want to confirm the selected offer?')) {
        fetch(`<?php echo url('listings/properties/confirm-offer'); ?>/` + itemId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to confirm offer'); }
        }).catch(err => { console.error(err); alert('An error occurred while confirming the offer'); });
    }
}

function keepForListing(itemId) {
    if (confirm('Are you sure you want to keep this offer for listing?')) {
        fetch(`<?php echo url('listings/properties/keep-for-listing-action'); ?>/` + itemId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to keep property for listing'); }
        }).catch(err => { console.error(err); alert('An error occurred while keeping property for listing'); });
    }
}

function listProperty(itemId) {
    if (confirm('Are you sure you want to list this property?')) {
        fetch(`<?php echo url('listings/properties/list-property-action'); ?>/` + itemId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to list property'); }
        }).catch(err => { console.error(err); alert('An error occurred while listing the property'); });
    }
}

function closeOffer(itemId) {
    if (confirm('Are you sure you want to close the selected offer?')) {
        fetch(`<?php echo url('listings/properties/close-offer-action'); ?>/` + itemId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to close offer'); }
        }).catch(err => { console.error(err); alert('An error occurred while closing the offer'); });
    }
}

function cancelOffer(itemId) {
    if (confirm('Are you sure you want to cancel the selected offer?')) {
        fetch(`<?php echo url('listings/properties/cancel-offer-action'); ?>/` + itemId, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); } else { alert('Failed to cancel offer'); }
        }).catch(err => { console.error(err); alert('An error occurred while cancelling the offer'); });
    }
}
</script>
