<?php
if(!isset($_SESSION)){ session_start(); }
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
?>
<div class="topbar">
    <div class="logo">🏥 Hospital CDSS</div>
    <div class="user-info">
        <?=$_SESSION['user']?> (<?=$_SESSION['role']?>)
        | <a href="logout.php">Logout</a>
    </div>
</div>