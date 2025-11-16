<?php $pageTitle = 'Investments Dashboard'; ?>


<style>
  body, .dashboard-font, .card, .h1, .h2, .h3, .h4, .h5, .h6, .text-xs, .text-uppercase {
    font-family: 'Inter', Arial, sans-serif !important;
    font-weight: 400 !important;
    letter-spacing: 0.01em;
  }
  .dashboard-card-title {
    font-weight: 500 !important;
    font-size: 1rem;
  }
  .dashboard-card-value {
    font-weight: 500 !important;
    font-size: 1.25rem;
  }
  .dashboard-card-amount {
    font-weight: 400 !important;
    font-size: 1rem;
    color: #6c757d;
  }
  .dashboard-card {
    margin-bottom: 1.5rem;
    min-height: 160px;
  }
</style>

<div class="container-fluid py-4">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Investments Dashboard</h1>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- New Projects Card -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <a href="/investments/new-projects">
                  <div class="text-xs dashboard-card-title text-primary text-uppercase mb-1">New Projects</div>
              </a>
                <div class="h5 mb-0 dashboard-card-value text-gray-800"><?php echo htmlspecialchars($stats['pendingProjects']['totalnumber'] ?? 0, ENT_QUOTES); ?></div>
                <div class="h6 mb-0 dashboard-card-amount text-gray-600">
                ₦<?php echo number_format($stats['pendingProjects']['totalamount'] ?? 0, 2, '.', ','); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Awaiting Inspections Card -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <a href="/investments/awaiting-inspection">
                  <div class="text-xs dashboard-card-title text-primary text-uppercase mb-1">Awaiting Inspections</div>
              </a>
                <div class="h5 mb-0 dashboard-card-value text-gray-800"><?php echo htmlspecialchars($stats['awaitingProjects']['totalnumber'] ?? 0, ENT_QUOTES); ?></div>
                <div class="h6 mb-0 dashboard-card-amount text-gray-600">
                ₦<?php echo number_format($stats['awaitingProjects']['totalamount'] ?? 0, 2, '.', ','); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Concluded Inspections Card -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <a href="/investments/inspection-concluded">
                  <div class="text-xs dashboard-card-title text-primary text-uppercase mb-1">Concluded Inspections</div>
              </a>
                <div class="h5 mb-0 dashboard-card-value text-gray-800"><?php echo htmlspecialchars($stats['concludedProjects']['totalnumber'] ?? 0, ENT_QUOTES); ?></div>
                <div class="h6 mb-0 dashboard-card-amount text-gray-600">
                ₦<?php echo number_format($stats['concludedProjects']['totalamount'] ?? 0, 2, '.', ','); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Rejected Projects Card -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <a href="/investments/inspection-rejected">
                  <div class="text-xs dashboard-card-title text-primary text-uppercase mb-1">Rejected Projects</div>
              </a>
                <div class="h5 mb-0 dashboard-card-value text-gray-800"><?php echo htmlspecialchars($stats['rejectedProjects']['totalnumber'] ?? 0, ENT_QUOTES); ?></div>
                <div class="h6 mb-0 dashboard-card-amount text-gray-600">
                ₦<?php echo number_format($stats['rejectedProjects']['totalamount'] ?? 0, 2, '.', ','); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Second Row -->
  <div class="row">
    <!-- Approved Projects Card -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <a href="/investments/inspection-approved">
                  <div class="text-xs dashboard-card-title text-primary text-uppercase mb-1">Approved Projects</div>
              </a>
                <div class="h5 mb-0 dashboard-card-value text-gray-800"><?php echo htmlspecialchars($stats['approvedProjects']['totalnumber'] ?? 0, ENT_QUOTES); ?></div>
                <div class="h6 mb-0 dashboard-card-amount text-gray-600">
                ₦<?php echo number_format($stats['approvedProjects']['totalamount'] ?? 0, 2, '.', ','); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Awaiting Listing Card -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <a href="/investments/awaiting-listing">
                  <div class="text-xs dashboard-card-title text-primary text-uppercase mb-1">Awaiting Listing</div>
              </a>
                <div class="h5 mb-0 dashboard-card-value text-gray-800"><?php echo htmlspecialchars($stats['awaitingListingProjects']['totalnumber'] ?? 0, ENT_QUOTES); ?></div>
                <div class="h6 mb-0 dashboard-card-amount text-gray-600">
                ₦<?php echo number_format($stats['awaitingListingProjects']['totalamount'] ?? 0, 2, '.', ','); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Listed Projects Card -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <a href="/investments/listed">
                  <div class="text-xs dashboard-card-title text-primary text-uppercase mb-1">Listed Projects</div>
              </a>
                <div class="h5 mb-0 dashboard-card-value text-gray-800"><?php echo htmlspecialchars($stats['listedProjects']['totalnumber'] ?? 0, ENT_QUOTES); ?></div>
                <div class="h6 mb-0 dashboard-card-amount text-gray-600">
                ₦<?php echo number_format($stats['listedProjects']['totalamount'] ?? 0, 2, '.', ','); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Closed Projects Card -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <a href="/investments/closed">
                  <div class="text-xs dashboard-card-title text-primary text-uppercase mb-1">Closed Projects</div>
              </a>
                <div class="h5 mb-0 dashboard-card-value text-gray-800"><?php echo htmlspecialchars($stats['closedProjects']['totalnumber'] ?? 0, ENT_QUOTES); ?></div>
                <div class="h6 mb-0 dashboard-card-amount text-gray-600">
                ₦<?php echo number_format($stats['closedProjects']['totalamount'] ?? 0, 2, '.', ','); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Active Projects Section -->
  <div class="mt-4 mb-4">
    <h5>Active Projects</h5>
  </div>
  <div class="row mb-5">
    <?php foreach (($offers ?? []) as $offer): ?>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card">
          <img src="<?php echo htmlspecialchars(Helpers::imageUrl($offer['picurl'] ?? 'img/default-property.jpg'), ENT_QUOTES); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($offer['title'] ?? 'Project', ENT_QUOTES); ?>">
          <div class="card-body">
            <p class="card-text">
              <strong>List Type:</strong> <?php echo htmlspecialchars($offer['bidtype'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Title:</strong> <?php echo htmlspecialchars($offer['title'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>No. of Offers:</strong> <?php echo htmlspecialchars($offer['bidcount'] ?? 0, ENT_QUOTES); ?><br>
              <strong>Average:</strong> ₦<?php echo number_format($offer['averageoffer'] ?? 0, 2, '.', ','); ?><br>
              <strong>List Amount:</strong> ₦<?php echo number_format($offer['price'] ?? 0, 2, '.', ','); ?>
            </p>
            <a href="/investments/project-detail/<?php echo htmlspecialchars($offer['itemid'] ?? '', ENT_QUOTES); ?>" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Pending Projects Section -->
  <div class="mt-4">
    <h6>Pending Projects</h6>
  </div>
  <div class="row">
    <?php foreach (($recentPending ?? []) as $property): ?>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card">
          <img src="<?php echo htmlspecialchars(Helpers::imageUrl($property['picurl'] ?? 'img/default-property.jpg'), ENT_QUOTES); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title'] ?? 'Project', ENT_QUOTES); ?>">
          <div class="card-body">
            <p class="card-text">
              <strong>List Type:</strong> <?php echo htmlspecialchars($property['bidtype'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Title:</strong> <?php echo htmlspecialchars($property['title'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Amount:</strong> ₦<?php echo number_format($property['price'] ?? 0, 2, '.', ','); ?>
            </p>
            <a href="/investments/project-detail/<?php echo htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES); ?>" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Awaiting Inspection Section -->
  <div class="mt-4">
    <h5>Awaiting Inspection</h5>
  </div>
  <div class="row">
    <?php foreach (($recentAwaiting ?? []) as $property): ?>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card">
          <img src="<?php echo htmlspecialchars(Helpers::imageUrl($property['picurl'] ?? 'img/default-property.jpg'), ENT_QUOTES); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title'] ?? 'Project', ENT_QUOTES); ?>">
          <div class="card-body">
            <p class="card-text">
              <strong>List Type:</strong> <?php echo htmlspecialchars($property['bidtype'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Title:</strong> <?php echo htmlspecialchars($property['title'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Inspection Lead:</strong> <?php echo htmlspecialchars($property['inspectionlead'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Insp Log Date:</strong> <?php echo !empty($property['inspectionstartdate']) ? date('d/m/Y', strtotime($property['inspectionstartdate'])) : 'N/A'; ?>
            </p>
            <a href="/investments/project-detail/<?php echo htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES); ?>" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Inspection Concluded Section -->
  <div class="mt-4">
    <h5>Inspection Concluded</h5>
  </div>
  <div class="row">
    <?php foreach (($inspconcluded ?? []) as $property): ?>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card">
          <img src="<?php echo htmlspecialchars(Helpers::imageUrl($property['picurl'] ?? 'img/default-property.jpg'), ENT_QUOTES); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title'] ?? 'Project', ENT_QUOTES); ?>">
          <div class="card-body">
            <p class="card-text">
              <strong>List Type:</strong> <?php echo htmlspecialchars($property['bidtype'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Title:</strong> <?php echo htmlspecialchars($property['title'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Inspection Lead:</strong> <?php echo htmlspecialchars($property['inspectionlead'] ?? 'N/A', ENT_QUOTES); ?><br>
              <strong>Insp Start Date:</strong> <?php echo !empty($property['inspectionstartdate']) ? date('d/m/Y', strtotime($property['inspectionstartdate'])) : 'N/A'; ?>
            </p>
            <a href="/investments/project-detail/<?php echo htmlspecialchars($property['itemid'] ?? '', ENT_QUOTES); ?>" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>
