<?php
require __DIR__ . '/php/footer.php';
require __DIR__ . '/php/gmail_mailer.php';

$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = filter_input(INPUT_POST, 'to', FILTER_VALIDATE_EMAIL) ?: MAIL_TO;
    $result = send_gmail_message(
        $to,
        'CISC3003 Paper02B Gmail SMTP Test',
        "This is a PHPMailer Gmail SMTP test from Scenario B.\nStudent: SITINIEK DC227126"
    );
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Scenario B Gmail Test</title><link rel="stylesheet" href="css/styles.css"></head><body><header><h1>B.03/B.04 Gmail SMTP Test</h1><nav><a href="index.php">Contact</a></nav></header><main><section class="card"><p>Uses PHPMailer with Gmail SMTP: <code>smtp.gmail.com</code>, port <code>465</code>, SMTPS. Gmail requires a Google app password.</p><?php if ($result): ?><div class="notice <?= $result['ok'] ? 'success' : 'error' ?>"><strong>Status:</strong> <?= htmlspecialchars($result['status']) ?><pre><?= htmlspecialchars($result['debug']) ?></pre></div><?php endif; ?><form method="post"><label>Send test email to</label><input name="to" type="email" value="<?= htmlspecialchars(MAIL_TO) ?>" required><button>Send Gmail Test</button></form></section></main><?php exam_footer(); ?></body></html>
