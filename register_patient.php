<?php
session_start(); include("config/db.php");
if(!isset($_SESSION['user'])){ header("Location: login.php"); exit(); }

if(isset($_POST['save'])){
  $name=$_POST['name']; $gender=$_POST['gender'];
  $dob=$_POST['dob']; $address=$_POST['address']; $phone=$_POST['phone'];
  $conn->query("INSERT INTO patient(name,gender,date_of_birth,address,phone) VALUES('$name','$gender','$dob','$address','$phone')");
  $msg="Patient Saved Successfully";
}
?>
<link rel="stylesheet" href="assets/css/style.css">

<div class="sidebar">
<a href="dashboard.php">Dashboard</a>
<a href="view_patients.php">View Patients</a>
</div>

<div class="main">
<div class="header">Register Patient</div>
<?php if(isset($msg)) echo "<div class='alert'>$msg</div>"; ?>
<form method="POST" onsubmit="return confirmSubmit();">
<input name="name" placeholder="Full Name" required>
<select name="gender"><option>Male</option><option>Female</option></select>
<input type="date" name="dob">
<textarea name="address" placeholder="Address"></textarea>
<input name="phone" placeholder="Phone">
<button name="save">Save Patient</button>
</form>
</div>