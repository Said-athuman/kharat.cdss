<?php
session_start();
include("config/db.php");
if(!isset($_SESSION['user'])){ header("Location: login.php"); exit(); }

$id = $_GET['id'];
$patient = $conn->query("SELECT * FROM patient WHERE patient_id='$id'")->fetch_assoc();

if(isset($_POST['analyze'])){
    $symptoms = strtolower($_POST['symptoms']);
    $score = 0;

    if(str_contains($symptoms,"fever")) $score+=2;
    if(str_contains($symptoms,"cough")) $score+=1;
    if(str_contains($symptoms,"weight loss")) $score+=2;
    if(str_contains($symptoms,"shortness breath")) $score+=3;

    $risk = $score>=5 ? "HIGH RISK" : ($score>=3 ? "MEDIUM RISK" : "LOW RISK");
}
?>

<link rel="stylesheet" href="assets/css/style.css">

<div class="main">
<div class="header">AI Diagnosis for <?php echo $patient['name']; ?></div>

<form method="POST">
<textarea name="symptoms" placeholder="Enter symptoms separated by comma"></textarea>
<button name="analyze">Analyze</button>
</form>

<?php if(isset($risk)){ ?>
<div class="card">
<h3>AI Result: <?php echo $risk; ?></h3>
<p>Score: <?php echo $score; ?></p>
</div>
<?php } ?>
</div>