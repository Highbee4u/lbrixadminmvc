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
                                <h4 class="font-weight-bolder">Forgot Password</h4>
                                <p class="mb-0">Enter your email address to receive an OTP</p>
                            </div>
                            <div class="card-body">
                                <?php 
                                $errors = Session::flash('errors');
                                if ($errors && isset($errors['email'])): 
                                ?>
                                    <div class="alert alert-danger text-white" role="alert">
                                        <?php echo is_array($errors['email']) ? $errors['email'][0] : $errors['email']; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($errors && isset($errors['general'])): ?>
                                    <div class="alert alert-danger text-white" role="alert">
                                        <?php echo is_array($errors['general']) ? $errors['general'][0] : $errors['general']; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form role="form" method="POST" action="/forgot-password" id="forgotPasswordForm">
                                    <input type="hidden" name="csrf_token" value="<?php echo Session::token(); ?>">
                                    
                                    <div class="flex flex-col mb-3">
                                        <label for="email" class="form-control-label">Email Address</label>
                                        <input type="email" 
                                               name="email" 
                                               id="email"
                                               class="form-control form-control-lg" 
                                               value="<?php echo Session::old('email', ''); ?>" 
                                               placeholder="Enter your email address"
                                               aria-label="Email"
                                               required>
                                        <small class="text-muted">We'll send a 6-digit OTP to this email address</small>
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Send OTP</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 text-sm mx-auto">
                                    Remember your password?
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
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">Password Recovery</h4>
                            <p class="text-white position-relative">Enter your email address and we'll send you an OTP to reset your password.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgotPasswordForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            
            if (!email || !email.includes('@')) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Email',
                    text: 'Please enter a valid email address',
                    confirmButtonColor: '#5e72e4'
                });
                return false;
            }
        });
    }
});
</script>
