<?php
class ChangePasswordController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Show the change password form
     */
    public function show() {
        // Check if user is authenticated
        if (!Auth::check()) {
            Response::redirect('/login');
            return;
        }

        $this->viewWithLayout('auth/change-password', ['title' => 'Change Password']);
    }

    /**
     * Process password change
     */
    public function update() {
        // Check if user is authenticated
        if (!Auth::check()) {
            Response::redirect(url('login'));
            return;
        }

        $request = Request::getInstance();
        
        // Validate input
        $validator = new Validator($request->post(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required'
        ]);

        if (!$validator->validate()) {
            Session::flash('errors', $validator->errors());
            Session::setOld($request->post());
            Response::redirect('/change-password');
            return;
        }

        $currentPassword = $request->post('current_password');
        $newPassword = $request->post('new_password');
        $confirmPassword = $request->post('confirm_password');

        // Verify new password and confirm password match
        if ($newPassword !== $confirmPassword) {
            Session::flash('errors', [
                'confirm_password' => ['New password and confirm password do not match']
            ]);
            Response::redirect('/change-password');
            return;
        }

        // Get current user
        $user = Auth::user();
        if (!$user) {
            Session::flash('errors', [
                'general' => ['Unable to retrieve user information']
            ]);
            Response::redirect('/change-password');
            return;
        }

        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            Session::flash('errors', [
                'current_password' => ['Current password is incorrect']
            ]);
            Response::redirect('/change-password');
            return;
        }

        // Update password in database
        $db = Database::getInstance();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $updated = $db->update('users', [
            'password' => $hashedPassword,
            'modifydate' => date('Y-m-d H:i:s')
        ], 'userid = ?', [$user['userid']]);

        if (!$updated) {
            Session::flash('errors', [
                'general' => ['Failed to update password. Please try again.']
            ]);
            Response::redirect(url('change-password'));
            return;
        }

        // Send email notification
        $this->sendPasswordChangeNotification($user);

        // Log the user out
        Auth::logout();

        // Show success message with SweetAlert and redirect to login
        Session::flash('password_changed', true);
        Response::redirect(url('login'));
    }

    /**
     * Send password change notification email
     */
    private function sendPasswordChangeNotification($user) {
        try {
            $mailService = new MailService();
            $supportEmail = Config::get('support.email', 'support@lbrix.com');
            $supportPhone = Config::get('support.phone', '+1-234-567-8900');
            
            $userName = trim(($user['surname'] ?? '') . ' ' . ($user['firstname'] ?? ''));
            $userEmail = $user['email'] ?? '';
            
            if (empty($userEmail)) {
                return; // Cannot send email without email address
            }

            $subject = 'Password Changed Successfully - LBRIX Admin';
            
            $htmlMessage = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #5e72e4; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                    .content { background-color: #f8f9fa; padding: 30px; border-radius: 0 0 5px 5px; }
                    .alert { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; }
                    .support-info { background-color: #e7f3ff; padding: 15px; margin: 20px 0; border-radius: 5px; }
                    .footer { text-align: center; margin-top: 20px; color: #6c757d; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Password Changed Successfully</h2>
                    </div>
                    <div class='content'>
                        <p>Hello " . htmlspecialchars($userName) . ",</p>
                        
                        <p>Your password for LBRIX Admin has been changed successfully on <strong>" . date('F j, Y \a\t g:i A') . "</strong>.</p>
                        
                        <p>You can now log in to your account using your new password.</p>
                        
                        <div class='alert'>
                            <strong>⚠️ Did you make this change?</strong><br>
                            If you did not perform this action, please contact our support team immediately. Your account security is important to us.
                        </div>
                        
                        <div class='support-info'>
                            <strong>Support Contact Information:</strong><br>
                            📧 Email: <a href='mailto:" . htmlspecialchars($supportEmail) . "'>" . htmlspecialchars($supportEmail) . "</a><br>
                            📞 Phone: " . htmlspecialchars($supportPhone) . "
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

Your password for LBRIX Admin has been changed successfully on " . date('F j, Y \a\t g:i A') . ".

You can now log in to your account using your new password.

⚠️ IMPORTANT: If you did not perform this action, please contact our support team immediately.

Support Contact Information:
Email: " . $supportEmail . "
Phone: " . $supportPhone . "

Thank you for using LBRIX Admin.

Best regards,
LBRIX Admin Team

---
This is an automated message. Please do not reply to this email.
            ";
            
            $mailService->sendHtml($userEmail, $subject, $htmlMessage, $textMessage);
            
        } catch (Exception $e) {
            // Log error but don't fail the password change
            Logger::error("Failed to send password change notification: " . $e->getMessage());
        }
    }
}
