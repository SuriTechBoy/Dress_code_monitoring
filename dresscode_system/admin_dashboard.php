<?php
include "config/db.php";

$total_students = $conn->query("SELECT COUNT(*) as c FROM students")->fetch_assoc()['c'];

$total_violations = $conn->query("SELECT COUNT(*) as c FROM violations")->fetch_assoc()['c'];

$today_violations = $conn->query("SELECT COUNT(*) as c FROM violations WHERE DATE(date)=CURDATE()")->fetch_assoc()['c'];

?>

<!DOCTYPE html>
<html>
<head>
<style>
body.dark-mode{
    background:#121212;
    color:white;
}

.dark-mode .card{
    background:#1e1e1e;
    color:white;
}

.dark-mode table{
    color:white;
}

.dark-mode input{
    background:#333;
    color:white;
    border:1px solid #555;
}

.dark-mode .btn{
    opacity:0.9;
}

.toggle-btn{
    position:fixed;
    top:20px;
    right:20px;
    z-index:1000;
}
</style>
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">
<button onclick="toggleDarkMode()" class="btn btn-dark toggle-btn">
🌙 Dark Mode
</button>
<div class="container mt-5">

<h2 class="text-center mb-4">Admin Dashboard</h2>

<div class="row">

<div class="col-md-4">
<div class="card p-4 text-center shadow">
<h3><?php echo $total_students ?></h3>
<p>Total Students</p>
</div>
</div>

<div class="col-md-4">
<div class="card p-4 text-center shadow">
<h3><?php echo $total_violations ?></h3>
<p>Total Violations</p>
</div>
</div>

<div class="col-md-4">
<div class="card p-4 text-center shadow">
<h3><?php echo $today_violations ?></h3>
<p>Today's Violations</p>
</div>
</div>

</div>

<hr>

<div class="text-center">

<a href="charts.php" class="btn btn-primary">Violation Charts</a>

<a href="search_student.php" class="btn btn-success">Search Student</a>

<a href="daily_report.php" class="btn btn-warning">Daily Report</a>

</div>

</div> <a href="export_pdf.php" class="btn btn-danger">
Download PDF Report
</a>
<a href="export_report.php" class="btn btn-danger">
Export Violations Report
</a>
<script>

function toggleDarkMode(){

document.body.classList.toggle("dark-mode");

if(document.body.classList.contains("dark-mode")){
localStorage.setItem("theme","dark");
}else{
localStorage.setItem("theme","light");
}

}

window.onload=function(){

let theme=localStorage.getItem("theme");

if(theme==="dark"){
document.body.classList.add("dark-mode");
}

}

</script>
</body>
</html>