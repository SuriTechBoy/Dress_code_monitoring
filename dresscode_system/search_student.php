<?php
include "config/db.php";

$result=null;

if(isset($_GET['q'])){

$q=$_GET['q'];

$result=$conn->query("
SELECT * FROM students
WHERE student_id LIKE '%$q%'
OR name LIKE '%$q%'
");

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

<title>Search Student</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
<button onclick="toggleDarkMode()" class="btn btn-dark toggle-btn">
🌙 Dark Mode
</button>
<div class="container mt-5">

<h3>Search Student</h3>

<form method="GET">

<input type="text" name="q" class="form-control" placeholder="Enter Roll or Name">

<br>

<button class="btn btn-primary">Search</button>

</form>

<hr>

<?php

if($result){

while($row=$result->fetch_assoc()){

echo "<div class='card p-3 mb-2'>";

echo "<b>".$row['name']."</b><br>";
echo "Roll: ".$row['student_id']."<br>";
echo "Dept: ".$row['department'];

echo "</div>";

}

}

?>

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