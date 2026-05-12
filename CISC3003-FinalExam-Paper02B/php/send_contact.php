<?php
require __DIR__ . '/connect.php';
require __DIR__ . '/gmail_mailer.php';

$name = trim($_POST['full_name'] ?? '');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$subject = trim($_POST['subject'] ?? '');
$body = trim($_POST['message'] ?? '');
$status = 'validation-error';
$debug = 'Please complete all fields with a valid email and at least 10 message characters.';

if ($name && $email && $subject && strlen($body) >= 10) {
    $stmt = $mysqli->prepare('INSERT INTO contact_messages(full_name,email,subject,message_body) VALUES(?,?,?,?)');
    $stmt->bind_param('ssss', $name, $email, $subject, $body);
    $stmt->execute();

    $result = send_gmail_message(
        MAIL_TO,
        '[CISC3003 Scenario B] ' . $subject,
        "From: $name <$email>\n\n$body",
        $email,
        $name
    );
    $status = $result['status'];
    $debug = $result['debug'];
}

file_put_contents(__DIR__ . '/mail-debug.log', date('c') . " status=$status\n$debug\n", FILE_APPEND);
header('Location: thanks.php?status=' . urlencode($status));
exit;
?>
