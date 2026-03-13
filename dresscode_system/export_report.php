<?php
include "config/db.php";

$data = $conn->query("SELECT * FROM violations ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Violations Report</title>

<style>

body{
font-family:Arial;
margin:40px;
}

h2{
text-align:center;
}

table{
width:100%;
border-collapse:collapse;
}

table,th,td{
border:1px solid black;
}

th,td{
padding:10px;
text-align:center;
}

button{
margin-top:20px;
padding:10px 20px;
font-size:16px;
}

</style>

</head>

<body>

<h2>Dress Code Violations Report</h2>

<table>

<tr>
<th>Name</th>
<th>Roll No</th>
<th>Department</th>
<th>Violation</th>
<th>Date</th>
</tr>

<?php
while($row = $data->fetch_assoc()){
?>

<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['student_id']; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['violation_type']; ?></td>
<td><?php echo $row['date']; ?></td>
</tr>

<?php
}
?>

</table>

<center>

<button onclick="window.print()">Download / Print PDF</button>

</center>

</body>
</html>