<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar can be added here if needed -->
        </div>
    </div>
</div>
<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Reset Password</h4>
                                <p class="mb-0">Enter your new password</p>
                            </div>
                            <div class="card-body">
                                <?php 
                                $errors = Session::flash('errors');
                                if ($errors && isset($errors['general'])): 
                                ?>
                                    <div class="alert alert-danger text-white" role="alert">
                                        <?php echo is_array($errors['general']) ? $errors['general'][0] : $errors['general']; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form role="form" method="POST" action="/reset-password" id="resetPasswordForm">
                                    <input type="hidden" name="csrf_token" value="<?php echo Session::token(); ?>">
                                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                    
                                    <div class="flex flex-col mb-3">
                                        <label for="password" class="form-control-label">New Password</label>
                                        <input type="password" 
                                               name="password" 
                                               id="password"
                                               class="form-control form-control-lg <?php echo ($errors && isset($errors['password'])) ? 'is-invalid' : ''; ?>" 
                                               placeholder="Enter new password"
                                               aria-label="Password"
                                               required>
                                        <?php if ($errors && isset($errors['password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?php echo is_array($errors['password']) ? $errors['password'][0] : $errors['password']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <small class="text-muted">Minimum 6 characters</small>
                                    </div>
                                    
                                    <div class="flex flex-col mb-3">
                                        <label for="password_confirmation" class="form-control-label">Confirm Password</label>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation"
                                               class="form-control form-control-lg <?php echo ($errors && isset($errors['password_confirmation'])) ? 'is-invalid' : ''; ?>" 
                                               placeholder="Confirm new password"
                                               aria-label="Confirm Password"
                                               required>
                                        <?php if ($errors && isset($errors['password_confirmation'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?php echo is_array($errors['password_confirmation']) ? $errors['password_confirmation'][0] : $errors['password_confirmation']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="alert alert-info text-white" role="alert">
                                        <i class="fa fa-info-circle me-2"></i>
                                        After resetting your password, you'll be redirected to the login page.
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Reset Password</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 text-sm mx-auto">
                                    <a href="/login" class="text-primary text-gradient font-weight-bold">Back to Login</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
                            background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">New Password</h4>
                            <p class="text-white position-relative">Choose a strong password to keep your account secure.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetPasswordForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            if (password.length < 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Too Short',
                    text: 'Password must be at least 6 characters long',
                    confirmButtonColor: '#5e72e4'
                });
                return false;
            }
            
            if (password !== passwordConfirmation) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords Do Not Match',
                    text: 'Please make sure both passwords are identical',
                    confirmButtonColor: '#5e72e4'
                });
                return false;
            }
        });
    }
});
</script>
