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
                                <h4 class="font-weight-bolder">Verify OTP</h4>
                                <p class="mb-0">Enter the OTP sent to your email</p>
                            </div>
                            <div class="card-body">
                                <?php 
                                $errors = Session::flash('errors');
                                if ($errors && isset($errors['otp'])): 
                                ?>
                                    <div class="alert alert-danger text-white" role="alert">
                                        <?php echo is_array($errors['otp']) ? $errors['otp'][0] : $errors['otp']; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($errors && isset($errors['general'])): ?>
                                    <div class="alert alert-danger text-white" role="alert">
                                        <?php echo is_array($errors['general']) ? $errors['general'][0] : $errors['general']; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="alert alert-info text-white mb-3" role="alert">
                                    <i class="fa fa-envelope me-2"></i>
                                    We've sent a 6-digit OTP to:<br>
                                    <strong><?php echo htmlspecialchars($email ?? Session::get('verify_email', '')); ?></strong>
                                </div>
                                
                                <form role="form" method="POST" action="<?php echo url('verify-otp'); ?>" id="verifyOtpForm">
                                    <input type="hidden" name="csrf_token" value="<?php echo Session::token(); ?>">
                                    
                                    <div class="flex flex-col mb-3">
                                        <label for="otp" class="form-control-label">Enter OTP</label>
                                        <input type="text" 
                                               name="otp" 
                                               id="otp"
                                               class="form-control form-control-lg text-center" 
                                               value="<?php echo Session::old('otp', ''); ?>" 
                                               placeholder="000000"
                                               maxlength="6"
                                               pattern="[0-9]{6}"
                                               aria-label="OTP"
                                               style="letter-spacing: 10px; font-size: 24px; font-weight: bold;"
                                               required>
                                        <small class="text-muted">Please enter the 6-digit code (valid for 10 minutes)</small>
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Verify OTP</button>
                                    </div>
                                </form>
                                
                                <div class="text-center mt-3">
                                    <a href="<?php echo url('forgot-password'); ?>" class="text-sm text-muted">
                                        <i class="fa fa-redo me-1"></i> Didn't receive OTP? Request new one
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 text-sm mx-auto">
                                    <a href="<?php echo url('login'); ?>" class="text-primary text-gradient font-weight-bold">Back to Login</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
                            background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">Almost There!</h4>
                            <p class="text-white position-relative">Check your email for the OTP code to continue with password reset.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    const form = document.getElementById('verifyOtpForm');
    
    // Auto-focus on OTP input
    if (otpInput) {
        otpInput.focus();
        
        // Only allow numbers
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const otp = otpInput.value;
            
            if (otp.length !== 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid OTP',
                    text: 'Please enter the complete 6-digit OTP',
                    confirmButtonColor: '#5e72e4'
                });
                return false;
            }
        });
    }
});
</script>
