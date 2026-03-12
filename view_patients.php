<?php
session_start();
include("config/db.php");
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Handle Edit
if(isset($_POST['update'])){
    $id = $_POST['patient_id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $conn->query("UPDATE patient SET name='$name', gender='$gender', date_of_birth='$dob', address='$address', phone='$phone' WHERE patient_id='$id'");
    $msg = "Patient Updated Successfully";
}

// Handle Delete
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM patient WHERE patient_id='$id'");
    $msg = "Patient Deleted Successfully";
}
?>

<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/script.js"></script>

<div class="sidebar">
    <h2>Welcome, <?php echo $_SESSION['user']; ?></h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="register_patient.php">Register Patient</a>
    <a href="view_patients.php">View Patients</a>
    <a href="diagnosis.php">AI Diagnosis</a>
    <a href="drug_check.php">Drug Checker</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
<div class="header">All Patients</div>

<?php if(isset($msg)) echo "<div class='alert'>$msg</div>"; ?>

<input type="text" id="search" onkeyup="searchPatient()" placeholder="Search Patient Name">

<table id="patientTable">
<tr>
<th>ID</th><th>Name</th><th>Gender</th><th>DOB</th><th>Phone</th><th>Actions</th>
</tr>

<?php
$r = $conn->query("SELECT * FROM patient ORDER BY patient_id DESC");
while($row = $r->fetch_assoc()){
    echo "<tr>
    <td>{$row['patient_id']}</td>
    <td>{$row['name']}</td>
    <td>{$row['gender']}</td>
    <td>{$row['date_of_birth']}</td>
    <td>{$row['phone']}</td>
    <td>
        <button onclick=\"openEditModal({$row['patient_id']}, '{$row['name']}', '{$row['gender']}', '{$row['date_of_birth']}', '{$row['address']}', '{$row['phone']}')\">Edit</button>
        <a href='view_patients.php?delete={$row['patient_id']}' onclick='return confirm(\"Are you sure to delete this patient?\")'>Delete</a>
    </td>
    </tr>";
}
?>
</table>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal()">&times;</span>
<h3>Edit Patient</h3>
<form method="POST">
<input type="hidden" name="patient_id" id="modal_id">
<input type="text" name="name" id="modal_name" placeholder="Full Name" required>
<select name="gender" id="modal_gender"><option>Male</option><option>Female</option></select>
<input type="date" name="dob" id="modal_dob" required>
<textarea name="address" id="modal_address" placeholder="Address"></textarea>
<input type="text" name="phone" id="modal_phone" placeholder="Phone" required>
<button name="update">Update Patient</button>
</form>
</div>
</div>

<script>
function openEditModal(id,name,gender,dob,address,phone){
    document.getElementById('editModal').style.display='block';
    document.getElementById('modal_id').value=id;
    document.getElementById('modal_name').value=name;
    document.getElementById('modal_gender').value=gender;
    document.getElementById('modal_dob').value=dob;
    document.getElementById('modal_address').value=address;
    document.getElementById('modal_phone').value=phone;
}

function closeModal(){
    document.getElementById('editModal').style.display='none';
}

// Close modal when clicking outside
window.onclick = function(event){
    if(event.target==document.getElementById('editModal')){
        closeModal();
    }
}
</script>

<style>
/* Modal styling */
.modal{
    display:none;
    position:fixed;
    z-index:1000;
    padding-top:100px;
    left:0; top:0;
    width:100%; height:100%;
    overflow:auto;
    background:rgba(0,0,0,0.5);
}
.modal-content{
    background:white;
    margin:auto;
    padding:20px;
    border-radius:8px;
    width:400px;
    box-shadow:0 4px 12px rgba(0,0,0,0.3);
}
.close{
    color:#aaa;
    float:right;
    font-size:28px;
    font-weight:bold;
    cursor:pointer;
}
.close:hover{color:black;}
</style>