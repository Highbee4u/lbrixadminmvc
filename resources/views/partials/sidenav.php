<?php
$currentUser = Auth::user();
$userId = $currentUser['userid'] ?? 999;
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
?>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="<?php echo url('dashboard'); ?>">
            <img src="<?php echo asset('images/logo-ct-dark.png'); ?>" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bolder">LBRIX Admin</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <div class="overflow-auto h-100" id="sidenav-scrollbar">
            <ul class="navbar-nav">
                <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link <?php echo $currentPath == '/dashboard' ? 'active' : ''; ?>" href="<?php echo url('dashboard'); ?>">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- Configuration Section -->
            <li class="nav-item mt-5">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Configuration</h6>
            </li>

            <?php if ($userId < 100): ?>
            <!-- Admin Setup -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#adminSetupMenu" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-settings-gear-65 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Admin Setup</span>
                </a>
                <div class="collapse" id="adminSetupMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('admin/roles'); ?>">Admin Roles</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('admin/item-services'); ?>">Item Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('admin/services'); ?>">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('admin/inspection-status'); ?>">Inspection Status</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('admin/investments'); ?>">Investments</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('admin/bid-types'); ?>">Bid Types</a></li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>

            <!-- Setups -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#setupMenu" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-settings text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Setups</span>
                </a>
                <div class="collapse" id="setupMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/countries'); ?>">Countries</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/states'); ?>">States</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/sublocations'); ?>">Sub-locations</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/currency'); ?>">Currencies</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/item-types'); ?>">Item Types</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/item-doc-types'); ?>">Item Doc Types</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/item-pic-types'); ?>">Item Pic Types</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/inspect-pic-types'); ?>">Inspect Pic Types</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/payment-terms'); ?>">Payment Terms</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/inspection-doc-types'); ?>">Inspect Doc Types</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/ownership-types'); ?>">Ownerships</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/project-types'); ?>">Project Types</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/list-types'); ?>">List Types</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('setup/investor-setup'); ?>">Investors</a></li>
                    </ul>
                </div>
            </li>

            <!-- Inspection -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#inspectionMenu" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-check-bold text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Inspection</span>
                </a>
                <div class="collapse" id="inspectionMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('inspection/tasks'); ?>">Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('inspection/requests'); ?>">Requests</a></li>
                    </ul>
                </div>
            </li>

            <!-- Operations Section -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Operations</h6>
            </li>

            <!-- Offers -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#offersMenu" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tag text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Offers</span>
                </a>
                <div class="collapse" id="offersMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('offers/active-property'); ?>">Active Property Offers</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('offers/closed-property'); ?>">Closed Property Offers</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('offers/active-project'); ?>">Active Project Offers</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('offers/closed-project'); ?>">Closed Project Offers</a></li>
                    </ul>
                </div>
            </li>

            <!-- Listings & Offers -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listingsMenu" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-building text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Listings & Offers</span>
                </a>
                <div class="collapse" id="listingsMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/dashboard'); ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/new-properties'); ?>">New/Pending</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/awaiting-inspection'); ?>">Awaiting Inspection</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/inspection-progress'); ?>">In Progress</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/inspection-concluded'); ?>">Concluded</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/inspection-rejected'); ?>">Rejected</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/inspection-approved'); ?>">Approved</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/awaiting-listing'); ?>">Awaiting Listing</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/listed'); ?>">Listed</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('listings/closed'); ?>">Closed</a></li>
                    </ul>
                </div>
            </li>

            <!-- Projects & Investments -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#investmentsMenu" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-money-coins text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Projects & Investments</span>
                </a>
                <div class="collapse" id="investmentsMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/dashboard'); ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/new-projects'); ?>">New/Pending</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/awaiting-inspection'); ?>">Awaiting Inspection</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/inspection-progress'); ?>">In Progress</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/inspection-concluded'); ?>">Concluded</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/inspection-rejected'); ?>">Rejected</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/inspection-approved'); ?>">Approved</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/awaiting-listing'); ?>">Awaiting Listing</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/listed'); ?>">Listed</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('investments/closed'); ?>">Closed</a></li>
                    </ul>
                </div>
            </li>

            <!-- Requests -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#requestsMenu" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-email-83 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Requests</span>
                </a>
                <div class="collapse" id="requestsMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('requests/properties'); ?>">Properties</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('requests/investments'); ?>">Investments</a></li>
                    </ul>
                </div>
            </li>

            <!-- User Register -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#usersMenu" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-circle-08 text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Register</span>
                </a>
                <div class="collapse" id="usersMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('users/customers'); ?>">Customers</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('users/attorneys'); ?>">Attorneys</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('users/inspectors'); ?>">Inspectors</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo url('users/admin'); ?>">Admin</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        </div>
    </div>
</aside>
