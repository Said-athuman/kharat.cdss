<?php
session_start(); include("config/db.php");
if(!isset($_SESSION['user'])){ header("Location: login.php"); exit(); }
?>
<link rel="stylesheet" href="assets/css/style.css">

<div class="sidebar">
<a href="dashboard.php">Dashboard</a>
<a href="view_patients.php">Patients</a>
</div>

<div class="main">
<div class="header">AI Diagnosis (Advanced Scoring)</div>

<form method="POST">
<select name="patient_id">
<?php $r=$conn->query("SELECT * FROM patient");
while($row=$r->fetch_assoc()){ echo "<option value='{$row['patient_id']}'>{$row['name']}</option>"; }
?>
</select>
<textarea name="symptoms" placeholder="Enter symptoms separated by comma"></textarea>
<button name="analyze">Analyze</button>
</form>

<?php
if(isset($_POST['analyze'])){
  $sym_input=strtolower($_POST['symptoms']);
  $symptoms=array_map('trim',explode(',',$sym_input));
  $score_table=["fever"=>2,"headache"=>2,"cough"=>1,"fatigue"=>1,"weight loss"=>2,"shortness breath"=>3];
  $total_score=0; foreach($symptoms as $s){ if(isset($score_table[$s])) $total_score+=$score_table[$s]; }
  $risk=$total_score>=5?"High Risk":($total_score>=3?"Medium Risk":"Low Risk");
  echo "<div class='card'><h3>AI Suggestion: $risk (Score: $total_score)</h3></div>";
}
?>
</div>