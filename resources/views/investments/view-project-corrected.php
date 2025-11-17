<?php $pageTitle = 'Project detail'; ?>

<div class="main-content">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">
                                    <i class="fas fa-eye text-primary me-2"></i>View Investment Project
                                </h3>
                            </div>
                            <div class="col text-end">
                                <a href="javascript:history.back()" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Back
                                </a>
                                <?php if ($project['itemstatusid'] < 10): ?>
                                    <a href="/investments/edit-project?id=<?php echo htmlspecialchars($project['itemid'], ENT_QUOTES); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-1"></i>Edit Project
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Card body -->
                    <div class="card-body">
                        <div class="accordion" id="projectAccordion">
                            <!-- Profile Accordion Item (Default Open) -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingProfile">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfile" aria-expanded="true" aria-controls="collapseProfile" style="background-color: #f8f9fa;">
                                        <i class="fas fa-info-circle me-2"></i>Profile
                                    </button>
                                </h2>
                                <div id="collapseProfile" class="accordion-collapse collapse show" aria-labelledby="headingProfile" data-bs-parent="#projectAccordion">
                                    <div class="accordion-body">
                                        <h6 class="heading-small text-muted mb-4">Project Information</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label text-dark fw-bold">Title</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['title'] ?? '', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Address</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['address'] ?? '', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Price</label>
                                                    <p class="mb-0"><?php echo isset($project['price']) ? number_format($project['price'], 2, '.', ',') : 'N/A'; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Financee (Project Owner)</label>
                                                    <p class="mb-0"><?php echo isset($project['financee']) ? htmlspecialchars(trim(($project['financee']['surname'] ?? '') . ' ' . ($project['financee']['firstname'] ?? '') . ' ' . ($project['financee']['middlename'] ?? '')), ENT_QUOTES) : 'N/A'; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Coordinate</label>
                                                    <p class="mb-0"><?php echo isset($project['geolatitude'], $project['geolongitude']) ? htmlspecialchars($project['geolatitude'] . ', ' . $project['geolongitude'], ENT_QUOTES) : '0.0, 0.0'; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Financee's Phone</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['financee']['phone'] ?? 'N/A', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Financee Email</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['financee']['email'] ?? 'N/A', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Project Scale</label>
                                                    <p class="mb-0">
                                                        <?php
                                                        $projectscale = "";
                                                        if (isset($project['price'])) {
                                                            if ($project['price'] < 100000000) {
                                                                $projectscale = "Small Scale";
                                                            } elseif ($project['price'] > 100000000 && $project['price'] < 500000000) {
                                                                $projectscale = "Medium Scale";
                                                            } elseif ($project['price'] > 500000000) {
                                                                $projectscale = "Large Scale";
                                                            }
                                                        }
                                                        echo $projectscale ?: '--';
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Price Range</label>
                                                    <p class="mb-0"><?php echo isset($project['minprice'], $project['maxprice']) ? number_format($project['minprice'], 2, '.', ',') . " - " . number_format($project['maxprice'], 2, '.', ',') : "0.00 - 0.00"; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Number of Investors</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['investOption']['title'] ?? '--', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Unit of Investment</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['investunit'] ?? '0', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Tenure Investment</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['tenure'] ?? '--', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Return Investment</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['investreturns'] ?? '-', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Attorney Name</label>
                                                    <p class="mb-0"><?php echo isset($project['attorney']) ? htmlspecialchars(trim(($project['attorney']['surname'] ?? '') . ' ' . ($project['attorney']['firstname'] ?? '') . ' ' . ($project['attorney']['middlename'] ?? '')), ENT_QUOTES) : 'N/A'; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Attorney Phone</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['attorney']['phone'] ?? 'N/A', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Attorney Email</label>
                                                    <p class="mb-0"><?php echo htmlspecialchars($project['attorney']['email'] ?? 'N/A', ENT_QUOTES); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label fw-bold">Description</label>
                                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($project['description'] ?? '', ENT_QUOTES)); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <h6 class="heading-small text-muted mb-4">Location & Coordinates</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Location</label>
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($project['itemlocation'] ?? 'N/A', ENT_QUOTES); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">State</label>
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($project['state']['title'] ?? 'N/A', ENT_QUOTES); ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Latitude</label>
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($project['itemlat'] ?? 'N/A', ENT_QUOTES); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Longitude</label>
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($project['itemlong'] ?? 'N/A', ENT_QUOTES); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Altitude</label>
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($project['itemalt'] ?? 'N/A', ENT_QUOTES); ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-4" />

                                        <h6 class="heading-small text-muted mb-4">Project Scale</h6>
                                        <?php
                                        $projectScale = 0;
                                        if (isset($project['itemProfiles']) && !empty($project['itemProfiles'])) {
                                            foreach ($project['itemProfiles'] as $profile) {
                                                if (isset($profile['quantity']) && isset($profile['unitrate'])) {
                                                    $projectScale += floatval($profile['quantity']) * floatval($profile['unitrate']);
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="alert alert-info">
                                                    <strong>Total Project Scale:</strong> <?php echo number_format($projectScale, 2); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Profile Options Table -->
                                        <?php if (isset($project['itemProfiles']) && !empty($project['itemProfiles'])): ?>
                                            <div class="table-responsive mt-3">
                                                <table class="table align-items-center table-flush table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col">Profile Option</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Unit Rate</th>
                                                            <th scope="col">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($project['itemProfiles'] as $profile): ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="fas fa-cube text-primary me-2"></i>
                                                                        <span><?php echo htmlspecialchars($profile['profileOption']['title'] ?? 'N/A', ENT_QUOTES); ?></span>
                                                                    </div>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($profile['quantity'] ?? '0', ENT_QUOTES); ?></td>
                                                                <td><?php echo number_format($profile['unitrate'] ?? 0, 2); ?></td>
                                                                <td>
                                                                    <strong><?php echo number_format((floatval($profile['quantity'] ?? 0) * floatval($profile['unitrate'] ?? 0)), 2); ?></strong>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-center py-3">
                                                <p class="text-muted">No profile options available</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Images Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingImages">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImages" aria-expanded="false" aria-controls="collapseImages" style="background-color: #f8f9fa;">
                                        <i class="fas fa-images me-2"></i>Images
                                    </button>
                                </h2>
                                <div id="collapseImages" class="accordion-collapse collapse" aria-labelledby="headingImages" data-bs-parent="#projectAccordion">
                                    <div class="accordion-body">
                                        <h6 class="heading-small text-muted mb-4">Project Images</h6>
                                        <div class="row">
                                            <?php if (isset($project['itemPics']) && !empty($project['itemPics'])): ?>
                                                <?php foreach ($project['itemPics'] as $pic): ?>
                                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                                        <div class="card">
                                                            <a target="_blank" href="<?php echo htmlspecialchars(Helpers::imageUrl($pic['picurl']), ENT_QUOTES); ?>">
                                                                <img src="<?php echo htmlspecialchars(Helpers::imageUrl($pic['picurl']), ENT_QUOTES); ?>" class="card-img-top" alt="Project Image" style="height: 200px; object-fit: cover;">
                                                            </a>
                                                            <div class="card-body p-2">
                                                                <h6 class="card-title text-sm"><?php echo htmlspecialchars($pic['pictitle'], ENT_QUOTES); ?></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="col-12">
                                                    <div class="text-center py-5">
                                                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">No images available</p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingDocuments">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDocuments" aria-expanded="false" aria-controls="collapseDocuments" style="background-color: #f8f9fa;">
                                        <i class="fas fa-file-alt me-2"></i>Documents
                                    </button>
                                </h2>
                                <div id="collapseDocuments" class="accordion-collapse collapse" aria-labelledby="headingDocuments" data-bs-parent="#projectAccordion">
                                    <div class="accordion-body">
                                        <h6 class="heading-small text-muted mb-4">Project Documents</h6>
                                        <div class="row">
                                            <?php if (isset($project['itemDocs']) && !empty($project['itemDocs'])): ?>
                                                <div class="table-responsive">
                                                    <table class="table align-items-center table-flush table-striped">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col">Document Type</th>
                                                                <th scope="col">File</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Entry Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($project['itemDocs'] as $doc): ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fas fa-file-alt text-primary me-2"></i>
                                                                            <span><?php echo htmlspecialchars($doc['itemDocType']['title'] ?? 'Document', ENT_QUOTES); ?></span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/storage/<?php echo htmlspecialchars($doc['docurl'], ENT_QUOTES); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                            <i class="fas fa-eye me-1"></i>View File
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge <?php echo $doc['docstatus'] ? 'bg-success' : 'bg-secondary'; ?>">
                                                                            <?php echo $doc['docstatus'] ? 'Visible' : 'Hidden'; ?>
                                                                        </span>
                                                                    </td>
                                                                    <td><?php echo isset($doc['entrydate']) ? date('d/m/Y', strtotime($doc['entrydate'])) : 'N/A'; ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php else: ?>
                                                <div class="col-12">
                                                    <div class="text-center py-5">
                                                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">No documents available</p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inspection Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingInspection">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInspection" aria-expanded="false" aria-controls="collapseInspection" style="background-color: #f8f9fa;">
                                        <i class="fas fa-search me-2"></i>Inspection
                                    </button>
                                </h2>
                                <div id="collapseInspection" class="accordion-collapse collapse" aria-labelledby="headingInspection" data-bs-parent="#projectAccordion">
                                    <div class="accordion-body">
                                        <h6 class="heading-small text-muted mb-4">Project Inspection</h6>
                                        <div class="row">
                                            <?php if (isset($project['inspectionTasks']) && !empty($project['inspectionTasks'])): ?>
                                                <div class="table-responsive">
                                                    <table class="table align-items-center table-flush table-striped">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col">Actions</th>
                                                                <th scope="col">Task ID</th>
                                                                <th scope="col">Inspection Date</th>
                                                                <th scope="col">Inspector</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Note</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($project['inspectionTasks'] as $task): ?>
                                                                <tr>
                                                                             <td>
                                                                        <div class="btn-group" role="group">
                                                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="actionDropdown<?php echo $task['inspectiontaskid']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="fas fa-ellipsis-v"></i>
                                                                            </button>
                                                                           <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo $task['inspectiontaskid'] ?? ''; ?>">

                                                                               <?php
                                                                                   $projectId     = htmlspecialchars($project['itemid'] ?? '', ENT_QUOTES);
                                                                                   $inspectionId  = htmlspecialchars($task['inspectiontaskid'] ?? '', ENT_QUOTES);

                                                                                   $statusId      = $task['statusid'] ?? null; // <-- prevents undefined index

                                                                                   // CORRECTED: Use the same URL pattern as other working links in this file
                                                                                   $approveUrl = '/investments/view-project?id=' . $projectId . '&inspectionid=' . $inspectionId . '&approvestatus=4';
                                                                                   $rejectUrl  = '/investments/view-project?id=' . $projectId . '&inspectionid=' . $inspectionId . '&approvestatus=5';

                                                                                   // Disable logic safely
                                                                                   $disableApprove = ($statusId !== null && $statusId > 1 && $statusId != 4) ? 'disabled' : '';
                                                                                   $disableReject  = ($statusId !== null && $statusId > 1 && $statusId != 5) ? 'disabled' : '';
                                                                               ?>

                                                                               <li>
                                                                                   <a class="dropdown-item <?php echo $disableApprove; ?>" href="<?php echo $approveUrl; ?>">
                                                                                       Approve
                                                                                   </a>
                                                                               </li>

                                                                               <li>
                                                                                   <a class="dropdown-item <?php echo $disableReject; ?>" href="<?php echo $rejectUrl; ?>">
                                                                                       Reject
                                                                                   </a>
                                                                               </li>

                                                                           </ul>


                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge bg-primary"><?php echo htmlspecialchars($task['inspectiontaskid'], ENT_QUOTES); ?></span>
                                                                    </td>
                                                                    <td><?php echo isset($task['inspectiondate']) ? date('d/m/Y', strtotime($task['inspectiondate'])) : 'N/A'; ?></td>
                                                                    <td><?php echo isset($task['inspectionLead']) ? htmlspecialchars(trim(($task['inspectionLead']['surname'] ?? '') . ' ' . ($task['inspectionLead']['firstname'] ?? '') . ' ' . ($task['inspectionLead']['middlename'] ?? '')), ENT_QUOTES) : 'N/A'; ?></td>
                                                                    <td>
                                                                        <span class="badge <?php echo isset($task['inspectionStatus']) ? 'bg-info' : 'bg-secondary'; ?>">
                                                                            <?php echo isset($task['inspectionStatus']) ? htmlspecialchars($task['inspectionStatus']['title'], ENT_QUOTES) : 'N/A'; ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span title="<?php echo htmlspecialchars($task['note'] ?? '', ENT_QUOTES); ?>">
                                                                            <?php 
                                                                            $note = $task['note'] ?? '';
                                                                            echo htmlspecialchars(strlen($note) > 30 ? substr($note, 0, 30) . '...' : $note, ENT_QUOTES); 
                                                                            ?>
                                                                        </span>
                                                                    </td>
                                                           
                                                                </tr>
                                                                <?php if (isset($task['inspectionTaskTeam']) && !empty($task['inspectionTaskTeam'])): ?>
                                                                    <tr>
                                                                        <td colspan="6" class="bg-light">
                                                                            <small class="text-muted"><strong>Team Members:</strong></small>
                                                                            <div class="mt-1">
                                                                                <?php foreach ($task['inspectionTaskTeam'] as $teamMember): ?>
                                                                                    <span class="badge bg-light text-dark me-1">
                                                                                        <?php echo isset($teamMember['user']) ? htmlspecialchars(trim(($teamMember['user']['surname'] ?? '') . ' ' . ($teamMember['user']['firstname'] ?? '') . ' ' . ($teamMember['user']['middlename'] ?? '')), ENT_QUOTES) : 'N/A'; ?>
                                                                                    </span>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php else: ?>
                                                <div class="col-12">
                                                    <div class="text-center py-5">
                                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">No inspection tasks available</p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Investors Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingInvestors">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInvestors" aria-expanded="false" aria-controls="collapseInvestors" style="background-color: #f8f9fa;">
                                        <i class="fas fa-users me-2"></i>Investors
                                    </button>
                                </h2>
                                <div id="collapseInvestors" class="accordion-collapse collapse" aria-labelledby="headingInvestors" data-bs-parent="#projectAccordion">
                                    <div class="accordion-body">
                                        <h6 class="heading-small text-muted mb-4">Project Investors</h6>
                                        <div class="row">
                                            <?php if (isset($project['itemBids']) && !empty($project['itemBids'])): ?>
                                                <div class="table-responsive">
                                                    <table class="table align-items-center table-flush table-striped">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col">Actions</th>
                                                                <th scope="col">Investor</th>
                                                                <th scope="col">Investment Amount</th>
                                                                <th scope="col">Duration</th>
                                                                <th scope="col">Payment Terms</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($project['itemBids'] as $bid): ?>
                                                                <tr>
                                                                                                                                        <td>
                                                                        <?php if ($project['itemstatusid'] == 10): ?>
                                                                            <div class="btn-group" role="group">
                                                                                <?php if ($bid['status'] != 1): ?>
                                                                                    <a class="btn btn-sm btn-success" 
                                                                                       href="/investments/view-project?id=<?php echo htmlspecialchars($project['itemid'], ENT_QUOTES); ?>&setbidstatus=1&itembidid=<?php echo htmlspecialchars($bid['itembidid'], ENT_QUOTES); ?>" 
                                                                                       onclick="return confirm('Are you sure you want to confirm this investment offer?')">
                                                                                        <i class="fas fa-check"></i> Confirm
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                                <?php if ($bid['status'] != -1): ?>
                                                                                    <a class="btn btn-sm btn-danger" 
                                                                                       href="/investments/view-project?id=<?php echo htmlspecialchars($project['itemid'], ENT_QUOTES); ?>&setbidstatus=-1&itembidid=<?php echo htmlspecialchars($bid['itembidid'], ENT_QUOTES); ?>" 
                                                                                       onclick="return confirm('Are you sure you want to reject this investment offer?')">
                                                                                        <i class="fas fa-times"></i> Reject
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        <?php else: ?>
                                                                            <span class="text-muted">N/A</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar avatar-sm me-3">
                                                                                <i class="fas fa-user text-primary"></i>
                                                                            </div>
                                                                            <div>
                                                                                <span class="fw-bold"><?php echo isset($bid['bidder']) ? htmlspecialchars(trim(($bid['bidder']['surname'] ?? '') . ' ' . ($bid['bidder']['firstname'] ?? '') . ' ' . ($bid['bidder']['middlename'] ?? '')), ENT_QUOTES) : 'N/A'; ?></span>
                                                                                <?php if (isset($bid['note']) && !empty($bid['note'])): ?>
                                                                                    <br><small class="text-muted">
                                                                                        <?php 
                                                                                        $bidNote = $bid['note'];
                                                                                        echo htmlspecialchars(strlen($bidNote) > 50 ? substr($bidNote, 0, 50) . '...' : $bidNote, ENT_QUOTES); 
                                                                                        ?>
                                                                                    </small>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span class="fw-bold text-success"><?php echo number_format($bid['proposedamount'], 2); ?></span>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($bid['serviceduration'] ?? 'N/A', ENT_QUOTES); ?></td>
                                                                    <td><?php echo htmlspecialchars($bid['paymentterms'] ?? 'N/A', ENT_QUOTES); ?></td>
                                                                    <td>
                                                                        <?php if ($bid['status'] == 1): ?>
                                                                            <span class="badge bg-success">Confirmed</span>
                                                                        <?php elseif ($bid['status'] == -1): ?>
                                                                            <span class="badge bg-danger">Rejected</span>
                                                                        <?php else: ?>
                                                                            <span class="badge bg-warning">Pending</span>
                                                                        <?php endif; ?>
                                                                    </td>

                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Project Action Buttons -->
                                                <div class="row mt-4">
                                                    <div class="col-12">
                                                        <div class="d-flex gap-2 flex-wrap">
                                                            <a class="btn btn-primary <?php echo $project['itemstatusid'] != 10 ? 'disabled' : ''; ?>" 
                                                               href="<?php echo $project['itemstatusid'] != 10 ? '#' : '/investments/view-project?id=' . htmlspecialchars($project['itemid'], ENT_QUOTES) . '&setstatus=15'; ?>" 
                                                               onclick="return confirm('Are you sure you want to confirm selected offer for this project?')">
                                                                <i class="fas fa-check-circle me-2"></i>Confirm Selected Investor
                                                            </a>
                                                            <a class="btn btn-outline-primary <?php echo ($project['itemstatusid'] != 4 && $project['itemstatusid'] != 10) ? 'disabled' : ''; ?>" 
                                                               href="<?php echo ($project['itemstatusid'] != 4 && $project['itemstatusid'] != 10) ? '#' : '/investments/view-project?id=' . htmlspecialchars($project['itemid'], ENT_QUOTES) . '&setstatus=9&setbidid=0'; ?>" 
                                                               onclick="return confirm('Are you sure you want to keep this project for listing?')">
                                                                <i class="fas fa-list me-2"></i>Keep for Listing
                                                            </a>
                                                            <a class="btn btn-outline-success <?php echo ($project['itemstatusid'] != 4 && $project['itemstatusid'] != 9) ? 'disabled' : ''; ?>" 
                                                               href="<?php echo ($project['itemstatusid'] != 4 && $project['itemstatusid'] != 9) ? '#' : '/investments/view-project?id=' . htmlspecialchars($project['itemid'], ENT_QUOTES) . '&setstatus=10'; ?>" 
                                                               onclick="return confirm('Are you sure you want to list this project?')">
                                                                <i class="fas fa-upload me-2"></i>List Project
                                                            </a>
                                                            <a class="btn btn-outline-danger <?php echo ($project['itemstatusid'] >= 10 && $project['itemstatusid'] != 20) ? '' : 'disabled'; ?>" 
                                                               href="<?php echo ($project['itemstatusid'] >= 10 && $project['itemstatusid'] != 20) ? '/investments/view-project?id=' . htmlspecialchars($project['itemid'], ENT_QUOTES) . '&setstatus=20' : '#'; ?>" 
                                                               onclick="return confirm('Are you sure you want to close this project?')">
                                                                <i class="fas fa-times-circle me-2"></i>Close Project
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="col-12">
                                                    <div class="text-center py-5">
                                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">No investors available</p>
                                                    </div>
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
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Replace all onclick confirm dialogs with SweetAlert2
    $('a[onclick]').each(function() {
        const $link = $(this);
        const href = $link.attr('href');
        const onclickAttr = $link.attr('onclick');
        
        // Skip if href is # or javascript:
        if (href === '#' || href.startsWith('javascript:') || !href) {
            return;
        }
        
        // Extract message from onclick="return confirm('message')"
        const confirmMatch = onclickAttr.match(/confirm\('(.+?)'\)/);
        if (!confirmMatch) {
            return;
        }
        
        const message = confirmMatch[1];
        
        // Remove onclick attribute
        $link.removeAttr('onclick');
        
        // Add new click handler with SweetAlert2
        $link.on('click', function(e) {
            e.preventDefault();
            
            // Determine icon and button color based on action
            let icon = 'question';
            let confirmButtonColor = '#3085d6';
            let confirmButtonText = 'Yes, proceed';
            
            if (message.toLowerCase().includes('reject')) {
                icon = 'warning';
                confirmButtonColor = '#d33';
                confirmButtonText = 'Yes, reject';
            } else if (message.toLowerCase().includes('approve') || message.toLowerCase().includes('confirm')) {
                icon = 'success';
                confirmButtonColor = '#28a745';
                confirmButtonText = 'Yes, confirm';
            } else if (message.toLowerCase().includes('close')) {
                icon = 'warning';
                confirmButtonColor = '#ffc107';
                confirmButtonText = 'Yes, close';
            } else if (message.toLowerCase().includes('list')) {
                icon = 'info';
                confirmButtonColor = '#17a2b8';
                confirmButtonText = 'Yes, list';
            }
            
            Swal.fire({
                title: 'Confirm Action',
                text: message,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Navigate to the URL
                    window.location.href = href;
                }
            });
        });
    });
    
    // Check for success/error messages from server (if any)
    <?php if (isset($_SESSION['success_message'])): ?>
        toastr.success('<?php echo addslashes($_SESSION['success_message']); ?>');
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        toastr.error('<?php echo addslashes($_SESSION['error_message']); ?>');
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
});
</script>

<?php
// Include footer
include __DIR__ . '/../partials/footer.php';
?>