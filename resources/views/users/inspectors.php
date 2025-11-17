<?php $pageTitle = 'Inspectors'; ?>

<div class="container-fluid py-4">
    <!-- Filter Bar Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-filter me-2"></i>Filter Inspectors
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
                        <h6 class="mb-0">Inspectors</h6>
                        <a href="<?php echo url("users/create&type=inspector"); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>Add New Inspector
                        </a>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Staff No</th>
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
                                <?php if (!empty($inspectors['data'])): ?>
                                    <?php foreach ($inspectors['data'] as $inspector): ?>
                                        <tr>
                                            <td class="align-middle">
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-secondary mb-0" type="button" id="dropdownInspector<?php echo $inspector['userid']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v text-xs"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownInspector<?php echo $inspector['userid']; ?>">
                                                        <li>
                                                            <a class="dropdown-item" href='<?php echo url("users/edit/{$inspector['userid']}?type=inspector"); ?>'>
                                                                <i class="fas fa-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <?php if ($inspector['status'] == 1): ?>
                                                        <li>
                                                            <a class="dropdown-item deactivate-user" href="#" 
                                                               data-userid="<?php echo $inspector['userid']; ?>"
                                                               data-name="<?php echo htmlspecialchars(trim(($inspector['surname'] ?? '') . ' ' . ($inspector['firstname'] ?? '')), ENT_QUOTES); ?>">
                                                                Deactivate
                                                            </a>
                                                        </li>
                                                        <?php endif; ?>
                                                        <?php if ($inspector['status'] == 0): ?>
                                                        <li>
                                                            <a class="dropdown-item activate-user" href="#" 
                                                               data-userid="<?php echo $inspector['userid']; ?>"
                                                               data-name="<?php echo htmlspecialchars(trim(($inspector['surname'] ?? '') . ' ' . ($inspector['firstname'] ?? '')), ENT_QUOTES); ?>">
                                                                Activate
                                                            </a>
                                                        </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($inspector['staffno'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars(trim(($inspector['surname'] ?? '') . ' ' . ($inspector['firstname'] ?? '') . ' ' . ($inspector['middlename'] ?? '')), ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($inspector['email'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($inspector['phone'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($inspector['gender_title'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo htmlspecialchars($inspector['username'] ?? 'N/A', ENT_QUOTES); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-sm <?php echo ($inspector['status'] ?? 0) == 1 ? 'bg-success' : 'bg-secondary'; ?>">
                                                    <?php echo ($inspector['status'] ?? 0) == 1 ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?php echo !empty($inspector['entrydate']) ? date('d/m/y', strtotime($inspector['entrydate'])) : 'N/A'; ?>
                                                </span>
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">No inspectors found</p>
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

    <?php $paginationData = $inspectors; include __DIR__ . '/../partials/pagination.php'; ?>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Deactivate inspector
    document.querySelectorAll('.deactivate-user').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const userid = this.dataset.userid;
            const name = this.dataset.name;
            
            if (!userid) {
                toastr.error('Inspector ID is missing');
                return;
            }
            
            Swal.fire({
                title: 'Deactivate Inspector?',
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
                    
                    fetch(`<?php echo url("users/quick-update/"); ?>${userid}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(r => r.json().then(data => ({ok: r.ok, data})))
                    .then(({ok, data}) => {
                        if (ok && data.success) {
                            toastr.success(data.message || 'Inspector deactivated successfully');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            toastr.error(data.message || 'Failed to deactivate inspector');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while deactivating the inspector');
                    });
                }
            });
        });
    });
    
    // Activate inspector
    document.querySelectorAll('.activate-user').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const userid = this.dataset.userid;
            const name = this.dataset.name;
            
            if (!userid) {
                toastr.error('Inspector ID is missing');
                return;
            }
            
            Swal.fire({
                title: 'Activate Inspector?',
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
                    
                    fetch(`<?php echo url("users/quick-update/"); ?>${userid}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(r => r.json().then(data => ({ok: r.ok, data})))
                    .then(({ok, data}) => {
                        if (ok && data.success) {
                            toastr.success(data.message || 'Inspector activated successfully');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            toastr.error(data.message || 'Failed to activate inspector');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while activating the inspector');
                    });
                }
            });
        });
    });
});
</script>

<script>
// Filter functionality
document.getElementById('applyFilters').addEventListener('click', function() {
    const filters = {
        email: document.getElementById('email_filter').value.trim(),
        phone: document.getElementById('phone_filter').value.trim(),
        entrydate: document.getElementById('entrydate_filter').value,
    };

    // Start with current URL and preserve existing parameters
    const currentUrl = new URL(window.location.href);
    const params = new URLSearchParams(currentUrl.search);

    // Add filter parameters
    Object.keys(filters).forEach(key => {
        if (filters[key]) {
            params.set(key, filters[key]);
        } else {
            params.delete(key); // Remove empty filter values
        }
    });

    // Preserve existing page parameter for better UX
    const currentPage = currentUrl.searchParams.get('page');
    if (currentPage) {
        params.set('page', currentPage);
    }

    // Navigate with all preserved parameters
    const url = currentUrl.origin + currentUrl.pathname + (params.toString() ? '?' + params.toString() : '');
    window.location.href = url;
});

document.getElementById('resetFilters').addEventListener('click', function() {
    document.getElementById('email_filter').value = '';
    document.getElementById('phone_filter').value = '';
    document.getElementById('entrydate_filter').value = '';

    // Keep only essential routing parameters, remove filters
    const currentUrl = new URL(window.location.href);
    const params = new URLSearchParams();
    
    // Preserve action parameter for routing
    const action = currentUrl.searchParams.get('action');
    if (action) {
        params.set('action', action);
    }

    // Navigate to cleaned URL
    const url = currentUrl.origin + currentUrl.pathname + (params.toString() ? '?' + params.toString() : '');
    window.location.href = url;
});

document.querySelectorAll('#email_filter, #phone_filter, #entrydate_filter').forEach(input => {
    input.addEventListener('keypress', function(e) {
        if (e.which === 13) {
            document.getElementById('applyFilters').click();
        }
    });
});
</script>
