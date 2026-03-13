<?php
include "config/db.php";

$data=$conn->query("
SELECT * FROM violations
ORDER BY date DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Daily Violations</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h3>Violation Report</h3>

<table class="table table-bordered">

<tr>
<th>Image</th>
<th>Name</th>
<th>Roll</th>
<th>Violation</th>
<th>Date</th>
</tr>

<?php

while($row=$data->fetch_assoc()){

echo "<tr>";

echo "<td><img src='".$row['id_card_image']."' width='80'></td>";

echo "<td>".$row['name']."</td>";

echo "<td>".$row['student_id']."</td>";

echo "<td>".$row['violation_type']."</td>";

echo "<td>".$row['date']."</td>";

echo "</tr>";

}

?>

</table>

</div>

</body>
</html>