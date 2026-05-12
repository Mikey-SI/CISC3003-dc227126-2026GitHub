<?php
$mysqli = new mysqli('localhost', 'root', '', 'cisc3003_p2a_dc227126');
if ($mysqli->connect_errno) { die('Database connection failed: ' . htmlspecialchars($mysqli->connect_error)); }
$mysqli->set_charset('utf8mb4');
?>
