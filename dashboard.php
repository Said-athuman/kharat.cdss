<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Basic Statistics
$totalPatients = $conn->query("SELECT COUNT(*) as t FROM patient")->fetch_assoc()['t'];
$male = $conn->query("SELECT COUNT(*) as t FROM patient WHERE gender='Male'")->fetch_assoc()['t'];
$female = $conn->query("SELECT COUNT(*) as t FROM patient WHERE gender='Female'")->fetch_assoc()['t'];

// Monthly Registration Data
$monthly = $conn->query("
SELECT MONTH(date_of_birth) as month, COUNT(*) as total
FROM patient
GROUP BY MONTH(date_of_birth)
");

$months = [];
$counts = [];

while($row = $monthly->fetch_assoc()){
    $months[] = $row['month'];
    $counts[] = $row['total'];
}
?>

<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    <div class="header">Hospital Clinical Decision Support System</div>

    <!-- Quick Action Buttons -->
    <div style="display:flex; gap:20px; margin-bottom:20px;">
        <a href="register_patient.php" class="card" style="flex:1; text-align:center; text-decoration:none;">
            <h3>➕ Register Patient</h3>
        </a>

        <a href="view_patients.php" class="card" style="flex:1; text-align:center; text-decoration:none;">
            <h3>🔍 View & Diagnose</h3>
        </a>
    </div>

    <!-- Animated Counters -->
    <div style="display:flex; gap:20px; margin-bottom:20px;">
        <div class="card" style="flex:1; text-align:center;">
            <h3>Total Patients</h3>
            <h1 id="totalCounter">0</h1>
        </div>

        <div class="card" style="flex:1; text-align:center;">
            <h3>Male Patients</h3>
            <h1 id="maleCounter">0</h1>
        </div>

        <div class="card" style="flex:1; text-align:center;">
            <h3>Female Patients</h3>
            <h1 id="femaleCounter">0</h1>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="card">
        <h3>Patients Distribution by Gender</h3>
        <canvas id="genderChart"></canvas>
    </div>

    <div class="card">
        <h3>Monthly Patient Registration</h3>
        <canvas id="monthlyChart"></canvas>
    </div>

</div>

<script>
// Animated Counter Function
function animateCounter(id, endValue){
    let current = 0;
    let increment = endValue / 50;
    let counter = document.getElementById(id);

    let interval = setInterval(function(){
        current += increment;
        if(current >= endValue){
            current = endValue;
            clearInterval(interval);
        }
        counter.innerText = Math.floor(current);
    }, 20);
}

animateCounter("totalCounter", <?php echo $totalPatients; ?>);
animateCounter("maleCounter", <?php echo $male; ?>);
animateCounter("femaleCounter", <?php echo $female; ?>);

// Gender Chart
new Chart(document.getElementById('genderChart'), {
    type: 'bar',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            label: 'Patients by Gender',
            data: [<?php echo $male; ?>, <?php echo $female; ?>],
            backgroundColor: ['#0b6fa4','#4CAF50']
        }]
    },
    options: { responsive:true }
});

// Monthly Line Chart
new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Registrations Per Month',
            data: <?php echo json_encode($counts); ?>,
            borderColor: '#0b6fa4',
            fill: false,
            tension: 0.3
        }]
    },
    options: { responsive:true }
});
</script>