<?php

include "config/db.php";

$roll = $_POST['roll'];
$name = $_POST['name'];
$branch = $_POST['branch'];
$image = $_POST['image'];

$sql="SELECT * FROM students WHERE student_id='$roll'";
$result=$conn->query($sql);

if($result->num_rows==0){

echo "<h3 style='color:red'>Student not found in DB</h3>";
exit();

}

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
<title>Student Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">
<button onclick="toggleDarkMode()" class="btn btn-dark toggle-btn">
🌙 Dark Mode
</button>
<div class="container mt-5">

<div class="card shadow p-4">

<h3 class="text-center">Student Details</h3>

<div class="row mt-4">
<div class="row mt-4 align-items-center">

<div class="col-md-6 text-center">

<img src="<?php echo $image ?>" class="img-fluid rounded shadow" style="max-width:450px;">

</div>

<div class="col-md-6">

<h4 class="mb-3"><?php echo $name ?></h4>

<p><b>Roll No:</b> <?php echo $roll ?></p>
<p><b>Branch:</b> <?php echo $branch ?></p>

</div>

</div>

</div>

<hr>

<h4>Dress Code Violations</h4>

<form action="submit_violation.php" method="POST">

<input type="hidden" name="roll" value="<?php echo $roll ?>">
<input type="hidden" name="name" value="<?php echo $name ?>">
<input type="hidden" name="branch" value="<?php echo $branch ?>">
<input type="hidden" name="image" value="<?php echo $image ?>">

<div class="form-check">
<input class="form-check-input" type="checkbox" name="violation[]" value="No Shoes">
<label>No Shoes</label>
</div>

<div class="form-check">
<input class="form-check-input" type="checkbox" name="violation[]" value="Not Inshirt">
<label>Not Inshirt</label>
</div>

<div class="form-check">
<input class="form-check-input" type="checkbox" name="violation[]" value="Jeans Pant">
<label>Jeans Pant</label>
</div>

<div class="form-check">
<input class="form-check-input" type="checkbox" name="violation[]" value="No ID Card">
<label>No ID Card</label>
</div>

<br>

<button class="btn btn-danger">Submit Complaint</button>

<a href="scan_ocr.php" class="btn btn-secondary">Back</a>

</form>

</div>

</div>
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