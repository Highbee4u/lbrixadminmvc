<div class="container-fluid py-4">
    <!-- Properties Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-3" style="color: white">Properties</h3>
        </div>
    </div>
    
    <!-- Properties Row 1 -->
    <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">New Properties</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $pendingproperties ? $pendingproperties->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $pendingproperties ? number_format((float)($pendingproperties->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">AWT Inspection</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $awaitingproperties ? $awaitingproperties->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $awaitingproperties ? number_format((float)($awaitingproperties->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Concluded</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $concludedinspproperties ? $concludedinspproperties->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $concludedinspproperties ? number_format((float)($concludedinspproperties->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Rejected</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $rejectedproperties ? $rejectedproperties->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $rejectedproperties ? number_format((float)($rejectedproperties->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-fat-remove text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Properties Row 2 -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Approved</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $approvedproperties ? $approvedproperties->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $approvedproperties ? number_format((float)($approvedproperties->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="ni ni-like-2 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">AWT Listing</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $awaitinglistingproperties ? $awaitinglistingproperties->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $awaitinglistingproperties ? number_format((float)($awaitinglistingproperties->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-collection text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Listed</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $listedproperties ? $listedproperties->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $listedproperties ? number_format((float)($listedproperties->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-shop text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Closed</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $closedproperties ? $closedproperties->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $closedproperties ? number_format((float)($closedproperties->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-dark shadow-dark text-center rounded-circle">
                                    <i class="ni ni-lock-circle-open text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Section -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-3">Projects</h3>
            </div>
        </div>

        <!-- Projects Row 1 -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">New Projects</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $pendingprojects ? $pendingprojects->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $pendingprojects ? number_format((float)($pendingprojects->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">AWT Inspection</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $awaitingprojects ? $awaitingprojects->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $awaitingprojects ? number_format((float)($awaitingprojects->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Concluded</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $concludedinspprojects ? $concludedinspprojects->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $concludedinspprojects ? number_format((float)($concludedinspprojects->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Rejected</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $rejectedprojects ? $rejectedprojects->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $rejectedprojects ? number_format((float)($rejectedprojects->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-fat-remove text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Row 2 -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Approved</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $approvedprojects ? $approvedprojects->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $approvedprojects ? number_format((float)($approvedprojects->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="ni ni-like-2 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">AWT Listing</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $awaitinglistingprojects ? $awaitinglistingprojects->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $awaitinglistingprojects ? number_format((float)($awaitinglistingprojects->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-collection text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Listed</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $listedprojects ? $listedprojects->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $listedprojects ? number_format((float)($listedprojects->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-shop text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Closed</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        <?php echo $closedprojects ? $closedprojects->totalnumber : 0; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-sm">₦<?php echo $closedprojects ? number_format((float)($closedprojects->totalamount ?? 0), 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-dark shadow-dark text-center rounded-circle">
                                    <i class="ni ni-lock-circle-open text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
