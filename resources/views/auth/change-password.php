<?php
$pageTitle = 'Change Password';


?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0 font-weight-bold text-lg">Change Password</p>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-sm mb-4">Please enter your current password and choose a new password.</p>
                    
                    <?php 
                    $errors = Session::flash('errors');
                    ?>
                    
                    <?php if ($errors && isset($errors['general'])): ?>
                        <div class="alert alert-danger text-white" role="alert">
                            <strong>Error!</strong> <?php echo is_array($errors['general']) ? $errors['general'][0] : $errors['general']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form role="form" method="POST" action="/change-password" id="changePasswordForm">
                        <input type="hidden" name="csrf_token" value="<?php echo Session::token(); ?>">
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="current_password" class="form-control-label">Current Password <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           name="current_password" 
                                           id="current_password"
                                           class="form-control <?php echo ($errors && isset($errors['current_password'])) ? 'is-invalid' : ''; ?>" 
                                           placeholder="Enter your current password"
                                           required>
                                    <?php if ($errors && isset($errors['current_password'])): ?>
                                        <div class="invalid-feedback d-block">
                                            <?php echo is_array($errors['current_password']) ? $errors['current_password'][0] : $errors['current_password']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_password" class="form-control-label">New Password <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           name="new_password" 
                                           id="new_password"
                                           class="form-control <?php echo ($errors && isset($errors['new_password'])) ? 'is-invalid' : ''; ?>" 
                                           placeholder="Enter new password"
                                           required>
                                    <?php if ($errors && isset($errors['new_password'])): ?>
                                        <div class="invalid-feedback d-block">
                                            <?php echo is_array($errors['new_password']) ? $errors['new_password'][0] : $errors['new_password']; ?>
                                        </div>
                                    <?php endif; ?>
                                    <small class="text-muted">Minimum 6 characters</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password" class="form-control-label">Confirm New Password <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           name="confirm_password" 
                                           id="confirm_password"
                                           class="form-control <?php echo ($errors && isset($errors['confirm_password'])) ? 'is-invalid' : ''; ?>" 
                                           placeholder="Confirm new password"
                                           required>
                                    <?php if ($errors && isset($errors['confirm_password'])): ?>
                                        <div class="invalid-feedback d-block">
                                            <?php echo is_array($errors['confirm_password']) ? $errors['confirm_password'][0] : $errors['confirm_password']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info text-white" role="alert">
                                    <i class="fa fa-info-circle me-2"></i>
                                    <strong>Note:</strong> After changing your password, you will be logged out and need to log in again with your new password.
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="/dashboard" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('changePasswordForm');
    
    form.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'New password and confirm password do not match!',
                confirmButtonColor: '#5e72e4'
            });
            return false;
        }
        
        if (newPassword.length < 6) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Password Too Short',
                text: 'New password must be at least 6 characters long!',
                confirmButtonColor: '#5e72e4'
            });
            return false;
        }
    });
});
</script>
