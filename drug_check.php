<?php
session_start();
include("config/db.php");
if(!isset($_SESSION['user'])) header("Location: login.php");

$result="";
$class="";

if(isset($_POST['check'])){

    $drug1 = strtolower(trim($_POST['drug1']));
    $drug2 = strtolower(trim($_POST['drug2']));

    // SIMPLE INTERACTION LOGIC
    $interactions = [
        "paracetamol-ibuprofen" => ["Safe Combination","low"],
        "aspirin-warfarin" => ["High Bleeding Risk","high"],
        "amoxicillin-contraceptive" => ["Reduces Contraceptive Effect","medium"],
        "metformin-alcohol" => ["Lactic Acidosis Risk","high"],
        "ibuprofen-diclofenac" => ["High Stomach Ulcer Risk","high"]
    ];

    $key1 = $drug1."-".$drug2;
    $key2 = $drug2."-".$drug1;

    if(isset($interactions[$key1])){
        $result = $interactions[$key1][0];
        $class = $interactions[$key1][1];
    }
    elseif(isset($interactions[$key2])){
        $result = $interactions[$key2][0];
        $class = $interactions[$key2][1];
    }
    else{
        $result = "No Known Serious Interaction (Consult Pharmacist)";
        $class = "low";
    }
}
?>

<link rel="stylesheet" href="assets/css/style.css">

<div class="sidebar">
<h2>Welcome, <?=$_SESSION['user']?></h2>
<a href="dashboard.php">Dashboard</a>
<a href="register_patient.php">Register Patient</a>
<a href="view_patients.php">View Patients</a>
<a href="diagnosis.php">AI Diagnosis</a>
<a href="drug_check.php">Drug Checker</a>
<a href="logout.php">Logout</a>
</div>

<div class="main">
<h2>Drug Interaction Checker</h2>

<form method="POST" style="width:400px;">
<label>Drug 1</label>
<input type="text" name="drug1" required>

<label>Drug 2</label>
<input type="text" name="drug2" required>

<button name="check">Check Interaction</button>
</form>

<?php if($result!=""){ ?>
<div class="result-box <?=$class?>">
Result: <?=$result?>
</div>
<?php } ?>

</div>