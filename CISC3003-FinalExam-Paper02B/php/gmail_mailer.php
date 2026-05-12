<?php
require_once __DIR__ . '/mail_config.php';

function send_gmail_message(string $to, string $subject, string $body, ?string $replyEmail = null, ?string $replyName = null): array
{
    $autoload = dirname(__DIR__) . '/vendor/autoload.php';
    if (!file_exists($autoload)) {
        return ['ok' => false, 'status' => 'missing-phpmailer', 'debug' => 'PHPMailer vendor/autoload.php was not found.'];
    }

    if (!gmail_is_configured()) {
        return ['ok' => false, 'status' => 'smtp-not-configured', 'debug' => 'Set GMAIL_USERNAME and GMAIL_APP_PASSWORD, or create php/gmail_credentials.local.php.'];
    }

    require_once $autoload;
    $smtpTranscript = '';

    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function (string $line, int $level) use (&$smtpTranscript): void {
            $smtpTranscript .= "[$level] $line\n";
        };
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = gmail_username();
        $mail->Password = gmail_app_password();
        $mail->SMTPSecure = SMTP_PORT === 465
            ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS
            : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];
        $mail->CharSet = 'UTF-8';
        $mail->setFrom(gmail_username(), SMTP_FROM_NAME);
        $mail->addAddress($to);
        if ($replyEmail) {
            $mail->addReplyTo($replyEmail, $replyName ?: $replyEmail);
        }
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
        return ['ok' => true, 'status' => 'sent', 'debug' => $smtpTranscript];
    } catch (Throwable $error) {
        return ['ok' => false, 'status' => 'smtp-debug', 'debug' => $error->getMessage() . "\n" . $smtpTranscript];
    }
}
?>
