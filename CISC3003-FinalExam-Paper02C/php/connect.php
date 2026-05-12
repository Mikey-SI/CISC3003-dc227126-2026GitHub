<?php
$mysqli=new mysqli('localhost','root','','cisc3003_p2c_dc227126'); if($mysqli->connect_errno){die('DB failed: '.htmlspecialchars($mysqli->connect_error));} $mysqli->set_charset('utf8mb4');
?>
