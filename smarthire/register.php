<?php
include("db.php");

if(isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) 
            VALUES ('$name', '$email', '$hashed_password')";

    if(mysqli_query($conn, $sql)) {
        echo "Registration Successful!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - SmartHire</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Enter Name" required><br><br>
        <input type="email" name="email" placeholder="Enter Email" required><br><br>
        <input type="password" name="password" placeholder="Enter Password" required><br><br>
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>
