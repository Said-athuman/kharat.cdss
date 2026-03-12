<?php
include("config.php");

if(isset($_POST['add'])){
    $patient=$_POST['patient'];
    $test=$_POST['test'];
    $result=$_POST['result'];

    $stmt=$conn->prepare("INSERT INTO laboratory(patient_id,test_name,result) VALUES(?,?,?)");
    $stmt->bind_param("iss",$patient,$test,$result);
    $stmt->execute();
}

$patients=$conn->query("SELECT * FROM patients");
$labs=$conn->query("SELECT laboratory.*, patients.fullname 
                    FROM laboratory 
                    JOIN patients ON laboratory.patient_id=patients.id");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>

<div class="content">

<h2>🧪 Laboratory Records</h2>

<form method="POST">
<select name="patient" required>
<option value="">Select Patient</option>
<?php while($p=$patients->fetch_assoc()){ ?>
<option value="<?=$p['id']?>"><?=$p['fullname']?></option>
<?php } ?>
</select>

<input name="test" placeholder="Test Name" required>
<input name="result" placeholder="Result" required>
<button name="add">Save</button>
</form>

<table>
<tr><th>Patient</th><th>Test</th><th>Result</th></tr>
<?php while($row=$labs->fetch_assoc()){ ?>
<tr>
<td><?=$row['fullname']?></td>
<td><?=$row['test_name']?></td>
<td><?=$row['result']?></td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>