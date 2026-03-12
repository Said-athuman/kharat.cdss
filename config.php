<?php
$conn = new mysqli("localhost","root","","hospital_cdss");
if($conn->connect_error){ die("Connection failed"); }
session_start();
?>