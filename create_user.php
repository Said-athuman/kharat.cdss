<?php
include("config.php");

$adminPass = password_hash("admin123", PASSWORD_DEFAULT);
$labPass = password_hash("lab134", PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (username,password,role) VALUES
('admin','$adminPass','admin'),
('lab','$labPass','lab')");

echo "Users Created Successfully!";
?>