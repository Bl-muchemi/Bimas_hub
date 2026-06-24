<?php
session_start();
include "includes/db.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']); // New role input from form

    if(empty($name) || empty($email) || empty($password) || empty($role)){
        $message = "All fields are required.";
    } else {

        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $message = "Email already registered.";
        } else {

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

            if($stmt->execute()){
                $message = "Registration successful. You can now <a href='login.php'>login</a>.";
            } else {
                $message = "Something went wrong. Please try again.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Bimas Hub Register</title>
<style>
body{
    font-family: Arial;
    background:#f5f5f5;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.box{
    background:white;
    padding:40px;
    width:350px;
    border-radius:8px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
h2{
    text-align:center;
    color:#ff6f00;
}
input, select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:5px;
}
button{
    width:100%;
    padding:12px;
    background:#ff6f00;
    border:none;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
}
button:hover{
    background:#e65c00;
}
.message{
    text-align:center;
    margin-bottom:10px;
    color:red;
}
.login{
    text-align:center;
    margin-top:10px;
}
.login a{
    color:#ff6f00;
    text-decoration:none;
}
</style>
</head>
<body>

<div class="box">
<h2>Create Account</h2>

<div class="message"><?php echo $message; ?></div>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    
    <!-- Role selector -->
    <select name="role" required>
        <option value="">Select Role</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit">Register</button>
</form>

<div class="login">
    Already have an account? <a href="login.php">Login</a>
</div>
</div>

</body>
</html>