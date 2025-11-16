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
                                <h4 class="font-weight-bolder">Sign In</h4>
                                <p class="mb-0">Enter your email/username and password to sign in</p>
                            </div>
                            <div class="card-body">
                                <?php 
                                $errors = Session::flash('errors');
                                $passwordChanged = Session::flash('password_changed');
                                if ($errors && isset($errors['login'])): 
                                ?>
                                    <div class="alert alert-danger text-white" role="alert">
                                        <?php echo is_array($errors['login']) ? $errors['login'][0] : $errors['login']; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form role="form" method="POST" action="<?php echo url('login'); ?>" id="loginForm">
                                    <input type="hidden" name="csrf_token" value="<?php echo Session::token(); ?>">
                                    
                                    <div class="flex flex-col mb-3">
                                        <input type="text" 
                                               name="login" 
                                               id="loginInput"
                                               class="form-control form-control-lg" 
                                               value="<?php echo Session::old('login', ''); ?>" 
                                               placeholder="Email or Username"
                                               aria-label="Login">
                                        <?php if ($errors && isset($errors['login'])): ?>
                                            <p class="text-danger text-xs pt-1">
                                                <?php echo is_array($errors['login']) ? $errors['login'][0] : $errors['login']; ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="flex flex-col mb-3">
                                        <input type="password" 
                                               name="password" 
                                               id="passwordInput"
                                               class="form-control form-control-lg" 
                                               placeholder="Password"
                                               aria-label="Password">
                                        <?php if ($errors && isset($errors['password'])): ?>
                                            <p class="text-danger text-xs pt-1">
                                                <?php echo is_array($errors['password']) ? $errors['password'][0] : $errors['password']; ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="remember" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 text-sm mx-auto">
                                    Forgot your password?
                                    <a href="<?php echo url('forgot-password'); ?>" class="text-primary text-gradient font-weight-bold">Reset here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
                            background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new currency"</h4>
                            <p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php if ($passwordChanged): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Password Changed Successfully!',
        html: 'Your password has been updated successfully.<br><br>Please log in with your new password.',
        confirmButtonColor: '#5e72e4',
        confirmButtonText: 'OK'
    }).then(() => {
        // Show a toast notification after closing the alert
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: 'info',
            title: 'A notification email has been sent to your email address'
        });
    });
});
</script>
<?php endif; ?>

<?php
$passwordResetSuccess = Session::flash('password_reset_success');
if ($passwordResetSuccess):
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Password Reset Successfully!',
        html: 'Your password has been reset successfully.<br><br>Please log in with your new password.',
        confirmButtonColor: '#5e72e4',
        confirmButtonText: 'OK'
    });
});
</script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const loginValue = document.getElementById('loginInput').value;
            const passwordValue = document.getElementById('passwordInput').value;

            if (!loginValue || !passwordValue) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Information',
                    text: 'Please enter both email/username and password',
                    confirmButtonColor: '#5e72e4'
                });
                return false;
            }

            // No confirmation on login - submit directly but show a loading indicator
            Swal.fire({
                title: 'Signing in...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit the form
            loginForm.submit();
        });
    }
});
</script>
