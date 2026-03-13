<?php

include "config/db.php";

$roll=$_POST['roll'];
$name=$_POST['name'];
$branch=$_POST['branch'];

$violations=implode(", ",$_POST['violation']);

$image=$_POST['image'];

$image=str_replace('data:image/png;base64,','',$image);
$image=str_replace(' ','+',$image);

$data=base64_decode($image);

$file="uploads/".time().".png";

file_put_contents($file,$data);

$sql="INSERT INTO violations(student_id,name,department,violation_type,id_card_image,date)
VALUES('$roll','$name','$branch','$violations','$file',NOW())";

$conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow p-4 text-center">

<h3 class="text-success">Complaint Recorded Successfully</h3>

<br>

<a href="scan_ocr.php" class="btn btn-primary">Scan Next Student</a>

</div>

</div>

</body>
</html>