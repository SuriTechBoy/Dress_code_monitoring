<?php
session_start();
include("db.php");
include("config.php");

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$score=null;
$strengths="";
$missing_skills="";
$suggestion="";
$resume_text="";

/* ================= AI FUNCTION ================= */

function analyzeWithAI($resume_text,$job_role){

$prompt = "Analyze this resume for the role $job_role.

Resume:
$resume_text

Return JSON with score, strengths, missing_skills and suggestions.";

$data = [
"model" => "llama3",
"prompt" => $prompt,
"stream" => false,
"format" => "json"
];

$ch = curl_init("http://localhost:11434/api/generate");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
"Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

curl_close($ch);

$result = json_decode($response,true);

$content = $result['response'] ?? "";

$analysis = json_decode($content,true);

if($analysis){
return $analysis;
}

return [
"score"=>60,
"strengths"=>"Basic resume detected",
"missing_skills"=>"Add more technical skills",
"suggestions"=>"Include projects and internships"
];

}
/* ================= FORM SUBMIT ================= */

if(isset($_POST['analyze'])){

$job_role=$_POST['job_role'];
$user_id=$_SESSION['user_id'];

if(isset($_FILES['resume_file']) && $_FILES['resume_file']['error']==0){

$allowed=["txt","pdf","docx"];
$fileType=strtolower(pathinfo($_FILES["resume_file"]["name"],PATHINFO_EXTENSION));

if(!in_array($fileType,$allowed)){
die("Only TXT, PDF or DOCX files allowed");
}

$target_dir="uploads/";
$filename=time()."_".basename($_FILES["resume_file"]["name"]);
$target_file=$target_dir.$filename;

move_uploaded_file($_FILES["resume_file"]["tmp_name"],$target_file);

/* TEXT EXTRACTION */

if($fileType=="txt"){
$resume_text=file_get_contents($target_file);
}
else{
$resume_text="Resume uploaded but analysis works best with TXT resumes.";
}

}

/* ================= AI ANALYSIS ================= */

$analysis = analyzeWithAI($resume_text,$job_role);

$score=$analysis['score'] ?? 0;
$strengths=$analysis['strengths'] ?? "No data";
$missing_skills=$analysis['missing_skills'] ?? "No data";
$suggestion=$analysis['suggestions'] ?? "No data";

/* ================= SAVE TO DB ================= */

mysqli_query($conn,"INSERT INTO resumes
(user_id,job_role,resume_text,score,match_percent)
VALUES
('$user_id','$job_role','$resume_text','$score','$score')");

}

?>

<!DOCTYPE html>
<html>
<head>

<title>SmartHire Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

<div class="container mt-5">

<h2 class="mb-4">Welcome <?php echo $_SESSION['user_name']; ?> 👋</h2>

<!-- Upload Resume -->

<div class="card bg-secondary p-4 mb-4">

<h4>Upload Resume for Analysis</h4>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6">

<label>Select Job Role</label>

<select name="job_role" class="form-select" required>

<option value="">Select Job Role</option>
<option value="Software Engineer">Software Engineer</option>
<option value="Web Developer">Web Developer</option>
<option value="Full Stack Developer">Full Stack Developer</option>
<option value="Data Analyst">Data Analyst</option>
<option value="Data Engineer">Data Engineer</option>
<option value="Cyber Security">Cyber Security</option>
<option value="Networking Engineer">Networking Engineer</option>
<option value="AI Engineer">AI Engineer</option>

</select>

</div>

<div class="col-md-6">

<label>Upload Resume</label>

<input type="file" name="resume_file" class="form-control" required>

</div>

</div>

<br>

<button type="submit" name="analyze" class="btn btn-success">
Analyze Resume
</button>

</form>

</div>

<?php if($score!==null): ?>

<div class="card bg-secondary text-center p-4 mb-4">

<h3>Resume Score</h3>

<h1><?php echo $score; ?>%</h1>

</div>

<div class="row">

<div class="col-md-4">

<div class="card bg-success p-3">

<h5>Strengths</h5>
<p><?php echo $strengths; ?></p>

</div>

</div>

<div class="col-md-4">

<div class="card bg-danger p-3">

<h5>Missing Skills</h5>
<p><?php echo $missing_skills; ?></p>

</div>

</div>

<div class="col-md-4">

<div class="card bg-info text-dark p-3">

<h5>AI Suggestions</h5>
<p><?php echo $suggestion; ?></p>

</div>

</div>

</div>

<?php endif; ?>

<hr>

<!-- HISTORY -->

<h3>Resume History</h3>

<?php

$user_id=$_SESSION['user_id'];

$result=mysqli_query($conn,"SELECT * FROM resumes WHERE user_id='$user_id' ORDER BY created_at DESC");

?>

<table class="table table-dark table-striped">

<tr>
<th>Job Role</th>
<th>Score</th>
<th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)): ?>

<tr>
<td><?php echo $row['job_role']; ?></td>
<td><?php echo $row['score']; ?>%</td>
<td><?php echo $row['created_at']; ?></td>
</tr>

<?php endwhile; ?>

</table>

<hr>

<!-- CHART -->

<h3>Score Trend</h3>

<canvas id="scoreChart"></canvas>

<?php

$chart=mysqli_query($conn,"SELECT score,created_at FROM resumes WHERE user_id='$user_id'");

$scores=[];
$dates=[];

while($r=mysqli_fetch_assoc($chart)){

$scores[]=$r['score'];
$dates[]=$r['created_at'];

}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx=document.getElementById('scoreChart');

new Chart(ctx,{
type:'line',
data:{
labels: <?php echo json_encode($dates); ?>,
datasets:[{
label:'Resume Score Trend',
data: <?php echo json_encode($scores); ?>,
borderColor:'lime',
borderWidth:2
}]
}
});

</script>

<br>

<a href="logout.php" class="btn btn-danger">Logout</a>

</div>

</body>
</html>