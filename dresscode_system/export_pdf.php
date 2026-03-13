<?php

require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

include "config/db.php";

$dompdf = new Dompdf();

$data = $conn->query("SELECT * FROM violations ORDER BY date DESC");

$html = "<h2 style='text-align:center'>Dress Code Violations Report</h2>";

$html .= "<table border='1' width='100%' cellpadding='5'>
<tr>
<th>Student Name</th>
<th>Roll No</th>
<th>Department</th>
<th>Violation</th>
<th>Date</th>
</tr>";

while($row = $data->fetch_assoc()){

$html .= "<tr>
<td>".$row['name']."</td>
<td>".$row['student_id']."</td>
<td>".$row['department']."</td>
<td>".$row['violation_type']."</td>
<td>".$row['date']."</td>
</tr>";

}

$html .= "</table>";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');

$dompdf->render();

$dompdf->stream("violations_report.pdf");

?>