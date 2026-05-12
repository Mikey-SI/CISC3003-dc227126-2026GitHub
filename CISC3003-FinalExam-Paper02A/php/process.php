<?php
require __DIR__ . '/footer.php';
require __DIR__ . '/connect.php';

$errors = [];
$name = trim($_POST['full_name'] ?? '');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$sid = strtoupper(trim($_POST['student_id'] ?? ''));
$msg = trim($_POST['message'] ?? '');
$topic = trim($_POST['topic'] ?? '');
$mode = trim($_POST['mode'] ?? '');
$skills = implode(', ', array_map('trim', $_POST['skills'] ?? []));

if ($name === '') $errors[] = 'Name required';
if (!$email) $errors[] = 'A.06 invalid email';
if (!preg_match('/^DC[0-9]{6}$/', $sid)) $errors[] = 'Invalid student ID';
if (strlen($msg) < 10) $errors[] = 'Textarea too short';
if ($topic === '') $errors[] = 'Topic required';
if ($mode === '') $errors[] = 'Mode required';

if (!$errors) {
    $stmt = $mysqli->prepare('INSERT INTO scenario_a_submissions(full_name,email,student_id,message,topic,study_mode,skills) VALUES(?,?,?,?,?,?,?)');
    $stmt->bind_param('sssssss', $name, $email, $sid, $msg, $topic, $mode, $skills);
    $ok = $stmt->execute();
    if (!$ok) $errors[] = $stmt->error;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>A.05-A.08 PHP Processing Result</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<main>
  <section class="card">
    <h1>A.05-A.08 PHP Processing Result</h1>
    <?php if ($errors): ?>
      <div class="notice error">
        <strong>Validation failed.</strong>
        <p><?= htmlspecialchars(implode('; ', $errors)) ?></p>
      </div>
      <a class="button" href="index.php">Back to Scenario A form</a>
    <?php else: ?>
      <div class="notice success">
        <h2>Form data saved successfully.</h2>
        <p>The PHP script validated the input using filter functions and inserted the data with a prepared statement. SQL injection is prevented because values are bound using <code>bind_param()</code>.</p>
      </div>
      <table>
        <tr><th>Full Name</th><td><?= htmlspecialchars($name) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($email) ?></td></tr>
        <tr><th>Student ID</th><td><?= htmlspecialchars($sid) ?></td></tr>
        <tr><th>Topic</th><td><?= htmlspecialchars($topic) ?></td></tr>
        <tr><th>Study Mode</th><td><?= htmlspecialchars($mode) ?></td></tr>
        <tr><th>Message</th><td><?= nl2br(htmlspecialchars($msg)) ?></td></tr>
        <tr><th>Skills</th><td><?= htmlspecialchars($skills) ?></td></tr>
      </table>
      <nav>
        <a href="index.php">Back to Scenario A form</a>
        <a class="secondary" href="list.php">View inserted records</a>
      </nav>
    <?php endif; ?>
  </section>
</main>
<?php exam_footer(); ?>
</body>
</html>
