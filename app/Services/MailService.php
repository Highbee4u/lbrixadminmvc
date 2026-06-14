<?php
class MailService {
    private $transport;
    private $smtpHost;
    private $smtpPort;
    private $smtpUser;
    private $smtpPass;
    private $smtpEncryption;
    private $fromAddress;
    private $fromName;

    public function __construct() {
        // Configuration comes from config/mail.php (define() constants), mirroring
        // how config/database.php exposes DB_* constants. Falls back to MailHog
        // local defaults so dev mail is captured even without the config file.
        $this->transport      = defined('MAIL_TRANSPORT') ? MAIL_TRANSPORT : 'smtp';
        $this->smtpHost       = defined('MAIL_SMTP_HOST') ? MAIL_SMTP_HOST : '127.0.0.1';
        $this->smtpPort       = defined('MAIL_SMTP_PORT') ? MAIL_SMTP_PORT : 1025;
        $this->smtpUser       = defined('MAIL_SMTP_USER') ? MAIL_SMTP_USER : '';
        $this->smtpPass       = defined('MAIL_SMTP_PASS') ? MAIL_SMTP_PASS : '';
        $this->smtpEncryption = defined('MAIL_SMTP_ENCRYPTION') ? MAIL_SMTP_ENCRYPTION : '';
        $this->fromAddress    = defined('MAIL_FROM') ? MAIL_FROM : 'no-reply@lbrix.test';
        $this->fromName       = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'LBRIX Admin';
    }

    /**
     * Send a message. Dispatches to SMTP (e.g. MailHog locally) or to PHP's
     * native mail() depending on MAIL_TRANSPORT.
     */
    public function send($to, $subject, $message, $headers = []) {
        $fromHeader = $this->fromName !== ''
            ? $this->fromName . ' <' . $this->fromAddress . '>'
            : $this->fromAddress;

        $headers['From']     = $fromHeader;
        $headers['Reply-To'] = $fromHeader;
        $headers['X-Mailer'] = 'PHP/' . phpversion();

        if ($this->transport === 'smtp') {
            return $this->sendViaSmtp($to, $subject, $message, $headers);
        }

        $headerString = '';
        foreach ($headers as $key => $value) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }

        return mail($to, $subject, $message, $headerString);
    }

    public function sendHtml($to, $subject, $htmlMessage, $textMessage = null) {
        // Use canonical header casing ("Content-Type") so MIME parsers /
        // mail clients reliably detect the multipart structure.
        $headers = [
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/html; charset=UTF-8'
        ];

        $message = $htmlMessage;

        if ($textMessage) {
            $boundary = md5(uniqid('', true));
            $headers['Content-Type'] = 'multipart/alternative; boundary="' . $boundary . '"';

            $message  = "--{$boundary}\r\n";
            $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
            $message .= trim($textMessage) . "\r\n";
            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
            $message .= trim($htmlMessage) . "\r\n";
            $message .= "--{$boundary}--";
        }

        return $this->send($to, $subject, $message, $headers);
    }

    /**
     * Deliver a message over a raw SMTP connection.
     * Supports optional AUTH LOGIN and TLS/SSL; MailHog needs neither.
     */
    private function sendViaSmtp($to, $subject, $message, $headers) {
        $recipients = is_array($to) ? $to : [$to];

        $host = $this->smtpHost;
        if ($this->smtpEncryption === 'ssl') {
            $host = 'ssl://' . $host;
        }

        $errno = 0;
        $errstr = '';
        $socket = @fsockopen($host, $this->smtpPort, $errno, $errstr, 15);
        if (!$socket) {
            Logger::error("SMTP connection failed to {$this->smtpHost}:{$this->smtpPort} - {$errstr} ({$errno})");
            return false;
        }
        stream_set_timeout($socket, 15);

        try {
            $this->smtpExpect($socket, 220);

            $ehloHost = $this->ehloHostname();
            $this->smtpCommand($socket, 'EHLO ' . $ehloHost, 250);

            if ($this->smtpEncryption === 'tls') {
                $this->smtpCommand($socket, 'STARTTLS', 220);
                if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    Logger::error('SMTP STARTTLS negotiation failed.');
                    fclose($socket);
                    return false;
                }
                $this->smtpCommand($socket, 'EHLO ' . $ehloHost, 250);
            }

            if ($this->smtpUser !== '') {
                $this->smtpCommand($socket, 'AUTH LOGIN', 334);
                $this->smtpCommand($socket, base64_encode($this->smtpUser), 334);
                $this->smtpCommand($socket, base64_encode($this->smtpPass), 235);
            }

            $this->smtpCommand($socket, 'MAIL FROM:<' . $this->fromAddress . '>', 250);
            foreach ($recipients as $recipient) {
                $this->smtpCommand($socket, 'RCPT TO:<' . $recipient . '>', [250, 251]);
            }

            $this->smtpCommand($socket, 'DATA', 354);

            $data  = 'Subject: ' . $subject . "\r\n";
            $data .= 'To: ' . implode(', ', $recipients) . "\r\n";
            $data .= 'Date: ' . date('r') . "\r\n";
            foreach ($headers as $key => $value) {
                $data .= $key . ': ' . $value . "\r\n";
            }
            $data .= "\r\n";
            // Dot-stuffing: escape lines that begin with a period.
            $data .= preg_replace('/^\./m', '..', $message);
            $data .= "\r\n.";

            $this->smtpCommand($socket, $data, 250);
            $this->smtpCommand($socket, 'QUIT', 221);
        } catch (Exception $e) {
            Logger::error('SMTP send failed: ' . $e->getMessage());
            fclose($socket);
            return false;
        }

        fclose($socket);
        return true;
    }

    /**
     * Write an SMTP command and assert the response code.
     */
    private function smtpCommand($socket, $command, $expectedCode) {
        fwrite($socket, $command . "\r\n");
        return $this->smtpExpect($socket, $expectedCode);
    }

    /**
     * Read an SMTP reply and throw if the status code is unexpected.
     */
    private function smtpExpect($socket, $expectedCode) {
        $response = '';
        while (($line = fgets($socket, 515)) !== false) {
            $response .= $line;
            // A space in the 4th column marks the final line of a reply.
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }

        $code = (int) substr($response, 0, 3);
        $expected = is_array($expectedCode) ? $expectedCode : [$expectedCode];
        if (!in_array($code, $expected, true)) {
            throw new Exception("Unexpected SMTP reply: " . trim($response));
        }

        return $response;
    }

    private function ehloHostname() {
        $host = $_SERVER['SERVER_NAME'] ?? gethostname();
        return $host ?: 'localhost';
    }
}
