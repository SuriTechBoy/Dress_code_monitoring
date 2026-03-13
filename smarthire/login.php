<?php
session_start();
include("db.php");

$error = "";

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid Password!";
        }

    } else {
        $error = "User Not Found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - SmartHire AI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

<!-- NAVBAR -->

<nav class="navbar navbar-dark bg-black px-4">
<a class="navbar-brand text-info fw-bold" href="index.php">
SmartHire AI
</a>
</nav>

<!-- LOGIN FORM -->

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card bg-secondary p-4">

<h3 class="text-center">Login</h3>

<?php if($error!=""): ?>

<div class="alert alert-danger mt-2">
<?php echo $error; ?>
</div>

<?php endif; ?>

<form method="POST" class="mt-3">

<input class="form-control mb-3"
type="email"
name="email"
placeholder="Enter Email"
required>

<input class="form-control mb-3"
type="password"
name="password"
placeholder="Enter Password"
required>

<button class="btn btn-info w-100" name="login">
Login
</button>

</form>

<p class="text-center mt-3">
Don't have an account?
<a href="register.php" class="text-info">Register</a>
</p>

</div>

</div>

</div>

</div>


<!-- STATS SECTION -->

<div class="container mt-5 text-center">

<h2 class="mb-4">Why SmartHire AI?</h2>

<div class="row">

<div class="col-md-4 mb-3">
<div class="card bg-secondary text-white p-4">
<h1 class="text-info">10+</h1>
<p>Supported Job Roles</p>
</div>
</div>

<div class="col-md-4 mb-3">
<div class="card bg-secondary text-white p-4">
<h1 class="text-info">AI</h1>
<p>Powered Resume Analysis</p>
</div>
</div>

<div class="col-md-4 mb-3">
<div class="card bg-secondary text-white p-4">
<h1 class="text-info">Instant</h1>
<p>Resume Feedback & Suggestions</p>
</div>
</div>

</div>

</div>


<!-- FOOTER -->

<footer class="bg-black text-center text-muted p-3 mt-5">

© <?php echo date("Y"); ?> SmartHire AI  
Developed by Suri 🚀

</footer>

</body>
</html>