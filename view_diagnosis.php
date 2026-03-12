<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

/* ================= DELETE PATIENT ================= */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM patient WHERE patient_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    header("Location: view_patients.php");
    exit();
}

/* ================= UPDATE PATIENT ================= */
if(isset($_POST['update'])){
    $id = $_POST['patient_id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE patient SET name=?, gender=?, dob=?, address=?, phone=? WHERE patient_id=?");
    $stmt->bind_param("sssssi",$name,$gender,$dob,$address,$phone,$id);
    $stmt->execute();
    header("Location: view_patients.php");
    exit();
}

$patients = $conn->query("SELECT * FROM patient ORDER BY patient_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Patients</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="sidebar">
    <h2>Welcome, <?php echo $_SESSION['user']; ?></h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="register_patient.php">Register Patient</a>
    <a href="view_patients.php" class="active">View Patients</a>
    <a href="diagnosis.php">AI Diagnosis</a>
    <a href="drug_check.php">Drug Checker</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
<div class="header">All Patients</div>

<input type="text" id="search" onkeyup="searchPatient()" placeholder="Search Patient Name">

<table id="patientTable">
<tr>
<th>ID</th>
<th>Name</th>
<th>Gender</th>
<th>DOB</th>
<th>Phone</th>
<th>Actions</th>
</tr>

<?php while($row = $patients->fetch_assoc()){ ?>
<tr>
<td><?= $row['patient_id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['gender'] ?></td>
<td><?= $row['dob'] ?></td>
<td><?= $row['phone'] ?></td>
<td class="action-buttons">

<button class="btn-edit"
onclick="openEditModal(
'<?= $row['patient_id'] ?>',
'<?= $row['name'] ?>',
'<?= $row['gender'] ?>',
'<?= $row['dob'] ?>',
'<?= $row['address'] ?>',
'<?= $row['phone'] ?>'
)">
✏ Edit
</button>

<a href="view_patients.php?delete=<?= $row['patient_id'] ?>"
class="btn-delete"
onclick="return confirm('Delete this patient permanently?')">
🗑 Delete
</a>

</td>
</tr>
<?php } ?>
</table>
</div>

<!-- ================= EDIT MODAL ================= -->
<div id="editModal" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal()">&times;</span>
<h3>Edit Patient</h3>
<form method="POST">
<input type="hidden" name="patient_id" id="modal_id">
<input type="text" name="name" id="modal_name" required>
<select name="gender" id="modal_gender">
<option>Male</option>
<option>Female</option>
</select>
<input type="date" name="dob" id="modal_dob" required>
<textarea name="address" id="modal_address"></textarea>
<input type="text" name="phone" id="modal_phone" required>
<button name="update" class="btn-update">Update Patient</button>
</form>
</div>
</div>

<script>
function searchPatient(){
    let input=document.getElementById("search").value.toLowerCase();
    let rows=document.querySelectorAll("#patientTable tr");
    rows.forEach((row,i)=>{
        if(i===0)return;
        let name=row.cells[1].innerText.toLowerCase();
        row.style.display=name.includes(input)?"":"none";
    });
}

function openEditModal(id,name,gender,dob,address,phone){
    document.getElementById('editModal').style.display='block';
    modal_id.value=id;
    modal_name.value=name;
    modal_gender.value=gender;
    modal_dob.value=dob;
    modal_address.value=address;
    modal_phone.value=phone;
}
function closeModal(){
    document.getElementById('editModal').style.display='none';
}
window.onclick=function(e){
    if(e.target==document.getElementById('editModal')){
        closeModal();
    }
}
</script>

</body>
</html>