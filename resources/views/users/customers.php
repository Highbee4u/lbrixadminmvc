<?php $pageTitle = 'Customers'; ?>
<?php include __DIR__ . '/../partials/topnav.php'; ?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Customer Filter
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-6">
                            <label for="email_filter" class="form-label fw-bold">Email</label>
                            <input type="text" name="email" id="email_filter" class="form-control" value="<?php echo htmlspecialchars($filters['email'] ?? '', ENT_QUOTES); ?>" placeholder="Filter by email">
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="phone_filter" class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" id="phone_filter" class="form-control" value="<?php echo htmlspecialchars($filters['phone'] ?? '', ENT_QUOTES); ?>" placeholder="Filter by phone">
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <label for="entrydate_filter" class="form-label fw-bold">Entry Date</label>
                            <input type="date" name="entrydate" id="entrydate_filter" class="form-control" value="<?php echo htmlspecialchars($filters['entrydate'] ?? '', ENT_QUOTES); ?>">
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-2 align-items-center justify-content-lg-start justify-content-center">
                                <button type="button" class="btn btn-primary" id="applyFilters">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                    <i class="fas fa-times me-2"></i>Reset
                                </button>
                                <?php 
                                $activeFilters = array_filter($filters ?? []);
                                if (count($activeFilters) > 0): 
                                ?>
                                <span class="badge bg-info text-white ms-2">
                                    <i class="fas fa-filter me-1"></i><?php echo count($activeFilters); ?> active filter(s)
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Customers</h6>
                        <a href="/users/create?type=customer" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>Add New Customer
                        </a>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Full Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gender</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Entry Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($customers['data'])): ?>
                                    <?php foreach ($customers['data'] as $customer): ?>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-link text-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?php echo htmlspecialchars($customer['userid'] ?? '', ENT_QUOTES); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown<?php echo htmlspecialchars($customer['userid'] ?? '', ENT_QUOTES); ?>">
                                                        <li>
                                                            <a class="dropdown-item" href="/users/edit?id=<?php echo $customer['userid']; ?>&type=customer">
                                                                <i class="fas fa-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item convert-attorney" href="javascript:;" 
                                                               data-userid="<?php echo htmlspecialchars($customer['userid'] ?? '', ENT_QUOTES); ?>"
                                                               data-name="<?php echo htmlspecialchars(trim(($customer['surname'] ?? '') . ' ' . ($customer['firstname'] ?? '')), ENT_QUOTES); ?>">
                                                                <i class="fas fa-exchange-alt me-2"></i>Convert to Attorney
                                                            </a>
                                                        </li>
                                                        <?php if (($customer['status'] ?? 0) == 1): ?>
                                                        <li>
                                                            <a class="dropdown-item deactivate-user" href="javascript:;" 
                                                               data-userid="<?php echo htmlspecialchars($customer['userid'] ?? '', ENT_QUOTES); ?>"
                                                               data-name="<?php echo htmlspecialchars(trim(($customer['surname'] ?? '') . ' ' . ($customer['firstname'] ?? '')), ENT_QUOTES); ?>">
                                                                <i class="fas fa-ban me-2"></i>Deactivate
                                                            </a>
                                                        </li>
                                                        <?php else: ?>
                                                        <li>
                                                            <a class="dropdown-item activate-user" href="javascript:;" 
                                                               data-userid="<?php echo htmlspecialchars($customer['userid'] ?? '', ENT_QUOTES); ?>"
                                                               data-name="<?php echo htmlspecialchars(trim(($customer['surname'] ?? '') . ' ' . ($customer['firstname'] ?? '')), ENT_QUOTES); ?>">
                                                                <i class="fas fa-check me-2"></i>Activate
                                                            </a>
                                                        </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars(trim(($customer['surname'] ?? '') . ' ' . ($customer['firstname'] ?? '') . ' ' . ($customer['middlename'] ?? '')), ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($customer['email'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($customer['phone'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($customer['gender_title'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($customer['username'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-sm <?php echo ($customer['status'] ?? 0) == 1 ? 'bg-success' : 'bg-secondary'; ?>">
                                                    <?php echo ($customer['status'] ?? 0) == 1 ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo !empty($customer['entrydate']) ? date('d/m/y', strtotime($customer['entrydate'])) : 'N/A'; ?>
                                                </span>
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No customers found</p>
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

    <?php $paginationData = $customers; include __DIR__ . '/../partials/pagination.php'; ?>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<script>
// Handle Convert to Attorney
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('convert-attorney') || e.target.closest('.convert-attorney')) {
        e.preventDefault();
        const element = e.target.closest('.convert-attorney');
        const userid = element.dataset.userid;
        const name = element.dataset.name;

        if (!userid) {
            toastr.error('User ID is required');
            return;
        }

        Swal.fire({
            title: 'Convert to Attorney?',
            text: `Are you sure you want to convert "${name}" to attorney?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, convert!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('usertypeid', '2');
                
                fetch(`/users/quick-update/${userid}`, {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json().then(data => ({ok: r.ok, data})))
                .then(({ok, data}) => {
                    if (ok && data.success) {
                        toastr.success('Customer converted to attorney successfully');
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        toastr.error(data.message || 'Failed to convert customer');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while converting the customer');
                });
            }
        });
    }
});

// Handle Deactivate
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('deactivate-user') || e.target.closest('.deactivate-user')) {
        e.preventDefault();
        const element = e.target.closest('.deactivate-user');
        const userid = element.dataset.userid;
        const name = element.dataset.name;

        if (!userid) {
            toastr.error('User ID is required');
            return;
        }

        Swal.fire({
            title: 'Deactivate User?',
            text: `Are you sure you want to deactivate "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, deactivate!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('status', '0');
                
                fetch(`/users/quick-update/${userid}`, {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json().then(data => ({ok: r.ok, data})))
                .then(({ok, data}) => {
                    if (ok && data.success) {
                        toastr.success('User deactivated successfully');
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        toastr.error(data.message || 'Failed to deactivate user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while deactivating the user');
                });
            }
        });
    }
});

// Handle Activate
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('activate-user') || e.target.closest('.activate-user')) {
        e.preventDefault();
        const element = e.target.closest('.activate-user');
        const userid = element.dataset.userid;
        const name = element.dataset.name;

        if (!userid) {
            toastr.error('User ID is required');
            return;
        }

        Swal.fire({
            title: 'Activate User?',
            text: `Are you sure you want to activate "${name}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, activate!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('status', '1');
                
                fetch(`/users/quick-update/${userid}`, {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json().then(data => ({ok: r.ok, data})))
                .then(({ok, data}) => {
                    if (ok && data.success) {
                        toastr.success('User activated successfully');
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        toastr.error(data.message || 'Failed to activate user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while activating the user');
                });
            }
        });
    }
});
</script>

<script>
// Filter functionality
document.getElementById('applyFilters').addEventListener('click', function() {
    const filters = {
        email: document.getElementById('email_filter').value,
        phone: document.getElementById('phone_filter').value,
        entrydate: document.getElementById('entrydate_filter').value,
    };

    // Build query string
    const params = new URLSearchParams();
    Object.keys(filters).forEach(key => {
        if (filters[key]) {
            params.append(key, filters[key]);
        }
    });

    // Reload page with filters
    const url = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
    window.location.href = url;
});

// Reset Filters
document.getElementById('resetFilters').addEventListener('click', function() {
    // Clear all filter inputs
    document.getElementById('email_filter').value = '';
    document.getElementById('phone_filter').value = '';
    document.getElementById('entrydate_filter').value = '';

    // Reload page without any query parameters
    window.location.href = window.location.pathname;
});

// Auto-apply filters on Enter key press in filter inputs
document.querySelectorAll('#email_filter, #phone_filter, #entrydate_filter').forEach(input => {
    input.addEventListener('keypress', function(e) {
        if (e.which === 13) { // Enter key
            document.getElementById('applyFilters').click();
        }
    });
});
</script>
