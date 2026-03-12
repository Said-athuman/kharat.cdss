<?php
session_start();
include("config/db.php");
if(isset($_SESSION['user'])){ header("Location: dashboard.php"); exit(); }

if(isset($_POST['login'])){
  $u=$_POST['username']; $p=$_POST['password'];
  $q=$conn->query("SELECT * FROM users WHERE username='$u' AND password='$p'");
  if($q->num_rows>0){ $_SESSION['user']=$u; header("Location: dashboard.php"); exit(); }
  else $error="Invalid Login";
}
?>
<link rel="stylesheet" href="assets/css/style.css">

<div class="login-container">
<img src="images/hospital_logo.png" alt="Hospital Logo">
<h2>Hospital CDSS Login</h2>
<?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>
</div>