<?php

include "config/db.php";

/* ---------------------------
   24 Batch Students
   24BFA05001 → 24BFA05462
----------------------------*/

for($i=1;$i<=462;$i++){

$num = str_pad($i,3,"0",STR_PAD_LEFT);

$id = "24BFA05".$num;

$name = "Student24_".$num;

$sql = "INSERT INTO students(student_id,name,department,year)
VALUES('$id','$name','CSE',2)";

$conn->query($sql);

}


/* ---------------------------
   25 Batch Students
   25BFA05L001 → 25BFA05L044
----------------------------*/

for($i=1;$i<=44;$i++){

$num = str_pad($i,3,"0",STR_PAD_LEFT);

$id = "25BFA05L".$num;

$name = "Student25_".$num;

$sql = "INSERT INTO students(student_id,name,department,year)
VALUES('$id','$name','CSE',1)";

$conn->query($sql);

}

echo "All students inserted successfully";

?>