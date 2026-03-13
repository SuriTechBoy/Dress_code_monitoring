<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

/* ---------- Statistics ---------- */

$total_users = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM users"))['total'];

$total_resumes = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM resumes"))['total'];

$best_score = mysqli_fetch_assoc(mysqli_query($conn,"SELECT MAX(score) as max_score FROM resumes"))['max_score'];

/* ---------- Tables ---------- */

$result_users = mysqli_query($conn,"SELECT * FROM users");

$result_resumes = mysqli_query($conn,
"SELECT users.name,resumes.job_role,resumes.score,resumes.created_at
FROM resumes
JOIN users ON resumes.user_id = users.id
ORDER BY resumes.score DESC");

?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Panel - SmartHire</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

<div class="container mt-5">

<h2 class="mb-4">👨‍💼 SmartHire Admin Panel</h2>


<!-- STATS CARDS -->

<div class="row mb-4">

<div class="col-md-4">

<div class="card bg-secondary text-center p-3">

<h3><?php echo $total_users; ?></h3>

<p>Total Users</p>

</div>

</div>

<div class="col-md-4">

<div class="card bg-secondary text-center p-3">

<h3><?php echo $total_resumes; ?></h3>

<p>Total Resumes Analyzed</p>

</div>

</div>

<div class="col-md-4">

<div class="card bg-secondary text-center p-3">

<h3><?php echo $best_score; ?>%</h3>

<p>Highest Resume Score</p>

</div>

</div>

</div>


<!-- USERS TABLE -->

<h4 class="mt-4">👥 Registered Users</h4>

<table class="table table-dark table-striped">

<thead>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
</tr>

</thead>

<tbody>

<?php while($user=mysqli_fetch_assoc($result_users)): ?>

<tr>

<td><?php echo $user['id']; ?></td>

<td><?php echo $user['name']; ?></td>

<td><?php echo $user['email']; ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>



<!-- LEADERBOARD -->

<h4 class="mt-5">🏆 Resume Score Leaderboard</h4>

<table class="table table-dark table-striped">

<thead>

<tr>
<th>User</th>
<th>Job Role</th>
<th>Score</th>
<th>Date</th>
</tr>

</thead>

<tbody>

<?php while($resume=mysqli_fetch_assoc($result_resumes)): ?>

<tr>

<td><?php echo $resume['name']; ?></td>

<td><?php echo $resume['job_role']; ?></td>

<td><?php echo $resume['score']; ?>%</td>

<td><?php echo $resume['created_at']; ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>


<div class="mt-4">

<a href="dashboard.php" class="btn btn-info">
Back to Dashboard
</a>

<a href="logout.php" class="btn btn-danger">
Logout
</a>

</div>

</div>

</body>
</html>