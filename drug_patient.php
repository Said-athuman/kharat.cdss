<?php
session_start();
include("config/db.php");
if(!isset($_SESSION['user'])){ header("Location: login.php"); exit(); }

$id = $_GET['id'];
$patient = $conn->query("SELECT * FROM patient WHERE patient_id='$id'")->fetch_assoc();

if(isset($_POST['check'])){
    $d1 = $_POST['drug1'];
    $d2 = $_POST['drug2'];

    if($d1=="Aspirin" && $d2=="Warfarin"){
        $result="⚠ HIGH RISK INTERACTION";
    } else {
        $result="✔ Safe Combination";
    }
}
?>

<link rel="stylesheet" href="assets/css/style.css">

<div class="main">
<div class="header">Drug Check for <?php echo $patient['name']; ?></div>

<form method="POST">
<select name="drug1">
<option>Aspirin</option>
<option>Warfarin</option>
<option>Amoxicillin</option>
</select>

<select name="drug2">
<option>Aspirin</option>
<option>Warfarin</option>
<option>Amoxicillin</option>
</select>

<button name="check">Check Interaction</button>
</form>

<?php if(isset($result)){ ?>
<div class="card">
<h3><?php echo $result; ?></h3>
</div>
<?php } ?>
</div>