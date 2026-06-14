<?php

/**
 * Mail Configuration
 * Define constants that are available globally (mirrors config/database.php).
 *
 * Local development uses MailHog (https://github.com/mailhog/MailHog):
 *   - SMTP:    127.0.0.1:1025
 *   - Web UI:  http://127.0.0.1:8025
 * MailHog accepts plain SMTP with no AUTH / no STARTTLS, so the SMTP
 * credentials below are left empty and encryption disabled for local.
 */

$isProduction = false;

if ($isProduction) {
    // PRODUCTION MAIL SERVER CREDENTIALS
    define('MAIL_TRANSPORT', 'smtp');         // 'smtp' or 'mail'
    define('MAIL_SMTP_HOST', '');
    define('MAIL_SMTP_PORT', 587);
    define('MAIL_SMTP_USER', '');
    define('MAIL_SMTP_PASS', '');
    define('MAIL_SMTP_ENCRYPTION', 'tls');    // 'tls', 'ssl' or ''
    define('MAIL_FROM', 'no-reply@lbrix.com');
    define('MAIL_FROM_NAME', 'LBRIX Admin');
} else {
    // LOCAL DEVELOPMENT (MailHog)
    define('MAIL_TRANSPORT', 'smtp');
    define('MAIL_SMTP_HOST', '127.0.0.1');
    define('MAIL_SMTP_PORT', 1025);
    define('MAIL_SMTP_USER', '');
    define('MAIL_SMTP_PASS', '');
    define('MAIL_SMTP_ENCRYPTION', '');
    define('MAIL_FROM', 'no-reply@lbrix.test');
    define('MAIL_FROM_NAME', 'LBRIX Admin');
}

// Support contact details used in transactional emails.
define('SUPPORT_EMAIL', 'support@lbrix.com');
define('SUPPORT_PHONE', '+234 800 000 0000');
