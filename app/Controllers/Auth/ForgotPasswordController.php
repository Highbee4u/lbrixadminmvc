<?php
class ForgotPasswordController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Show the forgot password form
     */
    public function show()
    {
        $this->view('auth/forgot-password', ['title' => 'Forgot Password'], 'layouts/guest');
    }

    /**
     * Send OTP to email
     */
    public function sendOTP()
    {
        $request = Request::getInstance();
        
        // Validate input
        $validator = new Validator($request->post(), [
            'email' => 'required|email'
        ]);

        if (!$validator->validate()) {
            Session::flash('errors', $validator->errors());
            Session::setOld($request->post());
            Response::redirect('/forgot-password');
            return;
        }

        $email = $request->post('email');

        // Find user by email
        $db = Database::getInstance();
        $user = $db->selectOne(
            "SELECT * FROM users WHERE email = ? AND isdeleted != -1",
            [$email]
        );

        if (!$user) {
            Session::flash('errors', [
                'email' => ['No account found with this email address.']
            ]);
            Session::setOld($request->post());
            Response::redirect('/forgot-password');
            return;
        }

        // Generate 6-digit OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP in session for 10 minutes (600 seconds)
        Session::set('password_reset_otp', [
            'otp' => $otp,
            'user_id' => $user['userid'],
            'email' => $email,
            'created_at' => time()
        ]);

        // Log OTP for debugging (remove in production)
        // Logger::info("Generated OTP for password reset: " . $otp . " for user ID: " . $user['userid']);

        // Send OTP via email
        $sent = $this->sendEmailOTP($email, $otp, $user);

        if (!$sent) {
            Session::flash('errors', [
                'email' => ['Failed to send OTP. Please try again.']
            ]);
            Response::redirect('/forgot-password');
            return;
        }

        Session::flash('otp_sent', true);
        Session::flash('email', $email);
        Response::redirect('/verify-otp');
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyOTP()
    {
        $email = Session::flash('email');
        $otpSent = Session::flash('otp_sent');
        
        if (!$email || !$otpSent) {
            Session::flash('errors', [
                'general' => ['Please request an OTP first.']
            ]);
            Response::redirect('/forgot-password');
            return;
        }

        // Re-set email for the form
        Session::set('verify_email', $email);
        
        $this->view('auth/verify-otp', ['title' => 'Verify OTP', 'email' => $email], 'layouts/guest');
    }

    /**
     * Verify OTP
     */
    public function verifyOTP()
    {
        $request = Request::getInstance();
        
        // Validate input
        $validator = new Validator($request->post(), [
            'otp' => 'required|min:6'
        ]);

        if (!$validator->validate()) {
            Session::flash('errors', $validator->errors());
            Session::setOld($request->post());
            Response::redirect('/verify-otp');
            return;
        }

        $otp = $request->post('otp');
        $otpData = Session::get('password_reset_otp');

        if (!$otpData) {
            Session::flash('errors', [
                'otp' => ['OTP expired. Please request a new one.']
            ]);
            Response::redirect('/forgot-password');
            return;
        }

        // Check if OTP is expired (10 minutes)
        if (time() - $otpData['created_at'] > 600) {
            Session::remove('password_reset_otp');
            Session::flash('errors', [
                'otp' => ['OTP expired. Please request a new one.']
            ]);
            Response::redirect('/forgot-password');
            return;
        }

        // Verify OTP
        if ($otp !== $otpData['otp']) {
            Session::flash('errors', [
                'otp' => ['Invalid OTP. Please try again.']
            ]);
            Response::redirect('/verify-otp');
            return;
        }

        // OTP verified, create reset token
        $resetToken = bin2hex(random_bytes(32));
        Session::set('password_reset_token', [
            'token' => $resetToken,
            'user_id' => $otpData['user_id'],
            'email' => $otpData['email'],
            'created_at' => time()
        ]);

        // Clear OTP
        Session::remove('password_reset_otp');

        Session::flash('otp_verified', true);
        Response::redirect('/reset-password?token=' . $resetToken);
    }

    /**
     * Show reset password form
     */
    public function showResetPassword()
    {
        $request = Request::getInstance();
        $token = $request->get('token');

        if (!$token) {
            Session::flash('errors', [
                'general' => ['Invalid reset link.']
            ]);
            Response::redirect('/forgot-password');
            return;
        }

        $tokenData = Session::get('password_reset_token');

        if (!$tokenData || $tokenData['token'] !== $token) {
            Session::flash('errors', [
                'general' => ['Invalid or expired reset link.']
            ]);
            Response::redirect('/forgot-password');
            return;
        }

        // Check if token is expired (30 minutes)
        if (time() - $tokenData['created_at'] > 1800) {
            Session::remove('password_reset_token');
            Session::flash('errors', [
                'general' => ['Reset link expired. Please request a new one.']
            ]);
            Response::redirect('/forgot-password');
            return;
        }

        $this->view('auth/reset-password-new', ['title' => 'Reset Password', 'token' => $token], 'layouts/guest');
    }

    /**
     * Reset password
     */
    public function resetPassword()
    {
        $request = Request::getInstance();
        
        // Validate input
        $validator = new Validator($request->post(), [
            'token' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required'
        ]);

        if (!$validator->validate()) {
            Session::flash('errors', $validator->errors());
            Session::setOld($request->post());
            Response::redirect('/reset-password?token=' . $request->post('token'));
            return;
        }

        $token = $request->post('token');
        $password = $request->post('password');
        $passwordConfirmation = $request->post('password_confirmation');

        // Check if passwords match
        if ($password !== $passwordConfirmation) {
            Session::flash('errors', [
                'password_confirmation' => ['Passwords do not match.']
            ]);
            Response::redirect('/reset-password?token=' . $token);
            return;
        }

        $tokenData = Session::get('password_reset_token');

        if (!$tokenData || $tokenData['token'] !== $token) {
            Session::flash('errors', [
                'general' => ['Invalid or expired reset token.']
            ]);
            Response::redirect('/forgot-password');
            return;
        }

        // Update password
        $db = Database::getInstance();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $updated = $db->update('users', [
            'password' => $hashedPassword,
            'modifydate' => date('Y-m-d H:i:s')
        ], 'userid = ?', [$tokenData['user_id']]);

        if (!$updated) {
            Session::flash('errors', [
                'general' => ['Failed to reset password. Please try again.']
            ]);
            Response::redirect('/reset-password?token=' . $token);
            return;
        }

        // Clear token
        Session::remove('password_reset_token');
        Session::remove('verify_email');

        // Redirect to login with success message
        Session::flash('password_reset_success', true);
        Response::redirect('/login');
    }

    /**
     * Send OTP via email
     */
    private function sendEmailOTP($email, $otp, $user)
    {
        try {
            $mailService = new MailService();
            $userName = trim(($user['surname'] ?? '') . ' ' . ($user['firstname'] ?? ''));
            
            $subject = 'Password Reset OTP - LBRIX Admin';
            
            $htmlMessage = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #5e72e4; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                    .content { background-color: #f8f9fa; padding: 30px; border-radius: 0 0 5px 5px; }
                    .otp-box { background-color: #fff; border: 2px dashed #5e72e4; padding: 20px; text-align: center; margin: 20px 0; border-radius: 5px; }
                    .otp-code { font-size: 32px; font-weight: bold; color: #5e72e4; letter-spacing: 5px; }
                    .alert { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; }
                    .footer { text-align: center; margin-top: 20px; color: #6c757d; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Password Reset Request</h2>
                    </div>
                    <div class='content'>
                        <p>Hello " . htmlspecialchars($userName) . ",</p>
                        
                        <p>We received a request to reset your password for your LBRIX Admin account.</p>
                        
                        <div class='otp-box'>
                            <p style='margin: 0; font-size: 14px; color: #666;'>Your OTP Code:</p>
                            <div class='otp-code'>" . $otp . "</div>
                            <p style='margin: 10px 0 0 0; font-size: 12px; color: #999;'>Valid for 10 minutes</p>
                        </div>
                        
                        <p>Please enter this OTP on the password reset page to continue.</p>
                        
                        <div class='alert'>
                            <strong>⚠️ Security Notice:</strong><br>
                            If you did not request a password reset, please ignore this email or contact support if you have concerns about your account security.
                        </div>
                        
                        <p>Thank you for using LBRIX Admin.</p>
                        
                        <p>Best regards,<br>
                        <strong>LBRIX Admin Team</strong></p>
                    </div>
                    <div class='footer'>
                        <p>This is an automated message. Please do not reply to this email.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $textMessage = "
Hello " . $userName . ",

We received a request to reset your password for your LBRIX Admin account.

Your OTP Code: " . $otp . "
Valid for 10 minutes

Please enter this OTP on the password reset page to continue.

SECURITY NOTICE: If you did not request a password reset, please ignore this email or contact support.

Thank you for using LBRIX Admin.

Best regards,
LBRIX Admin Team

---
This is an automated message. Please do not reply to this email.
            ";
            
            return $mailService->sendHtml($email, $subject, $htmlMessage, $textMessage);
            
        } catch (Exception $e) {
            Logger::error("Failed to send OTP email: " . $e->getMessage());
            return false;
        }
    }
}