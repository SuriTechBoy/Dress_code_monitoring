<?php
include "config/db.php";

$dept_data = $conn->query("
SELECT department,COUNT(*) as total
FROM violations
GROUP BY department
");

$labels=[];
$data=[];

while($row=$dept_data->fetch_assoc()){

$labels[]=$row['department'];
$data[]=$row['total'];

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Violation Charts</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h3 class="text-center">Violations by Department</h3>

<canvas id="chart"></canvas>

</div>

<script>

let ctx=document.getElementById('chart');

new Chart(ctx,{
type:'bar',
data:{
labels:<?php echo json_encode($labels) ?>,
datasets:[{
label:'Violations',
data:<?php echo json_encode($data) ?>,
backgroundColor:'red'
}]
}
});

</script>

</body>
</html>