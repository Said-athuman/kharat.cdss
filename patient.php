<?php
include("config.php");

if(isset($_POST['add'])){
    $name=$_POST['name'];
    $gender=$_POST['gender'];
    $dob=$_POST['dob'];
    $phone=$_POST['phone'];

    $stmt=$conn->prepare("INSERT INTO patients(fullname,gender,dob,phone) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss",$name,$gender,$dob,$phone);
    $stmt->execute();
}

$result=$conn->query("SELECT * FROM patients");
?>

<h2>Patients</h2>

<form method="POST">
<input name="name" placeholder="Full Name" required>
<input name="gender" placeholder="Gender" required>
<input type="date" name="dob" required>
<input name="phone" placeholder="Phone" required>
<button name="add">Add Patient</button>
</form>

<table border="1">
<tr><th>Name</th><th>Gender</th><th>DOB</th><th>Phone</th></tr>
<?php while($row=$result->fetch_assoc()){ ?>
<tr>
<td><?=$row['fullname']?></td>
<td><?=$row['gender']?></td>
<td><?=$row['dob']?></td>
<td><?=$row['phone']?></td>
</tr>
<?php } ?>
</table>