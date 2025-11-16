<?php
class MailService {
    private $smtpHost;
    private $smtpPort;
    private $smtpUser;
    private $smtpPass;

    public function __construct() {
        $this->smtpHost = Config::get('mail.smtp_host', 'smtp.example.com');
        $this->smtpPort = Config::get('mail.smtp_port', 587);
        $this->smtpUser = Config::get('mail.smtp_user', '');
        $this->smtpPass = Config::get('mail.smtp_pass', '');
    }

    public function send($to, $subject, $message, $headers = []) {
        $headers['From'] = Config::get('mail.from', 'noreply@example.com');
        $headers['Reply-To'] = $headers['From'];
        $headers['X-Mailer'] = 'PHP/' . phpversion();

        $headerString = '';
        foreach ($headers as $key => $value) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }

        return mail($to, $subject, $message, $headerString);
    }

    public function sendHtml($to, $subject, $htmlMessage, $textMessage = null) {
        $headers = [
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8'
        ];

        $message = $htmlMessage;

        if ($textMessage) {
            $boundary = md5(time());
            $headers['Content-type'] = 'multipart/alternative; boundary="' . $boundary . '"';

            $message = "--{$boundary}\r\n";
            $message .= "Content-type: text/plain; charset=UTF-8\r\n\r\n";
            $message .= $textMessage . "\r\n\r\n";
            $message .= "--{$boundary}\r\n";
            $message .= "Content-type: text/html; charset=UTF-8\r\n\r\n";
            $message .= $htmlMessage . "\r\n\r\n";
            $message .= "--{$boundary}--";
        }

        return $this->send($to, $subject, $message, $headers);
    }
}