<?php 
$pageTitle = 'Create New ' . ucfirst($userType ?? 'Customer'); 
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Create New <?php echo ucfirst($userType ?? 'Customer'); ?></h6>
                        <a href="/users/<?php echo $userType ?? 'customer'; ?>s" class="btn btn-sm btn-secondary">Back to <?php echo ucfirst($userType ?? 'Customer'); ?>s</a>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/users/store" method="POST" id="userForm">
                        <input type="hidden" name="user_type" value="<?php echo htmlspecialchars($userType ?? 'customer'); ?>">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="userTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
                                    <i class="fas fa-user me-2"></i>User Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="role-tab" data-bs-toggle="tab" data-bs-target="#role" type="button" role="tab" aria-controls="role" aria-selected="false">
                                    <i class="fas fa-user-tag me-2"></i>User Role
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab" aria-controls="service" aria-selected="false">
                                    <i class="fas fa-cogs me-2"></i>User Service
                                </button>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content mt-4" id="userTabsContent">
                            <!-- User Information Tab -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title" class="form-control-label">Title</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Mr, Mrs, Dr, etc.">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staffno" class="form-control-label">Staff Number</label>
                                            <input type="text" name="staffno" id="staffno" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <?php if ($userType == 'attorney'): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="otherusertype" class="form-control-label">Attorney Type</label>
                                            <input type="text" name="otherusertype" id="otherusertype" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="registrationnumber" class="form-control-label">Registration Number</label>
                                            <input type="text" name="registrationnumber" id="registrationnumber" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="surname" class="form-control-label">Surname *</label>
                                            <input type="text" name="surname" id="surname" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname" class="form-control-label">First Name *</label>
                                            <input type="text" name="firstname" id="firstname" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="middlename" class="form-control-label">Middle Name</label>
                                            <input type="text" name="middlename" id="middlename" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">Email Address *</label>
                                            <input type="email" name="email" id="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-control-label">Phone Number</label>
                                            <input type="text" name="phone" id="phone" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender" class="form-control-label">Gender</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dateofbirth" class="form-control-label">Date of Birth</label>
                                            <input type="date" name="dateofbirth" id="dateofbirth" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="occupation" class="form-control-label">Occupation</label>
                                            <input type="text" name="occupation" id="occupation" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address" class="form-control-label">Address</label>
                                            <textarea name="address" id="address" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username" class="form-control-label">Username *</label>
                                            <input type="text" name="username" id="username" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Status</label>
                                            <div class="form-check">
                                                <input type="checkbox" name="status" id="status" class="form-check-input" value="1" checked>
                                                <label for="status" class="form-check-label">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-control-label">Password *</label>
                                            <input type="password" name="password" id="password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-control-label">Confirm Password *</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Role Tab -->
                            <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="role-tab">
                                <div class="row">
                                    <?php if ($userType === 'admin'): ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="usertypeid" class="form-control-label">Admin Role *</label>
                                            <select name="usertypeid" id="usertypeid" class="form-control" required>
                                                <option value="">Select Admin Role</option>
                                                <?php if (!empty($adminRoles)): ?>
                                                    <?php foreach ($adminRoles as $role): ?>
                                                        <option value="<?php echo $role['adminroleid']; ?>">
                                                            <?php echo htmlspecialchars($role['title'], ENT_QUOTES); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usertypeid" class="form-control-label">User Type *</label>
                                            <select name="usertypeid" id="usertypeid" class="form-control" required>
                                                <option value="">Select User Type</option>
                                                <option value="1" <?php echo ($userType === 'customer') ? 'selected' : ''; ?>>Customer</option>
                                                <option value="2" <?php echo ($userType === 'attorney') ? 'selected' : ''; ?>>Attorney</option>
                                                <option value="3" <?php echo ($userType === 'inspector') ? 'selected' : ''; ?>>Inspector</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="adminroleid" class="form-control-label">Admin Role (Optional)</label>
                                            <select name="adminroleid" id="adminroleid" class="form-control">
                                                <option value="">N/A - Not Admin User</option>
                                                <?php if (!empty($adminRoles)): ?>
                                                    <?php foreach ($adminRoles as $role): ?>
                                                        <option value="<?php echo $role['adminroleid']; ?>">
                                                            <?php echo htmlspecialchars($role['title'], ENT_QUOTES); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- User Service Tab -->
                            <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="serviceid" class="form-control-label">Service</label>
                                            <select name="serviceid" id="serviceid" class="form-control">
                                                <option value="">Select Service</option>
                                                <?php if (!empty($services)): ?>
                                                    <?php foreach ($services as $service): ?>
                                                        <option value="<?php echo $service['serviceid']; ?>">
                                                            <?php echo htmlspecialchars($service['title'], ENT_QUOTES); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Create <?php echo ucfirst($userType ?? 'Customer'); ?>
                                </button>
                                <a href="/users/<?php echo $userType ?? 'customer'; ?>s" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tabs
    const tabButtons = document.querySelectorAll('#userTabs button[data-bs-toggle="tab"]');

    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all tab buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
            });

            // Add active class to clicked button
            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');

            // Hide all tab panes
            const tabPanes = document.querySelectorAll('#userTabsContent .tab-pane');
            tabPanes.forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Show the target tab pane
            const targetId = this.getAttribute('data-bs-target');
            const targetPane = document.querySelector(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });

    // Form validation for password match
    const form = document.getElementById('userForm');
    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        
        if (password !== passwordConfirm) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }
    });
});
</script>
